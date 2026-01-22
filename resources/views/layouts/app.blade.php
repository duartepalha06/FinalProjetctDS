<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestor de Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .form-container {
            background-color: #eef1f3;
            padding: 2.25rem;
            border-radius: 12px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.07);
            max-width: 680px;
            width: 90%;
            margin: auto;
        }

        .form-title {
            text-align: center;
            margin-bottom: 1rem;
            color: #343a40;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .form-label { font-weight: 600; }

        .form-control { border-radius: 8px; padding: 0.6rem 0.75rem; }

        .btn-submit { background-color: #0d6efd; border: none; border-radius: 8px; padding: 0.6rem 1.2rem; font-weight: 700; }
        .btn-submit:hover { background-color: #0b5ed7; }

        a.text-primary { color: #0d6efd !important; }

        /* Sidebar sofisticada */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            height: 100vh;
            background: linear-gradient(180deg, #343a40 0%, #495057 50%, #6c757d 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 15px 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 12px 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar-brand span {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 12px;
        }

        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 5px;
        }

        .sidebar-nav .nav-link {
            display: block;
            padding: 10px 15px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-nav .nav-link.active {
            background: #0d6efd;
            color: white;
            box-shadow: 0 3px 10px rgba(13, 110, 253, 0.3);
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer .user-info {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .sidebar-footer .btn-logout {
            width: 100%;
            padding: 10px;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ff6b6b;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-footer .btn-logout:hover {
            background: rgba(220, 53, 69, 0.4);
            color: white;
        }

        .main-content {
            margin-left: 230px;
            padding: 25px;
            min-height: 100vh;
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-top: 70px;
            }
        }

        /* Tabelas responsivas */
        .table {
            margin-bottom: 1rem;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Cards responsivos */
        .card {
            margin-bottom: 1rem;
            border: 1px solid #e0e0e0;
        }

        .card-img-top {
            object-fit: cover;
        }

        /* Buttons responsivos */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: normal;
            overflow: visible;
            word-wrap: break-word;
            min-height: 44px;
        }

        .btn-sm {
            min-height: auto;
        }

        /* Containers responsivos */
        .container {
            width: 100%;
            padding-left: 15px;
            padding-right: 15px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Média queries - Tablets */
        @media (max-width: 768px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .card {
                margin-bottom: 0.8rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1rem;
            }

            .card-text {
                font-size: 0.9rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th, .table td {
                padding: 0.5rem;
            }

            .btn {
                padding: 0.4rem 0.7rem;
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
            }

            .row > div {
                margin-bottom: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.25rem;
            }

            h5 {
                font-size: 1rem;
            }

            .mb-4 {
                margin-bottom: 1.5rem !important;
            }

            .mb-3 {
                margin-bottom: 1rem !important;
            }

            .mt-4 {
                margin-top: 1.5rem !important;
            }
        }

        /* Média queries - Celulares */
        @media (max-width: 480px) {
            .container {
                padding-left: 8px;
                padding-right: 8px;
            }

            .navbar-brand {
                font-size: 0.9rem;
            }

            .nav-link {
                font-size: 0.75rem;
                padding: 0.2rem 0.4rem !important;
            }

            .card {
                margin-bottom: 0.8rem;
            }

            .card-body {
                padding: 0.8rem;
            }

            .card-title {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .card-text {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table th {
                padding: 0.3rem;
                font-size: 0.75rem;
            }

            .table td {
                padding: 0.3rem;
            }

            .btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.75rem;
            }

            .btn-sm {
                padding: 0.25rem 0.4rem;
                font-size: 0.65rem;
            }

            .badge {
                font-size: 0.65rem;
                padding: 0.3rem 0.4rem;
            }

            .alert {
                padding: 0.8rem;
                font-size: 0.85rem;
            }

            .alert p {
                margin-bottom: 0.25rem;
            }

            h1 {
                font-size: 1.2rem;
                margin-bottom: 1rem;
            }

            h2 {
                font-size: 1rem;
                margin-bottom: 0.8rem;
            }

            h5 {
                font-size: 0.9rem;
            }

            .form-label {
                font-size: 0.8rem;
            }

            .form-control {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .mb-3 {
                margin-bottom: 0.8rem !important;
            }

            .mb-2 {
                margin-bottom: 0.5rem !important;
            }

            .mt-4 {
                margin-top: 1rem !important;
            }

            .p-3 {
                padding: 0.8rem !important;
            }

            /* Tabelas em mobile - modo stacked */
            .table-responsive {
                overflow-x: auto;
            }

            .d-flex {
                gap: 0.3rem;
            }

            .gap-2 {
                gap: 0.3rem !important;
            }
        }
    </style>
</head>
<body>
    <!-- Botão toggle para mobile -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </button>

    <!-- Sidebar -->
    @auth
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span>Gestor de Stock</span>
        </div>

        <nav class="sidebar-nav">
            <ul>
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('products.index')) active @endif" href="{{ route('products.index') }}">
                            Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('categories.*')) active @endif" href="{{ route('categories.index') }}">
                            Categorias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('funcionarios.*')) active @endif" href="{{ route('funcionarios.index') }}">
                            Funcionários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('estatisticas.*')) active @endif" href="{{ route('estatisticas.index') }}">
                            Estatísticas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('stock-history.*')) active @endif" href="{{ route('stock-history.index') }}">
                            Histórico Stock
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative @if (request()->routeIs('alerts.*')) active @endif" href="{{ route('alerts.index') }}">
                            Alertas
                            @if (App\Models\Alert::where('read', false)->count() > 0)
                                <span class="badge rounded-pill bg-danger" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">
                                    {{ App\Models\Alert::where('read', false)->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('shop.index')) active @endif" href="{{ route('shop.index') }}">
                            Loja
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                Olá, {{ auth()->user()->name }}
            </div>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Conteúdo -->
    <div class="@auth main-content @endauth @guest container mt-4 @endguest">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>
