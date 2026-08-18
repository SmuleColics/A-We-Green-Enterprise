<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstablishmentType extends Model
{
    protected $fillable = ['client_type_id', 'name', 'icon', 'size', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }
}
