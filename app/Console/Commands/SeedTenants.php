<?php

namespace App\Console\Commands;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class SeedTenants extends Command
{
    protected $signature = 'db:seed-tenants';

    protected $description = 'Seed databases for all tenants';

    public function handle()
    {
        $tenants = Tenant::all();  // Get all tenants from the main database

        foreach ($tenants as $tenant) {
            // Dynamically configure the tenant database connection
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

            DB::purge('tenant');  // Clear the existing connection
            DB::reconnect('tenant');  // Reconnect to the tenant's database

            // Run seeders for the tenant's database
            Artisan::call('db:seed', [
                '--database' => 'tenant',  // Use the tenant connection
                '--class' => 'TenantDatabaseSeeder',  // You can modify this to call specific seeders
                '--force' => true,  // Ensure no confirmation prompt
            ]);

            $this->info("Seeded database for tenant: {$tenant->domain}");
        }
    }
}
