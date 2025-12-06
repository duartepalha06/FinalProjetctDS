@extends('layouts.app')

@section('title', 'Categoria: ' . $category->name)

@section('content')
    <h1>Produtos da Categoria: {{ $category->name }}</h1>

    @if ($products->isEmpty())
        <p>Não há produtos nesta categoria.</p>
    @else
        <ul class="list-group">
            @foreach ($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $product->name }}
                    <span class="badge bg-secondary">{{ $product->quantity }} unidades</span>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Voltar</a>
@endsection
