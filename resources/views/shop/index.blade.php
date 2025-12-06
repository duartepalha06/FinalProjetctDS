@extends('layouts.app')

@section('title', 'Loja')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Bem-vindo à Loja, {{ auth()->user()->name }}!</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <span class="text-muted">Sem imagem</span>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>

                            <div class="mb-3">
                                <p class="mb-1"><strong>Preço:</strong> {{ number_format($product->price, 2, ',', '.') }} €</p>
                                <p class="mb-1"><strong>Quantidade Disponível:</strong> <span class="badge bg-info">{{ $product->quantity }}</span></p>
                            </div>

                            <div class="d-flex gap-2">
                                <form action="{{ route('shop.decrease', $product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                        - Reduzir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Nenhum produto disponível no momento.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
