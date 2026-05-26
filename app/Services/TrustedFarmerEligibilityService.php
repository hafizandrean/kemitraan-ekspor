<?php

namespace App\Services;

use App\Models\Partnership;
use App\Models\User;

class TrustedFarmerEligibilityService
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess
    ) {}

    public function evaluate(User $farmer): void
    {
        if ($farmer->role !== 'farmer') {
            return;
        }

        $minCompleted = (int) config('permissions.limits.trusted_min_completed_partnerships', 5);
        $minRating = (int) config('permissions.limits.trusted_min_rating', 5);

        $completedWithTopRating = Partnership::query()
            ->where('farmer_id', $farmer->id)
            ->where('status', 'completed')
            ->where('rating', '>=', $minRating)
            ->count();

        if ($completedWithTopRating >= $minCompleted) {
            $farmer->update(['is_trusted_farmer' => true]);
        }
    }

    public function qualifiesForPremiumDiscount(User $farmer): bool
    {
        return $farmer->is_trusted_farmer && ! $this->premiumAccess->isPremium($farmer);
    }
}
