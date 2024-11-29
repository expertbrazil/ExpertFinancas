@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Usuário
        </a>
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
                                    <span class="badge bg-{{ $user->role->name === 'root' ? 'danger' : ($user->role->name === 'admin' ? 'primary' : 'info') }}">
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->ativo ? 'success' : 'warning' }}">
                                        {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        @if($user->email !== 'root@expertfinancas.com.br')
                                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                                <img src="{{ asset('images/edit.svg') }}" alt="Editar Usuário" title="Editar Usuário" class="w-8 h-8">
                                            </a>
                                            <a href="{{ route('users.password.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900">
                                                <img src="{{ asset('images/key.svg') }}" alt="Alterar Senha" title="Alterar Senha" class="w-8 h-8">
                                            </a>
                                            <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-{{ $user->ativo ? 'red' : 'green' }}-600 hover:text-{{ $user->ativo ? 'red' : 'green' }}-900" title="{{ $user->ativo ? 'Desativar' : 'Ativar' }}">
                                                    <img src="{{ asset('images/' . ($user->ativo ? 'ban' : 'check') . '.svg') }}" alt="{{ $user->ativo ? 'Desativar' : 'Ativar' }}" class="w-8 h-8">
                                                </button>
                                            </form>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este usuário?')" title="Excluir Usuário">
                                                    <img src="{{ asset('images/trash.svg') }}" alt="Excluir Usuário" class="w-8 h-8">
                                                </button>
                                            </form>
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
