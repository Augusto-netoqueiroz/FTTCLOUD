@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold">Convites</h1>
      <p class="text-sm text-gray-500">Gerencie convites pendentes da empresa {{ $tenant->name }}.</p>
    </div>
  </div>

  <form method="post" action="{{ route('invites.store') }}" class="bg-white p-4 rounded shadow mb-6">
    @csrf
    <div class="grid md:grid-cols-3 gap-3">
      <div>
        <label class="block text-sm">E-mail</label>
        <input name="email" type="email" class="border rounded w-full px-3 py-2" required>
        @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
      </div>
      <div>
        <label class="block text-sm">Permissão</label>
        <select name="role" class="border rounded w-full px-3 py-2">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Convidar</button>
      </div>
    </div>
  </form>

  <div class="bg-white rounded shadow">
    <table class="w-full text-left">
      <thead>
        <tr><th class="p-3">E-mail</th><th class="p-3">Permissão</th><th class="p-3">Expira</th><th class="p-3 w-40">Ações</th></tr>
      </thead>
      <tbody>
        @forelse($invites as $i)
        <tr class="border-t">
          <td class="p-3">{{ $i->email }}</td>
          <td class="p-3">{{ $i->role }}</td>
          <td class="p-3">{{ $i->expires_at?->diffForHumans() ?? '—' }}</td>
          <td class="p-3">
            <div class="flex items-center gap-2">
              <code class="text-xs">{{ route('invites.accept', $i->token) }}</code>
              <form method="post" action="{{ route('invites.destroy',$i) }}" onsubmit="return confirm('Remover convite?')">
                @csrf @method('DELETE')
                <button class="px-2 py-1 border rounded">Remover</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td class="p-3 text-slate-500" colspan="4">Nenhum convite.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
