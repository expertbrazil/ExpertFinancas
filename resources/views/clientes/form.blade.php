@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span>{{ isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' }}</span>
                </div>

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

                    @if(isset($cliente))
                        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" id="formCliente">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('clientes.store') }}" id="formCliente">
                    @endif
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Pessoa <span class="text-danger">*</span></label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="tipo_pessoa" id="PF" value="PF" 
                                        {{ old('tipo_pessoa', $cliente->tipo_pessoa ?? 'PF') == 'PF' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="PF">Pessoa Física</label>

                                    <input type="radio" class="btn-check" name="tipo_pessoa" id="PJ" value="PJ"
                                        {{ old('tipo_pessoa', $cliente->tipo_pessoa ?? '') == 'PJ' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="PJ">Pessoa Jurídica</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" value="1" 
                                        {{ old('status', $cliente->status ?? '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label">Ativo</label>
                                </div>
                            </div>
                        </div>

                        <div id="pessoa_fisica" class="pessoa-fields">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nome_completo" 
                                        value="{{ old('nome_completo', $cliente->nome_completo ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">CPF <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control cpf" name="cpf" 
                                        value="{{ old('cpf', $cliente->cpf ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento" 
                                        value="{{ old('data_nascimento', $cliente->data_nascimento ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div id="pessoa_juridica" class="pessoa-fields" style="display:none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Razão Social <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="razao_social" 
                                        value="{{ old('razao_social', $cliente->razao_social ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control cnpj" name="cnpj" 
                                        value="{{ old('cnpj', $cliente->cnpj ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Data de Fundação</label>
                                    <input type="date" class="form-control" name="data_fundacao" 
                                        value="{{ old('data_fundacao', $cliente->data_fundacao ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control cep" id="cep" name="cep" 
                                    value="{{ old('cep', $cliente->cep ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="logradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro" 
                                    value="{{ old('logradouro', $cliente->logradouro ?? '') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" 
                                    value="{{ old('numero', $cliente->numero ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" 
                                    value="{{ old('complemento', $cliente->complemento ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" 
                                    value="{{ old('bairro', $cliente->bairro ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" 
                                    value="{{ old('cidade', $cliente->cidade ?? '') }}">
                            </div>
                            <div class="col-md-1">
                                <label for="uf" class="form-label">UF</label>
                                <input type="text" class="form-control" id="uf" name="uf" maxlength="2" 
                                    value="{{ old('uf', $cliente->uf ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="{{ old('email', $cliente->email ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" class="form-control telefone" id="telefone" name="telefone" 
                                    value="{{ old('telefone', $cliente->telefone ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control telefone" id="celular" name="celular" 
                                    value="{{ old('celular', $cliente->celular ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>{{ isset($cliente) ? 'Atualizar' : 'Salvar' }}
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
<script src="{{ asset('js/app.js') }}"></script>
@endpush
