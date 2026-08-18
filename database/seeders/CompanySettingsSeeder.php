<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class CompanySettingsSeeder extends Seeder
{
    /**
     * Seeds the current, real hardcoded values as the initial rows so
     * turning Settings on doesn't change anything visible on day one.
     */
    public function run(): void
    {
        $defaults = [
            'company_name' => 'A We Green Enterprise',
            'company_tagline' => 'We Bring The Right Technology',
            'company_description' => 'We bring the right technology to communities — through CCTV, solar, and public address solutions since 2015.',
            'company_founded_year' => '2015',
            'company_logo_path' => 'css/images/AWeGreen-Logo.svg',
            'company_address_main' => "Alta Tierra Homes Phase 4, Blk 51 Lot 30\nBrgy. A. Olaes, Gen. Mariano Alvarez, Cavite 4117",
            'company_address_satellite' => "Alta Tierra Homes Phase 5, Blk 14 Lot 5\nBrgy. A. Olaes, Gen. Mariano Alvarez, Cavite 4117",
            'company_phone_primary' => '0998 884 5671',
            'company_phone_secondary' => '0917 752 3343',
            'company_phone_landline' => '(046) 443 6374',
            'company_email_primary' => 'awegreenenterprise@gmail.com',
            'company_email_secondary' => null,
            'company_hours_days' => 'Mon – Sat',
            'company_hours_open' => '08:00',
            'company_hours_close' => '17:00',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'company']);
        }
    }
}
