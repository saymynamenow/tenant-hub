<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TenantModels as Tenant;

class CheckTenantStatus
{
    /**
     * Handle an incoming request.
     * Return 404 if the host corresponds to a tenant that is not active.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $parts = explode('.', $host);

        // if host doesn't have subdomain (like example.test) then skip
        if (count($parts) < 3) {
            return $next($request);
        }

        $subdomain = $parts[0];

        $tenant = Tenant::where('slug', $subdomain)->first();

        // if no tenant matched, this is probably central domain -> allow
        if (!$tenant) {
            return $next($request);
        }

        // if tenant exists but is not active, pretend it's not found
        if (!in_array($tenant->status, ['active'])) {
            abort(404);
        }

        return $next($request);
    }
}
