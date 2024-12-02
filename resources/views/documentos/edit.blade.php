@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Editar Documento</h1>
        <div>
            <a href="{{ route('documentos.show', $documento) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('documentos.update', $documento) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" 
                                    {{ old('cliente_id', $documento->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }} ({{ $cliente->cpf_cnpj }})
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tipo" class="form-label">Tipo de Documento</label>
                        <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="">Selecione o tipo</option>
                            <option value="contrato" {{ old('tipo', $documento->tipo) == 'contrato' ? 'selected' : '' }}>Contrato</option>
                            <option value="nota_fiscal" {{ old('tipo', $documento->tipo) == 'nota_fiscal' ? 'selected' : '' }}>Nota Fiscal</option>
                            <option value="recibo" {{ old('tipo', $documento->tipo) == 'recibo' ? 'selected' : '' }}>Recibo</option>
                            <option value="outros" {{ old('tipo', $documento->tipo) == 'outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="titulo" class="form-label">Título do Documento</label>
                        <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror"
                            value="{{ old('titulo', $documento->titulo) }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="3" 
                            class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $documento->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="arquivo" class="form-label">Arquivo</label>
                        <input type="file" name="arquivo" id="arquivo" 
                            class="form-control @error('arquivo') is-invalid @enderror">
                        <small class="text-muted">Tamanho máximo: 10MB. Deixe em branco para manter o arquivo atual.</small>
                        @if($documento->arquivo_nome)
                            <div class="mt-2">
                                <strong>Arquivo atual:</strong> {{ $documento->arquivo_nome }}
                                ({{ number_format($documento->arquivo_tamanho / 1024 / 1024, 2) }} MB)
                            </div>
                        @endif
                        @error('arquivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
