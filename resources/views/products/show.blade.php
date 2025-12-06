@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">← Voltar</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if ($product->image)
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <span class="text-muted">Sem imagem</span>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h1>{{ $product->name }}</h1>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Preço:</strong></p>
                            <p class="fs-5 text-success">{{ number_format($product->price, 2, ',', '.') }} €</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Quantidade:</strong></p>
                            <p class="fs-5">{{ $product->quantity }} un.</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Categoria:</strong></p>
                            <p>{{ $product->category->name ?? 'Sem categoria' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Qty Mínima:</strong></p>
                            <p>{{ $product->min_quantity ?? '-' }} un.</p>
                        </div>
                    </div>

                    @if ($product->description)
                        <div class="mb-3">
                            <p class="mb-1"><strong>Descrição:</strong></p>
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tens a certeza que queres eliminar?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
