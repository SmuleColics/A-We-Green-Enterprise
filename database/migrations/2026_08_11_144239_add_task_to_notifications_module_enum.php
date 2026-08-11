<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the old enum and create a new one with 'Task' added
            $table->enum('module', ['Assessment', 'Quotation', 'Project', 'Client', 'Account', 'Settings', 'Task'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->enum('module', ['Assessment', 'Quotation', 'Project', 'Client', 'Account', 'Settings'])->change();
        });
    }
};