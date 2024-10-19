<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\StatesTableSeed;
use Database\Seeders\RegionsTableSeed;
use Illuminate\Support\Facades\Config;
use Database\Seeders\CitiesTableSeeder;
use Database\Seeders\CountriesTableSeeder;
use Database\Seeders\ProvincesTableSeeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds for all tenant databases.
     */
    public function run()
    {
        // Fetch all tenants from the main database
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Dynamically configure tenant's database connection
            Config::set('database.connections.tenant', [
                'driver'    => 'mysql',
                'host'      => $tenant->db_host,
                'database'  => $tenant->db_name,
                'username'  => $tenant->db_user,
                'password'  => $tenant->db_password,
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => '',
                'strict'    => true,
                'engine'    => null,
            ]);

            // Purge the previous tenant connection and reconnect to the new tenant database
            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');

            $this->command->info("Seeding data for tenant: {$tenant->domain}");

            // Now seed data into the tenant's database (you can modify this to fit your needs)

            User::updateOrCreate(
                ['email' => 'jefersonpn@gmail.com'], // Attributes to check for existence
                [
                    'name' => 'Jeferson',
                    'type' => 1,
                    'phone' => '3517659040',
                    'password' => Hash::make('Intellp4'),
                ]
            );

            // You can also call other tenant-specific seeders here if needed
            $this->call([
                //CountriesTableSeeder::class,
                //StatesTableSeed::class,
                //RegionsTableSeed::class,
                //ProvincesTableSeeder::class,
                //CitiesTableSeeder::class,
            ]);
        }
    }
}
