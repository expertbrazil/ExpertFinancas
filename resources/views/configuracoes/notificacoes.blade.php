@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Notificações</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notificações</li>
    </ol>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-bell me-1"></i>
                    Configurações de Notificações
                </div>
                <div class="card-body">
                    <form>
                        <!-- Notificações por Email -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-envelope me-2"></i>
                                    Notificações por Email
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Ativar notificações por email</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Frequência de Resumo</label>
                                    <select class="form-select">
                                        <option>Diário</option>
                                        <option>Semanal</option>
                                        <option>Mensal</option>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Faturas vencidas</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Faturas a vencer</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Novos tickets</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Relatórios gerados</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Backup realizado</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Alertas do sistema</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notificações Push -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-mobile-alt me-2"></i>
                                    Notificações Push
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Ativar notificações push</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Faturas vencidas</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Novos tickets</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Alertas importantes</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Mensagens do sistema</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notificações do Sistema -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-desktop me-2"></i>
                                    Notificações do Sistema
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Ativar notificações do sistema</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Som de Notificação</label>
                                    <select class="form-select">
                                        <option>Padrão</option>
                                        <option>Som 1</option>
                                        <option>Som 2</option>
                                        <option>Sem som</option>
                                    </select>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Mostrar notificações na área de trabalho</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Configurações
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Histórico de Notificações
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date">Hoje 10:30</div>
                            <div class="timeline-content">
                                <div class="text-primary">Fatura Vencida</div>
                                <div class="small">Fatura #1234 venceu hoje</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">Ontem 15:45</div>
                            <div class="timeline-content">
                                <div class="text-success">Backup Realizado</div>
                                <div class="small">Backup automático concluído com sucesso</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">22/05 09:15</div>
                            <div class="timeline-content">
                                <div class="text-warning">Novo Ticket</div>
                                <div class="small">Ticket #789 aberto por Cliente XYZ</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Dicas
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        Configure as notificações por email para receber resumos diários das atividades importantes.
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Mantenha as notificações de faturas vencidas ativas para evitar atrasos.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    padding: 10px 0;
    border-left: 2px solid #e9ecef;
    padding-left: 20px;
    position: relative;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -7px;
    top: 15px;
    width: 12px;
    height: 12px;
    background: #fff;
    border: 2px solid #007bff;
    border-radius: 50%;
}

.timeline-date {
    font-size: 0.8rem;
    color: #6c757d;
}

.timeline-content {
    margin-top: 5px;
}
</style>
@endsection
