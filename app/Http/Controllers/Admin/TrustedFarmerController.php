<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrustedFarmerController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $farmers = User::query()
            ->where('role', 'farmer')
            ->withCount('products')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($builder) use ($q) {
                    $builder->where('name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%');
                });
            })
            ->orderByDesc('is_trusted_farmer')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $trustedCount = User::where('role', 'farmer')->where('is_trusted_farmer', true)->count();

        return view('admin.farmers.index', compact('farmers', 'q', 'trustedCount'));
    }

    public function toggle(User $user): RedirectResponse
    {
        abort_unless($user->role === 'farmer', 404);

        $isTrusted = ! $user->is_trusted_farmer;
        $user->update(['is_trusted_farmer' => $isTrusted]);

        $message = $isTrusted
            ? 'Petani berhasil ditandai sebagai Trusted Farmer.'
            : 'Status Trusted Farmer dicabut.';

        return back()->with('success', $message);
    }
}
