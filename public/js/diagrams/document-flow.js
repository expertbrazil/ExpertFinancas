function createDocumentFlowDiagram(graph) {
    const nodes = [
        {
            id: 'start',
            shape: 'circle',
            x: 50,
            y: 100,
            width: 60,
            height: 60,
            attrs: {
                body: {
                    fill: '#4CAF50',
                    stroke: '#43A047',
                },
                label: {
                    text: 'Início',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'upload',
            shape: 'rect',
            x: 200,
            y: 90,
            width: 120,
            height: 80,
            attrs: {
                body: {
                    fill: '#2196F3',
                    stroke: '#1E88E5',
                    rx: 6,
                    ry: 6,
                },
                label: {
                    text: 'Upload de\nDocumento',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'validate',
            shape: 'diamond',
            x: 400,
            y: 80,
            width: 100,
            height: 100,
            attrs: {
                body: {
                    fill: '#FFC107',
                    stroke: '#FFB300',
                },
                label: {
                    text: 'Validar\nArquivo',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'error',
            shape: 'rect',
            x: 390,
            y: 250,
            width: 120,
            height: 60,
            attrs: {
                body: {
                    fill: '#F44336',
                    stroke: '#E53935',
                    rx: 6,
                    ry: 6,
                },
                label: {
                    text: 'Erro de\nValidação',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'process',
            shape: 'rect',
            x: 600,
            y: 90,
            width: 120,
            height: 80,
            attrs: {
                body: {
                    fill: '#2196F3',
                    stroke: '#1E88E5',
                    rx: 6,
                    ry: 6,
                },
                label: {
                    text: 'Processar\nDocumento',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'store',
            shape: 'rect',
            x: 800,
            y: 90,
            width: 120,
            height: 80,
            attrs: {
                body: {
                    fill: '#2196F3',
                    stroke: '#1E88E5',
                    rx: 6,
                    ry: 6,
                },
                label: {
                    text: 'Armazenar\nDocumento',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'end',
            shape: 'circle',
            x: 1000,
            y: 100,
            width: 60,
            height: 60,
            attrs: {
                body: {
                    fill: '#4CAF50',
                    stroke: '#43A047',
                },
                label: {
                    text: 'Fim',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
    ];

    const edges = [
        {
            source: 'start',
            target: 'upload',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
        },
        {
            source: 'upload',
            target: 'validate',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
            labels: [
                {
                    position: 0.5,
                    attrs: {
                        label: {
                            text: 'Arquivo\nEnviado',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'validate',
            target: 'error',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
            labels: [
                {
                    position: 0.5,
                    attrs: {
                        label: {
                            text: 'Inválido',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'error',
            target: 'upload',
            router: {
                name: 'manhattan',
                args: {
                    startDirections: ['left'],
                    endDirections: ['bottom'],
                },
            },
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
            labels: [
                {
                    position: 0.5,
                    attrs: {
                        label: {
                            text: 'Tentar\nNovamente',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'validate',
            target: 'process',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
            labels: [
                {
                    position: 0.5,
                    attrs: {
                        label: {
                            text: 'Válido',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'process',
            target: 'store',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
        },
        {
            source: 'store',
            target: 'end',
            attrs: {
                line: {
                    stroke: '#5c6bc0',
                    strokeWidth: 2,
                    targetMarker: {
                        name: 'block',
                        width: 12,
                        height: 8,
                    },
                },
            },
        },
    ];

    graph.fromJSON({ nodes, edges });
    graph.centerContent();
}
