<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;  // Import the Str helper

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch the countries by their code to map cities to countries
        $countries = DB::table('countries')->pluck('id', 'code');
        // Fetch the states by their code to map cities to states for Brazil
        $brazilStates = DB::table('states')->where('country_id', $countries['BR'])->pluck('id', 'code');
        // Fetch the regions by their code to map cities to regions for Italy
        $italyRegions = DB::table('regions')->where('country_id', $countries['IT'])->pluck('id', 'code');

        // Process Brazilian cities
        $this->processCsv(
            base_path('public/csv/brazil_cities.csv'),
            $brazilStates, // Pass Brazil states as the region/state mapping
            'BR' // Indicate it's for Brazil
        );

        // Process Italian cities
        $this->processCsv(
            base_path('public/csv/italy_cities.csv'),
            $italyRegions, // Pass Italian regions as the region/state mapping
            'IT' // Indicate it's for Italy
        );
    }

    /**
     * Process the CSV file for either Brazil or Italy.
     *
     * @param string $csvFilePath
     * @param array $regionStateMapping
     * @param string $countryCode
     * @return void
     */
    private function processCsv($csvFilePath, $regionStateMapping, $countryCode)
    {
        // Open the CSV file using the correct delimiter (semicolon ;)
        $csvData = array_map(function($data) {
            return str_getcsv($data, ';');  // Use semicolon as delimiter
        }, file($csvFilePath));

        // Clean header names to match the actual CSV headers
        $header = array_map(function($value) {
            return strtolower(trim($value));
        }, array_shift($csvData)); // Remove header row and clean headers

        // Insert cities into the table using upsert
        foreach ($csvData as $row) {
            $cityData = array_combine($header, $row);

            // Check if the region/state code exists in the mapping (either for Brazil or Italy)
            if (!isset($regionStateMapping[$cityData['region_code']])) {
                $this->command->info("Undefined region/state code: " . $cityData['region_code'] . " for city: " . $cityData['name']);
                continue; // Skip this iteration and move on to the next city
            }

            // Ensure that the city name is properly encoded in UTF-8
            $cityName = utf8_encode($cityData['name']);

            // If slug is not provided, generate it dynamically from the city name
            $citySlug = isset($cityData['slug']) ? utf8_encode($cityData['slug']) : Str::slug($cityName, '-');

            // Prepare the city data based on the country
            $city = [
                'name' => $cityName,  // Ensure UTF-8 encoding
                'slug' => $citySlug,  // Ensure UTF-8 encoding or generated slug
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Handle Brazil with 'code_ibge' and Italy with 'code_istat'
            if ($countryCode === 'BR') {
                $city['code_ibge'] = $cityData['code_ibge'];  // CSV column "code_ibge" for Brazil
                $city['state_id'] = $regionStateMapping[$cityData['region_code']];  // Map state for Brazil
            } elseif ($countryCode === 'IT') {
                $city['code_istat'] = $cityData['code_istat'];  // CSV column "code_istat" for Italy
                $city['region_id'] = $regionStateMapping[$cityData['region_code']];  // Map region for Italy
            }

            // Insert or update city record
            DB::table('cities')->upsert($city, ['name'], ['updated_at']);
        }

        $this->command->info("All valid cities for {$countryCode} seeded successfully.");
    }
}
