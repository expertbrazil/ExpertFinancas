@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Editar Plano de Hospedagem</h1>
        <a href="{{ route('hosting-plans.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hosting-plans.update', $hostingPlan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome do Plano</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $hostingPlan->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Imagem</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($hostingPlan->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $hostingPlan->image) }}" 
                                     alt="{{ $hostingPlan->name }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 100px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="monthly_price" class="form-label">Preço Mensal</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('monthly_price') is-invalid @enderror" 
                                   id="monthly_price" name="monthly_price" 
                                   value="{{ old('monthly_price', $hostingPlan->monthly_price) }}" required>
                        </div>
                        @error('monthly_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="semiannual_price" class="form-label">Preço Semestral</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('semiannual_price') is-invalid @enderror" 
                                   id="semiannual_price" name="semiannual_price" 
                                   value="{{ old('semiannual_price', $hostingPlan->semiannual_price) }}" required>
                        </div>
                        @error('semiannual_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="annual_price" class="form-label">Preço Anual</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" min="0" 
                                   class="form-control @error('annual_price') is-invalid @enderror" 
                                   id="annual_price" name="annual_price" 
                                   value="{{ old('annual_price', $hostingPlan->annual_price) }}" required>
                        </div>
                        @error('annual_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição do Plano</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $hostingPlan->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                               {{ old('active', $hostingPlan->active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Plano Ativo</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Atualizar Plano
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
