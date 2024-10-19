<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class MigrateTenants extends Command
{
    protected $signature = 'migrate:tenants';

    protected $description = 'Run migrations for all tenant databases';

    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Dynamically set the tenant's database connection
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

            DB::purge('tenant');  // Clear existing tenant connection
            DB::reconnect('tenant');  // Reconnect to the tenant's database

            // Run migrations for the tenant's database
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true,  // Ensure there are no confirmation prompts
            ]);

            $this->info("Migrations run for tenant: {$tenant->domain}");
        }
    }
}
