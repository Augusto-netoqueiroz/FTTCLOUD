<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Illuminate\Http\Request;

/**
 * CallController
 *
 * Fornece endpoints para consultar e manipular registros de chamadas
 * pertencentes ao tenant atual.  As tabelas de chamada utilizam o
 * escopo global de tenant, portanto não é necessário filtrar manualmente.
 */
class CallController extends Controller
{
    /**
     * Lista todas as chamadas do tenant atual.
     */
    public function index()
    {
        $calls = Call::with(['legs', 'recordings'])->orderByDesc('id')->paginate(25);
        return response()->json($calls);
    }

    /**
     * Armazena uma nova chamada.  Este endpoint pode ser utilizado
     * para registrar uma chamada recebida do Asterisk via webhook ou
     * para registrar chamadas simuladas durante desenvolvimento.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'direction' => 'required|string|in:incoming,outgoing',
            'status'    => 'required|string',
            'started_at'=> 'nullable|date',
            'ended_at'  => 'nullable|date|after_or_equal:started_at',
            'duration'  => 'nullable|integer',
            'metadata'  => 'nullable|array',
        ]);

        $call = Call::create($data);
        return response()->json($call, 201);
    }

    /**
     * Exibe uma chamada específica.
     */
    public function show(Call $call)
    {
        $call->load(['legs', 'recordings']);
        return response()->json($call);
    }

    /**
     * Atualiza uma chamada.
     */
    public function update(Request $request, Call $call)
    {
        $data = $request->validate([
            'status'    => 'sometimes|string',
            'ended_at'  => 'sometimes|date|after_or_equal:started_at',
            'duration'  => 'sometimes|integer',
            'metadata'  => 'sometimes|array',
        ]);
        $call->update($data);
        return response()->json($call);
    }

    /**
     * Remove uma chamada.
     */
    public function destroy(Call $call)
    {
        $call->delete();
        return response()->json(null, 204);
    }
}