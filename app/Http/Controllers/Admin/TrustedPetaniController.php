<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrustedPetaniController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $farmers = User::query()
            ->where('role', 'petani')
            ->withCount('products')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($builder) use ($q) {
                    $builder->where('name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%');
                });
            })
            ->orderByDesc('is_trusted_petani')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $trustedCount = User::where('role', 'petani')->where('is_trusted_petani', true)->count();

        return view('admin.petani.index', compact('farmers', 'q', 'trustedCount'));
    }

    public function toggle(User $user): RedirectResponse
    {
        abort_unless($user->role === 'petani', 404);

        $isTrusted = ! $user->is_trusted_petani;
        $user->update(['is_trusted_petani' => $isTrusted]);

        $message = $isTrusted
            ? 'Petani berhasil ditandai sebagai Petani Tepercaya.'
            : 'Status Petani Tepercaya dicabut.';

        return back()->with('success', $message);
    }
}
