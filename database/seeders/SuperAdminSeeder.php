<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name'        => 'Owner',
            'last_name'         => 'Name',
            'email'             => 'awegreen.enterprise@gmail.com',
            'password'          => Hash::make('AweGreen1!'),
            'role'              => User::ROLE_SUPER_ADMIN,
            'status'            => 'active',
            'email_verified_at' => now(),
        ]);
    }
}