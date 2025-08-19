@extends('layouts.app')

@section('content')
<h1>Gerenciar Tenants e Usuários</h1>

{{-- Formulário para criar nova empresa/tenant --}}
<form method="POST" action="{{ route('register-tenant') }}">
    @csrf
    <h3>Novo Tenant</h3>
    <input type="text" name="tenant_name" placeholder="Nome da empresa" required class="form-input">
    <input type="text" name="subdomain" placeholder="Slug interno" required class="form-input">
    <input type="text" name="name" placeholder="Nome do usuário admin" required class="form-input">
    <input type="email" name="email" placeholder="Email do admin" required class="form-input">
    <input type="password" name="password" placeholder="Senha" required class="form-input">
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required class="form-input">
    <button class="btn btn-primary" type="submit">Criar Empresa</button>
</form>

{{-- Formulário para criar novo usuário no tenant atual --}}
<form method="POST" action="{{ route('register-user') }}" style="margin-top:40px;">
    @csrf
    <h3>Novo Usuário</h3>
    <input type="text" name="name" placeholder="Nome" required class="form-input">
    <input type="email" name="email" placeholder="Email" required class="form-input">
    <input type="password" name="password" placeholder="Senha" required class="form-input">
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required class="form-input">
    <button class="btn btn-primary" type="submit">Criar Usuário</button>
</form>
@endsection
