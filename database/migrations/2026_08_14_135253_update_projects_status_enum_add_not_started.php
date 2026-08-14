<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE projects MODIFY status ENUM('Active', 'Not Started', 'In Progress', 'On Hold', 'Completed') NOT NULL DEFAULT 'Not Started'");
        DB::table('projects')->where('status', 'Active')->update(['status' => 'Not Started']);
        DB::statement("ALTER TABLE projects MODIFY status ENUM('Not Started', 'In Progress', 'On Hold', 'Completed') NOT NULL DEFAULT 'Not Started'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE projects MODIFY status ENUM('Active', 'Not Started', 'In Progress', 'On Hold', 'Completed') NOT NULL DEFAULT 'Not Started'");
        DB::table('projects')->whereIn('status', ['Not Started', 'In Progress'])->update(['status' => 'Active']);
        DB::statement("ALTER TABLE projects MODIFY status ENUM('Active', 'On Hold', 'Completed') NOT NULL DEFAULT 'Active'");
    }
};
