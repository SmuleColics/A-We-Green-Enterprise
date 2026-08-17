<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('notify_assessment')->default(true)->after('notes');
            $table->boolean('notify_quotation')->default(true)->after('notify_assessment');
            $table->boolean('notify_project')->default(true)->after('notify_quotation');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['notify_assessment', 'notify_quotation', 'notify_project']);
        });
    }
};
