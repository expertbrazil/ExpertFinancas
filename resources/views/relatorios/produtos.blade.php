@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Relatório de Produtos</h1>
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
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produtos com Estoque Baixo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Código</th>
                                    <th>Categoria</th>
                                    <th class="text-end">Estoque Atual</th>
                                    <th class="text-end">Estoque Mínimo</th>
                                    <th class="text-end">Valor Unitário</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produtos->where('estoque', '<=', DB::raw('estoque_minimo')) as $produto)
                                    <tr class="{{ $produto->estoque == 0 ? 'table-danger' : 'table-warning' }}">
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->codigo }}</td>
                                        <td>{{ $produto->categoria->nome }}</td>
                                        <td class="text-end">{{ $produto->estoque }}</td>
                                        <td class="text-end">{{ $produto->estoque_minimo }}</td>
                                        <td class="text-end">R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                                        <td>
                                            @if($produto->estoque == 0)
                                                <span class="badge bg-danger">Sem Estoque</span>
                                            @else
                                                <span class="badge bg-warning">Estoque Baixo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhum produto com estoque baixo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Todos os Produtos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th class="text-end">Estoque</th>
                                    <th class="text-end">Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produtos as $produto)
                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->categoria->nome }}</td>
                                        <td class="text-end">{{ $produto->estoque }}</td>
                                        <td class="text-end">R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                                        <td>
                                            @if(!$produto->ativo)
                                                <span class="badge bg-danger">Inativo</span>
                                            @elseif($produto->estoque == 0)
                                                <span class="badge bg-danger">Sem Estoque</span>
                                            @elseif($produto->estoque <= $produto->estoque_minimo)
                                                <span class="badge bg-warning">Estoque Baixo</span>
                                            @else
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
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
                    <div class="mb-3">
                        <label class="form-label text-muted">Total de Produtos</label>
                        <div class="h4">{{ $produtos->count() }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Produtos Ativos</label>
                        <div class="h4">{{ $produtos->where('ativo', true)->count() }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Produtos sem Estoque</label>
                        <div class="h4">{{ $produtos->where('estoque', 0)->count() }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Produtos com Estoque Baixo</label>
                        <div class="h4">{{ $produtos->where('estoque', '>', 0)->where('estoque', '<=', DB::raw('estoque_minimo'))->count() }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Valor Total em Estoque</label>
                        <div class="h4">R$ {{ number_format($produtos->sum(DB::raw('estoque * valor')), 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Status do Estoque</h5>
                </div>
                <div class="card-body">
                    <canvas id="estoqueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('estoqueChart').getContext('2d');
    const semEstoque = {{ $produtos->where('estoque', 0)->count() }};
    const estoqueBaixo = {{ $produtos->where('estoque', '>', 0)->where('estoque', '<=', DB::raw('estoque_minimo'))->count() }};
    const estoqueNormal = {{ $produtos->where('estoque', '>', DB::raw('estoque_minimo'))->count() }};

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Sem Estoque', 'Estoque Baixo', 'Estoque Normal'],
            datasets: [{
                data: [semEstoque, estoqueBaixo, estoqueNormal],
                backgroundColor: ['#dc3545', '#ffc107', '#198754']
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
