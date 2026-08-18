<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'default_size', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function establishmentTypes()
    {
        return $this->hasMany(EstablishmentType::class)->orderBy('sort_order');
    }
}
