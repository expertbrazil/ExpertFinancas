@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Tickets</h1>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Novo Ticket</a>
    </div>

    @include('layouts.partials.alerts')

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Título</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Ações</th>
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
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhum ticket encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-end">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
