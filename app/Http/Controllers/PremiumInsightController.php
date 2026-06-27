<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumInsightController extends Controller
{
    public function index()
    {
        $commodities = \App\Models\Commodity::with('prices')->withLatestPrice()->get();

        foreach ($commodities as $commodity) {
            $commodity->trend_percentage = 0;
            $commodity->trend_direction = 'neutral';
            
            $sortedPrices = $commodity->prices->sortByDesc('recorded_date')->values();
            if ($sortedPrices->count() >= 2) {
                $current = $sortedPrices[0]->price;
                $previous = $sortedPrices[1]->price;
                
                if ($previous > 0) {
                    $diff = $current - $previous;
                    $commodity->trend_percentage = round(($diff / $previous) * 100, 2);
                    $commodity->trend_direction = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'neutral');
                }
            }
        }

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
