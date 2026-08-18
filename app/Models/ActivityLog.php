<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'module',
        'action',
        'description',
        'ip_address',
        'is_archived',
        'archived_at',
        'archived_by',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    // ── Relationships ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    // ── Scopes ──
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
