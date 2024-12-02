@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Permissões</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Permissões</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user-lock me-1"></i>
                Gerenciar Permissões
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="fas fa-plus"></i> Novo Perfil
            </button>
        </div>
        <div class="card-body">
            <div class="accordion" id="rolesAccordion">
                <!-- Perfil Administrador -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#adminRole">
                            <i class="fas fa-user-shield me-2"></i> Administrador
                        </button>
                    </h2>
                    <div id="adminRole" class="accordion-collapse collapse show" data-bs-parent="#rolesAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label fw-bold">
                                                    Financeiro
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Receitas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Despesas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Fluxo de Caixa</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Conciliação</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label fw-bold">
                                                    Clientes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Visualizar</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Adicionar</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Editar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Excluir</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label fw-bold">
                                                    Relatórios
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Clientes</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Faturas</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Tickets</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Financeiro</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label fw-bold">
                                                    Configurações
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Empresa</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Usuários</label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Permissões</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Sistema</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perfil Usuário -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#userRole">
                            <i class="fas fa-user me-2"></i> Usuário
                        </button>
                    </h2>
                    <div id="userRole" class="accordion-collapse collapse" data-bs-parent="#rolesAccordion">
                        <div class="accordion-body">
                            <!-- Conteúdo similar ao do Administrador, mas com menos permissões marcadas -->
                        </div>
                    </div>
                </div>

                <!-- Perfil Cliente -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#clientRole">
                            <i class="fas fa-user-tie me-2"></i> Cliente
                        </button>
                    </h2>
                    <div id="clientRole" class="accordion-collapse collapse" data-bs-parent="#rolesAccordion">
                        <div class="accordion-body">
                            <!-- Conteúdo similar ao do Administrador, mas com permissões mínimas -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novo Perfil -->
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nome do Perfil</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Copiar Permissões de</label>
                        <select class="form-select">
                            <option value="">Selecione um perfil...</option>
                            <option>Administrador</option>
                            <option>Usuário</option>
                            <option>Cliente</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Criar Perfil</button>
            </div>
        </div>
    </div>
</div>
@endsection
