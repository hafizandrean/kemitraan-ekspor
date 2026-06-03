<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SystemNotification;
use App\Services\PremiumAccessService;
use App\Services\TrustedPetaniEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess,
        private readonly TrustedPetaniEligibilityService $trustedPetani
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless(in_array($user->role, ['petani', 'eksportir'], true), 403);

        $plans = SubscriptionPlan::all();

        $activeSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();

        $pendingSubscription = $user->subscriptions()
            ->where('status', 'pending')
            ->first();

        return view('premium.index', [
            'user' => $user,
            'plans' => $plans,
            'isPremium' => $this->premiumAccess->isPremium($user),
            'activeSubscription' => $activeSubscription,
            'pendingSubscription' => $pendingSubscription,
            'trustedDiscount' => $user->role === 'petani' && $this->trustedPetani->qualifiesForPremiumDiscount($user),
            'permissions' => config('permissions.features'),
        ]);
    }

    public function checkout(Request $request, $planId): View
    {
        $user = $request->user();
        abort_unless(in_array($user->role, ['petani', 'eksportir'], true), 403);

        $plan = SubscriptionPlan::findOrFail($planId);
        abort_if($plan->price == 0, 403, 'Paket gratis tidak memerlukan checkout.');

        // Enforce no active subscriptions
        $hasActive = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->exists();
        if ($hasActive) {
            return redirect()->route('premium.index')->with('error', 'Anda sudah memiliki keanggotaan premium yang aktif.');
        }

        // Apply discount for trusted petani
        $price = $plan->price;
        $hasDiscount = false;
        if ($user->role === 'petani' && $this->trustedPetani->qualifiesForPremiumDiscount($user)) {
            $price = $plan->price * 0.8;
            $hasDiscount = true;
        }

        // Reuse or create a pending transaction
        $subscription = $user->subscriptions()
            ->where('plan_id', $plan->id)
            ->where('status', 'pending')
            ->first();

        if (!$subscription) {
            $transactionId = 'SUB-' . strtoupper(Str::random(10));
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'transaction_id' => $transactionId,
                'payment_type' => 'qris',
                'gross_amount' => $price,
                'status' => 'pending',
            ]);
        }

        return view('premium.checkout', [
            'subscription' => $subscription,
            'plan' => $plan,
            'price' => $price,
            'hasDiscount' => $hasDiscount,
        ]);
    }

    public function simulatePayment(Request $request): RedirectResponse
    {
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status', 'success'); // success or failed
        $paymentType = $request->input('payment_type', 'qris');

        $subscription = Subscription::where('transaction_id', $transactionId)->firstOrFail();

        $serverKey = config('midtrans.server_key', 'SB-Mid-server-dummyKey123');
        $statusCode = $status === 'success' ? '200' : '400';
        $grossAmount = number_format($subscription->gross_amount, 2, '.', '');

        // Calculate production-ready SHA-512 signature key
        $signatureKey = hash("sha512", $transactionId . $statusCode . $grossAmount . $serverKey);

        // Build mock Midtrans webhook request payload
        $payload = [
            'order_id' => $transactionId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => $status === 'success' ? 'settlement' : 'expire',
            'payment_type' => $paymentType,
        ];

        // Call callback internally mimicking actual gateway webhook dispatch
        $mockRequest = Request::create('/payment/callback', 'POST', $payload);
        $this->callback($mockRequest);

        if ($status === 'success') {
            return redirect()
                ->route('premium.index')
                ->with('success', 'Pembayaran sukses disimulasikan via Midtrans Snap! Akun Anda aktif otomatis. 🎉');
        } else {
            return redirect()
                ->route('premium.index')
                ->with('error', 'Pembayaran gagal disimulasikan. Status transaksi dibatalkan.');
        }
    }

    /**
     * Midtrans Webhook Callback Receiver
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key', 'SB-Mid-server-dummyKey123');

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $calculated = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        // Verify authenticity of signature - WAJIB KERAS
        if ($signatureKey !== $calculated) {
            \Illuminate\Support\Facades\Log::warning("Signature Mismatch: ID: $orderId, Code: $statusCode, Amount: $grossAmount, Key: $signatureKey, Calculated: $calculated, ServerKey: $serverKey");
            abort(403, 'Invalid signature key');
        }

        $subscription = Subscription::where('transaction_id', $orderId)->first();
        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $transactionStatus = $request->input('transaction_status');
        $paymentType = $request->input('payment_type');

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $plan = $subscription->plan;
            $durationDays = $plan->duration_days > 0 ? $plan->duration_days : 30;
            $endDate = now()->addDays($durationDays);

            \Illuminate\Support\Facades\DB::transaction(function () use ($subscription, $paymentType, $endDate, $grossAmount) {
                $subscription->update([
                    'status' => 'active',
                    'payment_type' => $paymentType,
                    'start_date' => now(),
                    'end_date' => $endDate,
                    'paid_at' => now(),
                ]);

                $user = $subscription->user;
                $user->update([
                    'account_tier' => 'premium',
                    'premium_expires_at' => $endDate,
                ]);

                // Deactivate any other active subscriptions for this user
                $subscription->user->subscriptions()
                    ->where('id', '!=', $subscription->id)
                    ->where('status', 'active')
                    ->update(['status' => 'expired']);

                \App\Models\SystemNotification::create([
                    'user_id' => $user->id,
                    'title' => 'Pembayaran Premium Berhasil!',
                    'message' => 'Pembayaran Rp' . number_format($grossAmount, 0, ',', '.') . ' via ' . strtoupper($paymentType) . ' sukses. Premium aktif hingga ' . $endDate->format('d M Y') . '.',
                    'is_read' => false,
                ]);
            });

        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $statusMapping = match($transactionStatus) {
                'expire' => 'expired',
                'cancel' => 'cancelled',
                default => 'failed',
            };

            \Illuminate\Support\Facades\DB::transaction(function () use ($subscription, $statusMapping) {
                $subscription->update([
                    'status' => $statusMapping,
                ]);

                \App\Models\SystemNotification::create([
                    'user_id' => $subscription->user_id,
                    'title' => 'Pembayaran Premium Gagal',
                    'message' => 'Transaksi pembayaran premium Anda gagal, kedaluwarsa, atau dibatalkan oleh bank.',
                    'is_read' => false,
                ]);
            });
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }

    public function history(Request $request): View
    {
        $user = $request->user();
        $subscriptions = $user->subscriptions()->with('plan')->latest()->paginate(10);

        return view('premium.history', compact('subscriptions', 'user'));
    }
}
