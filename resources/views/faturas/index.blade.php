@extends('layouts.app')

@section('title', 'Faturas')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Lista de Faturas</h2>
                <a href="{{ route('faturas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Fatura
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filtros -->
            <div class="filters mb-4">
                <form action="{{ route('faturas.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" name="cliente" id="cliente" class="form-control" 
                                   value="{{ request('cliente') }}" placeholder="Nome do cliente">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Todos</option>
                                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                                <option value="vencido" {{ request('status') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                                <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="data_inicio" class="form-label">Data Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control" 
                                   value="{{ request('data_inicio') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="data_fim" class="form-label">Data Fim</label>
                            <input type="date" name="data_fim" id="data_fim" class="form-control" 
                                   value="{{ request('data_fim') }}">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-group w-100">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Resumo -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="card-title">Total de Faturas</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6 class="card-title">Valor Total</h6>
                            <h3 class="mb-0">R$ {{ number_format($stats['valor_total'], 2, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6 class="card-title">Pendentes</h6>
                            <h3 class="mb-0">{{ $stats['pendentes'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title">Vencidas</h6>
                            <h3 class="mb-0">{{ $stats['vencidas'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Vencimento</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faturas as $fatura)
                            <tr>
                                <td>{{ $fatura->id }}</td>
                                <td>{{ $fatura->cliente->nome }}</td>
                                <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $fatura->status_class }}">
                                        {{ $fatura->status_text }}
                                    </span>
                                </td>
                                <td>{{ $fatura->vencimento->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('faturas.show', $fatura) }}" class="btn btn-sm btn-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('faturas.edit', $fatura) }}" class="btn btn-sm btn-success" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('faturas.destroy', $fatura) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" 
                                                    onclick="return confirm('Tem certeza que deseja excluir esta fatura?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-3"></i>
                                        <p class="mb-0">Nenhuma fatura encontrada.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Mostrando {{ $faturas->firstItem() ?? 0 }} até {{ $faturas->lastItem() ?? 0 }} de {{ $faturas->total() }} registros
                </div>
                <div>
                    {{ $faturas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .filters {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .card .badge {
        padding: 0.5em 0.8em;
        font-size: 0.85em;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endpush
