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
        // Recursos públicos/estáticos podem ignorar tenant
        if (
            $request->is('login') || $request->is('login/*')
            || $request->is('register') || $request->is('register/*')
            || $request->is('forgot') || $request->is('forgot/*')
            || $request->is('password/*')
            || $request->is('css/*') || $request->is('js/*') || $request->is('images/*')
            || $request->is('storage/*')
        ) {
            return $next($request);
        }

        $tenant = null;

        // 1) Usuário autenticado define o tenant (padrão single-domain)
        if (auth()->check() && auth()->user()->tenant_id) {
            $tenant = Tenant::find(auth()->user()->tenant_id);
        }

        // 2) Header opcional para API/Admin cross-tenant: X-Tenant-ID
        if (!$tenant) {
            $headerId = $request->header('X-Tenant-ID') ?? $request->header('X-Org') ?? null;
            if ($headerId) {
                $tenant = Tenant::find($headerId);
            }
        }

        // 3) Sessão opcional (ex.: um “switcher” manual)
        if (!$tenant && session()->has('tenant_id')) {
            $tenant = Tenant::find(session('tenant_id'));
        }

        // 4) Parâmetro de rota opcional {tenant} (id numérico)
        if (!$tenant) {
            $routeTenant = $request->route('tenant') ?? $request->route('organization') ?? null;
            if ($routeTenant) {
                // aceita ID direto ou model vinculado
                if ($routeTenant instanceof Tenant) {
                    $tenant = $routeTenant;
                } else {
                    $tenant = Tenant::find($routeTenant);
                }
            }
        }

        // Se ainda não resolveu, para rotas “tenant” exigimos um contexto
        if (!$tenant) {
            abort(400, 'Tenant not resolved. (single-domain: use user.tenant_id, X-Tenant-ID, session ou rota)');
        }

        // Checagem de segurança: o usuário só pode usar o próprio tenant
        // (ajuste conforme sua política — ex.: role 'superadmin' pode atravessar)
        if (auth()->check() && auth()->user()->tenant_id && auth()->user()->tenant_id !== $tenant->id) {
            if (!auth()->user()->hasRole('superadmin')) {
                abort(403, 'Forbidden for this tenant.');
            }
        }

        // injeta no container para uso de app('tenant')
        app()->instance('tenant', $tenant);

        // persistência opcional na sessão (útil p/ web)
        session(['tenant_id' => $tenant->id]);

        return $next($request);
    }
}
