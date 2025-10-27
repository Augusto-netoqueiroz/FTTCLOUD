<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantSettingsController extends Controller
{
    public function edit()
    {
        $tenant = app('tenant') ?? abort(400,'Tenant not resolved.');
        return view('tenant.settings', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = app('tenant') ?? abort(400,'Tenant not resolved.');

        $data = $request->validate([
            'name'      => ['required','string','max:120'],
            'subdomain' => ['required','alpha_dash','max:120', 'unique:tenants,subdomain,'.$tenant->id],
            // se quiser permitir plano/limites aqui, adicione os campos
        ]);

        $tenant->update($data);

        return back()->with('ok','Configurações salvas.');
    }
}
