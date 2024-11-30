@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Novo Plano de Hospedagem</h1>
        <a href="{{ route('planos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('planos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome do Plano</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Imagem</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/png,image/jpeg,image/svg+xml,image/webp">
                        <small class="text-muted">Formatos permitidos: PNG, JPEG, SVG, WEBP. Tamanho máximo: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="monthly_price" class="form-label">Preço Mensal</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" 
                                   class="form-control money @error('monthly_price') is-invalid @enderror" 
                                   id="monthly_price" name="monthly_price" 
                                   value="{{ old('monthly_price') }}" required>
                        </div>
                        @error('monthly_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="semiannual_price" class="form-label">Preço Semestral</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" 
                                   class="form-control money @error('semiannual_price') is-invalid @enderror" 
                                   id="semiannual_price" name="semiannual_price" 
                                   value="{{ old('semiannual_price') }}" required>
                        </div>
                        @error('semiannual_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="annual_price" class="form-label">Preço Anual</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" 
                                   class="form-control money @error('annual_price') is-invalid @enderror" 
                                   id="annual_price" name="annual_price" 
                                   value="{{ old('annual_price') }}" required>
                        </div>
                        @error('annual_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição do Plano</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                               {{ old('active') ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Plano Ativo</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Plano
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.money').mask('#.##0,00', {
        reverse: true,
        placeholder: '0,00'
    });

    $('form').submit(function() {
        $('.money').each(function() {
            var value = $(this).val().replace(/\./g, '').replace(',', '.');
            $(this).val(value);
        });
    });
});
</script>
@endpush
@endsection
