<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ScheduleSettingsSeeder extends Seeder
{
    /**
     * Seeds today's real scheduling rule (Sunday closed, one booking per
     * half-day slot) as explicit settings — previously the Sunday rule was
     * hardcoded in client-assessment.js only, and slot capacity was never
     * enforced anywhere. Nothing changes for clients on cutover.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'scheduling_working_days'],
            ['value' => json_encode([1, 2, 3, 4, 5, 6]), 'group' => 'scheduling'] // 0=Sun..6=Sat, Sunday closed
        );

        Setting::updateOrCreate(
            ['key' => 'scheduling_max_bookings_per_slot'],
            ['value' => '1', 'group' => 'scheduling']
        );
    }
}
