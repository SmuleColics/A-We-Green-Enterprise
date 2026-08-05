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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('client_id')->unique(); // CLT-2026-001

            // Service location
            $table->string('block')->nullable();
            $table->string('lot')->nullable();
            $table->string('street')->nullable(); // Street / Purok / Sitio
            $table->string('barangay');
            $table->string('province');
            $table->string('city');
            $table->string('zip_code')->nullable();
            $table->text('notes')->nullable(); // special instructions

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
