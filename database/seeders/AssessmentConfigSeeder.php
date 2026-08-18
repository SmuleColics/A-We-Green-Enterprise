<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Seeder;

class AssessmentConfigSeeder extends Seeder
{
    /**
     * Seeds today's real client types and establishment types — pulled from
     * the live booking wizard (client-assessment.blade.php step 1 cards and
     * client-assessment.js estabOptions), the richest of the three
     * previously-independent copies. Nothing changes for clients on cutover.
     */
    public function run(): void
    {
        $data = [
            'Residential' => [
                'description' => 'Individual homeowner',
                'icon' => 'home',
                'default_size' => 'small',
                'establishments' => [
                    ['name' => 'Home / Residence', 'icon' => 'home', 'size' => 'small'],
                    ['name' => 'Apartment / Condominium', 'icon' => 'apartment', 'size' => 'small'],
                    ['name' => 'Townhouse', 'icon' => 'villa', 'size' => 'small'],
                    ['name' => 'Boarding House / Dormitory', 'icon' => 'bed', 'size' => 'large'],
                ],
            ],
            'Subdivision' => [
                'description' => 'Gated community or homeowners association',
                'icon' => 'holiday_village',
                'default_size' => 'large',
                'establishments' => [
                    ['name' => 'Subdivision / HOA', 'icon' => 'holiday_village', 'size' => 'large'],
                    ['name' => 'Condominium Complex', 'icon' => 'location_city', 'size' => 'large'],
                ],
            ],
            'Commercial' => [
                'description' => 'Business or company',
                'icon' => 'business',
                'default_size' => 'large',
                'establishments' => [
                    ['name' => 'Office / Commercial Space', 'icon' => 'storefront', 'size' => 'small'],
                    ['name' => 'Warehouse / Industrial', 'icon' => 'warehouse', 'size' => 'large'],
                    ['name' => 'Mall / Shopping Center', 'icon' => 'local_mall', 'size' => 'large'],
                    ['name' => 'Restaurant / Café', 'icon' => 'restaurant', 'size' => 'small'],
                    ['name' => 'Hotel / Resort', 'icon' => 'hotel', 'size' => 'large'],
                    ['name' => 'Factory / Plant', 'icon' => 'factory', 'size' => 'large'],
                    ['name' => 'Bank / Financial Institution', 'icon' => 'account_balance_wallet', 'size' => 'small'],
                    ['name' => 'Gas Station', 'icon' => 'local_gas_station', 'size' => 'small'],
                ],
            ],
            'Government' => [
                'description' => 'Barangay, school, government office',
                'icon' => 'account_balance',
                'default_size' => 'large',
                'establishments' => [
                    ['name' => 'Barangay Hall', 'icon' => 'account_balance', 'size' => 'small'],
                    ['name' => 'School / University', 'icon' => 'school', 'size' => 'large'],
                    ['name' => 'Hospital / Health Center', 'icon' => 'local_hospital', 'size' => 'large'],
                    ['name' => 'Sports Facility / Gym', 'icon' => 'sports_soccer', 'size' => 'large'],
                    ['name' => 'Park / Public Space', 'icon' => 'park', 'size' => 'large'],
                    ['name' => 'Terminal / Transport Hub', 'icon' => 'directions_bus', 'size' => 'large'],
                    ['name' => 'Police Station / Fire', 'icon' => 'local_police', 'size' => 'small'],
                    ['name' => 'Museum / Cultural Center', 'icon' => 'museum', 'size' => 'large'],
                ],
            ],
            'Agricultural' => [
                'description' => 'Farm, poultry, or aquaculture site',
                'icon' => 'agriculture',
                'default_size' => 'large',
                'establishments' => [
                    ['name' => 'Farm / Plantation', 'icon' => 'agriculture', 'size' => 'large'],
                    ['name' => 'Poultry / Livestock Facility', 'icon' => 'pets', 'size' => 'large'],
                    ['name' => 'Fishpond / Aquaculture', 'icon' => 'water', 'size' => 'large'],
                ],
            ],
            'Institutional' => [
                'description' => 'Church, NGO, or cooperative',
                'icon' => 'diversity_3',
                'default_size' => 'small',
                'establishments' => [
                    ['name' => 'Church / Chapel', 'icon' => 'church', 'size' => 'small'],
                    ['name' => 'NGO / Foundation Office', 'icon' => 'volunteer_activism', 'size' => 'small'],
                    ['name' => 'Cooperative', 'icon' => 'handshake', 'size' => 'small'],
                ],
            ],
        ];

        $order = 0;
        foreach ($data as $name => $config) {
            $clientType = ClientType::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $config['description'],
                    'icon' => $config['icon'],
                    'default_size' => $config['default_size'],
                    'sort_order' => $order++,
                    'active' => true,
                ]
            );

            $estabOrder = 0;
            foreach ($config['establishments'] as $estab) {
                $clientType->establishmentTypes()->updateOrCreate(
                    ['name' => $estab['name']],
                    [
                        'icon' => $estab['icon'],
                        'size' => $estab['size'],
                        'sort_order' => $estabOrder++,
                        'active' => true,
                    ]
                );
            }
        }
    }
}
