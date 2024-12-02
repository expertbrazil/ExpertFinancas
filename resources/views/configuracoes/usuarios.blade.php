@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Usuários</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users-cog me-1"></i>
                Gerenciar Usuários
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i> Novo Usuário
            </button>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4 class="mb-0">25</h4>
                            <div class="small">Total de Usuários</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4 class="mb-0">20</h4>
                            <div class="small">Ativos</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4 class="mb-0">3</h4>
                            <div class="small">Administradores</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4 class="mb-0">5</h4>
                            <div class="small">Inativos</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th>Último Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="path/to/avatar.jpg" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                João Silva
                            </td>
                            <td>joao.silva@expertfinancas.com.br</td>
                            <td><span class="badge bg-primary">Administrador</span></td>
                            <td><span class="badge bg-success">Ativo</span></td>
                            <td>Hoje às 10:30</td>
                            <td>
                                <button class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Bloquear">
                                    <i class="fas fa-lock"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="path/to/avatar2.jpg" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                Maria Santos
                            </td>
                            <td>maria.santos@expertfinancas.com.br</td>
                            <td><span class="badge bg-info">Usuário</span></td>
                            <td><span class="badge bg-success">Ativo</span></td>
                            <td>Ontem às 15:45</td>
                            <td>
                                <button class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" title="Bloquear">
                                    <i class="fas fa-lock"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novo Usuário -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perfil</label>
                        <select class="form-select">
                            <option>Administrador</option>
                            <option>Usuário</option>
                            <option>Cliente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option>Ativo</option>
                            <option>Inativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection
