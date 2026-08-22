<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ties together sibling Assessment rows created from one wizard
     * submission (one row per selected service, up to 2) so they can be
     * recognized as "the same physical visit" for slot-capacity counting
     * and for the "part of the same visit" UI hint, without merging them
     * back into one record downstream.
     */
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->uuid('booking_group_id')->nullable()->after('client_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn('booking_group_id');
        });
    }
};
