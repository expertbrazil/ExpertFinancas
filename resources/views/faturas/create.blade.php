@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Nova Fatura</h1>
        <a href="{{ route('faturas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('faturas.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }} ({{ $cliente->cpf_cnpj }})
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numero" class="form-label">Número da Fatura</label>
                        <input type="text" name="numero" id="numero" class="form-control @error('numero') is-invalid @enderror"
                            value="{{ old('numero') }}" required>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="data_emissao" class="form-label">Data de Emissão</label>
                        <input type="date" name="data_emissao" id="data_emissao" 
                            class="form-control @error('data_emissao') is-invalid @enderror"
                            value="{{ old('data_emissao', date('Y-m-d')) }}" required>
                        @error('data_emissao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                        <input type="date" name="data_vencimento" id="data_vencimento" 
                            class="form-control @error('data_vencimento') is-invalid @enderror"
                            value="{{ old('data_vencimento') }}" required>
                        @error('data_vencimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" name="valor" id="valor" step="0.01" min="0"
                                class="form-control @error('valor') is-invalid @enderror"
                                value="{{ old('valor') }}" required>
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="pago" {{ old('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                            <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Atualiza a data de vencimento para 30 dias após a data de emissão quando esta é alterada
    document.getElementById('data_emissao').addEventListener('change', function() {
        const dataEmissao = new Date(this.value);
        const dataVencimento = new Date(dataEmissao);
        dataVencimento.setDate(dataVencimento.getDate() + 30);
        
        const dataVencimentoFormatada = dataVencimento.toISOString().split('T')[0];
        document.getElementById('data_vencimento').value = dataVencimentoFormatada;
    });
});
</script>
@endpush
