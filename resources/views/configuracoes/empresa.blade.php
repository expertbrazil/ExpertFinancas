@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Configurações da Empresa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Configurações da Empresa</li>
    </ol>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i>
                    Dados da Empresa
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Razão Social</label>
                                <input type="text" class="form-control" value="Expert Finanças LTDA">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nome Fantasia</label>
                                <input type="text" class="form-control" value="Expert Finanças">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control" value="12.345.678/0001-90">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Inscrição Estadual</label>
                                <input type="text" class="form-control" value="123456789">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="contato@expertfinancas.com.br">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" value="(11) 3456-7890">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">CEP</label>
                                <input type="text" class="form-control" value="01234-567">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" value="Av. Paulista, 1000">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control" value="Bela Vista">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" value="São Paulo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select class="form-select">
                                    <option value="SP" selected>São Paulo</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="MG">Minas Gerais</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Site</label>
                            <input type="url" class="form-control" value="https://www.expertfinancas.com.br">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-image me-1"></i>
                    Logo da Empresa
                </div>
                <div class="card-body text-center">
                    <img src="path/to/logo.png" alt="Logo" class="img-fluid mb-3" style="max-width: 200px;">
                    <div>
                        <button class="btn btn-primary">
                            <i class="fas fa-upload"></i> Alterar Logo
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cog me-1"></i>
                    Configurações Adicionais
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Moeda Padrão</label>
                        <select class="form-select">
                            <option value="BRL" selected>Real (R$)</option>
                            <option value="USD">Dólar ($)</option>
                            <option value="EUR">Euro (€)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fuso Horário</label>
                        <select class="form-select">
                            <option value="America/Sao_Paulo" selected>Brasília (UTC-3)</option>
                            <option value="America/New_York">Nova York (UTC-4)</option>
                            <option value="Europe/London">Londres (UTC+1)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Formato de Data</label>
                        <select class="form-select">
                            <option value="DD/MM/YYYY" selected>DD/MM/YYYY</option>
                            <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                            <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
