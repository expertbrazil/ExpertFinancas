@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detalhes da Fatura</h1>
        <div>
            <a href="{{ route('faturas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
            @if($fatura->url_boleto)
                <a href="{{ $fatura->url_boleto }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-barcode me-2"></i>Visualizar Boleto
                </a>
            @endif
            @if($fatura->status !== 'pago')
                <a href="{{ route('faturas.edit', $fatura) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações da Fatura</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Número da Fatura</label>
                            <div class="fw-bold">{{ $fatura->numero }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div>
                                @switch($fatura->status)
                                    @case('pendente')
                                        <span class="badge bg-warning">Pendente</span>
                                        @break
                                    @case('pago')
                                        <span class="badge bg-success">Pago</span>
                                        @break
                                    @case('vencido')
                                        <span class="badge bg-danger">Vencido</span>
                                        @break
                                    @case('cancelado')
                                        <span class="badge bg-secondary">Cancelado</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Data de Emissão</label>
                            <div class="fw-bold">{{ $fatura->data_emissao->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Data de Vencimento</label>
                            <div class="fw-bold">{{ $fatura->data_vencimento->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Valor Total</label>
                            <div class="fw-bold">R$ {{ number_format($fatura->valor, 2, ',', '.') }}</div>
                        </div>
                        @if($fatura->data_pagamento)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Data de Pagamento</label>
                                <div class="fw-bold">{{ $fatura->data_pagamento->format('d/m/Y') }}</div>
                            </div>
                        @endif
                    </div>

                    @if($fatura->linha_digitavel)
                        <div class="mt-3">
                            <label class="form-label text-muted">Linha Digitável</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $fatura->linha_digitavel }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $fatura->linha_digitavel }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    @endif
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
                        <div class="fw-bold">{{ $fatura->cliente->nome }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">CPF/CNPJ</label>
                        <div class="fw-bold">{{ $fatura->cliente->cpf_cnpj }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <div class="fw-bold">{{ $fatura->cliente->email }}</div>
                    </div>
                    <div>
                        <label class="form-label text-muted">Telefone</label>
                        <div class="fw-bold">{{ $fatura->cliente->telefone }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Linha digitável copiada para a área de transferência!');
    }).catch(err => {
        console.error('Erro ao copiar texto: ', err);
    });
}
</script>
@endpush
@endsection
