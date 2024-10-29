<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed user data for each tenant's database
        User::updateOrCreate(
            ['email' => 'jefersonpn@gmail.com'],
            [
                'name' => 'Jeferson',
                'type' => 1,
                'phone' => '3517659040',
                'password' => Hash::make('Intellp4'),
            ]
        );



        // Call additional tenant-specific seeders if necessary
        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeed::class,
            RegionsTableSeed::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
        ]);
    }
}
