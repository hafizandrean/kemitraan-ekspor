<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use App\Models\Product;
use App\Models\SystemNotification;
use App\Services\PartnershipWorkflowService;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function __construct(
        private readonly PartnershipWorkflowService $workflow
    ) {}

    public function apply(Request $request, Product $product)
    {
        abort_unless($request->user()?->role === 'eksportir', 403);

        if (!$request->user()->hasPremiumAccess()) {
            $countThisMonth = Partnership::where('eksportir_id', $request->user()->id)
                ->where('created_at', '>=', now()->startOfMonth())
                ->count();
            if ($countThisMonth >= 5) {
                return redirect()->route('premium.index')
                    ->with('error', 'Batas pengajuan kemitraan Free tercapai (maks. 5 pengajuan per bulan). Upgrade ke Premium untuk unlimited.');
            }
        }

        $exists = Partnership::query()
            ->where('product_id', $product->id)
            ->where('eksportir_id', $request->user()->id)
            ->whereIn('status', ['pending', 'active', 'completed'])
            ->exists();

        if ($exists) {
            return back()->with('success', 'Pengajuan kamu untuk produk ini sudah ada.');
        }

        $partnership = Partnership::create([
            'product_id' => $product->id,
            'petani_id' => $product->user_id,
            'eksportir_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        $this->workflow->logStage($partnership, 'pending', $request->user(), 'Pengajuan kerja sama dikirim.');

        SystemNotification::create([
            'user_id' => $product->user_id,
            'title' => 'Permintaan kerja sama baru',
            'message' => $request->user()->name.' mengajukan kerja sama untuk produk '.$product->nama_produk.'.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Pengajuan dikirim!');
    }

    public function requests()
    {
        abort_unless(request()->user()?->role === 'petani', 403);

        $requests = Partnership::query()
            ->where('petani_id', auth()->id())
            ->where('status', 'pending')
            ->with(['product', 'eksportir'])
            ->latest()
            ->get();

        return view('requests', compact('requests'));
    }

    public function accept($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'petani', 403);
        abort_unless($p->petani_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $this->workflow->startActivePartnership($p, request()->user());

        SystemNotification::create([
            'user_id' => $p->eksportir_id,
            'title' => 'Pengajuan diterima',
            'message' => 'Pengajuan kerja sama kamu untuk produk '.$p->product->nama_produk.' telah diterima.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Kerja sama dimulai. Lanjutkan di Riwayat Kerja Sama.');
    }

    public function reject($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'petani', 403);
        abort_unless($p->petani_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $p->update(['status' => 'rejected']);
        $this->workflow->logStage($p, 'rejected', request()->user(), 'Pengajuan ditolak.');

        SystemNotification::create([
            'user_id' => $p->eksportir_id,
            'title' => 'Pengajuan ditolak',
            'message' => 'Pengajuan kerja sama kamu untuk produk '.$p->product->nama_produk.' ditolak.',
            'is_read' => false,
        ]);

        return back();
    }
}
