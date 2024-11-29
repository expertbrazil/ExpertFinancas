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

    <style>
        :root {
            --primary-color: {{ $parametros->cor_primaria ?? '#0d6efd' }};
            --secondary-color: {{ $parametros->cor_secundaria ?? '#6c757d' }};
            --background-color: {{ $parametros->cor_fundo ?? '#ffffff' }};
            --text-color: {{ $parametros->cor_texto ?? '#212529' }};
            --navbar-color: {{ $parametros->cor_navbar ?? '#212529' }};
            --footer-color: {{ $parametros->cor_footer ?? '#212529' }};
        }
        .navbar-custom {
            background-color: var(--navbar-color) !important;
        }
        .footer-custom {
            background-color: var(--footer-color) !important;
        }
        .logo-img {
            max-height: 40px;
            width: auto;
        }
    </style>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: var(--background-color); color: var(--text-color);">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/">
                @if($parametros && $parametros->logo_path && file_exists(public_path($parametros->logo_path)))
                    <img src="/{{ $parametros->logo_path }}" alt="Logo" style="max-width: 200px; height: auto;">
                    <div class="text-white mt-2" style="font-size: 14px;">{{ $parametros->nome_sistema }}</div>
                @else
                    <span class="text-white" style="font-size: 14px;">{{ $parametros ? $parametros->nome_sistema : 'Expert Finanças' }}</span>
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('parametros.edit') }}">
                            <i class="fas fa-cogs"></i> Configurações
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
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
    </main>

    <footer class="footer mt-auto py-3 footer-custom text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    @if($parametros->texto_rodape)
                        {!! $parametros->texto_rodape !!}
                    @else
                        <h6 class="mb-2">Desenvolvido por</h6>
                        <p class="mb-0">Robson Jones Romanquio</p>
                        <small class="text-muted">ExpertBrazil WEB</small>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    @if($parametros->email_contato || $parametros->telefone_contato)
                        <p class="mb-2">
                            @if($parametros->email_contato)
                                <a href="mailto:{{ $parametros->email_contato }}" class="text-light text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>{{ $parametros->email_contato }}
                                </a>
                            @endif
                            @if($parametros->telefone_contato)
                                <br>
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $parametros->telefone_contato) }}" class="text-light text-decoration-none">
                                    <i class="fas fa-phone me-1"></i>{{ $parametros->telefone_contato }}
                                </a>
                            @endif
                        </p>
                    @endif
                    <p class="mb-0">
                        <small class="text-muted">Versão 1.0</small>
                    </p>
                    <p class="mb-0">
                        <small class="text-muted">&copy; {{ date('Y') }} {{ $parametros->nome_sistema ?? 'Todos os direitos reservados' }}</small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @stack('scripts')
</body>
</html>
