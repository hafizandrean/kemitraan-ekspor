<?php

namespace App\Http\Controllers;

use App\Services\PremiumAccessService;
use App\Services\TrustedFarmerEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PremiumController extends Controller
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess,
        private readonly TrustedFarmerEligibilityService $trustedFarmer
    ) {}

    public function upgrade(Request $request): View
    {
        $user = $request->user();
        abort_unless(in_array($user->role, ['farmer', 'exporter'], true), 403);

        return view('premium.upgrade', [
            'user' => $user,
            'isPremium' => $this->premiumAccess->isPremium($user),
            'trustedDiscount' => $user->role === 'farmer' && $this->trustedFarmer->qualifiesForPremiumDiscount($user),
            'permissions' => config('permissions.features'),
        ]);
    }

    public function submitVerification(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->role === 'farmer', 403);

        $request->validate([
            'verification_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        if ($user->verification_document_path) {
            Storage::disk('public')->delete($user->verification_document_path);
        }

        $path = $request->file('verification_document')->store('verifications', 'public');

        $user->update([
            'phone' => $request->phone,
            'verification_document_path' => $path,
            'verification_status' => 'pending',
        ]);

        return back()->with('success', 'Dokumen verifikasi dikirim. Tim admin akan meninjau dalam 1-3 hari kerja.');
    }
}
