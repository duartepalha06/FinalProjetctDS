@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <style>
        h1 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #343a40;
        }

        .btn-create {
            margin-bottom: 20px;
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
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            padding: 15px;
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

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-info { background-color: #17a2b8; color: white; }
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }

        .actions { display: flex; gap: 8px; flex-wrap: wrap; }

        .empty-message { text-align: center; padding: 40px; color: #6c757d; }

        .success-alert { background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #155724; }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Lista de Produtos</h1>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-success">Adicionar Produtos</a>
            @endif
        @endauth
    </div>

    @if (session('success'))
        <div class="success-alert">{{ session('success') }}</div>
    @endif

    @if ($products->isEmpty())
        <div class="empty-message">
            <p>Nenhum produto encontrado.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:80px;">Imagem</th>
                    <th>
                        <a href="{{ route('products.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' && request('sort') === 'name' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">Nome
                            @if($sort === 'name') <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                        </a>
                    </th>
                    <th style="width:140px;">
                        <a href="{{ route('products.index', ['sort' => 'quantity', 'direction' => request('direction') === 'asc' && request('sort') === 'quantity' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">Quantidade
                            @if($sort === 'quantity') <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                        </a>
                    </th>
                    <th style="width:140px;">
                        <a href="{{ route('products.index', ['sort' => 'price', 'direction' => request('direction') === 'asc' && request('sort') === 'price' ? 'desc' : 'asc']) }}" style="color: inherit; text-decoration: none;">Preço
                            @if($sort === 'price') <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span> @endif
                        </a>
                    </th>
                    <th style="width:240px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius:6px;">
                            @else
                                <span class="text-muted">Sem imagem</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price, 2, ',', '.') }} €</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-info">Ver</a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Tens a certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
