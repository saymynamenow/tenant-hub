<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TenantModels as Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $tenant = Tenant::where('slug', $subdomain)->first();
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        if (!in_array($tenant->status, ['active'])) {
            abort(404);
        }

        Config::set('database.connections.tenant', [
            'driver' => 'pgsql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => $tenant->database_name,
            'username' => $tenant->db_username,
            'password' => decrypt($tenant->db_password_encrypted),
            'charset' => 'UTF8',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ]);

        DB::setDefaultConnection('tenant');
        config(['session.connection' => 'tenant']);

        return $next($request);
    }
}
