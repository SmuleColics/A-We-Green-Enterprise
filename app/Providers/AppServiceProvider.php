<?php

namespace App\Providers;

use App\Models\Notification;
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
        View::composer('includes.topbar', function ($view) {
            if (auth()->check()) {
                $notifications = Notification::where(function ($q) {
                    $q->where('recipient_role', auth()->user()->role)
                        ->orWhere('user_id', auth()->id());
                })
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();

                $view->with([
                    'notifications' => $notifications,
                    'unreadCount' => $notifications->where('is_read', false)->count(),
                ]);
            }
        });
    }
}
