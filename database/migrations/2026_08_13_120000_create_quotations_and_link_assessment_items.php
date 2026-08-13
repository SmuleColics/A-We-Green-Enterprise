<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_items', function (Blueprint $table) {
            $table->foreignId('material_id')->nullable()->after('assessment_id')->constrained()->nullOnDelete();
            $table->decimal('unit_price', 12, 2)->nullable()->after('unit');
        });
        Schema::create('quotations', function (Blueprint $table) {
            $table->id(); $table->foreignId('assessment_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('reference_number')->unique(); $table->string('service_type'); $table->string('project_title');
            $table->decimal('labor_rate', 5, 2); $table->decimal('materials_subtotal', 12, 2); $table->decimal('labor_total', 12, 2); $table->decimal('grand_total', 12, 2);
            $table->string('status')->default('Sent'); $table->timestamp('sent_at')->nullable(); $table->timestamps();
        });
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id(); $table->foreignId('quotation_id')->constrained()->cascadeOnDelete(); $table->foreignId('material_id')->nullable()->constrained()->nullOnDelete();
            $table->string('description'); $table->decimal('quantity', 10, 2); $table->string('unit', 30); $table->decimal('unit_price', 12, 2); $table->decimal('line_total', 12, 2); $table->boolean('is_grouped_accessory')->default(false); $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('quotation_items'); Schema::dropIfExists('quotations');
        Schema::table('assessment_items', function (Blueprint $table) { $table->dropConstrainedForeignId('material_id'); $table->dropColumn('unit_price'); });
    }
};
