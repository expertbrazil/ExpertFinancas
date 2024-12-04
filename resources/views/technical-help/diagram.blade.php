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
                    <h3>Diagramas de Fluxo</h3>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary active" data-type="user">Fluxo de Usuários</button>
                        <button type="button" class="btn btn-primary" data-type="financial">Fluxo Financeiro</button>
                        <button type="button" class="btn btn-primary" data-type="document">Fluxo de Documentos</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="diagram-container" style="width: 100%; height: 600px; border: 1px solid #e5e7eb;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@antv/x6@2.x/dist/x6.js"></script>
<script src="{{ asset('js/diagrams/user-flow.js') }}"></script>
<script src="{{ asset('js/diagrams/financial-flow.js') }}"></script>
<script src="{{ asset('js/diagrams/document-flow.js') }}"></script>

<script>
let graph = null;

function initGraph() {
    if (graph) {
        graph.dispose();
    }

    return new X6.Graph({
        container: document.getElementById('diagram-container'),
        grid: {
            type: 'mesh',
            size: 10,
            visible: true,
            color: '#ddd',
        },
        mousewheel: {
            enabled: true,
            modifiers: ['ctrl', 'meta'],
            factor: 1.1,
            maxScale: 1.5,
            minScale: 0.5,
        },
        connecting: {
            anchor: 'center',
            connector: 'rounded',
            connectionPoint: 'anchor',
            router: 'manhattan',
        },
        interacting: {
            nodeMovable: false,
            edgeMovable: false,
            edgeLabelMovable: false,
            vertexMovable: false,
            vertexAddable: false,
            vertexDeletable: false,
        },
        background: {
            color: '#f8f9fa',
        },
    });
}

function showDiagram(type) {
    graph = initGraph();
    
    switch(type) {
        case 'user':
            createUserFlowDiagram(graph);
            break;
        case 'financial':
            createFinancialFlowDiagram(graph);
            break;
        case 'document':
            createDocumentFlowDiagram(graph);
            break;
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    // Inicializa com o diagrama de usuários
    showDiagram('user');

    // Configura os botões
    const buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Remove active de todos os botões
            buttons.forEach(btn => btn.classList.remove('active'));
            // Adiciona active ao botão clicado
            e.target.classList.add('active');
            // Mostra o diagrama correspondente
            showDiagram(e.target.dataset.type);
        });
    });
});
</script>
@endpush

@endsection
