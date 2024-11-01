<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantTableSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'name' => 'Cristiane',
                'lastname' => 'Gonçalves',
                'email' => 'cristianebvms@hotmail.com',
                'address_id' => null,
                'clinic_id' => null,
                'phones' => json_encode([
                    [
                        'Cristiane' => '67 99988-3220',
                    ],
                ]),
            ],
        ];

        foreach ($tenants as $tenantData) {
            Tenant::updateOrCreate(
                ['email' => $tenantData['email']],
                $tenantData
            );

        }
    }

}
