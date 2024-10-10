<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the country_id for Brazil using the 'code' field
        $brazil = DB::table('countries')->where('code', 'BR')->first();

        if (!$brazil) {
            $this->command->info('Brazil not found in countries table. Make sure Brazil is seeded with the correct code.');
            return;
        }

        // Array of Brazilian states
        $states = [
            ['name' => 'Acre', 'code' => 'AC'],
            ['name' => 'Alagoas', 'code' => 'AL'],
            ['name' => 'Amapá', 'code' => 'AP'],
            ['name' => 'Amazonas', 'code' => 'AM'],
            ['name' => 'Bahia', 'code' => 'BA'],
            ['name' => 'Ceará', 'code' => 'CE'],
            ['name' => 'Distrito Federal', 'code' => 'DF'],
            ['name' => 'Espírito Santo', 'code' => 'ES'],
            ['name' => 'Goiás', 'code' => 'GO'],
            ['name' => 'Maranhão', 'code' => 'MA'],
            ['name' => 'Mato Grosso', 'code' => 'MT'],
            ['name' => 'Mato Grosso do Sul', 'code' => 'MS'],
            ['name' => 'Minas Gerais', 'code' => 'MG'],
            ['name' => 'Pará', 'code' => 'PA'],
            ['name' => 'Paraíba', 'code' => 'PB'],
            ['name' => 'Paraná', 'code' => 'PR'],
            ['name' => 'Pernambuco', 'code' => 'PE'],
            ['name' => 'Piauí', 'code' => 'PI'],
            ['name' => 'Rio de Janeiro', 'code' => 'RJ'],
            ['name' => 'Rio Grande do Norte', 'code' => 'RN'],
            ['name' => 'Rio Grande do Sul', 'code' => 'RS'],
            ['name' => 'Rondônia', 'code' => 'RO'],
            ['name' => 'Roraima', 'code' => 'RR'],
            ['name' => 'Santa Catarina', 'code' => 'SC'],
            ['name' => 'São Paulo', 'code' => 'SP'],
            ['name' => 'Sergipe', 'code' => 'SE'],
            ['name' => 'Tocantins', 'code' => 'TO'],
        ];

        // Insert states into the table using upsert
        foreach ($states as $state) {
            DB::table('states')->upsert([
                'name' => $state['name'],
                'code' => $state['code'],
                'country_id' => $brazil->id,
                'created_at' => now(),
                'updated_at' => now(),
            ], ['code'], ['name', 'updated_at']);
        }

        $this->command->info('Brazilian states seeded successfully.');
    }

}
