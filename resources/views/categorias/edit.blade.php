@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Categoria</h3>
                </div>
                <form action="{{ route('categorias.update', $categoria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" 
                                           value="{{ old('codigo', $categoria->codigo) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" 
                                           value="{{ old('nome', $categoria->nome) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tipo">Tipo</label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="">Selecione...</option>
                                        <option value="receita" {{ old('tipo', $categoria->tipo) === 'receita' ? 'selected' : '' }}>
                                            Receita
                                        </option>
                                        <option value="despesa" {{ old('tipo', $categoria->tipo) === 'despesa' ? 'selected' : '' }}>
                                            Despesa
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="categoria_pai_id">Categoria Pai</label>
                                    <select class="form-control" id="categoria_pai_id" name="categoria_pai_id">
                                        <option value="">Nenhuma (Categoria Principal)</option>
                                        @foreach($categoriasPai as $categoriaPai)
                                            <option value="{{ $categoriaPai->id }}" 
                                                    {{ old('categoria_pai_id', $categoria->categoria_pai_id) == $categoriaPai->id ? 'selected' : '' }}
                                                    data-tipo="{{ $categoriaPai->tipo }}">
                                                {{ $categoriaPai->caminho_hierarquico }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" 
                                              rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="ativo" name="ativo" value="1"
                                               {{ old('ativo', $categoria->ativo) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ativo">Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializa o select2 para a categoria pai
    $('#categoria_pai_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Selecione uma categoria pai...',
        allowClear: true
    });

    // Quando o tipo é alterado, filtra as categorias pai do mesmo tipo
    $('#tipo').change(function() {
        var tipo = $(this).val();
        var $categoriaPai = $('#categoria_pai_id');
        
        if (tipo) {
            $categoriaPai.find('option').each(function() {
                var $option = $(this);
                if ($option.val()) {
                    var categoriaTipo = $option.data('tipo');
                    if (categoriaTipo !== tipo) {
                        $option.prop('disabled', true).prop('selected', false);
                    } else {
                        $option.prop('disabled', false);
                    }
                }
            });
            $categoriaPai.select2('destroy').select2({
                theme: 'bootstrap4',
                placeholder: 'Selecione uma categoria pai...',
                allowClear: true
            });
        }
    });

    // Dispara o evento change do tipo na carga da página
    $('#tipo').trigger('change');
});
</script>
@endpush
@endsection
