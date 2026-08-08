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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('client_type');
            $table->string('establishment_type');
            $table->enum('establishment_size', ['small', 'large'])->default('small');
            $table->date('preferred_date');
            $table->enum('time_slot', ['Morning', 'Afternoon', 'Full Day']);
            $table->json('services');
            $table->string('cctv_subtype')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Declined', 'Cancelled'])->default('Pending');
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
