@extends('layouts.app')

@section('title', 'Novo Ticket')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Novo Ticket</h1>

    @include('layouts.partials.alerts')

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                @if(Auth::user()->isAdmin())
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->razao_social ?? $cliente->nome_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="suporte" {{ old('categoria') == 'suporte' ? 'selected' : '' }}>Suporte Técnico</option>
                        <option value="financeiro" {{ old('categoria') == 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                        <option value="comercial" {{ old('categoria') == 'comercial' ? 'selected' : '' }}>Comercial</option>
                        <option value="outros" {{ old('categoria') == 'outros' ? 'selected' : '' }}>Outros</option>
                    </select>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prioridade" class="form-label">Prioridade</label>
                    <select name="prioridade" id="prioridade" class="form-select @error('prioridade') is-invalid @enderror" required>
                        <option value="">Selecione a prioridade</option>
                        <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                    @error('prioridade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="5" required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Criar Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
