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
            return $this->petaniDashboard($user);
        }

        return $this->eksportirDashboard($user);
    }

    private function petaniDashboard($user)
    {
        $totalProduk = Product::query()->where('user_id', $user->id)->count();
        $produkAktif = Product::query()->where('user_id', $user->id)->where('jumlah', '>', 0)->count();

        $incoming = Partnership::query()->where('petani_id', $user->id);
        $totalIncoming = (clone $incoming)->count();
        $accepted = (clone $incoming)->where('status', 'accepted')->count();
        $rejected = (clone $incoming)->where('status', 'rejected')->count();

        $produkTerakhir = Product::query()->where('user_id', $user->id)->latest()->first();
        $kerjaSamaTerbaru = Partnership::query()
            ->where('petani_id', $user->id)
            ->with('product', 'eksportir')
            ->latest()
            ->first();

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
        ]);
    }

    private function eksportirDashboard($user)
    {
        $allRequests = Partnership::query()->where('eksportir_id', $user->id);
        $totalPengajuan = (clone $allRequests)->count();
        $kerjaSamaAktif = (clone $allRequests)->where('status', 'accepted')->count();

        $pengajuanTerbaru = Partnership::query()
            ->where('eksportir_id', $user->id)
            ->with('product', 'petani')
            ->latest()
            ->first();

        $favoritTerbaru = $user->favorites()->latest('favorites.created_at')->first();

        $dailyLimit = $user->isPremium() ? null : 3;
        $usedToday = Partnership::query()
            ->where('eksportir_id', $user->id)
            ->whereDate('created_at', today())
            ->count();
        $remaining = $dailyLimit === null ? null : max(0, $dailyLimit - $usedToday);

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
        ]);
    }
}

