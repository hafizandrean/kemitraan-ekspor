<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = \App\Models\Commodity::withLatestPrice()->paginate(10);
        return view('admin.commodities.index', compact('commodities'));
    }

    public function create()
    {
        return view('admin.commodities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'initial_price' => 'required|numeric|min:0',
            'recorded_date' => 'required|date',
        ]);

        $commodity = \App\Models\Commodity::create([
            'name' => $validated['name'],
            'unit' => $validated['unit'],
        ]);

        $commodity->prices()->create([
            'price' => $validated['initial_price'],
            'recorded_date' => $validated['recorded_date'],
        ]);

        return redirect()->route('admin.commodities.index')->with('success', 'Commodity created successfully.');
    }

    public function show(\App\Models\Commodity $commodity)
    {
        $prices = $commodity->prices()->orderBy('recorded_date', 'desc')->get();
        return view('admin.commodities.show', compact('commodity', 'prices'));
    }

    public function edit(\App\Models\Commodity $commodity)
    {
        return view('admin.commodities.edit', compact('commodity'));
    }

    public function update(Request $request, \App\Models\Commodity $commodity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
        ]);

        $commodity->update($validated);

        return redirect()->route('admin.commodities.index')->with('success', 'Commodity updated successfully.');
    }

    public function storePrice(Request $request, \App\Models\Commodity $commodity)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'recorded_date' => 'required|date',
        ]);

        $commodity->prices()->create($validated);

        return redirect()->route('admin.commodities.show', $commodity)->with('success', 'Price recorded successfully.');
    }

    public function destroy(\App\Models\Commodity $commodity)
    {
        $commodity->delete();
        return redirect()->route('admin.commodities.index')->with('success', 'Commodity deleted successfully.');
    }
}
