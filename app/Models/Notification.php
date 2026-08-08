<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'recipient_role', 'module', 'title', 'message',
        'notifiable_id', 'notifiable_type', 'is_read',
    ];

    protected $casts = ['is_read' => 'boolean'];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
