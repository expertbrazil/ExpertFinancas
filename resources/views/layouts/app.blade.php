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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    <style>
        #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            color: #333;
        }
        .daily-verse {
            max-width: 640px;
            margin-right: 20px;
            font-size: 14px;
            color: #666;
            line-height: 1.3;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        .daily-verse p {
            margin: 0;
        }
        .verse-text {
            font-style: italic;
        }
        .verse-reference {
            font-weight: 500;
            color: #444;
            margin-top: 4px;
            font-size: 13px;
        }
        .sidebar {
            background-color: var(--sidebar-bg);
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
            overflow-y: auto;
        }
        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
            margin: 0;
        }
        .sidebar-menu li a {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: var(--primary-color);
            color: white;
        }
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .nav-user-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>
    <div id="loading">Carregando...</div>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('logos/logo.png') }}" alt="Expert Finanças">
            </div>
            
            <ul class="sidebar-menu">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span></span>
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
                @if(auth()->user()->role === 'root' || auth()->user()->role === 'admin')
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
                                <i class="fas fa-list-alt"></i>
                                <span>Logs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('technical-help.index') }}" class="{{ request()->routeIs('technical-help.*') ? 'active' : '' }}">
                                <i class="fas fa-question-circle"></i>
                                <span>Ajuda Técnica</span>
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
                    <h4 class="mb-0">@yield('title', '')</h4>
                </div>

                <div class="header-right">
                    <!-- Versículo do Dia -->
                    <div class="daily-verse d-none d-lg-block">
                        <div id="versiculo">
                            <div class="text-center">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Carregando...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="nav-link dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="nav-user-img" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user fa-fw"></i> Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-fw"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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
    <script src="{{ asset('js/money.js') }}"></script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loading').style.display = 'none';
        });

        // Versículos em português
        document.addEventListener('DOMContentLoaded', function() {
            const versiculoDiv = document.getElementById('versiculo');
            const versiculos = [
                { texto: "Porque Deus amou tanto o mundo que deu seu Filho Unigênito, para que todo aquele que nele crer não pereça, mas tenha a vida eterna.", referencia: "João 3:16" },
                { texto: "O Senhor é o meu pastor e nada me faltará.", referencia: "Salmos 23:1" },
                { texto: "Deus é a minha salvação; terei confiança e não temerei. O Senhor, sim, o Senhor é a minha força e o meu cântico; ele é a minha salvação!", referencia: "Isaías 12:2" },
                { texto: "Assim, quer vocês comam, quer bebam, quer façam qualquer outra coisa, façam tudo para a glória de Deus.", referencia: "1 Coríntios 10:31" },
                { texto: "Entrega o teu caminho ao Senhor; confia nele, e ele tudo fará.", referencia: "Salmos 37:5" },
                { texto: "Mas os que esperam no Senhor renovarão as suas forças; subirão com asas como águias; correrão, e não se cansarão; andarão, e não se fatigarão.", referencia: "Isaías 40:31" }
            ];

            const hoje = new Date();
            const indice = (hoje.getFullYear() + hoje.getMonth() + hoje.getDate()) % versiculos.length;
            const versiculoDoDia = versiculos[indice];

            versiculoDiv.innerHTML = `
                <div class="verse-content">
                    <p class="verse-text">"${versiculoDoDia.texto}"</p>
                    <p class="verse-reference">${versiculoDoDia.referencia}</p>
                </div>
            `;
        });

        // Submenu toggle
        document.querySelectorAll('.has-submenu > a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.parentElement;
                const submenu = parent.querySelector('.submenu');
                
                // Toggle active class
                parent.classList.toggle('open');
                
                // Toggle submenu
                if (submenu) {
                    if (submenu.style.maxHeight) {
                        submenu.style.maxHeight = null;
                    } else {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                    }
                }
            });
        });
    </script>
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({ startOnLoad: true });
    </script>
    @stack('scripts')
</body>
</html>