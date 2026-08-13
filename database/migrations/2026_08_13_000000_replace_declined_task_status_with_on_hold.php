<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Completed', 'Declined', 'On Hold') NOT NULL DEFAULT 'Pending'");
        DB::table('tasks')->where('status', 'Declined')->update(['status' => 'On Hold']);
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Completed', 'On Hold') NOT NULL DEFAULT 'Pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Completed', 'Declined', 'On Hold') NOT NULL DEFAULT 'Pending'");
        DB::table('tasks')->where('status', 'On Hold')->update(['status' => 'Declined']);
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Completed', 'Declined') NOT NULL DEFAULT 'Pending'");
    }
};
