@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Configurações do Sistema</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('parametros.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome do Sistema</label>
                                <input type="text" class="form-control" name="nome_sistema" 
                                    value="{{ old('nome_sistema', $parametro->nome_sistema) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Logo</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                @if($parametro->logo_path)
                                    <div class="mt-2">
                                        <img src="{{ $parametro->logo_url }}" alt="Logo atual" style="max-height: 50px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Cor Primária</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_primaria" 
                                        value="{{ old('cor_primaria', $parametro->cor_primaria) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_primaria', $parametro->cor_primaria) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cor Secundária</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_secundaria" 
                                        value="{{ old('cor_secundaria', $parametro->cor_secundaria) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_secundaria', $parametro->cor_secundaria) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cor de Fundo</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_fundo" 
                                        value="{{ old('cor_fundo', $parametro->cor_fundo) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_fundo', $parametro->cor_fundo) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Cor do Texto</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_texto" 
                                        value="{{ old('cor_texto', $parametro->cor_texto) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_texto', $parametro->cor_texto) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cor da Navbar</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_navbar" 
                                        value="{{ old('cor_navbar', $parametro->cor_navbar) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_navbar', $parametro->cor_navbar) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cor do Footer</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="cor_footer" 
                                        value="{{ old('cor_footer', $parametro->cor_footer) }}" required>
                                    <input type="text" class="form-control" value="{{ old('cor_footer', $parametro->cor_footer) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">E-mail de Contato</label>
                                <input type="email" class="form-control" name="email_contato" 
                                    value="{{ old('email_contato', $parametro->email_contato) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone de Contato</label>
                                <input type="text" class="form-control telefone" name="telefone_contato" 
                                    value="{{ old('telefone_contato', $parametro->telefone_contato) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Texto do Rodapé</label>
                                <textarea class="form-control" name="texto_rodape" rows="3">{{ old('texto_rodape', $parametro->texto_rodape) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-end">
                                    Salvar Configurações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {
    $('.telefone').mask('(00) 00000-0000');
    
    // Atualiza o valor do input text quando o color picker muda
    $('input[type="color"]').on('input', function() {
        $(this).next('input[type="text"]').val($(this).val());
    });
    
    // Preview das cores em tempo real
    function updateColors() {
        const style = `
            :root {
                --primary-color: ${$('input[name="cor_primaria"]').val()};
                --secondary-color: ${$('input[name="cor_secundaria"]').val()};
                --background-color: ${$('input[name="cor_fundo"]').val()};
                --text-color: ${$('input[name="cor_texto"]').val()};
                --navbar-color: ${$('input[name="cor_navbar"]').val()};
                --footer-color: ${$('input[name="cor_footer"]').val()};
            }
        `;
        
        $('#dynamic-colors').remove();
        $('<style id="dynamic-colors">' + style + '</style>').appendTo('head');
    }
    
    $('input[type="color"]').on('input', updateColors);
    updateColors();
});
</script>
@endpush
