<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Widen the enum first so existing 'Material' rows stay valid while
        // they're being relabeled.
        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment', 'Quotation', 'Project', 'Checklist', 'Employee',
            'Client', 'Staff', 'Settings', 'Auth', 'Task', 'Material', 'Item'
        )");

        DB::table('activity_logs')->where('module', 'Material')->update(['module' => 'Item']);

        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment', 'Quotation', 'Project', 'Checklist', 'Employee',
            'Client', 'Staff', 'Settings', 'Auth', 'Task', 'Item'
        )");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment', 'Quotation', 'Project', 'Checklist', 'Employee',
            'Client', 'Staff', 'Settings', 'Auth', 'Task', 'Item', 'Material'
        )");

        DB::table('activity_logs')->where('module', 'Item')->update(['module' => 'Material']);

        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment', 'Quotation', 'Project', 'Checklist', 'Employee',
            'Client', 'Staff', 'Settings', 'Auth', 'Task', 'Material'
        )");
    }
};
