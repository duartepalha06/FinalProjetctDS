@extends('layouts.app')

@section('title', 'Categoria: ' . $category->name)

@section('content')
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-4">Voltar</a>

    <h1 class="mb-4">Produtos da Categoria: {{ $category->name }}</h1>

    @if ($products->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">Não há produtos nesta categoria.</p>
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
                                <th class="text-end">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-secondary">{{ $product->quantity }} un.</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
