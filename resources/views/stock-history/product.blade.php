@extends('layouts.app')

@section('title', 'Histórico de Stock - ' . $product->name)

@section('content')
    <style>
        .product-info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 5px solid #0d6efd;
        }

        .product-info-card p {
            margin: 8px 0;
            color: #495057;
        }

        .product-info-card strong {
            color: #1a1a2e;
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

        .pagination-simple {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .pagination-simple .btn {
            min-width: 100px;
        }

        .pagination-simple .btn.disabled {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #adb5bd;
            cursor: not-allowed;
        }
    </style>

    <a href="{{ route('stock-history.index') }}" class="btn btn-secondary mb-4">Voltar</a>

    <h1 class="mb-2">Histórico de Stock</h1>
    <p class="text-muted mb-4">{{ $product->name }}</p>

    <div class="product-info-card">
        <p><strong>Categoria:</strong> {{ $product->category->name }}</p>
        <p><strong>Quantidade Atual:</strong> {{ $product->quantity }} un.</p>
        <p><strong>Preço:</strong> {{ number_format($product->price, 2, ',', '.') }} €</p>
    </div>

    @if ($histories->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">Não há registos no histórico para este produto.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Utilizador</th>
                                <th>Ação</th>
                                <th>Antes</th>
                                <th>Depois</th>
                                <th>Alteração</th>
                                <th>Motivo</th>
                                <th>Data/Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="pagination-simple">
            @if ($histories->onFirstPage())
                <span class="btn disabled">Anterior</span>
            @else
                <a href="{{ $histories->previousPageUrl() }}" class="btn btn-primary">Anterior</a>
            @endif

            @if (!$histories->hasMorePages())
                <span class="btn disabled">Seguinte</span>
            @else
                <a href="{{ $histories->nextPageUrl() }}" class="btn btn-primary">Seguinte</a>
            @endif
        </div>
    @endif
@endsection
