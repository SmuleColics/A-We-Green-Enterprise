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
        Schema::table('assessments', function (Blueprint $table) {
            $table->text('assessment_notes')->nullable()->after('notes');
            $table->timestamp('assessment_form_completed_at')
                ->nullable()
                ->after('assessment_notes');
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn([
                'assessment_notes',
                'assessment_form_completed_at',
            ]);
        });
    }
};
