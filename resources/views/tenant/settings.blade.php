@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Configurações da Empresa</h1>

  <form method="post" action="{{ route('tenant.settings.update') }}" class="space-y-4 bg-white p-4 rounded shadow">
    @csrf
    <div>
      <label class="block text-sm">Nome</label>
      <input name="name" class="border rounded w-full px-3 py-2" value="{{ old('name', $tenant->name) }}" required>
      @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
      <label class="block text-sm">Subdomínio</label>
      <div class="flex items-center gap-2">
        <input name="subdomain" class="border rounded w-full px-3 py-2" value="{{ old('subdomain', $tenant->subdomain) }}" required>
        <span class="text-sm text-slate-600">.fttelecom.cloud</span>
      </div>
      @error('subdomain')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
    </div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Salvar</button>
  </form>

  <div class="mt-6 bg-white p-4 rounded shadow">
    <div class="font-medium mb-2">Plano</div>
    <div class="text-slate-700">{{ $tenant->plan ?? 'free' }}</div>
    {{-- quando quiser, coloque limites / upgrade aqui --}}
  </div>
</div>
@endsection
