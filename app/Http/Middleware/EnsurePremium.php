<?php

namespace App\Http\Middleware;

use App\Services\PremiumAccessService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremium
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $this->premiumAccess->isPremium($user)) {
            if ($request->expectsJson()) {
                abort(403, 'Fitur ini memerlukan akun Premium.');
            }

            return redirect()
                ->route('premium.upgrade')
                ->with('error', 'Upgrade ke Premium untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
