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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Gestor de Stock</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('products.index')) active @endif" href="{{ route('products.index') }}">Produtos</a>
                            </li>
                            <li class="nav-item">
                               <a class="nav-link @if (request()->routeIs('categories.*')) active @endif" href="{{ route('categories.index') }}">Categorias</a>
                            </li>
                                     <li class="nav-item">
                                         <a class="nav-link @if (request()->routeIs('funcionarios.*') || request()->routeIs('funcionarios.index')) active @endif" href="{{ route('funcionarios.index') }}">Funcionários</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link @if (request()->routeIs('estatisticas.*') || request()->routeIs('estatisticas.index')) active @endif" href="{{ route('estatisticas.index') }}">Estatísticas</a>
                                     </li>
                            <li class="nav-item">
                               <a class="nav-link @if (request()->routeIs('stock-history.*')) active @endif" href="{{ route('stock-history.index') }}">Histórico Stock</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link @if (request()->routeIs('shop.index')) active @endif" href="{{ route('shop.index') }}">Loja</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                @auth
                    <ul class="navbar-nav ms-auto">
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('alerts.index') }}">
                                    🔔 Alertas
                                    @if (App\Models\Alert::where('read', false)->count() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ App\Models\Alert::where('read', false)->count() }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <span class="nav-link text-light">Olá, {{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color: white; text-decoration: none;">Sair</button>
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
