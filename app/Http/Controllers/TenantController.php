<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

/**
 * TenantController
 *
 * Controlador responsável pelo gerenciamento de tenants.  Estes
 * endpoints normalmente são acessíveis apenas por administradores
 * do sistema (não por usuários de tenants), portanto devem ser
 * protegidos via políticas/gates ou middlewares adequados.
 */
class TenantController extends Controller
{
    /**
     * Lista todos os tenants cadastrados.
     */
    public function index()
    {
        return response()->json(Tenant::all());
    }

    /**
     * Armazena um novo tenant.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'subdomain' => 'required|string|alpha_dash|max:255|unique:tenants,subdomain',
        ]);

        $tenant = Tenant::create([
            'name'      => $data['name'],
            'subdomain' => strtolower($data['subdomain']),
            'database'  => $request->get('database'),
        ]);

        return response()->json($tenant, 201);
    }

    /**
     * Exibe um tenant específico.
     */
    public function show(Tenant $tenant)
    {
        return response()->json($tenant);
    }

    /**
     * Atualiza um tenant.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $data = $request->validate([
            'name'      => 'sometimes|required|string|max:255',
            'subdomain' => 'sometimes|required|string|alpha_dash|max:255|unique:tenants,subdomain,' . $tenant->id,
        ]);

        $tenant->update($data);
        return response()->json($tenant);
    }

    /**
     * Remove um tenant.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return response()->json(null, 204);
    }
}