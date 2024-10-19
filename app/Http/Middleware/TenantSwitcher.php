<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;

class TenantSwitcher
{
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();
        // Retrieve the tenant from the default database
        $tenant = Tenant::where('domain', $domain)->first();

        if ($tenant) {
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

            // Switch to the tenant's database
            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');
        }

        return $next($request);
    }
}
