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
                    <nav aria-label="breadcrumb" class="mb-0">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('technical-help.index') }}">
                                    <i class="fas fa-book me-1"></i>
                                    Ajuda Técnica
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $content['title'] }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>{{ $content['title'] }}</h2>
                        <span class="text-muted">
                            <i class="far fa-clock me-1"></i>
                            Atualizado {{ \Carbon\Carbon::createFromTimestamp($content['updated_at'])->diffForHumans() }}
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-lg-9">
                            <div class="markdown-content">
                                {!! $content['html'] !!}
                            </div>

                            @if($relatedTopics->isNotEmpty())
                                <div class="mt-5">
                                    <h4 class="mb-4">Tópicos Relacionados</h4>
                                    <div class="row row-cols-1 row-cols-md-2 g-4">
                                        @foreach($relatedTopics as $relatedTopic)
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $relatedTopic['title'] }}</h5>
                                                        <p class="card-text small">{{ $relatedTopic['summary'] }}</p>
                                                        <a href="{{ route('technical-help.show', $relatedTopic['slug']) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            Ler mais
                                                            <i class="fas fa-arrow-right ms-1"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-3">
                            <div class="position-sticky" style="top: 2rem;">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Índice</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="toc" id="toc"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.markdown-content {
    line-height: 1.6;
}

.markdown-content h2,
.markdown-content h3,
.markdown-content h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.markdown-content pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
}

.markdown-content code {
    background: #f8f9fa;
    padding: 0.2em 0.4em;
    border-radius: 0.25rem;
    font-size: 0.9em;
}

.markdown-content blockquote {
    border-left: 4px solid #0d6efd;
    padding: 0.5rem 1rem;
    margin: 1rem 0;
    background: #f8f9fa;
}

.toc ul {
    list-style: none;
    padding-left: 0;
}

.toc ul ul {
    padding-left: 1.5rem;
}

.toc a {
    color: inherit;
    text-decoration: none;
    display: block;
    padding: 0.25rem 0;
}

.toc a:hover {
    color: #0d6efd;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gera o índice
    const toc = document.getElementById('toc');
    const headings = document.querySelectorAll('.markdown-content h2, .markdown-content h3');
    const tocList = document.createElement('ul');
    tocList.className = 'mb-0';

    headings.forEach((heading, index) => {
        const id = `heading-${index}`;
        heading.id = id;

        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = `#${id}`;
        a.textContent = heading.textContent;
        
        if (heading.tagName === 'H3') {
            li.style.paddingLeft = '1rem';
        }

        li.appendChild(a);
        tocList.appendChild(li);
    });

    toc.appendChild(tocList);
});
</script>
@endpush

@endsection
