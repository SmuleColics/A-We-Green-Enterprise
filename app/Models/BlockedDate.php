<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedDate extends Model
{
    protected $fillable = ['date', 'label'];

    protected $casts = ['date' => 'date'];
}
