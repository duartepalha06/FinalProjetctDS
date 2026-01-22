@extends('layouts.app')

@section('title', 'Histórico de Stock')

@section('content')
    <style>
        .badge-created {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-updated {
            background-color: #cfe2ff;
            color: #084298;
        }

        .badge-decreased {
            background-color: #f8d7da;
            color: #842029;
        }

        .quantity-change {
            font-weight: 600;
        }

        .quantity-increase {
            color: #28a745;
        }

        .quantity-decrease {
            color: #dc3545;
        }

        .search-box {
            display: flex;
            gap: 12px;
            align-items: center;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            padding: 12px 18px;
            max-width: 450px;
            margin-bottom: 25px;
        }

        .search-box input {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            height: 42px;
            font-size: 0.95rem;
            flex: 1;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .pagination-wrapper {
            text-align: center;
            margin-top: 35px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .pagination-info strong {
            color: #1a1a2e;
        }

        .pagination-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .pagination-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s;
        }

        .pagination-btn:hover:not(.disabled) {
            background: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .pagination-btn.disabled {
            color: #ccc;
            border-color: #e0e0e0;
            cursor: not-allowed;
        }

        .page-input {
            width: 50px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: #1a1a2e;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 5px;
            outline: none;
            transition: border-color 0.2s;
            -moz-appearance: textfield;
        }

        .page-input::-webkit-outer-spin-button,
        .page-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .page-input:focus {
            border-color: #0d6efd;
        }
    </style>

    <h1 class="mb-4">Histórico de Alterações de Stock</h1>

    <form method="GET" action="">
        <div class="search-box">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar produto ou funcionário" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info">Pesquisar</button>
        </div>
    </form>

    @if ($histories->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">Não há registos no histórico.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Utilizador</th>
                                <th>Ação</th>
                                <th>Antes</th>
                                <th>Depois</th>
                                <th>Alteração</th>
                                <th>Motivo</th>
                                <th>Data/Hora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr>
                                    <td>{{ $history->product->name }}</td>
                                    <td>{{ $history->user->name }}</td>
                                    <td>
                                        @if ($history->action === 'created')
                                            <span class="badge badge-created">Criado</span>
                                        @elseif ($history->action === 'updated')
                                            <span class="badge badge-updated">Atualizado</span>
                                        @elseif ($history->action === 'decreased')
                                            <span class="badge badge-decreased">Reduzido</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->quantity_before }} un.</td>
                                    <td>{{ $history->quantity_after }} un.</td>
                                    <td>
                                        <span class="quantity-change @if ($history->quantity_changed > 0) quantity-increase @else quantity-decrease @endif">
                                            @if ($history->quantity_changed > 0)+@endif{{ $history->quantity_changed }} un.
                                        </span>
                                    </td>
                                    <td>{{ $history->reason ?? '-' }}</td>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('stock-history.product', $history->product) }}" class="btn btn-info btn-sm">Ver Histórico</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if (!$histories->isEmpty())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            <strong>{{ $histories->firstItem() }} - {{ $histories->lastItem() }}</strong> de <strong>{{ $histories->total() }}</strong> registos
        </div>
        <div class="pagination-nav">
            @if ($histories->onFirstPage())
                <span class="pagination-btn disabled">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                </span>
            @else
                <a href="{{ $histories->previousPageUrl() }}" class="pagination-btn">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                </a>
            @endif

            <span style="font-weight: 700; font-size: 1.1rem; color: #1a1a2e;">
                <input type="number" class="page-input" value="{{ $histories->currentPage() }}" min="1" max="{{ $histories->lastPage() }}" onchange="goToPage(this.value)" onkeypress="if(event.key === 'Enter') goToPage(this.value)">
                <span style="font-weight: 400; color: #6c757d;">/ {{ $histories->lastPage() }}</span>
            </span>

            @if (!$histories->hasMorePages())
                <span class="pagination-btn disabled">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </span>
            @else
                <a href="{{ $histories->nextPageUrl() }}" class="pagination-btn">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </a>
            @endif
        </div>
    </div>

    <script>
        function goToPage(page) {
            const maxPage = {{ $histories->lastPage() }};
            page = parseInt(page);
            if (page < 1) page = 1;
            if (page > maxPage) page = maxPage;
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
    </script>
    @endif
@endsection
