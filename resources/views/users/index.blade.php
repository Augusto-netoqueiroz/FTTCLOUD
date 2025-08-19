@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div 
    x-data="usersPage({ initialUsers: @js($users), endpoints: @js($endpoints) })" 
    class="p-6"
>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Usuários</h1>
            <p class="text-sm text-gray-500">Gerencie usuários do tenant e vincule ramais PJSIP.</p>
        </div>
        <button @click="openCreate()" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
            Novo usuário
        </button>
    </div>

    <!-- Tabela -->
    <div class="bg-white dark:bg-slate-800 shadow rounded-2xl overflow-hidden">
        <div class="p-4 border-b dark:border-slate-700">
            <input type="text" placeholder="Pesquisar por nome ou e-mail..." x-model="search"
                   class="w-full md:w-96 px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900"/>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/40">
                    <tr class="text-left text-slate-600 dark:text-slate-300">
                        <th class="px-4 py-3">Nome</th>
                        <th class="px-4 py-3">E-mail</th>
                        <th class="px-4 py-3">Ramal (ps_endpoints.id)</th>
                        <th class="px-4 py-3 w-40">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="u in filtered" :key="u.id">
                        <tr class="border-t dark:border-slate-700 hover:bg-slate-50/50 dark:hover:bg-slate-900/40">
                            <td class="px-4 py-3" x-text="u.name"></td>
                            <td class="px-4 py-3" x-text="u.email"></td>
                            <td class="px-4 py-3">
                                <span x-text="u.extension_id ?? '—'" class="font-mono"></span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button @click="openEdit(u)" class="px-3 py-1.5 rounded-lg bg-amber-500 text-white hover:bg-amber-600">
                                        Editar
                                    </button>
                                    <button @click="destroy(u)" class="px-3 py-1.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filtered.length === 0">
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Nenhum usuário encontrado.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Criar -->
    <div x-show="showCreate" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"></div>
    <div x-show="showCreate" x-trap.noscroll="showCreate"
         x-transition
         class="fixed inset-0 z-50 grid place-items-center p-4">
        <div @click.outside="closeCreate()" class="w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border dark:border-slate-700">
            <div class="p-5 border-b dark:border-slate-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Novo usuário</h3>
                <button @click="closeCreate()" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                    ✕
                </button>
            </div>
            <form @submit.prevent="submitCreate" class="p-5 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm mb-1">Nome</label>
                        <input x-model="formCreate.name" type="text" required
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsCreate.name"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">E-mail</label>
                        <input x-model="formCreate.email" type="email" required
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsCreate.email"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Senha</label>
                        <input x-model="formCreate.password" type="password" minlength="8" required
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsCreate.password"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Ramal (opcional)</label>
                        <select x-model="formCreate.extension_id"
                                class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                            <option value="">— sem ramal —</option>
                            <template x-for="e in endpoints" :key="e">
                                <option :value="e" x-text="e"></option>
                            </template>
                        </select>
                        <p class="text-xs text-rose-600" x-text="errorsCreate.extension_id"></p>
                    </div>
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="closeCreate()" class="px-4 py-2 rounded-xl border dark:border-slate-700">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Editar -->
    <div x-show="showEdit" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"></div>
    <div x-show="showEdit" x-trap.noscroll="showEdit"
         x-transition
         class="fixed inset-0 z-50 grid place-items-center p-4">
        <div @click.outside="closeEdit()" class="w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border dark:border-slate-700">
            <div class="p-5 border-b dark:border-slate-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Editar usuário</h3>
                <button @click="closeEdit()" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                    ✕
                </button>
            </div>
            <form @submit.prevent="submitEdit" class="p-5 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm mb-1">Nome</label>
                        <input x-model="formEdit.name" type="text" required
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsEdit.name"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">E-mail</label>
                        <input x-model="formEdit.email" type="email" required
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsEdit.email"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Senha (deixe em branco para manter)</label>
                        <input x-model="formEdit.password" type="password" minlength="8"
                               class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                        <p class="text-xs text-rose-600" x-text="errorsEdit.password"></p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Ramal (opcional)</label>
                        <select x-model="formEdit.extension_id"
                                class="w-full px-3 py-2 rounded-lg border dark:border-slate-700 dark:bg-slate-900">
                            <option value="">— sem ramal —</option>
                            <template x-for="e in endpoints" :key="e">
                                <option :value="e" x-text="e"></option>
                            </template>
                        </select>
                        <p class="text-xs text-rose-600" x-text="errorsEdit.extension_id"></p>
                    </div>
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="closeEdit()" class="px-4 py-2 rounded-xl border dark:border-slate-700">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div class="fixed top-4 right-4 space-y-2 z-[60]">
        <template x-for="t in toasts" :key="t.id">
            <div x-text="t.text"
                 class="px-4 py-2 rounded-xl shadow bg-slate-900 text-white/90"></div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('usersPage', ({ initialUsers, endpoints }) => ({
        users: initialUsers,
        endpoints,
        search: '',
        showCreate: false,
        showEdit: false,
        current: null,
        toasts: [],
        errorsCreate: {},
        errorsEdit: {},
        formCreate: { name:'', email:'', password:'', extension_id:'' },
        formEdit:   { name:'', email:'', password:'', extension_id:'' },

        get filtered() {
            const s = this.search.trim().toLowerCase();
            if (!s) return this.users;
            return this.users.filter(u =>
                (u.name?.toLowerCase().includes(s)) ||
                (u.email?.toLowerCase().includes(s))
            );
        },

        csrf() { return document.querySelector('meta[name="csrf-token"]').content; },

        toast(text) {
            const id = Math.random().toString(36).slice(2);
            this.toasts.push({ id, text });
            setTimeout(() => this.toasts = this.toasts.filter(t => t.id !== id), 3000);
        },

        // CREATE
        openCreate(){ 
            this.errorsCreate = {};
            this.formCreate = { name:'', email:'', password:'', extension_id:'' };
            this.showCreate = true; 
        },
        closeCreate(){ this.showCreate = false; },
        async submitCreate(){
            this.errorsCreate = {};
            try{
                const res = await fetch(`{{ route('users.store') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.formCreate)
                });
                const json = await res.json();
                if(!res.ok){ 
                    if(json.errors) this.errorsCreate = json.errors;
                    else this.toast(json.message || 'Erro ao criar usuário');
                    return;
                }
                this.users.push(json.user);
                this.closeCreate();
                this.toast('Usuário criado com sucesso!');
            }catch(e){ this.toast('Erro de rede'); }
        },

        // EDIT
        openEdit(u){
            this.current = u;
            this.errorsEdit = {};
            this.formEdit = { 
                name: u.name, 
                email: u.email, 
                password: '', 
                extension_id: u.extension_id ?? '' 
            };
            this.showEdit = true;
        },
        closeEdit(){ this.showEdit = false; this.current = null; },
        async submitEdit(){
            if(!this.current) return;
            this.errorsEdit = {};
            try{
                const res = await fetch(`{{ url('/users') }}/${this.current.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.formEdit)
                });
                const json = await res.json();
                if(!res.ok){ 
                    if(json.errors) this.errorsEdit = json.errors;
                    else this.toast(json.message || 'Erro ao atualizar usuário');
                    return;
                }
                // Atualiza no array local
                const idx = this.users.findIndex(x => x.id === this.current.id);
                if (idx >= 0) this.users[idx] = json.user;
                this.closeEdit();
                this.toast('Usuário atualizado!');
            }catch(e){ this.toast('Erro de rede'); }
        },

        // DELETE
        async destroy(u){
            if(!confirm(`Excluir o usuário "${u.name}"?`)) return;
            try{
                const res = await fetch(`{{ url('/users') }}/${u.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.csrf(),
                        'Accept': 'application/json',
                    }
                });
                const json = await res.json();
                if(!res.ok){ this.toast(json.message || 'Erro ao excluir'); return; }
                this.users = this.users.filter(x => x.id !== u.id);
                this.toast('Usuário excluído.');
            }catch(e){ this.toast('Erro de rede'); }
        },
    }))
});
</script>
@endsection
