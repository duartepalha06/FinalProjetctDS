@extends('layouts.app')

@section('title', 'Loja')

@section('content')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            color: white;
            padding: 18px 22px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .welcome-banner h1 {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 5px;
            padding-bottom: 0;
        }

        .welcome-banner h1::after {
            display: none;
        }

        .welcome-banner p {
            opacity: 0.9;
            margin: 0;
            font-size: 0.9rem;
        }

        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
        }

        .product-card .card-img-top {
            height: 140px;
            object-fit: cover;
        }

        .product-card .no-image {
            height: 140px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 0.85rem;
        }

        .product-card .card-body {
            padding: 14px;
        }

        .product-card .card-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .product-card .price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .stock-indicator {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stock-available {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .stock-low {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
            color: #856404;
        }

        .stock-empty {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
    </style>

    <div class="welcome-banner">
        <h1>Bem-vindo à Loja, {{ auth()->user()->name }}!</h1>
        <p>Explore os nossos produtos disponíveis</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <div class="no-image">
                            <span>Sem imagem</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted flex-grow-1" style="font-size: 0.85rem;">{{ Str::limit($product->description, 60) }}</p>

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="price">{{ number_format($product->price, 2, ',', '.') }} €</span>
                            <span class="stock-indicator @if($product->quantity > 10) stock-available @elseif($product->quantity > 0) stock-low @else stock-empty @endif">
                                {{ $product->quantity }}
                            </span>
                        </div>

                        <form action="{{ route('shop.decrease', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                Reduzir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-message">
                    <p>Nenhum produto disponível no momento.</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
