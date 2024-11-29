@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categorias</h3>
                    <div class="card-tools">
                        <a href="{{ route('categorias.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nova Categoria
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Subcategorias</th>
                                    <th>Status</th>
                                    <th width="15%">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->codigo }}</td>
                                        <td>{{ $categoria->nome }}</td>
                                        <td>
                                            <span class="badge badge-{{ $categoria->tipo === 'receita' ? 'success' : 'danger' }}">
                                                {{ ucfirst($categoria->tipo) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($categoria->subcategorias->count() > 0)
                                                <button type="button" class="btn btn-link" data-toggle="collapse" 
                                                        data-target="#subcategorias-{{ $categoria->id }}">
                                                    Ver {{ $categoria->subcategorias->count() }} subcategoria(s)
                                                </button>
                                            @else
                                                <span class="text-muted">Nenhuma subcategoria</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $categoria->ativo ? 'success' : 'danger' }}">
                                                {{ $categoria->ativo ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('categorias.edit', $categoria) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(!$categoria->temSubcategorias())
                                                <form action="{{ route('categorias.destroy', $categoria) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($categoria->subcategorias->count() > 0)
                                        <tr class="collapse" id="subcategorias-{{ $categoria->id }}">
                                            <td colspan="6" class="p-0">
                                                <table class="table mb-0">
                                                    @foreach($categoria->subcategorias as $subcategoria)
                                                        <tr class="bg-light">
                                                            <td class="pl-4">{{ $subcategoria->codigo }}</td>
                                                            <td>{{ $subcategoria->nome }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $subcategoria->tipo === 'receita' ? 'success' : 'danger' }}">
                                                                    {{ ucfirst($subcategoria->tipo) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if($subcategoria->subcategorias->count() > 0)
                                                                    {{ $subcategoria->subcategorias->count() }} subcategoria(s)
                                                                @else
                                                                    <span class="text-muted">Nenhuma subcategoria</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-{{ $subcategoria->ativo ? 'success' : 'danger' }}">
                                                                    {{ $subcategoria->ativo ? 'Ativo' : 'Inativo' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('categorias.edit', $subcategoria) }}" 
                                                                   class="btn btn-sm btn-info">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                @if(!$subcategoria->temSubcategorias())
                                                                    <form action="{{ route('categorias.destroy', $subcategoria) }}" 
                                                                          method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                                onclick="return confirm('Tem certeza que deseja excluir esta subcategoria?')">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
