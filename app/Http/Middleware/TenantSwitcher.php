<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Facades\Log; // For logging purposes

class TenantSwitcher
{
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();

        // Retrieve the tenant from the default database
        $tenant = Tenant::where('domain', $domain)->first();

        if ($tenant) {
            // Log the tenant's information for debugging
            Log::info('Switching to tenant: ' . $tenant->domain);

            // Configure tenant's database connection dynamically
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
                // Switch to the tenant's database
                DB::purge('tenant');
                DB::reconnect('tenant');
                DB::setDefaultConnection('tenant');
            } catch (\Exception $e) {
                // Log any errors related to the tenant connection
                Log::error('Error switching to tenant database: ' . $e->getMessage());
            }
        } else {
            // Log if no tenant is found for the domain
            Log::warning('No tenant found for domain: ' . $domain);
        }

        // Ensure the next middleware in the stack is called
        return $next($request);
    }
}
