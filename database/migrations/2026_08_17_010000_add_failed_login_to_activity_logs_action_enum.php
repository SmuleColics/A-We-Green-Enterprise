<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE activity_logs MODIFY action ENUM(
            'Created',
            'Updated',
            'Archived',
            'Restored',
            'Deleted',
            'Requested',
            'Approved',
            'Rejected',
            'Login',
            'Logout',
            'Failed Login'
        )");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE activity_logs MODIFY action ENUM(
            'Created',
            'Updated',
            'Archived',
            'Restored',
            'Deleted',
            'Requested',
            'Approved',
            'Rejected',
            'Login',
            'Logout'
        )");
    }
};
