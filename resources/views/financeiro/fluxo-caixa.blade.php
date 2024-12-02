@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Fluxo de Caixa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Fluxo de Caixa</li>
    </ol>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 24.000,00</h4>
                    <div class="small">Saldo Atual</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 15.750,00</h4>
                    <div class="small">Total Entradas (Mês)</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 8.250,00</h4>
                    <div class="small">Total Saídas (Mês)</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h4 class="mb-0">R$ 7.500,00</h4>
                    <div class="small">Saldo do Mês</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-line me-1"></i>
            Movimentação Financeira
        </div>
        <div class="card-body">
            <canvas id="fluxoCaixaChart" width="100%" height="40"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Distribuição de Receitas
                </div>
                <div class="card-body">
                    <canvas id="receitasChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Distribuição de Despesas
                </div>
                <div class="card-body">
                    <canvas id="despesasChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Extrato
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15/05/2024</td>
                        <td>Consultoria Financeira</td>
                        <td><span class="badge bg-success">Entrada</span></td>
                        <td>Serviços</td>
                        <td class="text-success">+ R$ 2.500,00</td>
                        <td>R$ 24.000,00</td>
                    </tr>
                    <tr>
                        <td>10/05/2024</td>
                        <td>Aluguel Escritório</td>
                        <td><span class="badge bg-danger">Saída</span></td>
                        <td>Infraestrutura</td>
                        <td class="text-danger">- R$ 3.500,00</td>
                        <td>R$ 21.500,00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Fluxo de Caixa
    var ctx = document.getElementById('fluxoCaixaChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Entradas',
                data: [12000, 15000, 13000, 14500, 15750, 16000],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
            {
                label: 'Saídas',
                data: [8000, 7500, 8500, 8000, 8250, 8700],
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Receitas
    var ctxReceitas = document.getElementById('receitasChart').getContext('2d');
    new Chart(ctxReceitas, {
        type: 'pie',
        data: {
            labels: ['Serviços', 'Produtos', 'Outros'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: [
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ]
            }]
        }
    });

    // Gráfico de Despesas
    var ctxDespesas = document.getElementById('despesasChart').getContext('2d');
    new Chart(ctxDespesas, {
        type: 'pie',
        data: {
            labels: ['Infraestrutura', 'Pessoal', 'Suprimentos', 'Serviços'],
            datasets: [{
                data: [40, 35, 15, 10],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)'
                ]
            }]
        }
    });
</script>
@endpush
@endsection
