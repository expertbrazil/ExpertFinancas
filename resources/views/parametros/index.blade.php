@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Configurações do Sistema</h2>
        <a href="{{ route('parametros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Configuração
        </a>
    </div>
    <div class="card-body">
        @if($parametros->isEmpty())
            <div class="alert alert-info">
                Nenhuma configuração encontrada.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome do Sistema</th>
                            <th>Logo</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Última Atualização</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parametros as $parametro)
                            <tr>
                                <td>{{ $parametro->nome_sistema }}</td>
                                <td>
                                    @if($parametro->logo_path)
                                        <img src="{{ Storage::url($parametro->logo_path) }}" 
                                             alt="Logo" class="img-thumbnail" 
                                             style="max-height: 50px;">
                                    @else
                                        <span class="text-muted">Sem logo</span>
                                    @endif
                                </td>
                                <td>{{ $parametro->email_contato ?? 'Não definido' }}</td>
                                <td>{{ $parametro->telefone_contato ?? 'Não definido' }}</td>
                                <td>{{ $parametro->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('parametros.edit') }}" 
                                           class="btn btn-sm btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(count($parametros) > 1)
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $parametro->id }})" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $parametro->id }}" 
                                              action="{{ route('parametros.destroy', $parametro) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Tem certeza que deseja excluir esta configuração?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
