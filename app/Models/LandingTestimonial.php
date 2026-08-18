<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingTestimonial extends Model
{
    protected $fillable = ['name', 'role', 'quote', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];
}
