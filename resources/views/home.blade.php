@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <div>
            <button class="btn btn-primary">
                <i class="fas fa-download me-2"></i>Exportar Relatório
            </button>
        </div>
    </div>

    <!-- Cards Informativos -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Faturamento Mensal</div>
                            <div class="h5 mb-0">R$ {{ number_format($faturamentoMensal ?? 0, 2, ',', '.') }}</div>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Clientes Ativos</div>
                            <div class="h5 mb-0">{{ $clientesAtivos ?? 0 }}</div>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Contas a Receber</div>
                            <div class="h5 mb-0">R$ {{ number_format($contasReceber ?? 0, 2, ',', '.') }}</div>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small mb-1">Contas a Pagar</div>
                            <div class="h5 mb-0">R$ {{ number_format($contasPagar ?? 0, 2, ',', '.') }}</div>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-money-bill-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Tabelas -->
    <div class="row">
        <!-- Gráfico de Faturamento -->
        <div class="col-xl-8 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Faturamento nos Últimos 12 Meses</h5>
                </div>
                <div class="card-body">
                    <canvas id="faturamentoChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Últimas Atividades -->
        <div class="col-xl-4 mb-4">
            <div class="card card-dashboard h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Últimas Atividades</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($ultimasAtividades ?? [] as $atividade)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $atividade->descricao ?? 'Atividade' }}</h6>
                                    <small class="text-muted">{{ $atividade->data ?? 'Data' }}</small>
                                </div>
                                <p class="mb-1 small text-muted">{{ $atividade->detalhes ?? 'Detalhes da atividade' }}</p>
                            </div>
                        @empty
                            <div class="list-group-item">
                                <p class="mb-0 text-muted">Nenhuma atividade recente</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximos Vencimentos -->
    <div class="row">
        <div class="col-12">
            <div class="card card-dashboard">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Próximos Vencimentos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proximosVencimentos ?? [] as $vencimento)
                                    <tr>
                                        <td>{{ $vencimento->cliente ?? 'Cliente' }}</td>
                                        <td>{{ $vencimento->servico ?? 'Serviço' }}</td>
                                        <td>{{ $vencimento->data ?? 'Data' }}</td>
                                        <td>R$ {{ number_format($vencimento->valor ?? 0, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $vencimento->status_cor ?? 'warning' }}">
                                                {{ $vencimento->status ?? 'Pendente' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum vencimento próximo</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Faturamento
    var ctx = document.getElementById('faturamentoChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'Faturamento',
                data: {{ json_encode($dadosFaturamento ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }},
                borderColor: 'rgb(13, 110, 253)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
