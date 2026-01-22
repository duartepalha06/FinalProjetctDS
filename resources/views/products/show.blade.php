@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <style>
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .product-container {
            background: white;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .product-image-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            text-align: center;
        }

        .product-detail-img {
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;
            border-radius: 8px;
        }

        .product-no-img {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 1rem;
        }

        .product-info-section {
            padding: 25px;
        }

        .product-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-item.highlight {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        }

        .info-label {
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
        }

        .info-item.highlight .info-value {
            color: #155724;
        }

        .description-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .description-section p {
            margin: 0;
            color: #495057;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="product-header">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="product-container">
        <div class="row g-0">
            <div class="col-md-4">
                <div class="product-image-section h-100">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-detail-img">
                    @else
                        <div class="product-no-img">
                            <span>Sem imagem</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <div class="product-info-section">
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="info-grid">
                        <div class="info-item highlight">
                            <p class="info-label">Preço de Venda</p>
                            <p class="info-value mb-0">{{ number_format($product->price, 2, ',', '.') }} €</p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Preço de Produção</p>
                            <p class="info-value mb-0">{{ number_format($product->preco_de_producao ?? 0, 2, ',', '.') }} €</p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Quantidade em Stock</p>
                            <p class="info-value mb-0">{{ $product->quantity }} unidades</p>
                        </div>
                        <div class="info-item">
                            <p class="info-label">Qtd Mínima</p>
                            <p class="info-value mb-0">{{ $product->min_quantity ?? '-' }} unidades</p>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <p class="info-label">Categoria</p>
                            <p class="info-value mb-0">{{ $product->category->name ?? 'Sem categoria' }}</p>
                        </div>
                    </div>

                    @if ($product->description)
                        <div class="description-section">
                            <p class="info-label">Descrição</p>
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif

                    <div class="action-buttons">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmação Eliminar Produto -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Tem a certeza que pretende eliminar o produto <strong>{{ $product->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Produto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" required value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categoria</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">-- Selecione --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" class="form-control" rows="2">{{ $product->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantidade</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required value="{{ $product->quantity }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="min_quantity" class="form-label">Qtd Mínima</label>
                                    <input type="number" name="min_quantity" id="min_quantity" class="form-control" value="{{ $product->min_quantity }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Preço (€)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="preco_de_producao" class="form-label">Custo (€)</label>
                                    <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control" value="{{ $product->preco_de_producao }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagem</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
