@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Documentos</h1>
        <a href="{{ route('documentos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Documento
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Data Upload</th>
                            <th>Tamanho</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documentos as $documento)
                            <tr>
                                <td>{{ $documento->titulo }}</td>
                                <td>{{ $documento->cliente->nome }}</td>
                                <td>
                                    @switch($documento->tipo)
                                        @case('contrato')
                                            <span class="badge bg-primary">Contrato</span>
                                            @break
                                        @case('nota_fiscal')
                                            <span class="badge bg-info">Nota Fiscal</span>
                                            @break
                                        @case('recibo')
                                            <span class="badge bg-success">Recibo</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Outros</span>
                                    @endswitch
                                </td>
                                <td>{{ $documento->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($documento->arquivo_tamanho / 1024 / 1024, 2) }} MB</td>
                                <td>
                                    @if($documento->status)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('documentos.show', $documento) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-sm btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documentos.destroy', $documento) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir"
                                                onclick="return confirm('Tem certeza que deseja excluir este documento?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum documento encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $documentos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
