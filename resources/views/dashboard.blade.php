@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s;
        border: 1px solid #e9ecef;
    }
    .stats-card:hover {
        transform: translateY(-2px);
    }
    .stats-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 15px;
    }
    .stats-value {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }
    .stats-label {
        color: #6c757d;
        font-size: 14px;
    }
    .chart-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
    .activities-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e9ecef;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Cards de Estatísticas -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stats-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary-subtle">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <div>
                        <div class="stats-value">R$ {{ number_format($faturamentoMensal ?? 0, 2, ',', '.') }}</div>
                        <div class="stats-label">Faturamento Mensal</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stats-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success-subtle">
                        <i class="fas fa-users text-success"></i>
                    </div>
                    <div>
                        <div class="stats-value">{{ $clientesAtivos ?? 0 }}</div>
                        <div class="stats-label">Clientes Ativos</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stats-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info-subtle">
                        <i class="fas fa-file-invoice text-info"></i>
                    </div>
                    <div>
                        <div class="stats-value">{{ $contasReceber ?? 0 }}</div>
                        <div class="stats-label">Contas a Receber</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stats-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning-subtle">
                        <i class="fas fa-wallet text-warning"></i>
                    </div>
                    <div>
                        <div class="stats-value">R$ {{ number_format($contasPagar ?? 0, 2, ',', '.') }}</div>
                        <div class="stats-label">Contas a Pagar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Gráfico de Faturamento -->
        <div class="col-12 col-lg-8">
            <div class="chart-container">
                <h5 class="mb-4">Faturamento nos Últimos 12 Meses</h5>
                <canvas id="faturamentoChart" height="300"></canvas>
            </div>
        </div>

        <!-- Atividades Recentes -->
        <div class="col-12 col-lg-4">
            <div class="activities-container">
                <h5 class="mb-4">Últimas Atividades</h5>
                <div class="activities-list">
                    @forelse($ultimasAtividades ?? [] as $atividade)
                        <div class="activity-item d-flex align-items-center py-2">
                            <div class="activity-icon me-3">
                                <i class="fas fa-circle-dot text-primary"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-text">{{ $atividade->descricao }}</div>
                                <small class="text-muted">{{ $atividade->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Nenhuma atividade recente</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Próximos Vencimentos -->
        <div class="col-12">
            <div class="table-container p-4">
                <h5 class="mb-4">Próximos Vencimentos</h5>
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
                                    <td>{{ $vencimento->cliente }}</td>
                                    <td>{{ $vencimento->servico }}</td>
                                    <td>{{ $vencimento->data_vencimento->format('d/m/Y') }}</td>
                                    <td>R$ {{ number_format($vencimento->valor, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $vencimento->status_color }}">
                                            {{ $vencimento->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('faturamentoChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? array_map(function($m) { return date('M', mktime(0, 0, 0, $m, 1)); }, range(1, 12))) !!},
            datasets: [{
                label: 'Faturamento',
                data: {!! json_encode($faturamentoData ?? array_fill(0, 12, 0)) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
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

// Sessão de logout automático
let sessionTimeout;
function resetSessionTimeout() {
    clearTimeout(sessionTimeout);
    sessionTimeout = setTimeout(() => {
        alert('Sessão expirada. Você será deslogado.');
        window.location.href = '{{ route('logout') }}';
    }, 15 * 60 * 1000); // 15 minutos
}

document.addEventListener('mousemove', resetSessionTimeout);
document.addEventListener('keypress', resetSessionTimeout);
resetSessionTimeout();
</script>
@endpush
