<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data for the countries
        $countries = [
            [
                'name' => 'Italia',
                'code' => 'IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brasil',
                'code' => 'BR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Use upsert to insert or update existing records
        DB::table('countries')->upsert($countries, ['code'], ['name', 'updated_at']);
    }
}
