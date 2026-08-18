<?php

namespace Database\Seeders;

use App\Models\AssessmentService;
use Illuminate\Database\Seeder;

class AssessmentServicesSeeder extends Seeder
{
    /**
     * Seeds today's real assessment services and CCTV's sub-types — pulled
     * from the live booking wizard (client-assessment.blade.php Step 3).
     * Nothing changes for clients on cutover.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'CCTV Setup', 'icon' => 'videocam', 'has_subtypes' => true, 'subtypes' => [
                'Installation', 'Relocation', 'Rehabilitation', 'Restoration',
            ]],
            ['name' => 'Solar Setup', 'icon' => 'wb_sunny', 'has_subtypes' => false, 'subtypes' => []],
            ['name' => 'Street Light', 'icon' => 'light', 'has_subtypes' => false, 'subtypes' => []],
            ['name' => 'Public Address', 'icon' => 'speaker', 'has_subtypes' => false, 'subtypes' => []],
        ];

        foreach ($data as $order => $entry) {
            $service = AssessmentService::updateOrCreate(
                ['name' => $entry['name']],
                ['icon' => $entry['icon'], 'has_subtypes' => $entry['has_subtypes'], 'sort_order' => $order, 'active' => true]
            );

            foreach ($entry['subtypes'] as $subOrder => $name) {
                $service->subtypes()->updateOrCreate(['name' => $name], ['sort_order' => $subOrder, 'active' => true]);
            }
        }
    }
}
