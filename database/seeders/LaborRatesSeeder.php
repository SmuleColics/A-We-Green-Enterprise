<?php

namespace Database\Seeders;

use App\Models\LaborRate;
use Illuminate\Database\Seeder;

class LaborRatesSeeder extends Seeder
{
    /**
     * Seeds today's real labor rates — pulled from the hardcoded
     * AssessmentFormController::laborRate() lookup. Nothing changes for
     * quotations generated on cutover.
     */
    public function run(): void
    {
        $rates = [
            ['service_type' => 'CCTV Setup', 'client_type_condition' => 'Residential', 'rate_percent' => 15],
            ['service_type' => 'CCTV Setup', 'client_type_condition' => null, 'rate_percent' => 20],
            ['service_type' => 'Solar Setup', 'client_type_condition' => null, 'rate_percent' => 25],
            ['service_type' => 'Street Light', 'client_type_condition' => null, 'rate_percent' => 20],
            ['service_type' => 'Public Address', 'client_type_condition' => null, 'rate_percent' => 20],
        ];

        foreach ($rates as $rate) {
            LaborRate::updateOrCreate(
                ['service_type' => $rate['service_type'], 'client_type_condition' => $rate['client_type_condition']],
                ['rate_percent' => $rate['rate_percent'], 'active' => true]
            );
        }
    }
}
