<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\Product;

class PartnershipController extends Controller
{
    // 🔥 Eksportir ajukan kerja sama
    public function apply($productId)
    {
        $product = Product::findOrFail($productId);

        Partnership::create([
            'product_id' => $product->id,
            'petani_id' => $product->user_id,
            'eksportir_id' => auth()->id(),
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan dikirim!');
    }

    // 🔥 Petani lihat request
    public function requests()
    {
        $requests = Partnership::where('petani_id', auth()->id())->get();
        return view('requests', compact('requests'));
    }

    // 🔥 Accept
    public function accept($id)
    {
        $p = Partnership::findOrFail($id);
        $p->status = 'accepted';
        $p->save();

        return back();
    }

    // 🔥 Reject
    public function reject($id)
    {
        $p = Partnership::findOrFail($id);
        $p->status = 'rejected';
        $p->save();

        return back();
    }
}
