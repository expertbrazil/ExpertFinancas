@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('technical-help.sidebar')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>
                        Resultados da Busca
                        <small class="text-muted fs-6">{{ $topics->count() }} resultados para "{{ $query }}"</small>
                    </h3>
                </div>
                
                <div class="card-body">
                    @if($topics->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-search fa-3x text-muted"></i>
                            </div>
                            <h3>Nenhum resultado encontrado</h3>
                            <p class="text-muted">
                                Tente buscar por termos diferentes ou 
                                <a href="{{ route('technical-help.index') }}">volte para a documentação</a>
                            </p>
                        </div>
                    @else
                        @foreach($topics as $topic)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">
                                        <a href="{{ route('technical-help.show', $topic['slug']) }}" 
                                           class="text-decoration-none">
                                            {{ $topic['title'] }}
                                        </a>
                                    </h5>
                                    <span class="badge bg-info">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::createFromTimestamp($topic['updated_at'])->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="card-text">{{ $topic['summary'] }}</p>
                                <a href="{{ route('technical-help.show', $topic['slug']) }}" 
                                   class="btn btn-sm btn-primary">
                                    Ler mais
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: transform .2s;
}

.card:hover {
    transform: translateY(-2px);
}

.text-highlight {
    background-color: #fff3cd;
    padding: 0.1em 0.2em;
    border-radius: 0.2em;
}
</style>
@endpush
@endsection
