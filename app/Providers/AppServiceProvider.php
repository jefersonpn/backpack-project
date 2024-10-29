<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Skip tenant logic during migrations and seeding
        if (App::runningInConsole() && $this->isRunningMigrationOrSeeding()) {
            Log::info('Skipping tenant logic during migration or seeding');
            return;
        }

        // Check if the `tenants` table exists before querying
        if (Schema::hasTable('tenants')) {
            $domain = request()->getHost();

            // Find the tenant by domain in the main database (not tenant database)
            $tenant = Tenant::where('domain', $domain)->first();
            Log::info("Found tenant: {$tenant->domain}");

            if ($tenant) {
                Log::info("Configuring database connection for tenant: {$tenant->domain}");
                // Configure the tenant database connection dynamically
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

                try {
                    DB::purge('tenant');
                    DB::reconnect('tenant');
                    DB::setDefaultConnection('tenant');
                    // Test the connection
                    DB::connection('tenant')->getPdo();
                    Log::info('Tenant connection configured and tested successfully.');
                } catch (\Exception $e) {
                    Log::error('Failed to connect to tenant database: ' . $e->getMessage());
                    abort(500, 'Could not connect to tenant database.');
                }
            }
        }
    }

    /**
     * Check if the current artisan command is a migration or seeding operation.
     */
    private function isRunningMigrationOrSeeding()
    {
        $commands = ['migrate', 'migrate:install', 'migrate:refresh', 'migrate:reset', 'migrate:rollback', 'db:seed'];

        // Check if argv[1] exists before trying to access it
        $argv = app('request')->server->get('argv');

        return isset($argv[1]) && in_array($argv[1], $commands);
    }
}
