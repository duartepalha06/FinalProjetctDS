<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gestor de Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #eef1f3; /* slightly darker light grey */
            padding: 2.25rem;
            border-radius: 12px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.07);
            max-width: 680px; /* a bit wider */
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
