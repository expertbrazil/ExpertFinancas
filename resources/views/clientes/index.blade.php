@extends('layouts.app')

@section('content')
    <style>
        .action-btn {
            min-width: 32px !important;
            max-width: 32px !important;
            width: 32px !important;
            min-height: 32px !important;
            max-height: 32px !important;
            height: 32px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 2px !important;
        }
        .action-btn i {
            font-size: 14px !important;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Cliente
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Nome/Razão Social</th>
                            <th>CPF/CNPJ</th>
                            <th>E-mail</th>
                            <th>Celular</th>
                            <th>Cidade/UF</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->tipo_pessoa === 'PF' ? 'Física' : 'Jurídica' }}</td>
                                <td>{{ $cliente->tipo_pessoa === 'PF' ? $cliente->nome_completo : $cliente->razao_social }}</td>
                                <td>{{ $cliente->tipo_pessoa === 'PF' ? $cliente->cpf : $cliente->cnpj }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->celular }}</td>
                                <td>{{ $cliente->cidade }}/{{ $cliente->uf }}</td>
                                <td>
                                    <span class="badge {{ $cliente->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $cliente->status ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-info action-btn" title="Contratos">
                                            <i class="fas fa-file-contract"></i>
                                        </button>
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning action-btn" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger action-btn" onclick="return confirm('Tem certeza que deseja excluir este cliente?')" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
@endsection
