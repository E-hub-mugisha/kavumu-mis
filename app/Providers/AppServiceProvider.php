<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $unreadNotifications = $user->unreadNotifications()->latest()->get();
            $unreadCount = $unreadNotifications->count();

            $view->with([
                'unreadNotifications' => $unreadNotifications,
                'unreadCount' => $unreadCount
            ]);
        }
    });
    }
}
