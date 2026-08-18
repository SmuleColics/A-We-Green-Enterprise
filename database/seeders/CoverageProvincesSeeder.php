<?php

namespace Database\Seeders;

use App\Models\CoverageProvince;
use Illuminate\Database\Seeder;

class CoverageProvincesSeeder extends Seeder
{
    /**
     * Seeds today's real coverage list — pulled from the province dropdown
     * hardcoded in client-assessment.blade.php. Nothing changes for
     * clients on cutover.
     */
    public function run(): void
    {
        $provinces = [
            ['region' => 'NCR', 'province' => 'Metro Manila'],
            ['region' => 'Region IV-A (CALABARZON)', 'province' => 'Batangas'],
            ['region' => 'Region IV-A (CALABARZON)', 'province' => 'Cavite'],
            ['region' => 'Region IV-A (CALABARZON)', 'province' => 'Laguna'],
            ['region' => 'Region IV-A (CALABARZON)', 'province' => 'Quezon'],
            ['region' => 'Region IV-A (CALABARZON)', 'province' => 'Rizal'],
        ];

        foreach ($provinces as $order => $p) {
            CoverageProvince::updateOrCreate(
                ['province' => $p['province']],
                ['region' => $p['region'], 'sort_order' => $order, 'active' => true]
            );
        }
    }
}
