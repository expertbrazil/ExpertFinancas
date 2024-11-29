<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $parametros->nome_sistema ?? config('app.name', 'Expert Finanças') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-colors.css') }}">
    @auth
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @endauth

    <style>
        :root {
            --primary-color: {{ $parametros->cor_primaria ?? '#0d6efd' }};
            --secondary-color: {{ $parametros->cor_secundaria ?? '#6c757d' }};
            --background-color: {{ $parametros->cor_fundo ?? '#ffffff' }};
            --text-color: {{ $parametros->cor_texto ?? '#212529' }};
            --navbar-color: {{ $parametros->cor_navbar ?? '#212529' }};
            --footer-color: {{ $parametros->cor_footer ?? '#212529' }};
        }
    </style>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: var(--background-color); color: var(--text-color);">
    @auth
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand d-flex align-items-center">
                @if($parametros && $parametros->logo_path && file_exists(public_path($parametros->logo_path)))
                    <img src="/{{ $parametros->logo_path }}" alt="Logo" class="img-fluid">
                @else
                    <span class="text-white">{{ $parametros->nome_sistema ?? 'Expert Finanças' }}</span>
                @endif
            </a>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="#cadastrosSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-folder"></i> Cadastros
                </a>
                <ul class="sidebar-submenu collapse" id="cadastrosSubmenu">
                    <li>
                        <a href="{{ route('clientes.index') }}">
                            <i class="fas fa-users"></i> Clientes/Fornecedores
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('servicos.index') }}">
                            <i class="fas fa-concierge-bell"></i> Serviços
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('produtos.index') }}">
                            <i class="fas fa-box"></i> Produtos
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#financeiroSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-dollar-sign"></i> Financeiro
                </a>
                <ul class="sidebar-submenu collapse" id="financeiroSubmenu">
                    <li>
                        <a href="{{ route('contas-pagar.index') }}">
                            <i class="fas fa-money-bill-alt"></i> Contas a Pagar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contas-receber.index') }}">
                            <i class="fas fa-hand-holding-usd"></i> Contas a Receber
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('planos.index') }}">
                    <i class="fas fa-server"></i> Planos de Hospedagens
                </a>
            </li>

            <li>
                <a href="#parametrosSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="fas fa-cogs"></i> Parâmetros
                </a>
                <ul class="sidebar-submenu collapse" id="parametrosSubmenu">
                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> Usuários
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('parametros.edit') }}">
                            <i class="fas fa-wrench"></i> Configurações
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    @endauth

    <!-- Main Content -->
    <div class="main-content {{ !Auth::check() ? 'w-100' : '' }}">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
