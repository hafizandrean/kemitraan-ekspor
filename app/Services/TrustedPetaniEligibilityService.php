<?php

namespace App\Services;

use App\Models\Partnership;
use App\Models\User;

class TrustedPetaniEligibilityService
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess
    ) {}

    public function evaluate(User $petani): void
    {
        if ($petani->role !== 'petani') {
            return;
        }

        $minCompleted = (int) config('permissions.limits.trusted_min_completed_partnerships', 5);
        $minRating = (int) config('permissions.limits.trusted_min_rating', 5);

        $completedWithTopRating = Partnership::query()
            ->where('petani_id', $petani->id)
            ->where('status', 'completed')
            ->where('rating', '>=', $minRating)
            ->count();

        if ($completedWithTopRating >= $minCompleted) {
            $petani->update(['is_trusted_petani' => true]);
        }
    }

    public function qualifiesForPremiumDiscount(User $petani): bool
    {
        return $petani->is_trusted_petani && ! $this->premiumAccess->isPremium($petani);
    }
}
