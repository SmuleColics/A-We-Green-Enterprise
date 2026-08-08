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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null = role broadcast
            $table->enum('recipient_role', ['super_admin', 'admin', 'secretary', 'employee'])->nullable();
            $table->enum('module', ['Assessment', 'Quotation', 'Project', 'Client', 'Account', 'Settings']);
            $table->string('title');
            $table->string('message');
            $table->nullableMorphs('notifiable'); // links back to the Assessment/Quotation/etc record
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
