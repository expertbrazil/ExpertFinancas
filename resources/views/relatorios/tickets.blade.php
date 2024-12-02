@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Relatório de Tickets</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Relatório de Tickets</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-ticket-alt me-1"></i>
                Relatório de Tickets
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
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option>Aberto</option>
                        <option>Em Andamento</option>
                        <option>Resolvido</option>
                        <option>Fechado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Prioridade</label>
                    <select class="form-select">
                        <option value="">Todas</option>
                        <option>Baixa</option>
                        <option>Média</option>
                        <option>Alta</option>
                    </select>
                </div>
                <div class="col-md-2">
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
                            <h4 class="mb-0">85</h4>
                            <div class="small">Total de Tickets</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4 class="mb-0">65</h4>
                            <div class="small">Resolvidos</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4 class="mb-0">15</h4>
                            <div class="small">Em Andamento</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4 class="mb-0">5</h4>
                            <div class="small">Atrasados</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Tickets por Status
                        </div>
                        <div class="card-body">
                            <canvas id="ticketsStatusChart" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Tempo Médio de Resolução (dias)
                        </div>
                        <div class="card-body">
                            <canvas id="tempoResolucaoChart" width="100%" height="50"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data Abertura</th>
                            <th>Cliente</th>
                            <th>Assunto</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Tempo Resolução</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#2001</td>
                            <td>15/05/2024</td>
                            <td>Empresa ABC</td>
                            <td>Problema no acesso</td>
                            <td><span class="badge bg-danger">Alta</span></td>
                            <td><span class="badge bg-success">Resolvido</span></td>
                            <td>2 dias</td>
                        </tr>
                        <tr>
                            <td>#2002</td>
                            <td>16/05/2024</td>
                            <td>Cliente XYZ</td>
                            <td>Dúvida sobre relatório</td>
                            <td><span class="badge bg-warning">Média</span></td>
                            <td><span class="badge bg-warning">Em Andamento</span></td>
                            <td>1 dia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Status dos Tickets
    var ctxStatus = document.getElementById('ticketsStatusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: ['Resolvidos', 'Em Andamento', 'Abertos', 'Atrasados'],
            datasets: [{
                data: [65, 15, 10, 5],
                backgroundColor: [
                    'rgb(40, 167, 69)',
                    'rgb(255, 193, 7)',
                    'rgb(0, 123, 255)',
                    'rgb(220, 53, 69)'
                ]
            }]
        }
    });

    // Gráfico de Tempo de Resolução
    var ctxTempo = document.getElementById('tempoResolucaoChart').getContext('2d');
    new Chart(ctxTempo, {
        type: 'bar',
        data: {
            labels: ['Alta', 'Média', 'Baixa'],
            datasets: [{
                label: 'Tempo Médio (dias)',
                data: [2, 3, 5],
                backgroundColor: [
                    'rgb(220, 53, 69)',
                    'rgb(255, 193, 7)',
                    'rgb(40, 167, 69)'
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection
