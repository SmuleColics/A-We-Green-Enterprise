<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->unique()->constrained('quotations')->cascadeOnDelete();
            $table->string('reference_number')->unique();
            $table->string('project_title');
            $table->string('service_type');
            $table->string('location')->nullable();
            $table->decimal('total_budget', 12, 2);
            $table->enum('status', ['Active', 'On Hold', 'Completed'])->default('Active');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
