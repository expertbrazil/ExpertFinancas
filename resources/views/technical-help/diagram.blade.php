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
document.addEventListener('DOMContentLoaded', function() {
    let graph = null;
    let currentType = 'user';

    function initGraph() {
        if (graph) {
            graph.dispose();
        }

        graph = new X6.Graph({
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
            },
            connecting: {
                router: 'manhattan',
                connector: {
                    name: 'rounded',
                    args: {
                        radius: 8,
                    },
                },
                anchor: 'center',
                connectionPoint: 'anchor',
            },
        });

        return graph;
    }

    function loadDiagram(type) {
        graph = initGraph();
        currentType = type;
        
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

    // Adicionar eventos aos botões
    document.querySelectorAll('.btn-group .btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Load corresponding diagram
            loadDiagram(this.getAttribute('data-type'));
        });
    });

    // Inicializar com o diagrama de usuários
    loadDiagram('user');
});
</script>
@endpush

@endsection
