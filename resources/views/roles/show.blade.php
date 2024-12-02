@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detalhes da Função</h1>
        <div>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            @if($role->users->isEmpty())
                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Tem certeza que deseja excluir esta função?')">
                        <i class="fas fa-trash me-2"></i>Excluir
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações da Função</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nome</label>
                        <div class="fw-bold">{{ $role->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Descrição</label>
                        <div class="fw-bold">{{ $role->description ?: 'Sem descrição' }}</div>
                    </div>
                    <div>
                        <label class="form-label text-muted">Total de Usuários</label>
                        <div class="fw-bold">{{ $role->users->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Permissões</h5>
                </div>
                <div class="card-body">
                    @if($role->permissions->isNotEmpty())
                        <div class="row">
                            @foreach($role->permissions as $permission)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>{{ $permission->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Nenhuma permissão atribuída.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Usuários com esta Função</h5>
                </div>
                <div class="card-body">
                    @if($role->users->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->status)
                                                    <span class="badge bg-success">Ativo</span>
                                                @else
                                                    <span class="badge bg-danger">Inativo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Nenhum usuário com esta função.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
