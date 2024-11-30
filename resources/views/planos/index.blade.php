@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Planos de Hospedagem</h1>
        <a href="{{ route('planos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Novo Plano
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px">Imagem</th>
                            <th>Nome</th>
                            <th>Mensal</th>
                            <th>Semestral</th>
                            <th>Anual</th>
                            <th>Status</th>
                            <th style="width: 120px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    @if($plan->image)
                                        <img src="{{ asset('storage/' . $plan->image) }}" 
                                             alt="{{ $plan->name }}" 
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
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
                                        <a href="{{ route('planos.edit', $plan) }}" 
                                           class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center" 
                                           style="width: 32px; height: 32px;"
                                           title="Editar Plano">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('planos.toggle-status', $plan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-{{ $plan->active ? 'danger' : 'success' }} d-inline-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px;"
                                                    title="{{ $plan->active ? 'Desativar Plano' : 'Ativar Plano' }}">
                                                <i class="fas fa-{{ $plan->active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('planos.destroy', $plan) }}" method="POST" class="d-inline">
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                        <h5 class="text-muted">Nenhum plano cadastrado</h5>
                                        <p class="text-muted mb-0">Clique no botão "Novo Plano" para começar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
