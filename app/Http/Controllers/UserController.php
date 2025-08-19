<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $tenantId = Auth::user()->tenant_id;

        $users = User::query()
            ->where('tenant_id', $tenantId)
            ->select('id','name','email','extension_id','created_at')
            ->orderBy('name')
            ->get();

        // Opcional: carregar ramais do Asterisk (ps_endpoints) para o <select>
        $endpoints = DB::table('ps_endpoints')
            ->select('id') // VARCHAR(40)
            ->orderBy('id')
            ->get()
            ->pluck('id');

        return view('users.index', compact('users','endpoints'));
    }

    public function store(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;

        $data = $request->validate([
            'name'         => ['required','string','max:255'],
            'email'        => [
                'required','string','email','max:255',
                Rule::unique('users','email')->where(fn($q)=>$q->where('tenant_id',$tenantId)),
            ],
            'password'     => ['required','string','min:8'],
            'extension_id' => ['nullable','string','max:40', 'exists:ps_endpoints,id'],
        ]);

        $user = User::create([
            'tenant_id'    => $tenantId,
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'extension_id' => $data['extension_id'] ?? null,
        ]);

        return response()->json(['ok'=>true,'user'=>$user], 201);
    }

    public function update(Request $request, User $user)
    {
        $tenantId = Auth::user()->tenant_id;

        abort_if($user->tenant_id !== $tenantId, 403);

        $data = $request->validate([
            'name'         => ['required','string','max:255'],
            'email'        => [
                'required','string','email','max:255',
                Rule::unique('users','email')
                    ->ignore($user->id)
                    ->where(fn($q)=>$q->where('tenant_id',$tenantId)),
            ],
            'password'     => ['nullable','string','min:8'],
            'extension_id' => ['nullable','string','max:40', 'exists:ps_endpoints,id'],
        ]);

        $payload = [
            'name'         => $data['name'],
            'email'        => $data['email'],
            'extension_id' => $data['extension_id'] ?? null,
        ];
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        return response()->json(['ok'=>true,'user'=>$user]);
    }

    public function destroy(User $user)
    {
        $tenantId = Auth::user()->tenant_id;
        abort_if($user->tenant_id !== $tenantId, 403);

        // Evita auto-exclusão
        if ($user->id === Auth::id()) {
            return response()->json(['ok'=>false,'message'=>'Você não pode excluir sua própria conta.'], 422);
        }

        $user->delete();
        return response()->json(['ok'=>true]);
    }
}
