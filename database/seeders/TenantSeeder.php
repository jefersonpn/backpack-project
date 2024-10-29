<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'domain' => 'backpack-project.local',
                'db_name' => 'backpack_project',
                'db_user' => 'root',
                'db_password' => 'root',
                'db_host' => 'mysql-backpack',
                'logo' => 'site-1-logo.png',
            ],
            [
                'domain' => 'backpack-project-2.local',
                'db_name' => 'backpack_project_2',
                'db_user' => 'root',
                'db_password' => 'root',
                'db_host' => 'mysql-backpack',
                'logo' => 'site-2-logo.png',
            ],
        ];

        foreach ($tenants as $tenantData) {
            Tenant::updateOrCreate(
                ['domain' => $tenantData['domain']],
                $tenantData
            );

            $this->createTenantDatabase($tenantData);
            $this->runTenantMigrations($tenantData);
            $this->seedTenantDatabase($tenantData);
        }
    }

    private function createTenantDatabase($tenantData)
    {
        // Set the connection without specifying a database
        Config::set('database.connections.tenant.database', null);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $databaseName = $tenantData['db_name'];
        $charset = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';

        DB::connection('tenant')->statement("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET $charset COLLATE $collation");

        // Set the tenant's database name
        Config::set('database.connections.tenant.database', $databaseName);
        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    private function runTenantMigrations($tenantData)
    {
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--force' => true,
        ]);

        $this->command->info("Migrations run for tenant: {$tenantData['domain']}");
    }

    private function seedTenantDatabase($tenantData)
    {
        Artisan::call('db:seed', [
            '--database' => 'tenant',
            '--class' => 'TenantDatabaseSeeder', // This should seed tenant-specific data
            '--force' => true,
        ]);

        $this->command->info("Database seeded for tenant: {$tenantData['domain']}");
    }
}
