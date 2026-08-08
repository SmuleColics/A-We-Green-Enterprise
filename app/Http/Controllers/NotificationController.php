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
        string|array|null $recipientRole = 'admin',
        ?Model $notifiable = null,
        ?int $userId = null
    ): void {
        // Targeting a specific user (e.g. notifying one client) — single row, no role needed
        if ($userId !== null) {
            Notification::create([
                'user_id' => $userId,
                'recipient_role' => null,
                'module' => $module,
                'title' => $title,
                'message' => $message,
                'notifiable_id' => $notifiable?->id,
                'notifiable_type' => $notifiable ? get_class($notifiable) : null,
                'is_read' => false,
            ]);

            return;
        }

        // Broadcasting to one or more roles — one row per role, so each role's
        // bell/unread-count query only ever needs to check its own rows.
        $roles = is_array($recipientRole) ? $recipientRole : [$recipientRole];

        foreach ($roles as $role) {
            Notification::create([
                'user_id' => null,
                'recipient_role' => $role,
                'module' => $module,
                'title' => $title,
                'message' => $message,
                'notifiable_id' => $notifiable?->id,
                'notifiable_type' => $notifiable ? get_class($notifiable) : null,
                'is_read' => false,
            ]);
        }
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
