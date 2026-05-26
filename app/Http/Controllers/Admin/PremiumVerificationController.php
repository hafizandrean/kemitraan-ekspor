<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PremiumVerificationController extends Controller
{
    public function index(): View
    {
        $pending = User::query()
            ->where('role', 'farmer')
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.premium-verifications.index', compact('pending'));
    }

    public function approve(User $user): RedirectResponse
    {
        abort_unless($user->role === 'farmer', 404);

        $user->update([
            'verification_status' => 'approved',
            'account_tier' => 'premium',
            'premium_expires_at' => now()->addYear(),
        ]);

        return back()->with('success', 'Premium disetujui untuk '.$user->name.'.');
    }

    public function reject(User $user): RedirectResponse
    {
        abort_unless($user->role === 'farmer', 404);

        $user->update(['verification_status' => 'rejected']);

        return back()->with('success', 'Verifikasi ditolak.');
    }
}
