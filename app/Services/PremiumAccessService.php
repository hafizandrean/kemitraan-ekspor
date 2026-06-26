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

        // Check if there is an active subscription in database
        $hasActiveSub = $user->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->exists();

        if ($hasActiveSub) {
            return true;
        }

        // Fallback for user table fields
        return $user->account_tier === 'premium' &&
            (! $user->premium_expires_at || $user->premium_expires_at->isFuture());
    }

    public function canUploadProduct(User $user): bool
    {
        if ($user->role !== 'petani') {
            return false;
        }

        if ($this->isPremium($user)) {
            return true;
        }

        $max = (int) config('permissions.limits.free_petani_max_products', 5);

        return Product::where('user_id', $user->id)->count() < $max;
    }

    public function remainingProductSlots(User $user): ?int
    {
        if ($user->role !== 'petani' || $this->isPremium($user)) {
            return null;
        }

        $max = (int) config('permissions.limits.free_petani_max_products', 5);
        $used = Product::where('user_id', $user->id)->count();

        return max(0, $max - $used);
    }

    public function canViewExporterContact(User $user): bool
    {
        return $user->role === 'eksportir'
            || $user->role === 'admin'
            || ($user->role === 'petani' && $this->isPremium($user));
    }

    public function hasFeature(User $user, string $feature): bool
    {
        $allowed = config("permissions.features.{$feature}", []);

        if ($user->role === 'admin' && in_array('admin', $allowed, true)) {
            return true;
        }

        if ($user->role === 'petani') {
            if (in_array('petani', $allowed, true)) {
                return true;
            }

            if (in_array('petani_premium', $allowed, true) && $this->isPremium($user)) {
                return true;
            }
        }

        if ($user->role === 'eksportir' && in_array('eksportir', $allowed, true)) {
            return true;
        }

        return false;
    }
}
