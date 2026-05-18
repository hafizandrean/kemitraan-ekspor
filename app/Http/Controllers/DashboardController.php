<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'farmer') {
            return redirect()->route('dashboard.farmer');
        } elseif ($user->role === 'exporter') {
            return redirect()->route('dashboard.exporter');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        abort(403, 'Unauthorized action.');
    }

    public function farmer(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'farmer', 403);

        $totalProduk = Product::query()->where('user_id', $user->id)->count();
        $produkAktif = Product::query()->where('user_id', $user->id)->where('jumlah', '>', 0)->count();

        $incoming = Partnership::query()->where('farmer_id', $user->id);
        $totalIncoming = (clone $incoming)->count();
        $accepted = (clone $incoming)->where('status', 'accepted')->count();
        $rejected = (clone $incoming)->where('status', 'rejected')->count();

        $produkTerakhir = Product::query()->where('user_id', $user->id)->latest()->first();
        $kerjaSamaTerbaru = Partnership::query()
            ->where('farmer_id', $user->id)
            ->with('product', 'exporter')
            ->latest()
            ->first();

        // Data for Chart.js (Last 6 months)
        $months = collect(range(5, 0))->map(function ($i) {
            return today()->subMonths($i)->format('M Y');
        });

        $chartData = [
            'labels' => $months->values()->toArray(),
            'products' => $months->map(function ($month, $i) use ($user) {
                return Product::where('user_id', $user->id)
                    ->whereMonth('created_at', today()->subMonths(5 - $i)->month)
                    ->count();
            })->values()->toArray(),
            'partnerships' => $months->map(function ($month, $i) use ($user) {
                return Partnership::where('farmer_id', $user->id)
                    ->whereMonth('created_at', today()->subMonths(5 - $i)->month)
                    ->count();
            })->values()->toArray(),
        ];

        return view('dashboard', [
            'dashboardType' => 'farmer',
            'stats' => [
                'total_produk' => $totalProduk,
                'produk_aktif' => $produkAktif,
                'incoming_total' => $totalIncoming,
                'incoming_accepted' => $accepted,
                'incoming_rejected' => $rejected,
            ],
            'latest' => [
                'produk' => $produkTerakhir,
                'kerja_sama' => $kerjaSamaTerbaru,
            ],
            'chartData' => $chartData,
        ]);
    }

    public function exporter(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'exporter', 403);

        $allRequests = Partnership::query()->where('exporter_id', $user->id);
        $totalPengajuan = (clone $allRequests)->count();
        $kerjaSamaAktif = (clone $allRequests)->where('status', 'accepted')->count();

        $pengajuanTerbaru = Partnership::query()
            ->where('exporter_id', $user->id)
            ->with('product', 'farmer')
            ->latest()
            ->first();

        $favoritTerbaru = $user->favorites()->latest('favorites.created_at')->first();

        $dailyLimit = $user->isPremium() ? null : 3;
        $usedToday = Partnership::query()
            ->where('exporter_id', $user->id)
            ->whereDate('created_at', today())
            ->count();
        $remaining = $dailyLimit === null ? null : max(0, $dailyLimit - $usedToday);

        // Data for Chart.js (Last 6 months)
        $months = collect(range(5, 0))->map(function ($i) {
            return today()->subMonths($i)->format('M Y');
        });

        $chartData = [
            'labels' => $months->values()->toArray(),
            'pengajuan' => $months->map(function ($month, $i) use ($user) {
                return Partnership::where('exporter_id', $user->id)
                    ->whereMonth('created_at', today()->subMonths(5 - $i)->month)
                    ->count();
            })->values()->toArray(),
        ];

        return view('dashboard', [
            'dashboardType' => 'exporter',
            'stats' => [
                'total_pengajuan' => $totalPengajuan,
                'kerja_sama_aktif' => $kerjaSamaAktif,
            ],
            'latest' => [
                'pengajuan' => $pengajuanTerbaru,
                'favorit' => $favoritTerbaru,
            ],
            'account' => [
                'tier' => $user->account_tier,
                'is_premium' => $user->isPremium(),
                'remaining_limit' => $remaining,
            ],
            'chartData' => $chartData,
        ]);
    }

    public function admin(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'admin', 403);

        $totalUser = \App\Models\User::count();
        $totalFarmer = \App\Models\User::where('role', 'farmer')->count();
        $totalExporter = \App\Models\User::where('role', 'exporter')->count();
        $totalProduk = \App\Models\Product::count();
        $totalPartnership = \App\Models\Partnership::count();

        return view('dashboard', [
            'dashboardType' => 'admin',
            'stats' => [
                'total_user' => $totalUser,
                'total_farmer' => $totalFarmer,
                'total_exporter' => $totalExporter,
                'total_produk' => $totalProduk,
                'total_partnership' => $totalPartnership,
            ]
        ]);
    }
}

