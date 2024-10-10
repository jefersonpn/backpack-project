<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the country_id for Italy using the 'code' field
        $italy = DB::table('countries')->where('code', 'IT')->first();

        if (!$italy) {
            $this->command->info('Italy not found in countries table. Make sure Italy is seeded with the correct code.');
            return;
        }

        // Array of Italian regions
        $regions = [
            ['name' => 'Abruzzo', 'code' => 'ABR'],
            ['name' => 'Basilicata', 'code' => 'BAS'],
            ['name' => 'Calabria', 'code' => 'CAL'],
            ['name' => 'Campania', 'code' => 'CAM'],
            ['name' => 'Emilia-Romagna', 'code' => 'EMR'],
            ['name' => 'Friuli Venezia Giulia', 'code' => 'FVG'],
            ['name' => 'Lazio', 'code' => 'LAZ'],
            ['name' => 'Liguria', 'code' => 'LIG'],
            ['name' => 'Lombardia', 'code' => 'LOM'],
            ['name' => 'Marche', 'code' => 'MAR'],
            ['name' => 'Molise', 'code' => 'MOL'],
            ['name' => 'Piemonte', 'code' => 'PIE'],
            ['name' => 'Puglia', 'code' => 'PUG'],
            ['name' => 'Sardegna', 'code' => 'SAR'],
            ['name' => 'Sicilia', 'code' => 'SIC'],
            ['name' => 'Toscana', 'code' => 'TOS'],
            ['name' => 'Trentino-Alto Adige', 'code' => 'TAA'],
            ['name' => 'Umbria', 'code' => 'UMB'],
            ['name' => 'Valle d\'Aosta', 'code' => 'VDA'],
            ['name' => 'Veneto', 'code' => 'VEN'],
        ];

        // Insert regions into the table using upsert
        foreach ($regions as $region) {
            DB::table('regions')->upsert([
                'name' => $region['name'],
                'code' => $region['code'],
                'country_id' => $italy->id,
                'created_at' => now(),
                'updated_at' => now(),
            ], ['code'], ['name', 'updated_at']);
        }

        $this->command->info('Italian regions seeded successfully.');
    }
}
