@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Usuários</h1>
        @if(auth()->user()->role === 'root' || auth()->user()->role === 'admin')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Usuário
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Permissão</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'root' ? 'danger' : ($user->role === 'admin' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->ativo ? 'success' : 'warning' }}">
                                        {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        @if(auth()->user()->role === 'root' || 
                                            (auth()->user()->role === 'admin' && $user->role !== 'root'))
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Editar Usuário">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('users.password.edit', $user) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Alterar Senha">
                                                <i class="fas fa-key"></i>
                                            </a>
                                        @endif

                                        @if(auth()->user()->role === 'root')
                                            @if($user->email !== 'root@expertfinancas.com.br')
                                                <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-{{ $user->ativo ? 'danger' : 'success' }} d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="{{ $user->ativo ? 'Desativar Usuário' : 'Ativar Usuário' }}">
                                                        <i class="fas fa-{{ $user->ativo ? 'ban' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="return confirm('Tem certeza que deseja excluir este usuário?')" title="Excluir Usuário">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nenhum usuário encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
