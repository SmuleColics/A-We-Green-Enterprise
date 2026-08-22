<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * cctv_subtype now holds multiple selections (a client booking CCTV
     * work may need Installation + Relocation in one assessment), so it
     * moves from a single string to a JSON array — same shape as the
     * existing `services` column.
     */
    public function up(): void
    {
        DB::table('assessments')->whereNotNull('cctv_subtype')->get(['id', 'cctv_subtype'])->each(function ($row) {
            DB::table('assessments')->where('id', $row->id)->update([
                'cctv_subtype' => json_encode([$row->cctv_subtype]),
            ]);
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->json('cctv_subtype')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('cctv_subtype')->nullable()->change();
        });

        DB::table('assessments')->whereNotNull('cctv_subtype')->get(['id', 'cctv_subtype'])->each(function ($row) {
            $subtypes = json_decode($row->cctv_subtype, true);
            DB::table('assessments')->where('id', $row->id)->update([
                'cctv_subtype' => $subtypes[0] ?? null,
            ]);
        });
    }
};
