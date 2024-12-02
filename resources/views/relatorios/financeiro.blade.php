@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Relatório Financeiro</h1>
        <div>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="#" class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i>Exportar Excel
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('relatorios.financeiro') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                        value="{{ $dataInicio->format('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                        value="{{ $dataFim->format('Y-m-d') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total a Receber</h5>
                    <h2 class="mb-0">R$ {{ number_format($totalReceber, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total a Pagar</h5>
                    <h2 class="mb-0">R$ {{ number_format($totalPagar, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card {{ $saldo >= 0 ? 'bg-success' : 'bg-danger' }} text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Saldo</h5>
                    <h2 class="mb-0">R$ {{ number_format($saldo, 2, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Contas a Receber</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Categoria</th>
                                    <th>Vencimento</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contasReceber as $conta)
                                    <tr>
                                        <td>{{ $conta->cliente->nome }}</td>
                                        <td>{{ $conta->categoria->nome }}</td>
                                        <td>{{ $conta->data_vencimento->format('d/m/Y') }}</td>
                                        <td class="text-end">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhuma conta a receber encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">R$ {{ number_format($totalReceber, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Contas a Pagar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Categoria</th>
                                    <th>Vencimento</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contasPagar as $conta)
                                    <tr>
                                        <td>{{ $conta->fornecedor->nome }}</td>
                                        <td>{{ $conta->categoria->nome }}</td>
                                        <td>{{ $conta->data_vencimento->format('d/m/Y') }}</td>
                                        <td class="text-end">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhuma conta a pagar encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">R$ {{ number_format($totalPagar, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
    .bg-primary { background-color: #0d6efd !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-success { background-color: #198754 !important; }
}
</style>
@endpush
@endsection
