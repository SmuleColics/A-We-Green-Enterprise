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
    Schema::create('staff', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('staff_id')->unique(); // EMP-2026-001, SEC-2026-001, ADM-2026-001
      $table->date('date_joined')->nullable();

      // Address
      $table->string('block')->nullable();
      $table->string('lot')->nullable();
      $table->string('street')->nullable(); // Street / Purok / Sitio
      $table->string('barangay');
      $table->string('province');
      $table->string('city');
      $table->string('zip_code')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('staff');
  }
};
