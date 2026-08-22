<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * "Labor" covers flat-priced service charges that aren't a physical
     * good — e.g. fiber termination, per-camera rehab labor — so they can
     * be itemized on a quotation like any material (qty x unit price)
     * without the percentage labor rate being applied on top of them,
     * since the flat price already IS the labor charge.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE materials MODIFY category ENUM('CCTV', 'Solar', 'PA System', 'General', 'Labor')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE materials MODIFY category ENUM('CCTV', 'Solar', 'PA System', 'General')");
    }
};
