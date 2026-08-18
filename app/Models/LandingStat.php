<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingStat extends Model
{
    protected $fillable = ['placement', 'icon', 'value', 'label', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];
}
