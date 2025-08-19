<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use App\Events\UserStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'As credenciais informadas estão incorretas.'
                ], 422);
            }

            throw ValidationException::withMessages([
                'email' => ['As credenciais informadas estão incorretas.']
            ]);
        }

        Auth::login($user);

        // Cria sessão de usuário para métricas e WebSocket
        $session = UserSession::create([
            'tenant_id'  => $user->tenant_id,
            'user_id'    => $user->id,
            'started_at' => now(),
            'status'     => 'available',
        ]);

        // Salva o id da sessão atual na sessão HTTP
        session(['user_session_id' => $session->id]);

        // Dispara evento (agora o evento aceita UserSession diretamente)
        event(new UserStatusChanged($session));

        // Resposta JSON (p/ chamadas AJAX)
        if ($request->expectsJson()) {
            return response()->json([
                'user'         => $user,
                'token'        => $user->createToken('auth_token')->plainTextToken,
                'user_session' => $session->only(['id', 'started_at', 'status']),
            ]);
        }

        // Redireciona para a dashboard
        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $sessionId = session('user_session_id');

        if ($sessionId) {
            $session = UserSession::find($sessionId);

            if ($session) {
                $session->update([
                    'ended_at' => now(),
                    'status'   => 'offline',
                ]);

                // Garante que ended_at/status estejam atualizados no objeto
                $session->refresh();

                // Dispara evento com a sessão atualizada
                event(new UserStatusChanged($session));
            }

            session()->forget('user_session_id');
        }

        // Revoga token atual (se houver) e encerra autenticação
        $user?->currentAccessToken()?->delete();
        Auth::logout();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout realizado com sucesso']);
        }

        return redirect('/login');
    }
}
