<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;

class PremiumAccessService
{
    public function isPremium(User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->account_tier !== 'premium') {
            return false;
        }

        if ($user->premium_expires_at && $user->premium_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function canUploadProduct(User $user): bool
    {
        if ($user->role !== 'farmer') {
            return false;
        }

        if ($this->isPremium($user)) {
            return true;
        }

        $max = (int) config('permissions.limits.free_farmer_max_products', 5);

        return Product::where('user_id', $user->id)->count() < $max;
    }

    public function remainingProductSlots(User $user): ?int
    {
        if ($user->role !== 'farmer' || $this->isPremium($user)) {
            return null;
        }

        $max = (int) config('permissions.limits.free_farmer_max_products', 5);
        $used = Product::where('user_id', $user->id)->count();

        return max(0, $max - $used);
    }

    public function canViewExporterContact(User $user): bool
    {
        return $user->role === 'exporter'
            || $user->role === 'admin'
            || ($user->role === 'farmer' && $this->isPremium($user));
    }

    public function hasFeature(User $user, string $feature): bool
    {
        $allowed = config("permissions.features.{$feature}", []);

        if ($user->role === 'admin' && in_array('admin', $allowed, true)) {
            return true;
        }

        if ($user->role === 'farmer') {
            if (in_array('farmer', $allowed, true)) {
                return true;
            }

            if (in_array('farmer_premium', $allowed, true) && $this->isPremium($user)) {
                return true;
            }
        }

        if ($user->role === 'exporter' && in_array('exporter', $allowed, true)) {
            return true;
        }

        return false;
    }
}
