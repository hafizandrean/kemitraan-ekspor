<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumInsightController extends Controller
{
    public function index()
    {
        $commodities = \App\Models\Commodity::with('prices')->withLatestPrice()->get();

        // Format data for chart
        $chartData = [];
        foreach ($commodities as $commodity) {
            $data = [];
            foreach ($commodity->prices->sortBy('recorded_date') as $price) {
                $data[] = [
                    'x' => $price->recorded_date->format('Y-m-d'),
                    'y' => (float) $price->price
                ];
            }
            $chartData[] = [
                'label' => $commodity->name . ' (/' . $commodity->unit . ')',
                'data' => $data,
                'borderColor' => $this->getRandomColor(),
                'fill' => false,
                'tension' => 0.1
            ];
        }

        return view('premium.insight', compact('commodities', 'chartData'));
    }

    private function getRandomColor()
    {
        $hash = md5(mt_rand());
        return '#' . substr($hash, 0, 6);
    }
}
