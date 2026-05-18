<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SystemNotification;

class PartnershipController extends Controller
{
    // 🔥 Eksportir ajukan kerja sama
    public function apply(Request $request, Product $product)
    {
        abort_unless($request->user()?->role === 'exporter', 403);

        $exists = Partnership::query()
            ->where('product_id', $product->id)
            ->where('exporter_id', $request->user()->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return back()->with('success', 'Pengajuan kamu untuk produk ini sudah ada.');
        }

        Partnership::create([
            'product_id' => $product->id,
            'farmer_id' => $product->user_id,
            'exporter_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        SystemNotification::create([
            'user_id' => $product->user_id,
            'title' => 'Permintaan kerja sama baru',
            'message' => $request->user()->name.' mengajukan kerja sama untuk produk '.$product->nama_produk.'.',
            'is_read' => false,
        ]);

        return back()->with('success', 'Pengajuan dikirim!');
    }

    // 🔥 Petani lihat request
    public function requests()
    {
        abort_unless(request()->user()?->role === 'farmer', 403);

        $requests = Partnership::query()
            ->where('farmer_id', auth()->id())
            ->with(['product', 'exporter'])
            ->latest()
            ->get();

        return view('requests', compact('requests'));
    }

    // 🔥 Accept
    public function accept($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'farmer', 403);
        abort_unless($p->farmer_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $p->status = 'accepted';
        $p->save();

        SystemNotification::create([
            'user_id' => $p->exporter_id,
            'title' => 'Pengajuan diterima',
            'message' => 'Pengajuan kerja sama kamu untuk produk '.$p->product->nama_produk.' telah diterima.',
            'is_read' => false,
        ]);

        return back();
    }

    // 🔥 Reject
    public function reject($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'farmer', 403);
        abort_unless($p->farmer_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $p->status = 'rejected';
        $p->save();

        SystemNotification::create([
            'user_id' => $p->exporter_id,
            'title' => 'Pengajuan ditolak',
            'message' => 'Pengajuan kerja sama kamu untuk produk '.$p->product->nama_produk.' ditolak.',
            'is_read' => false,
        ]);

        return back();
    }

    // 🔥 History untuk Eksportir
    public function history()
    {
        abort_unless(request()->user()?->role === 'exporter', 403);

        $history = Partnership::query()
            ->where('exporter_id', auth()->id())
            ->with(['product', 'farmer'])
            ->latest()
            ->get();

        return view('partnerships.history', compact('history'));
    }
}
