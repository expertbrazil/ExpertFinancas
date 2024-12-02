@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Relatório de Clientes</h1>
        <div>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="#" class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i>Exportar Excel
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>CPF/CNPJ</th>
                            <th>Total de Contas</th>
                            <th>Contas Pendentes</th>
                            <th>Status</th>
                            <th>Última Atualização</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->cpf_cnpj }}</td>
                                <td>{{ $cliente->contas_receber_count }}</td>
                                <td>
                                    @if($cliente->contas_receber_pendentes_count > 0)
                                        <span class="badge bg-warning">
                                            {{ $cliente->contas_receber_pendentes_count }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">0</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>{{ $cliente->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum cliente encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Estatísticas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Total de Clientes</label>
                            <div class="h4">{{ $clientes->count() }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Clientes Ativos</label>
                            <div class="h4">{{ $clientes->where('ativo', true)->count() }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Total de Contas</label>
                            <div class="h4">{{ $clientes->sum('contas_receber_count') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Contas Pendentes</label>
                            <div class="h4">{{ $clientes->sum('contas_receber_pendentes_count') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Gráfico de Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="clientesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('clientesChart').getContext('2d');
    const ativos = {{ $clientes->where('ativo', true)->count() }};
    const inativos = {{ $clientes->where('ativo', false)->count() }};

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ativos', 'Inativos'],
            datasets: [{
                data: [ativos, inativos],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
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
