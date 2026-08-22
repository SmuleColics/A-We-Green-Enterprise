<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = ['quotation_id', 'item_id', 'description', 'quantity', 'unit', 'unit_price', 'line_total', 'is_grouped_accessory'];
    protected $casts = ['quantity' => 'decimal:2', 'unit_price' => 'decimal:2', 'line_total' => 'decimal:2', 'is_grouped_accessory' => 'boolean'];
    public function quotation() { return $this->belongsTo(Quotation::class); }
    public function item() { return $this->belongsTo(Item::class); }
}
