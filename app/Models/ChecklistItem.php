<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['project_id', 'quotation_item_id', 'item_id', 'item_name', 'quantity', 'unit', 'outgoing_quantity', 'outgoing_at', 'is_not_applicable', 'is_completed', 'completed_at', 'returned_quantity', 'returned_at'];
    protected $casts = ['quantity' => 'decimal:2', 'outgoing_quantity' => 'decimal:2', 'returned_quantity' => 'decimal:2', 'outgoing_at' => 'datetime', 'is_not_applicable' => 'boolean', 'is_completed' => 'boolean', 'completed_at' => 'datetime', 'returned_at' => 'datetime'];

    public function project() { return $this->belongsTo(Project::class); }
    public function item() { return $this->belongsTo(Item::class); }
    public function quotationItem() { return $this->belongsTo(QuotationItem::class); }
}
