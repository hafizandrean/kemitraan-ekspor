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

        if ($user->role === 'petani') {
            return redirect()->route('dashboard.petani');
        } elseif ($user->role === 'eksportir') {
            return redirect()->route('dashboard.eksportir');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        abort(403, 'Unauthorized action.');
    }

    public function petani(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'petani', 403);

        $totalProduk = Product::query()->where('user_id', $user->id)->count();
        $produkAktif = Product::query()->where('user_id', $user->id)->where('jumlah', '>', 0)->count();

        $incoming = Partnership::query()->where('petani_id', $user->id);
        $totalIncoming = (clone $incoming)->count();
        $accepted = (clone $incoming)->whereIn('status', ['active', 'completed'])->count();
        $rejected = (clone $incoming)->where('status', 'rejected')->count();

        $produkTerakhir = Product::query()->where('user_id', $user->id)->latest()->first();
        $kerjaSamaTerbaru = Partnership::query()
            ->where('petani_id', $user->id)
            ->with('product', 'eksportir')
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
                return Partnership::where('petani_id', $user->id)
                    ->whereMonth('created_at', today()->subMonths(5 - $i)->month)
                    ->count();
            })->values()->toArray(),
        ];

        return view('dashboard', [
            'dashboardType' => 'petani',
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

    public function eksportir(Request $request)
    {
        $user = $request->user();
        abort_unless($user->role === 'eksportir', 403);

        $allRequests = Partnership::query()->where('eksportir_id', $user->id);
        $totalPengajuan = (clone $allRequests)->count();
        $kerjaSamaAktif = (clone $allRequests)->whereIn('status', ['active', 'completed'])->count();

        $pengajuanTerbaru = Partnership::query()
            ->where('eksportir_id', $user->id)
            ->with('product', 'petani')
            ->latest()
            ->first();

        $favoritTerbaru = $user->favorites()->latest('favorites.created_at')->first();

        $monthlyLimit = $user->hasPremiumAccess() ? null : 5;
        $usedThisMonth = Partnership::query()
            ->where('eksportir_id', $user->id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        $remaining = $monthlyLimit === null ? null : max(0, $monthlyLimit - $usedThisMonth);

        // Data for Chart.js (Last 6 months)
        $months = collect(range(5, 0))->map(function ($i) {
            return today()->subMonths($i)->format('M Y');
        });

        $chartData = [
            'labels' => $months->values()->toArray(),
            'pengajuan' => $months->map(function ($month, $i) use ($user) {
                return Partnership::where('eksportir_id', $user->id)
                    ->whereMonth('created_at', today()->subMonths(5 - $i)->month)
                    ->count();
            })->values()->toArray(),
        ];

        return view('dashboard', [
            'dashboardType' => 'eksportir',
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
        $totalFarmer = \App\Models\User::where('role', 'petani')->count();
        $totalExporter = \App\Models\User::where('role', 'eksportir')->count();
        $totalProduk = \App\Models\Product::count();
        $totalPartnership = \App\Models\Partnership::count();
        $totalCategories = \App\Models\Category::count();
        $recommendedProduk = \App\Models\Product::where('is_recommended', true)->count();
        $trustedFarmers = \App\Models\User::where('role', 'petani')->where('is_trusted_petani', true)->count();

        return view('dashboard', [
            'dashboardType' => 'admin',
            'stats' => [
                'total_user' => $totalUser,
                'total_farmer' => $totalFarmer,
                'total_exporter' => $totalExporter,
                'total_produk' => $totalProduk,
                'total_partnership' => $totalPartnership,
                'total_categories' => $totalCategories,
                'recommended_produk' => $recommendedProduk,
                'trusted_farmers' => $trustedFarmers,
            ]
        ]);
    }
}
