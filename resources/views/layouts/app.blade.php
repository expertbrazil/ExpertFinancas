<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Expert Finanças') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Expert Finanças">
            </div>
            
            <ul class="sidebar-menu">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Cadastros -->
                <li class="has-submenu">
                    <a href="#" class="{{ request()->routeIs(['clientes.*', 'servicos.*', 'produtos.*']) ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Cadastros</span>
                        <i class="fas fa-chevron-right submenu-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Clientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('servicos.index') }}" class="{{ request()->routeIs('servicos.*') ? 'active' : '' }}">
                                <i class="fas fa-cogs"></i>
                                <span>Serviços</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('produtos.index') }}" class="{{ request()->routeIs('produtos.*') ? 'active' : '' }}">
                                <i class="fas fa-box"></i>
                                <span>Produtos</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Financeiro -->
                <li class="has-submenu">
                    <a href="#" class="{{ request()->routeIs(['faturas.*', 'contas-pagar.*', 'contas-receber.*', 'financeiro.*']) ? 'active' : '' }}">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Financeiro</span>
                        <i class="fas fa-chevron-right submenu-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('faturas.index') }}" class="{{ request()->routeIs('faturas.*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>Faturas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contas-receber.index') }}" class="{{ request()->routeIs('contas-receber.*') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span>Contas a Receber</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contas-pagar.index') }}" class="{{ request()->routeIs('contas-pagar.*') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Contas a Pagar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financeiro.fluxo-caixa') }}" class="{{ request()->routeIs('financeiro.fluxo-caixa') ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i>
                                <span>Fluxo de Caixa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('financeiro.conciliacao') }}" class="{{ request()->routeIs('financeiro.conciliacao') ? 'active' : '' }}">
                                <i class="fas fa-balance-scale"></i>
                                <span>Conciliação</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Suporte -->
                <li class="has-submenu">
                    <a href="#" class="{{ request()->routeIs(['tickets.*', 'categorias.*']) ? 'active' : '' }}">
                        <i class="fas fa-headset"></i>
                        <span>Suporte</span>
                        <i class="fas fa-chevron-right submenu-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                                <i class="fas fa-ticket-alt"></i>
                                <span>Tickets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categorias.index') }}" class="{{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                                <i class="fas fa-tags"></i>
                                <span>Categorias</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Relatórios -->
                <li class="has-submenu">
                    <a href="#" class="{{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Relatórios</span>
                        <i class="fas fa-chevron-right submenu-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('relatorios.financeiro') }}" class="{{ request()->routeIs('relatorios.financeiro') ? 'active' : '' }}">
                                <i class="fas fa-chart-pie"></i>
                                <span>Financeiro</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relatorios.clientes') }}" class="{{ request()->routeIs('relatorios.clientes') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Clientes</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Configurações (Admin) -->
                @if(auth()->user()->role->slug === 'root' || auth()->user()->role->slug === 'admin')
                <li class="has-submenu">
                    <a href="#" class="{{ request()->routeIs(['users.*', 'roles.*', 'parametros.*', 'configuracoes.*']) ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>Configurações</span>
                        <i class="fas fa-chevron-right submenu-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('configuracoes.empresa') }}" class="{{ request()->routeIs('configuracoes.empresa') ? 'active' : '' }}">
                                <i class="fas fa-building"></i>
                                <span>Empresa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="fas fa-users-cog"></i>
                                <span>Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                                <i class="fas fa-user-shield"></i>
                                <span>Funções</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('parametros.edit') }}" class="{{ request()->routeIs('parametros.*') ? 'active' : '' }}">
                                <i class="fas fa-sliders-h"></i>
                                <span>Parâmetros</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('configuracoes.backup') }}" class="{{ request()->routeIs('configuracoes.backup') ? 'active' : '' }}">
                                <i class="fas fa-database"></i>
                                <span>Backup</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('configuracoes.logs') }}" class="{{ request()->routeIs('configuracoes.logs') ? 'active' : '' }}">
                                <i class="fas fa-history"></i>
                                <span>Logs</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <button class="mobile-toggle d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="header-left">
                    <h4 class="mb-0">@yield('title', 'Dashboard')</h4>
                </div>

                <div class="header-right">
                    <!-- Notificações -->
                    <div class="notifications me-3">
                        <a href="#" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span class="badge bg-danger">3</span>
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="user-menu dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('images/avatar.png') }}" class="avatar" alt="User">
                            <span class="d-none d-md-inline ms-2">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user"></i> Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle submenu
            const hasSubmenuLinks = document.querySelectorAll('.has-submenu > a');
            hasSubmenuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    const wasOpen = parent.classList.contains('open');
                    
                    // Fecha todos os submenus
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        item.classList.remove('open');
                    });
                    
                    // Abre o submenu clicado (se não estava aberto)
                    if (!wasOpen) {
                        parent.classList.add('open');
                    }
                });
            });

            // Toggle mobile menu
            const mobileToggle = document.querySelector('.mobile-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Fecha o menu mobile ao clicar fora
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>