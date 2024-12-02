@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Lista de Tickets</h2>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Novo Ticket
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Filtros -->
        <div class="filters mb-4">
            <form action="{{ route('tickets.index') }}" method="GET" class="row g-3">
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
                            <option value="aberto" {{ request('status') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                            <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="fechado" {{ request('status') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select name="prioridade" id="prioridade" class="form-select">
                            <option value="">Todas</option>
                            <option value="baixa" {{ request('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ request('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ request('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select name="categoria" id="categoria" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                    {{ $categoria }}
                                </option>
                            @endforeach
                        </select>
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
                        <h6 class="card-title">Total de Tickets</h6>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6 class="card-title">Tickets Abertos</h6>
                        <h3 class="mb-0">{{ $stats['abertos'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">Em Andamento</h6>
                        <h3 class="mb-0">{{ $stats['em_andamento'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Resolvidos</h6>
                        <h3 class="mb-0">{{ $stats['fechados'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th width="100">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->cliente->razao_social ?? $ticket->cliente->nome_completo }}</td>
                        <td>{{ $ticket->titulo }}</td>
                        <td>
                            <span class="badge bg-{{ $ticket->status === 'aberto' ? 'danger' : ($ticket->status === 'em_andamento' ? 'warning' : 'success') }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $ticket->prioridade === 'alta' ? 'danger' : ($ticket->prioridade === 'media' ? 'warning' : 'info') }}">
                                {{ ucfirst($ticket->prioridade) }}
                            </span>
                        </td>
                        <td>{{ $ticket->categoria }}</td>
                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($ticket->status !== 'fechado')
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-success" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-ticket-alt fa-2x mb-3"></i>
                                <p class="mb-0">Nenhum ticket encontrado.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                Mostrando {{ $tickets->firstItem() ?? 0 }} até {{ $tickets->lastItem() ?? 0 }} de {{ $tickets->total() }} registros
            </div>
            <div>
                {{ $tickets->links() }}
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
