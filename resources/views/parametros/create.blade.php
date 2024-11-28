@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Nova Configuração</h2>
        <a href="{{ route('parametros.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('parametros.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Informações Básicas</h4>
                    <div class="mb-3">
                        <label for="nome_sistema" class="form-label">Nome do Sistema</label>
                        <input type="text" class="form-control @error('nome_sistema') is-invalid @enderror" 
                               id="nome_sistema" name="nome_sistema" value="{{ old('nome_sistema') }}" required>
                        @error('nome_sistema')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo do Sistema</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" name="logo" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_contato" class="form-label">E-mail de Contato</label>
                        <input type="email" class="form-control @error('email_contato') is-invalid @enderror" 
                               id="email_contato" name="email_contato" value="{{ old('email_contato') }}">
                        @error('email_contato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telefone_contato" class="form-label">Telefone de Contato</label>
                        <input type="text" class="form-control telefone @error('telefone_contato') is-invalid @enderror" 
                               id="telefone_contato" name="telefone_contato" value="{{ old('telefone_contato') }}">
                        @error('telefone_contato')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="texto_rodape" class="form-label">Texto do Rodapé</label>
                        <textarea class="form-control @error('texto_rodape') is-invalid @enderror" 
                                  id="texto_rodape" name="texto_rodape" rows="3">{{ old('texto_rodape') }}</textarea>
                        @error('texto_rodape')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Cores do Sistema</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cor_primaria" class="form-label">Cor Primária</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_primaria') is-invalid @enderror" 
                                       id="cor_primaria" name="cor_primaria" value="{{ old('cor_primaria', '#0d6efd') }}">
                                <input type="text" class="form-control" value="#0d6efd" data-color-input>
                                @error('cor_primaria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cor_secundaria" class="form-label">Cor Secundária</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_secundaria') is-invalid @enderror" 
                                       id="cor_secundaria" name="cor_secundaria" value="{{ old('cor_secundaria', '#6c757d') }}">
                                <input type="text" class="form-control" value="#6c757d" data-color-input>
                                @error('cor_secundaria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cor_fundo" class="form-label">Cor de Fundo</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_fundo') is-invalid @enderror" 
                                       id="cor_fundo" name="cor_fundo" value="{{ old('cor_fundo', '#ffffff') }}">
                                <input type="text" class="form-control" value="#ffffff" data-color-input>
                                @error('cor_fundo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cor_texto" class="form-label">Cor do Texto</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_texto') is-invalid @enderror" 
                                       id="cor_texto" name="cor_texto" value="{{ old('cor_texto', '#212529') }}">
                                <input type="text" class="form-control" value="#212529" data-color-input>
                                @error('cor_texto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cor_navbar" class="form-label">Cor da Barra de Navegação</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_navbar') is-invalid @enderror" 
                                       id="cor_navbar" name="cor_navbar" value="{{ old('cor_navbar', '#212529') }}">
                                <input type="text" class="form-control" value="#212529" data-color-input>
                                @error('cor_navbar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cor_footer" class="form-label">Cor do Rodapé</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color @error('cor_footer') is-invalid @enderror" 
                                       id="cor_footer" name="cor_footer" value="{{ old('cor_footer', '#212529') }}">
                                <input type="text" class="form-control" value="#212529" data-color-input>
                                @error('cor_footer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Visualização</h5>
                                <div class="preview-box p-3 rounded" id="preview-box">
                                    <p>Exemplo de texto com as cores selecionadas</p>
                                    <button class="btn preview-primary">Botão Primário</button>
                                    <button class="btn preview-secondary">Botão Secundário</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Salvar Configurações</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    $('.telefone').mask('(00) 00000-0000');

    // Atualiza input de texto quando cor é alterada
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', function() {
            const textInput = this.parentElement.querySelector('[data-color-input]');
            textInput.value = this.value;
            updatePreview();
        });
    });

    // Atualiza input de cor quando texto é alterado
    document.querySelectorAll('[data-color-input]').forEach(input => {
        input.addEventListener('input', function() {
            const colorInput = this.parentElement.querySelector('input[type="color"]');
            if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                colorInput.value = this.value;
                updatePreview();
            }
        });
    });

    // Função para atualizar preview
    function updatePreview() {
        const previewBox = document.getElementById('preview-box');
        const primaryBtn = previewBox.querySelector('.preview-primary');
        const secondaryBtn = previewBox.querySelector('.preview-secondary');

        previewBox.style.backgroundColor = document.getElementById('cor_fundo').value;
        previewBox.style.color = document.getElementById('cor_texto').value;
        
        primaryBtn.style.backgroundColor = document.getElementById('cor_primaria').value;
        primaryBtn.style.color = '#ffffff';
        
        secondaryBtn.style.backgroundColor = document.getElementById('cor_secundaria').value;
        secondaryBtn.style.color = '#ffffff';
    }

    // Inicializa preview
    updatePreview();
});
</script>
@endpush

@push('styles')
<style>
.preview-box {
    border: 1px solid #ddd;
    min-height: 150px;
}

.form-control-color {
    width: 50px;
}
</style>
@endpush
