<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotSuspended
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            if ($user->isBanned()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda telah diblokir permanen oleh admin.',
                ]);
            }

            if ($user->isSuspended()) {
                $routeName = $request->route() ? $request->route()->getName() : '';
                
                $isChatRoute = str_starts_with($routeName, 'chat.') || str_contains($routeName, 'chat');
                $isRestrictedRoute = $isChatRoute || $routeName === 'partnerships.apply';

                if ($isRestrictedRoute || $request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH') || $request->isMethod('DELETE')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => 'Tindakan dibatasi. Akun Anda sedang ditangguhkan (suspended) oleh admin.'
                        ], 403);
                    }

                    return redirect()->route('dashboard')->with('error', 'Akses dibatasi. Akun Anda sedang ditangguhkan (suspended) oleh admin.');
                }
            }
        }

        return $next($request);
    }
}
