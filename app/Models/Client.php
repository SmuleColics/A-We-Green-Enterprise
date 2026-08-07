<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'block',
        'lot',
        'street',
        'barangay',
        'province',
        'city',
        'zip_code',
        'notes',
    ];

    // ── Relationships ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── ID Generator ──
    public static function generateClientId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return "CLT-{$year}-".str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
