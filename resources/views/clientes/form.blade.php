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
                                        value="{{ old('cpf', $cliente->cpf ?? '') }}"
                                        placeholder="000.000.000-00">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento" 
                                        value="{{ old('data_nascimento', isset($cliente) && $cliente->data_nascimento ? $cliente->data_nascimento->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <div id="pessoa_juridica" class="pessoa-fields">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Razão Social <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="razao_social" 
                                        value="{{ old('razao_social', $cliente->razao_social ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nome Fantasia</label>
                                    <input type="text" class="form-control" name="nome_fantasia" 
                                        value="{{ old('nome_fantasia', $cliente->nome_fantasia ?? '') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control cnpj" name="cnpj" 
                                        value="{{ old('cnpj', $cliente->cnpj ?? '') }}"
                                        placeholder="00.000.000/0000-00">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Data de Fundação</label>
                                    <input type="date" class="form-control" name="data_fundacao" 
                                        value="{{ old('data_fundacao', isset($cliente) && $cliente->data_fundacao ? $cliente->data_fundacao->format('Y-m-d') : '') }}">
                                </div>
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
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" class="form-control celular" id="celular" name="celular" 
                                    value="{{ old('celular', $cliente->celular ?? '') }}">
                            </div>
                        </div>

                        <!-- Domínios -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Domínios</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="addDominio">
                                    <i class="fas fa-plus"></i> Adicionar Domínio
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="dominios-container">
                                    @if(isset($cliente) && $cliente->dominios->count() > 0)
                                        @foreach($cliente->dominios as $index => $dominio)
                                            <div class="row dominio-row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Nome do Domínio</label>
                                                    <input type="text" class="form-control" name="dominios[{{ $index }}][nome_dominio]" 
                                                        value="{{ $dominio->nome_dominio }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Data Registro</label>
                                                    <input type="date" class="form-control" name="dominios[{{ $index }}][data_registro]" 
                                                        value="{{ $dominio->data_registro?->format('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Data Vencimento</label>
                                                    <input type="date" class="form-control" name="dominios[{{ $index }}][data_vencimento]" 
                                                        value="{{ $dominio->data_vencimento?->format('Y-m-d') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Registrador</label>
                                                    <input type="text" class="form-control" name="dominios[{{ $index }}][registrador]" 
                                                        value="{{ $dominio->registrador }}">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-dominio">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Inscrições Estaduais -->
                        <div class="card mt-4" id="inscricoes-estaduais-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Inscrições Estaduais</h5>
                                <button type="button" class="btn btn-primary btn-sm" id="addInscricao">
                                    <i class="fas fa-plus"></i> Adicionar Inscrição
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="inscricoes-container">
                                    @if(isset($cliente) && $cliente->inscricoesEstaduais->count() > 0)
                                        @foreach($cliente->inscricoesEstaduais as $index => $inscricao)
                                            <div class="row inscricao-row mb-3">
                                                <div class="col-md-5">
                                                    <label class="form-label">Número da Inscrição</label>
                                                    <input type="text" class="form-control" name="inscricoes[{{ $index }}][numero_inscricao]" 
                                                        value="{{ $inscricao->numero_inscricao }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">UF</label>
                                                    <select class="form-select" name="inscricoes[{{ $index }}][uf]" required>
                                                        <option value="">Selecione...</option>
                                                        @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                                            <option value="{{ $uf }}" {{ $inscricao->uf == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="inscricoes[{{ $index }}][ativo]">
                                                        <option value="1" {{ $inscricao->ativo ? 'selected' : '' }}>Ativo</option>
                                                        <option value="0" {{ !$inscricao->ativo ? 'selected' : '' }}>Inativo</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-inscricao">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="observacoes" class="form-label">Observações</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $cliente->observacoes ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ isset($cliente) ? 'Atualizar' : 'Salvar' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/clientes.js') }}"></script>
<script>
    $(document).ready(function() {
        function togglePessoaFields() {
            const tipoPessoa = $('input[name="tipo_pessoa"]:checked').val();
            if (tipoPessoa === 'PF') {
                $('#pessoa_fisica').show();
                $('#pessoa_juridica').hide();
                $('input[name="razao_social"], input[name="cnpj"]').val('');
            } else {
                $('#pessoa_fisica').hide();
                $('#pessoa_juridica').show();
                $('input[name="nome_completo"], input[name="cpf"]').val('');
            }
        }

        togglePessoaFields();

        $('input[name="tipo_pessoa"]').change(function() {
            togglePessoaFields();
        });
    });
</script>
@endpush
@endsection
