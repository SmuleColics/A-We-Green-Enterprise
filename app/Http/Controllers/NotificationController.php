<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationController extends Controller
{
    // ── Static helper — call this from any controller ──
    public static function notify(
        string $module,
        string $title,
        string $message,
        ?string $recipientRole = 'admin',
        ?Model $notifiable = null,
        ?int $userId = null
    ): void {
        Notification::create([
            'user_id' => $userId,
            'recipient_role' => $userId ? null : $recipientRole,
            'module' => $module,
            'title' => $title,
            'message' => $message,
            'notifiable_id' => $notifiable?->id,
            'notifiable_type' => $notifiable ? get_class($notifiable) : null,
            'is_read' => false,
        ]);
    }

    public function index()
    {
        $notifications = Notification::where('recipient_role', auth()->user()->role)
            ->orWhere('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return response()->json($notifications);
    }

    public function markAllRead()
    {
        Notification::where('recipient_role', auth()->user()->role)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
