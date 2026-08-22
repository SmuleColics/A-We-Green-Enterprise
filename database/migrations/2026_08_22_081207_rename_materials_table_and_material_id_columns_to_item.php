<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Domain terminology rename: the catalog previously called "Material"
     * becomes "Item" (it already holds non-physical Labor entries, so
     * "Material" no longer fit). AssessmentItem/QuotationItem/ChecklistItem
     * are a distinct concept (a line entry referencing the catalog) and are
     * NOT renamed here — only their material_id FK becomes item_id.
     */
    public function up(): void
    {
        Schema::rename('materials', 'items');

        Schema::table('assessment_items', function (Blueprint $table) {
            $table->renameColumn('material_id', 'item_id');
        });

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->renameColumn('material_id', 'item_id');
        });

        Schema::table('checklist_items', function (Blueprint $table) {
            $table->renameColumn('material_id', 'item_id');
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->renameColumn('materials_subtotal', 'items_subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'material_id');
        });

        Schema::table('quotation_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'material_id');
        });

        Schema::table('assessment_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'material_id');
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->renameColumn('items_subtotal', 'materials_subtotal');
        });

        Schema::rename('items', 'materials');
    }
};
