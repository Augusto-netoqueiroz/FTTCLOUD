<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InviteController extends Controller
{
    /**
     * Lista de convites do tenant atual.
     */
    public function index()
    {
        $tenant = app()->bound('tenant') ? app('tenant') : null;
        abort_if(!$tenant, 400, 'Tenant not resolved.');

        // busca somente convites do tenant atual
        $invites = Invite::where('tenant_id', $tenant->id)
            ->latest()
            ->get();

        return view('invites.index', compact('invites', 'tenant'));
    }

    /**
     * Cria um novo convite para um e-mail.
     */
    public function store(Request $request)
    {
        $tenant = app()->bound('tenant') ? app('tenant') : null;
        abort_if(!$tenant, 400, 'Tenant not resolved.');

        $data = $request->validate([
            'email' => [
                'required', 'email',
                // garante que o e-mail ainda não exista no tenant
                Rule::unique('users', 'email')
                    ->where(fn($q) => $q->where('tenant_id', $tenant->id))
            ],
            'role' => ['required', 'string'],
        ]);

        $invite = Invite::create([
            'tenant_id' => $tenant->id,
            'email'     => $data['email'],
            'role'      => $data['role'],
            'expires_at'=> now()->addDays(7),
        ]);

        // aqui você pode enviar e-mail com o link:
        // Mail::to($invite->email)->send(new InviteMail($invite));

        return back()->with('ok', 'Convite criado: '.$invite->email);
    }

    /**
     * Remove um convite pendente.
     */
    public function destroy(Invite $invite)
    {
        $tenant = app()->bound('tenant') ? app('tenant') : null;
        abort_if(!$tenant, 400, 'Tenant not resolved.');

        abort_unless($invite->tenant_id === $tenant->id, 403);

        $invite->delete();

        return back()->with('ok', 'Convite removido.');
    }

    /**
     * Aceita um convite via token.
     */
    public function accept(string $token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        abort_if($invite->isExpired(), 410, 'Convite expirado.');

        $tenant = $invite->tenant;
        $user   = Auth::user();

        if (!$user) {
            // redireciona para login se não estiver autenticado
            session(['invite_token' => $token]);
            return redirect()->route('login')->with('error', 'Faça login para aceitar o convite.');
        }

        // opcional: validar que o e-mail bate com o convite
        // abort_unless($user->email === $invite->email, 403, 'E-mail não corresponde ao convite.');

        // associa o usuário ao tenant do convite
        $user->tenant_id = $tenant->id;
        $user->save();

        // atribui role (se usa spatie/permissions)
        if (method_exists($user, 'assignRole')) {
            $user->syncRoles([$invite->role]);
        }

        $invite->delete();

        return redirect('/users')->with('ok', 'Convite aceito com sucesso.');
    }
}
