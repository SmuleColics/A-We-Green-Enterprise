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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('contract_status')->nullable()->after('revision_requested_at');
            $table->string('contract_file')->nullable()->after('contract_status');
            $table->timestamp('contract_uploaded_at')->nullable()->after('contract_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['contract_status', 'contract_file', 'contract_uploaded_at']);
        });
    }
};
