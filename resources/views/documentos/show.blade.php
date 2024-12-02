@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detalhes do Documento</h1>
        <div>
            <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
            <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Editar
            </a>
            <a href="{{ Storage::url($documento->arquivo_path) }}" target="_blank" class="btn btn-info">
                <i class="fas fa-eye me-2"></i>Visualizar
            </a>
            <a href="{{ route('documentos.download', $documento) }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Download
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações do Documento</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Título</label>
                            <div class="fw-bold">{{ $documento->titulo }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Tipo</label>
                            <div>
                                @switch($documento->tipo)
                                    @case('contrato')
                                        <span class="badge bg-primary">Contrato</span>
                                        @break
                                    @case('nota_fiscal')
                                        <span class="badge bg-info">Nota Fiscal</span>
                                        @break
                                    @case('recibo')
                                        <span class="badge bg-success">Recibo</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Outros</span>
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Data de Upload</label>
                            <div class="fw-bold">{{ $documento->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
                                @if($documento->status)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Descrição</label>
                            <div class="fw-bold">{{ $documento->descricao ?: 'Nenhuma descrição fornecida.' }}</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted">Informações do Arquivo</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <th width="200">Nome do Arquivo</th>
                                    <td>{{ $documento->arquivo_nome }}</td>
                                </tr>
                                <tr>
                                    <th>Tipo do Arquivo</th>
                                    <td>{{ $documento->arquivo_tipo }}</td>
                                </tr>
                                <tr>
                                    <th>Tamanho</th>
                                    <td>{{ number_format($documento->arquivo_tamanho / 1024 / 1024, 2) }} MB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações do Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nome</label>
                        <div class="fw-bold">{{ $documento->cliente->nome }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">CPF/CNPJ</label>
                        <div class="fw-bold">{{ $documento->cliente->cpf_cnpj }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <div class="fw-bold">{{ $documento->cliente->email }}</div>
                    </div>
                    <div>
                        <label class="form-label text-muted">Telefone</label>
                        <div class="fw-bold">{{ $documento->cliente->telefone }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
