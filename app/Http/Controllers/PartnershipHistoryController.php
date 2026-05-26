<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless(in_array($user->role, ['farmer', 'exporter'], true), 403);

        $query = Partnership::query()
            ->with(['product', 'farmer', 'exporter']);

        if ($user->role === 'farmer') {
            $query->where('farmer_id', $user->id);
        } else {
            $query->where('exporter_id', $user->id);
        }

        if ($year = $request->query('year')) {
            $query->whereYear('created_at', $year);
        }

        if ($statusFilter = $request->query('status_filter')) {
            if ($statusFilter === 'berhasil') {
                $query->where('status', 'completed');
            } elseif ($statusFilter === 'gagal') {
                $query->whereIn('status', ['rejected', 'cancelled']);
            } elseif ($statusFilter === 'aktif') {
                $query->whereIn('status', ['pending', 'active']);
            }
        }

        if ($partner = trim((string) $request->query('partner', ''))) {
            $query->where(function ($q) use ($partner, $user) {
                if ($user->role === 'farmer') {
                    $q->whereHas('exporter', fn ($e) => $e->where('name', 'like', "%{$partner}%"));
                } else {
                    $q->whereHas('farmer', fn ($f) => $f->where('name', 'like', "%{$partner}%"));
                }
            });
        }

        $history = $query->latest()->paginate(10)->withQueryString();

        $years = Partnership::query()
            ->when($user->role === 'farmer', fn ($q) => $q->where('farmer_id', $user->id))
            ->when($user->role === 'exporter', fn ($q) => $q->where('exporter_id', $user->id))
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('partnerships.history', [
            'history' => $history,
            'years' => $years,
            'role' => $user->role,
        ]);
    }
}
