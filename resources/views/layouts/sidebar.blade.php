<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Principal</div>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @if(auth()->user()->hasPermission('clientes.view'))
                <div class="sb-sidenav-menu-heading">Gestão</div>
                <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Clientes
                </a>
                @endif

                @if(auth()->user()->hasPermission('tickets.view'))
                <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                    Tickets
                    @if(auth()->user()->isAdmin())
                        <span class="badge bg-danger ms-2" id="tickets-count"></span>
                    @endif
                </a>
                @endif

                @if(auth()->user()->hasPermission('faturas.view'))
                <a class="nav-link {{ request()->routeIs('faturas.*') ? 'active' : '' }}" href="{{ route('faturas.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    Faturas
                </a>
                @endif

                @if(auth()->user()->hasPermission('documentos.view'))
                <a class="nav-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}" href="{{ route('documentos.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Documentos
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <div class="sb-sidenav-menu-heading">Financeiro</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFinanceiro" aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                    Financeiro
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseFinanceiro" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('financeiro.receitas') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Receitas
                        </a>
                        <a class="nav-link" href="{{ route('financeiro.despesas') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-minus-circle"></i></div>
                            Despesas
                        </a>
                        <a class="nav-link" href="{{ route('financeiro.fluxo-caixa') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Fluxo de Caixa
                        </a>
                        <a class="nav-link" href="{{ route('financeiro.conciliacao') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-check-double"></i></div>
                            Conciliação Bancária
                        </a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Relatórios</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRelatorios" aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Relatórios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseRelatorios" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('relatorios.clientes') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="{{ route('relatorios.faturas') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Faturas
                        </a>
                        <a class="nav-link" href="{{ route('relatorios.tickets') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                            Tickets
                        </a>
                        <a class="nav-link" href="{{ route('relatorios.financeiro') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                            Financeiro
                        </a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Configurações</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseConfig" aria-expanded="false">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Configurações
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseConfig" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('configuracoes.empresa') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                            Empresa
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.usuarios') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                            Usuários
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.permissoes') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-lock"></i></div>
                            Permissões
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.notificacoes') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                            Notificações
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.integracao') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plug"></i></div>
                            Integrações
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.backup') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                            Backup
                        </a>
                        <a class="nav-link" href="{{ route('configuracoes.logs') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Logs do Sistema
                        </a>
                    </nav>
                </div>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado como:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para atualizar o contador de tickets
    function updateTicketCount() {
        if (document.getElementById('tickets-count')) {
            fetch('{{ route("api.tickets.count") }}')
                .then(response => response.json())
                .then(data => {
                    const count = document.getElementById('tickets-count');
                    if (data.count > 0) {
                        count.textContent = data.count;
                        count.style.display = 'inline';
                    } else {
                        count.style.display = 'none';
                    }
                });
        }
    }

    // Atualiza o contador a cada 1 minuto
    updateTicketCount();
    setInterval(updateTicketCount, 60000);

    // Adiciona efeito de hover nos itens do menu
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Adiciona efeito de ripple nos cliques
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.sb-sidenav {
    background: linear-gradient(145deg, #1a1c23 0%, #2c2f3a 100%);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 1rem;
    margin: 0.2rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.sb-sidenav-dark .sb-sidenav-menu .nav-link.active {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.sb-sidenav-menu-heading {
    color: rgba(255, 255, 255, 0.5);
    padding: 1rem;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sb-nav-link-icon {
    margin-right: 0.5rem;
    width: 1.5rem;
    text-align: center;
}

.badge {
    transition: all 0.3s ease;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* Animação para submenus */
.collapse {
    transition: all 0.3s ease-in-out;
}

.sb-sidenav-menu-nested .nav-link {
    padding-left: 3rem !important;
    font-size: 0.9rem;
}

/* Footer do sidebar */
.sb-sidenav-footer {
    background: rgba(0, 0, 0, 0.2);
    padding: 1rem;
    color: rgba(255, 255, 255, 0.6);
}

/* Scrollbar personalizada */
.sb-sidenav-menu::-webkit-scrollbar {
    width: 6px;
}

.sb-sidenav-menu::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.sb-sidenav-menu::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.sb-sidenav-menu::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>
@endpush
