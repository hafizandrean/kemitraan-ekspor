<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isPremium()) {
            if ($request->expectsJson()) {
                abort(403, 'Fitur khusus premium');
            }

            return redirect('/premium')
                ->with('error', 'Fitur khusus premium');
        }

        return $next($request);
    }
}
