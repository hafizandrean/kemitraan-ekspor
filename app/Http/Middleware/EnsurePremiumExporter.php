<?php

namespace App\Http\Middleware;

use App\Services\PremiumAccessService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremiumExporter
{
    public function __construct(
        private readonly PremiumAccessService $premiumAccess
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'eksportir' && !$this->premiumAccess->isPremium($user)) {
            if ($request->expectsJson()) {
                abort(403, 'Fitur chat memerlukan akun Premium.');
            }

            return redirect()
                ->route('premium.index')
                ->with('error', 'Upgrade ke Premium untuk mengakses fitur chat.');
        }

        return $next($request);
    }
}
