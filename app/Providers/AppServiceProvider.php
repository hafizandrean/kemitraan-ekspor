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
            $unreadMessagesCount = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $unreadCount = $user
                    ->systemNotifications()
                    ->where('is_read', false)
                    ->count();

                $unreadMessagesCount = \App\Models\Message::where('is_read', false)
                    ->whereHas('conversation', function ($q) use ($user) {
                        $q->where('farmer_id', $user->id)
                          ->orWhere('exporter_id', $user->id);
                    })
                    ->where('sender_id', '!=', $user->id)
                    ->count();
            }

            $view->with('unreadNotificationsCount', $unreadCount)
                 ->with('unreadMessagesCount', $unreadMessagesCount);
        });
    }
}
