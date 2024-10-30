<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
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
