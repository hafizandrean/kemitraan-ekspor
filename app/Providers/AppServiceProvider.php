<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $unreadCount = 0;

            if (Auth::check()) {
                $unreadCount = Auth::user()
                    ->systemNotifications()
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('unreadNotificationsCount', $unreadCount);
        });
    }
}
