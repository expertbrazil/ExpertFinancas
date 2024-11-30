@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Planos de Hospedagem</h1>
        <a href="{{ route('hosting-plans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Plano
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Mensal</th>
                            <th>Semestral</th>
                            <th>Anual</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr>
                                <td>
                                    @if($plan->image)
                                        <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->name }}" class="img-thumbnail" style="max-width: 50px;">
                                    @else
                                        <span class="text-muted">Sem imagem</span>
                                    @endif
                                </td>
                                <td>{{ $plan->name }}</td>
                                <td>R$ {{ number_format($plan->monthly_price, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($plan->semiannual_price, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($plan->annual_price, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $plan->active ? 'success' : 'danger' }}">
                                        {{ $plan->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('hosting-plans.edit', $plan) }}" 
                                           class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center" 
                                           style="width: 32px; height: 32px;"
                                           title="Editar Plano">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('hosting-plans.toggle-status', $plan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-{{ $plan->active ? 'danger' : 'success' }} d-inline-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;"
                                                    title="{{ $plan->active ? 'Desativar Plano' : 'Ativar Plano' }}">
                                                <i class="fas fa-{{ $plan->active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('hosting-plans.destroy', $plan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;"
                                                    onclick="return confirm('Tem certeza que deseja excluir este plano?')"
                                                    title="Excluir Plano">
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
        </div>
    </div>
</div>
@endsection
