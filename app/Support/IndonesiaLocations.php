<?php

namespace App\Support;

class IndonesiaLocations
{
    public static function all(): array
    {
        $locations = config('indonesia.locations', []);

        return collect($locations)->unique()->sort()->values()->all();
    }
}
