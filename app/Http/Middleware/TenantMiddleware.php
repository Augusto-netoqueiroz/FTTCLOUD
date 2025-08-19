<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ignore rotas públicas e assets
        if ($request->is('login') || $request->is('login/*')
            || $request->is('register') || $request->is('register/*')
            || $request->is('forgot') || $request->is('forgot/*')
            || $request->is('/') || $request->is('roadmap')
            || $request->is('theme/*') || $request->is('session/*')
            || $request->is('register-tenant')
            || $request->is('assets/*') || $request->is('build/*')
        ) {
            return $next($request);
        }

        // Se usa subdomínio para tenant: acme.fttelecom.cloud
        $host = $request->getHost();  // ex: acme.fttelecom.cloud
        $parts = explode('.', $host);
        $sub = $parts[0] ?? null;

        // Se for domínio raiz, não força tenant
        if (!$sub || $sub === 'www' || $host === 'fttelecom.cloud') {
            return $next($request);
        }

        $tenant = Tenant::where('domain', $sub)->first();
        if (!$tenant) {
            abort(404, 'Tenant not found.');
        }

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
