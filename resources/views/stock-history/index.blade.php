@extends('layouts.app')

@section('title', 'Histórico de Stock')

@section('content')
    <style>
        h1 {
            font-weight: bold;
            margin-bottom: 30px;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #f8f9fa;
            padding: 8px;
            text-align: left;
            font-weight: 600;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

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

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            white-space: normal;
            overflow: visible;
            min-height: 40px;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .pagination {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-decoration: none;
            color: #0d6efd;
        }

        .pagination a:hover {
            background-color: #f8f9fa;
        }

        .pagination .active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.6rem !important;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.75rem;
                min-height: 36px;
            }

            h1 {
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            table {
                font-size: 0.7rem;
            }

            th, td {
                padding: 0.4rem !important;
            }

            .btn {
                padding: 5px 8px;
                font-size: 0.65rem;
                min-height: 32px;
            }

            h1 {
                font-size: 1.1rem;
            }

            .pagination {
                gap: 3px;
            }

            .pagination a,
            .pagination span {
                padding: 5px 8px;
                font-size: 0.75rem;
            }
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
    </style>


    <h1>Histórico de Alterações de Stock</h1>


    <form method="GET" action="" style="margin-bottom: 30px; max-width: 420px;">
        <div style="display: flex; gap: 12px; align-items: center; background: #f8f9fa; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 8px 14px;">
            <input type="text" name="search" class="form-control" style="border-radius: 6px; border: 1px solid #dee2e6; box-shadow: none; height: 42px; font-size: 1rem; background: #fff; min-width: 400px; width: 100%; max-width: 600px;" placeholder="Pesquisar produto ou funcionário" value="{{ request('search') }}">
            <button type="submit" class="btn btn-info" style="border-radius: 6px; min-width: 100px; font-weight: 600; font-size: 1rem; height: 42px; margin-left: 4px; box-shadow: 0 2px 8px rgba(13,110,253,0.07);">Pesquisar</button>
        </div>
    </form>

    @if ($histories->isEmpty())
        <div class="empty-message">
            <p>Não há registos no histórico.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Utilizador</th>
                    <th>Ação</th>
                    <th>Quantidade Antes</th>
                    <th>Quantidade Depois</th>
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
                                @if ($history->quantity_changed > 0)
                                    +{{ $history->quantity_changed }}
                                @else
                                    {{ $history->quantity_changed }}
                                @endif
                                un.
                            </span>
                        </td>
                        <td>{{ $history->reason ?? '-' }}</td>
                        <td>{{ $history->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('stock-history.product', $history->product) }}" class="btn btn-info">Ver Histórico</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if (!$histories->isEmpty())
    <div style="text-align: center; margin-top: 40px;">
        <div style="margin-bottom: 20px; color: #343a40; font-size: 1rem;">
            <strong>{{ $histories->firstItem() }} - {{ $histories->lastItem() }}</strong> de <strong>{{ $histories->total() }}</strong> ações
        </div>
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
            @if ($histories->onFirstPage())
                <span style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #e0e0e0; display: inline-flex; align-items: center; justify-content: center; color: #ccc; cursor: not-allowed;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                </span>
            @else
                <a href="{{ $histories->previousPageUrl() }}" style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #dee2e6; display: inline-flex; align-items: center; justify-content: center; color: #6c757d; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                </a>
            @endif

            <span style="font-weight: 700; font-size: 1.2rem; color: #343a40;">
                <style>
                    #pageInput::-webkit-outer-spin-button,
                    #pageInput::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }
                    #pageInput {
                        -moz-appearance: textfield;
                    }
                </style>
                <input type="number" id="pageInput" value="{{ $histories->currentPage() }}" min="1" max="{{ $histories->lastPage() }}"
                    style="width: 50px; text-align: center; font-weight: 700; font-size: 1.2rem; color: #343a40; border: 2px solid #dee2e6; border-radius: 8px; padding: 5px; outline: none;"
                    onchange="goToPage(this.value)"
                    onkeypress="if(event.key === 'Enter') goToPage(this.value)">
                <span style="font-weight: 400; color: #6c757d;">/ {{ $histories->lastPage() }}</span>
            </span>

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

            @if (!$histories->hasMorePages())
                <span style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #e0e0e0; display: inline-flex; align-items: center; justify-content: center; color: #ccc; cursor: not-allowed;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </span>
            @else
                <a href="{{ $histories->nextPageUrl() }}" style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #dee2e6; display: inline-flex; align-items: center; justify-content: center; color: #6c757d; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 6px rgba(0,0,0,0.08);">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </a>
            @endif
        </div>
    </div>
    @endif
@endsection
