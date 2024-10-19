<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tenants = [
            [
                'domain' => 'backpack-project.local',
                'db_name' => 'backpack_project',
                'db_user' => 'root',
                'db_password' => 'root',
                'db_host' => 'mysql-backpack',
            ],
            [
                'domain' => 'backpack-project-2.local',
                'db_name' => 'backpack_project_2',
                'db_user' => 'root',
                'db_password' => 'root',
                'db_host' => 'mysql-backpack',
            ],
        ];

        foreach ($tenants as $tenantData) {
            // Create or update the tenant record in the main database
            $tenant = Tenant::updateOrCreate(
                ['domain' => $tenantData['domain']],
                $tenantData
            );

            // Dynamically set the tenant's database connection
            $this->createTenantDatabase($tenantData);
            $this->runTenantMigrations($tenantData);
            $this->seedTenantDatabase($tenantData);
        }
    }

    private function createTenantDatabase($tenantData)
    {
        // Temporarily set the database name to null to connect to the server
        Config::set('database.connections.tenant.database', null);

        // Reconnect to apply the new configuration
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Create the tenant database if it doesn't exist
        $databaseName = $tenantData['db_name'];
        $charset = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';

        DB::connection('tenant')->statement("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET $charset COLLATE $collation");

        // Set the database name in the configuration
        Config::set('database.connections.tenant.database', $databaseName);

        // Reconnect to the tenant's database
        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    private function runTenantMigrations($tenantData)
    {
        // Run migrations for the tenant's database
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => '/database/migrations/tenant', // Adjust the path if necessary
            '--force' => true,
        ]);

        $this->command->info("Migrations run for tenant: {$tenantData['domain']}");
    }

    private function seedTenantDatabase($tenantData)
    {
        // Seed the tenant's database
        Artisan::call('db:seed', [
            '--database' => 'tenant',
            '--class' => 'TenantDatabaseSeeder', // Create this seeder for tenant-specific data
            '--force' => true,
        ]);

        $this->command->info("Database seeded for tenant: {$tenantData['domain']}");
    }
}
