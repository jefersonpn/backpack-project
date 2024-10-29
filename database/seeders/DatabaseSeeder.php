<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeed::class,
            RegionsTableSeed::class,
            ProvincesTableSeeder::class,
            CitiesTableSeeder::class,
            UsersSeeder::class
        ]);
    }
}
