@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <h1 class="mb-4">Lista de Produtos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th style="cursor: pointer;">
                    <a href="{{ route('products.index', ['sort' => 'id', 'direction' => request('direction') === 'asc' && request('sort') === 'id' ? 'desc' : 'asc']) }}" style="color: white; text-decoration: none;">
                        Imagem
                        @if($sort === 'id')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </a>
                </th>
                <th style="cursor: pointer;">
                    <a href="{{ route('products.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' && request('sort') === 'name' ? 'desc' : 'asc']) }}" style="color: white; text-decoration: none;">
                        Nome
                        @if($sort === 'name')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </a>
                </th>
                <th style="cursor: pointer;">
                    <a href="{{ route('products.index', ['sort' => 'quantity', 'direction' => request('direction') === 'asc' && request('sort') === 'quantity' ? 'desc' : 'asc']) }}" style="color: white; text-decoration: none;">
                        Quantidade
                        @if($sort === 'quantity')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </a>
                </th>
                <th style="cursor: pointer;">
                    <a href="{{ route('products.index', ['sort' => 'price', 'direction' => request('direction') === 'asc' && request('sort') === 'price' ? 'desc' : 'asc']) }}" style="color: white; text-decoration: none;">
                        Preço
                        @if($sort === 'price')
                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </a>
                </th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                        @else
                            <span class="text-muted">Sem imagem</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ number_format($product->price, 2, ',', '.') }} €</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tens a certeza?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Nenhum produto encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
