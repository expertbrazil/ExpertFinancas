@extends('layouts.app')

@section('title', 'Visualizar Ticket')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Ticket #{{ $ticket->id }}</h1>
        <div>
            @if(Auth::user()->isAdmin())
            <form action="{{ route('tickets.update-status', $ticket) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                    <option value="aberto" {{ $ticket->status === 'aberto' ? 'selected' : '' }}>Aberto</option>
                    <option value="em_andamento" {{ $ticket->status === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="fechado" {{ $ticket->status === 'fechado' ? 'selected' : '' }}>Fechado</option>
                </select>
            </form>
            @endif
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Ticket Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket->titulo }}</h5>
                    <div class="mb-3">
                        <span class="badge bg-{{ $ticket->status === 'aberto' ? 'danger' : ($ticket->status === 'em_andamento' ? 'warning' : 'success') }} me-2">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <span class="badge bg-{{ $ticket->prioridade === 'alta' ? 'danger' : ($ticket->prioridade === 'media' ? 'warning' : 'info') }} me-2">
                            {{ ucfirst($ticket->prioridade) }}
                        </span>
                        <span class="badge bg-secondary">{{ $ticket->categoria }}</span>
                    </div>
                    <p class="card-text">{{ $ticket->descricao }}</p>
                    <small class="text-muted">
                        Criado por {{ $ticket->user->name }} em {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>

            <!-- Respostas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Respostas</h5>
                </div>
                <div class="card-body">
                    @forelse($ticket->respostas as $resposta)
                    <div class="border-bottom mb-3 pb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $resposta->user->name }}</strong>
                                @if($resposta->is_staff)
                                <span class="badge bg-primary ms-2">Staff</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $resposta->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mb-0">{{ $resposta->resposta }}</p>
                    </div>
                    @empty
                    <p class="text-center text-muted">Nenhuma resposta ainda.</p>
                    @endforelse

                    @if($ticket->status !== 'fechado')
                    <form action="{{ route('tickets.responder', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="resposta" class="form-label">Sua Resposta</label>
                            <textarea class="form-control @error('resposta') is-invalid @enderror" id="resposta" name="resposta" rows="3" required>{{ old('resposta') }}</textarea>
                            @error('resposta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Resposta</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Informações do Cliente -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Cliente</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Cliente:</strong> {{ $ticket->cliente->razao_social ?? $ticket->cliente->nome_completo }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $ticket->cliente->email }}</p>
                    <p class="mb-0"><strong>Telefone:</strong> {{ $ticket->cliente->telefone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
