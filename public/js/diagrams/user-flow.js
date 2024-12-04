function createUserFlowDiagram(graph) {
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
            id: 'register',
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
                    text: 'Cadastro\nde Usuário',
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
                    text: 'Validar\nDados',
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
            id: 'save',
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
                    text: 'Salvar no\nBanco',
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
            target: 'register',
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
                            text: 'Início',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'register',
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
                            text: 'Dados\nInformados',
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
            target: 'register',
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
                            text: 'Corrigir',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
        {
            source: 'validate',
            target: 'save',
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
            source: 'save',
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
            labels: [
                {
                    position: 0.5,
                    attrs: {
                        label: {
                            text: 'Sucesso',
                            fill: '#5c6bc0',
                            fontSize: 12,
                        },
                    },
                },
            ],
        },
    ];

    graph.fromJSON({ nodes, edges });
    graph.centerContent();
}
