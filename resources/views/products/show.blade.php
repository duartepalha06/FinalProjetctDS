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
                            <p class="mb-1"><strong>Preço de Produção:</strong></p>
                            <p class="fs-5 text-secondary">{{ number_format($product->preco_de_producao ?? 0, 2, ',', '.') }} €</p>
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
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tens a certeza que queres eliminar?')">Eliminar</button>
                        </form>
                    </div>
                    <!-- Modal Editar Produto (compacto) -->
                    <style>
                      .modal-compact .modal-content { font-size: 0.92rem; }
                      .modal-compact label, .modal-compact .form-label { font-size: 0.92rem; }
                      .modal-compact input, .modal-compact textarea, .modal-compact select { font-size: 0.92rem; padding: 0.35rem 0.5rem; }
                      .modal-compact .modal-title { font-size: 1.1rem; }
                      .modal-compact .btn { font-size: 0.92rem; padding: 0.35rem 0.8rem; }
                    </style>
                    <div class="modal fade modal-compact" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" required value="{{ $product->name }}">
                                </div>
                                <div class="mb-2">
                                    <label for="description" class="form-label">Descrição</label>
                                    <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label for="quantity" class="form-label">Quantidade</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required value="{{ $product->quantity }}">
                                </div>
                                <div class="mb-2">
                                    <label for="price" class="form-label">Preço (€)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ $product->price }}">
                                </div>
                                <div class="mb-2">
                                    <label for="preco_de_producao" class="form-label">Preço de Produção (€)</label>
                                    <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control" value="{{ $product->preco_de_producao }}">
                                </div>
                                <div class="mb-2">
                                    <label for="min_quantity" class="form-label">Quantidade Mínima</label>
                                    <input type="number" name="min_quantity" id="min_quantity" class="form-control" value="{{ $product->min_quantity }}">
                                </div>
                                <div class="mb-2">
                                    <label for="category_id" class="form-label">Categoria</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">-- Selecione uma categoria --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="image" class="form-label">Imagem</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                  <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
