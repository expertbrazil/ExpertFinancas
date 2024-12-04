@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('technical-help.sidebar')
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3>Ajuda Técnica</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach($topics as $topic)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title">{{ $topic['title'] }}</h5>
                                        <span class="badge bg-info">
                                            <i class="far fa-clock"></i>
                                            {{ \Carbon\Carbon::createFromTimestamp($topic['updated_at'])->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="card-text">{{ $topic['summary'] }}</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('technical-help.show', $topic['slug']) }}" class="btn btn-sm btn-primary">
                                        Ler mais
                                        <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.sidebar {
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    height: calc(100vh - 60px);
}

.sidebar .nav-link {
    color: #333;
    padding: .5rem 1rem;
    border-radius: .25rem;
    margin: 0.2rem 0;
}

.sidebar .nav-link:hover {
    background-color: rgba(0,0,0,.05);
}

.sidebar .nav-link.active {
    color: #2470dc;
    background-color: rgba(36,112,220,.1);
}

.card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}

.card-text {
    color: #555;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>
@endpush
@endsection

<?php
$topics = [
    [
        'title' => 'Regras de Autorização de Usuários',
        'slug' => 'autorizacao-usuarios',
        'summary' => 'Detalhamento das permissões e restrições de acesso para diferentes papéis de usuário no sistema.',
        'updated_at' => time(),
        'category' => 'Segurança'
    ],
    // ... outros tópicos ...
];
?>
