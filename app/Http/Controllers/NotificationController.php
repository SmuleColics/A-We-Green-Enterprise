<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
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
            if (self::isMutedForUser($userId, $module)) {
                return;
            }

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

    // A client or staff member can opt out of certain notification modules
    // from Settings. Personal (per-user) notifications are filtered out here,
    // at write time. Role-broadcast notifications are a single shared row per
    // role, so they can't be muted at write time — mutedModules() is used
    // again at read time (index/markAllRead/topbar) to filter those per viewer.
    private static function isMutedForUser(int $userId, string $module): bool
    {
        $user = User::find($userId);

        return $user !== null && in_array($module, self::mutedModules($user), true);
    }

    public static function mutedModules(User $user): array
    {
        if ($user->isClient()) {
            $client = $user->client;
            if ($client === null) {
                return [];
            }

            return collect([
                'Assessment' => 'notify_assessment',
                'Quotation' => 'notify_quotation',
                'Project' => 'notify_project',
            ])->reject(fn ($column) => $client->{$column})->keys()->all();
        }

        if ($user->isStaff()) {
            $staff = $user->staff;
            if ($staff === null) {
                return [];
            }

            return collect([
                'Assessment' => 'notify_assessment',
                'Quotation' => 'notify_quotation',
                'Task' => 'notify_task',
                'Project' => 'notify_project',
                'Checklist' => 'notify_checklist',
            ])->reject(fn ($column) => $staff->{$column})->keys()->all();
        }

        return [];
    }

    public function index()
    {
        $user = auth()->user();
        $muted = self::mutedModules($user);

        $notifications = Notification::where(function ($q) use ($user) {
            $q->where('recipient_role', $user->role)
                ->orWhere('user_id', $user->id);
        })
            ->when($muted !== [], fn ($q) => $q->whereNotIn('module', $muted))
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return response()->json($notifications);
    }

    public function markAllRead()
    {
        $user = auth()->user();
        $muted = self::mutedModules($user);

        Notification::where(function ($q) use ($user) {
            $q->where('recipient_role', $user->role)
                ->orWhere('user_id', $user->id);
        })
            ->when($muted !== [], fn ($q) => $q->whereNotIn('module', $muted))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markRead(Notification $notification)
    {
        $user = auth()->user();

        abort_unless(
            $notification->user_id === $user->id || $notification->recipient_role === $user->role,
            403
        );

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
