<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    const REVISION_REASON_CATEGORIES = [
        'Lower the Price',
        'Change Items / Quantity',
        'Change Placement / Location',
        'Change Project Scope',
        'Other',
    ];

    protected $fillable = ['assessment_id', 'reference_number', 'service_type', 'project_title', 'labor_rate', 'items_subtotal', 'labor_total', 'grand_total', 'status', 'sent_at', 'is_archived', 'archived_at', 'revision_reason_category', 'revision_reason', 'revision_requested_at', 'contract_status', 'contract_file', 'contract_uploaded_at'];
    protected $casts = ['labor_rate' => 'decimal:2', 'items_subtotal' => 'decimal:2', 'labor_total' => 'decimal:2', 'grand_total' => 'decimal:2', 'sent_at' => 'datetime', 'is_archived' => 'boolean', 'archived_at' => 'datetime', 'revision_requested_at' => 'datetime', 'contract_uploaded_at' => 'datetime'];
    public function assessment() { return $this->belongsTo(Assessment::class); }
    public function items() { return $this->hasMany(QuotationItem::class); }
    public function project() { return $this->hasOne(Project::class); }
}
