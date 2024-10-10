<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch the region IDs by their code to map province to region
        $regions = DB::table('regions')->whereIn('code', [
            'ABR', 'BAS', 'CAL', 'CAM', 'EMR', 'FVG', 'LAZ', 'LIG', 'LOM', 'MAR', 'MOL',
            'PIE', 'PUG', 'SAR', 'SIC', 'TOS', 'TAA', 'UMB', 'VDA', 'VEN'
        ])->pluck('id', 'code');

        // Array of Italian provinces with corresponding region IDs
        $provinces = [
            ['name' => 'Chieti', 'code' => 'CH', 'region_code' => 'ABR'],
            ['name' => 'L\'Aquila', 'code' => 'AQ', 'region_code' => 'ABR'],
            ['name' => 'Pescara', 'code' => 'PE', 'region_code' => 'ABR'],
            ['name' => 'Teramo', 'code' => 'TE', 'region_code' => 'ABR'],
            ['name' => 'Matera', 'code' => 'MT', 'region_code' => 'BAS'],
            ['name' => 'Potenza', 'code' => 'PZ', 'region_code' => 'BAS'],
            ['name' => 'Catanzaro', 'code' => 'CZ', 'region_code' => 'CAL'],
            ['name' => 'Cosenza', 'code' => 'CS', 'region_code' => 'CAL'],
            ['name' => 'Napoli', 'code' => 'NA', 'region_code' => 'CAM'],
            ['name' => 'Salerno', 'code' => 'SA', 'region_code' => 'CAM'],
            ['name' => 'Bologna', 'code' => 'BO', 'region_code' => 'EMR'],
            ['name' => 'Rimini', 'code' => 'RN', 'region_code' => 'EMR'],
            ['name' => 'Trieste', 'code' => 'TS', 'region_code' => 'FVG'],
            ['name' => 'Udine', 'code' => 'UD', 'region_code' => 'FVG'],
            ['name' => 'Roma', 'code' => 'RM', 'region_code' => 'LAZ'],
            ['name' => 'Latina', 'code' => 'LT', 'region_code' => 'LAZ'],
            ['name' => 'Genova', 'code' => 'GE', 'region_code' => 'LIG'],
            ['name' => 'Savona', 'code' => 'SV', 'region_code' => 'LIG'],
            ['name' => 'Milano', 'code' => 'MI', 'region_code' => 'LOM'],
            ['name' => 'Bergamo', 'code' => 'BG', 'region_code' => 'LOM'],
            ['name' => 'Ancona', 'code' => 'AN', 'region_code' => 'MAR'],
            ['name' => 'Pesaro', 'code' => 'PU', 'region_code' => 'MAR'],
            ['name' => 'Campobasso', 'code' => 'CB', 'region_code' => 'MOL'],
            ['name' => 'Isernia', 'code' => 'IS', 'region_code' => 'MOL'],
            ['name' => 'Torino', 'code' => 'TO', 'region_code' => 'PIE'],
            ['name' => 'Cuneo', 'code' => 'CN', 'region_code' => 'PIE'],
            ['name' => 'Bari', 'code' => 'BA', 'region_code' => 'PUG'],
            ['name' => 'Lecce', 'code' => 'LE', 'region_code' => 'PUG'],
            ['name' => 'Cagliari', 'code' => 'CA', 'region_code' => 'SAR'],
            ['name' => 'Sassari', 'code' => 'SS', 'region_code' => 'SAR'],
            ['name' => 'Palermo', 'code' => 'PA', 'region_code' => 'SIC'],
            ['name' => 'Catania', 'code' => 'CT', 'region_code' => 'SIC'],
            ['name' => 'Firenze', 'code' => 'FI', 'region_code' => 'TOS'],
            ['name' => 'Siena', 'code' => 'SI', 'region_code' => 'TOS'],
            ['name' => 'Trento', 'code' => 'TN', 'region_code' => 'TAA'],
            ['name' => 'Bolzano', 'code' => 'BZ', 'region_code' => 'TAA'],
            ['name' => 'Perugia', 'code' => 'PG', 'region_code' => 'UMB'],
            ['name' => 'Terni', 'code' => 'TR', 'region_code' => 'UMB'],
            ['name' => 'Aosta', 'code' => 'AO', 'region_code' => 'VDA'],
            ['name' => 'Venezia', 'code' => 'VE', 'region_code' => 'VEN'],
            ['name' => 'Verona', 'code' => 'VR', 'region_code' => 'VEN'],
        ];

        // Insert provinces into the table using upsert
        foreach ($provinces as $province) {
            DB::table('provinces')->upsert([
                'name' => $province['name'],
                'code' => $province['code'],
                'region_id' => $regions[$province['region_code']],
                'created_at' => now(),
                'updated_at' => now(),
            ], ['code'], ['name', 'updated_at']);
        }

        $this->command->info('Italian provinces seeded successfully.');
    }
}
