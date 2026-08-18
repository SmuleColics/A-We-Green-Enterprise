<?php

namespace App\Providers;

use App\Http\Controllers\NotificationController;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['includes.topbar', 'includes.client-nav'], function ($view) {
            if (! auth()->check()) {
                return;
            }

            $user = auth()->user();
            $muted = NotificationController::mutedModules($user);

            $notifications = Notification::with('notifiable')
                ->where(function ($q) use ($user) {
                    $q->where('recipient_role', $user->role)
                        ->orWhere('user_id', $user->id);
                })
                ->when($muted !== [], fn ($q) => $q->whereNotIn('module', $muted))
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            $view->with([
                'notifications' => $notifications,
                'unreadCount' => $notifications->where('is_read', false)->count(),
            ]);
        });
    }
}
