@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Conciliação Bancária</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Conciliação Bancária</li>
    </ol>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 24.000,00</h4>
                    <div class="small">Saldo Sistema</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 24.000,00</h4>
                    <div class="small">Saldo Bancário</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 0,00</h4>
                    <div class="small">Diferença</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">15</h4>
                    <div class="small">Itens Pendentes</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-check-double me-1"></i>
                Conciliação Bancária
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importarExtrato">
                <i class="fas fa-upload"></i> Importar Extrato
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor Sistema</th>
                            <th>Valor Banco</th>
                            <th>Diferença</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15/05/2024</td>
                            <td>Consultoria Financeira</td>
                            <td>R$ 2.500,00</td>
                            <td>R$ 2.500,00</td>
                            <td>R$ 0,00</td>
                            <td><span class="badge bg-success">Conciliado</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>10/05/2024</td>
                            <td>Aluguel Escritório</td>
                            <td>R$ 3.500,00</td>
                            <td>-</td>
                            <td>R$ 3.500,00</td>
                            <td><span class="badge bg-warning">Pendente</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Importar Extrato -->
<div class="modal fade" id="importarExtrato" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Extrato Bancário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Banco</label>
                        <select class="form-select">
                            <option>Selecione o banco</option>
                            <option>Banco do Brasil</option>
                            <option>Itaú</option>
                            <option>Bradesco</option>
                            <option>Santander</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Arquivo do Extrato</label>
                        <input type="file" class="form-control">
                        <div class="form-text">Formatos aceitos: OFX, CSV</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Período</label>
                        <div class="row">
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Data Inicial">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Data Final">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Importar</button>
            </div>
        </div>
    </div>
</div>
@endsection
