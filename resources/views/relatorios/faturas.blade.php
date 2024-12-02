@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Relatório de Faturas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Relatório de Faturas</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-invoice-dollar me-1"></i>
                Relatório de Faturas
            </div>
            <div>
                <button class="btn btn-success btn-sm me-2">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Exportar PDF
                </button>
            </div>
        </div>
        <div class="card-body">
            <form class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Data Inicial</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data Final</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option>Pago</option>
                        <option>Pendente</option>
                        <option>Atrasado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cliente</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option>Empresa ABC</option>
                        <option>Cliente XYZ</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4 class="mb-0">150</h4>
                            <div class="small">Total de Faturas</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4 class="mb-0">R$ 125.000,00</h4>
                            <div class="small">Valor Total</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4 class="mb-0">R$ 15.000,00</h4>
                            <div class="small">Pendente</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4 class="mb-0">R$ 5.000,00</h4>
                            <div class="small">Atrasado</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nº Fatura</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Data Vencimento</th>
                            <th>Data Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>15/05/2024</td>
                            <td>Empresa ABC</td>
                            <td>R$ 2.500,00</td>
                            <td><span class="badge bg-success">Pago</span></td>
                            <td>20/05/2024</td>
                            <td>18/05/2024</td>
                        </tr>
                        <tr>
                            <td>#1002</td>
                            <td>16/05/2024</td>
                            <td>Cliente XYZ</td>
                            <td>R$ 1.800,00</td>
                            <td><span class="badge bg-warning">Pendente</span></td>
                            <td>25/05/2024</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
