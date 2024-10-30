<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\TenantSeeder;
use Database\Seeders\StatesTableSeed;
use Database\Seeders\RegionsTableSeed;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\ProvincesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeed::class,
            RegionsTableSeed::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            UsersTableSeeder::class,
            TenantTableSeeder::class,
        ]);
    }
}
