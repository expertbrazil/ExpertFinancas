function createFinancialFlowDiagram(graph) {
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
            id: 'transaction',
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
                    text: 'Nova\nTransação',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'type',
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
                    text: 'Tipo de\nTransação',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'income',
            shape: 'rect',
            x: 300,
            y: 250,
            width: 120,
            height: 60,
            attrs: {
                body: {
                    fill: '#4CAF50',
                    stroke: '#43A047',
                    rx: 6,
                    ry: 6,
                },
                label: {
                    text: 'Receita',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'expense',
            shape: 'rect',
            x: 480,
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
                    text: 'Despesa',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'calculate',
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
                    text: 'Calcular\nSaldo',
                    fill: '#fff',
                    fontSize: 14,
                },
            },
        },
        {
            id: 'end',
            shape: 'circle',
            x: 800,
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
            target: 'transaction',
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
            source: 'transaction',
            target: 'type',
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
            source: 'type',
            target: 'income',
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
                            text: 'Entrada',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'type',
            target: 'expense',
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
                            text: 'Saída',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'income',
            target: 'calculate',
            router: {
                name: 'manhattan',
                args: {
                    startDirections: ['right'],
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
        },
        {
            source: 'expense',
            target: 'calculate',
            router: {
                name: 'manhattan',
                args: {
                    startDirections: ['right'],
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
        },
        {
            source: 'calculate',
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
