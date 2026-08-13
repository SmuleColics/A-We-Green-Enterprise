<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment',
            'Quotation',
            'Project',
            'Checklist',
            'Employee',
            'Client',
            'Staff',
            'Settings',
            'Auth',
            'Task',
            'Material'
        )");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE activity_logs MODIFY module ENUM(
            'Assessment',
            'Quotation',
            'Project',
            'Checklist',
            'Employee',
            'Client',
            'Staff',
            'Settings',
            'Auth',
            'Task'
        )");
    }
};