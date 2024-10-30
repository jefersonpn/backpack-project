<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            [
                'ragione_sociale' => 'Cristiane',
                'name' => 'Gonçalves',
                'address_id' => 'cristianebvms@hotmail.com',
                'doctors' => json_encode([
                    [
                        'Cristiane' => '67 99988-3220',
                    ],
                ]),
                'logo' => null,
                'header_img' => null,
                'colors' => json_encode([
                    [
                        'Cristiane' => '67 99988-3220',
                    ],
                ]),
                'cnpj' => null,
                'iva' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($clinics as $clinicData) {
            Clinic::updateOrCreate(
                ['email' => $clinicData['email']],
                $clinicData
            );

        }
    }
}
