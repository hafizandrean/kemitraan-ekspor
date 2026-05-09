<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\Product;

class PartnershipController extends Controller
{
    // 🔥 Eksportir ajukan kerja sama
    public function apply(Request $request, Product $product)
    {
        abort_unless($request->user()?->role === 'eksportir', 403);

        $exists = Partnership::query()
            ->where('product_id', $product->id)
            ->where('eksportir_id', $request->user()->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return back()->with('success', 'Pengajuan kamu untuk produk ini sudah ada.');
        }

        Partnership::create([
            'product_id' => $product->id,
            'petani_id' => $product->user_id,
            'eksportir_id' => $request->user()->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan dikirim!');
    }

    // 🔥 Petani lihat request
    public function requests()
    {
        abort_unless(request()->user()?->role === 'petani', 403);

        $requests = Partnership::query()
            ->where('petani_id', auth()->id())
            ->with(['product', 'eksportir'])
            ->latest()
            ->get();

        return view('requests', compact('requests'));
    }

    // 🔥 Accept
    public function accept($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'petani', 403);
        abort_unless($p->petani_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $p->status = 'accepted';
        $p->save();

        return back();
    }

    // 🔥 Reject
    public function reject($id)
    {
        $p = Partnership::findOrFail($id);
        abort_unless(request()->user()?->role === 'petani', 403);
        abort_unless($p->petani_id === auth()->id(), 403);
        abort_unless($p->status === 'pending', 422);

        $p->status = 'rejected';
        $p->save();

        return back();
    }
}
