@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Relatório de Serviços</h1>
        <div>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="#" class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i>Exportar Excel
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lista de Serviços</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Serviço</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Clientes</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($servicos as $servico)
                                    <tr>
                                        <td>{{ $servico->nome }}</td>
                                        <td>{{ Str::limit($servico->descricao, 50) }}</td>
                                        <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $servico->clientes_count }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($servico->ativo)
                                                <span class="badge bg-success">Ativo</span>
                                            @else
                                                <span class="badge bg-danger">Inativo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum serviço encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Estatísticas</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label text-muted">Total de Serviços</label>
                        <div class="h4">{{ $servicos->count() }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted">Serviços Ativos</label>
                        <div class="h4">{{ $servicos->where('ativo', true)->count() }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted">Total de Clientes</label>
                        <div class="h4">{{ $servicos->sum('clientes_count') }}</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted">Valor Médio</label>
                        <div class="h4">R$ {{ number_format($servicos->avg('valor'), 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribuição de Clientes</h5>
                </div>
                <div class="card-body">
                    <canvas id="servicosChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('servicosChart').getContext('2d');
    const servicos = @json($servicos->pluck('nome', 'clientes_count'));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.values(servicos),
            datasets: [{
                label: 'Número de Clientes',
                data: Object.keys(servicos),
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});

function exportToExcel() {
    // Implementar exportação para Excel usando biblioteca adequada
    alert('Funcionalidade de exportação será implementada em breve!');
}
</script>
@endpush

@push('styles')
<style>
@media print {
    .btn { display: none; }
    .card { border: none !important; }
}
</style>
@endpush
@endsection
