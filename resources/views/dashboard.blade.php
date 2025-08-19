@extends('layouts.app')

@section('content')
    <h1 style="font-family:'Space Grotesk', sans-serif; color:var(--text-primary); margin-bottom:20px;">Dashboard</h1>

    <div class="cards">
        <div class="card-stat">
            <h3>{{ $callsToday ?? 0 }}</h3>
            <span>Chamadas hoje</span>
        </div>
        <div class="card-stat">
            <h3>{{ $activeCalls ?? 0 }}</h3>
            <span>Chamadas ativas</span>
        </div>
        <div class="card-stat">
            <h3>{{ $pendingRecordings ?? 0 }}</h3>
            <span>Gravações pendentes</span>
        </div>
        <div class="card-stat">
            <h3>{{ $onlineUsers ?? 0 }}</h3>
            <span>Usuários online</span>
        </div>
    </div>

    {{-- Outras seções: tabelas de chamadas, métricas, etc. --}}
@endsection
