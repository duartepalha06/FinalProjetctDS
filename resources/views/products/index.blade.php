@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <style>
        .btn-create {
            margin-bottom: 20px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .product-img-placeholder {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 0.7rem;
        }

        .stock-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .stock-ok {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .stock-low {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
            color: #856404;
        }

        .stock-critical {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .sort-link {
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .sort-link:hover {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 0.6rem !important;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 0.4rem !important;
                font-size: 0.75rem;
            }
        }

        .actions {
            display: flex;
            flex-wrap: nowrap;
            gap: 6px;
            align-items: center;
        }

        .actions form {
            display: inline-block;
            margin: 0;
        }

        .actions .btn {
            white-space: nowrap;
        }
    </style>


    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Lista de Produtos</h1>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductModal">Adicionar Produtos</a>
            @endif
        @endauth
    </div>

    <!-- Modal de Criação de Produto -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createProductModalLabel">Adicionar Produto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Selecione --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantidade</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="min_quantity" class="form-label">Qtd Mínima</label>
                            <input type="number" name="min_quantity" id="min_quantity" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="price" class="form-label">Preço (€)</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="preco_de_producao" class="form-label">Custo (€)</label>
                            <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control">
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

    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
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
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal-{{ $product->id }}">Editar</a>
                                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline delete-product-form" data-product-id="{{ $product->id }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal-{{ $product->id }}">Eliminar</button>
                                                                </form>
                                                                <!-- Modal Confirmação Eliminar Produto -->
                                                                <div class="modal fade" id="deleteProductModal-{{ $product->id }}" tabindex="-1" aria-labelledby="deleteProductModalLabel-{{ $product->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="deleteProductModalLabel-{{ $product->id }}">Confirmar Eliminação</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Tem a certeza que pretende eliminar o produto <strong>{{ $product->name }}</strong>?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                                <button type="button" class="btn btn-danger" onclick="document.querySelector('.delete-product-form[data-product-id=\'{{ $product->id }}\']').submit();">Eliminar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                <!-- Modal Editar Produto -->
                                <div class="modal fade" id="editProductModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel-{{ $product->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel-{{ $product->id }}">Editar Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="name-{{ $product->id }}" class="form-label">Nome</label>
                                                        <input type="text" name="name" id="name-{{ $product->id }}" class="form-control" required value="{{ $product->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="category_id-{{ $product->id }}" class="form-label">Categoria</label>
                                                        <select name="category_id" id="category_id-{{ $product->id }}" class="form-select" required>
                                                            <option value="">-- Selecione --</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="description-{{ $product->id }}" class="form-label">Descrição</label>
                                                <textarea name="description" id="description-{{ $product->id }}" class="form-control" rows="2">{{ $product->description }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="quantity-{{ $product->id }}" class="form-label">Quantidade</label>
                                                        <input type="number" name="quantity" id="quantity-{{ $product->id }}" class="form-control" required value="{{ $product->quantity }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="min_quantity-{{ $product->id }}" class="form-label">Qtd Mínima</label>
                                                        <input type="number" name="min_quantity" id="min_quantity-{{ $product->id }}" class="form-control" value="{{ $product->min_quantity }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="price-{{ $product->id }}" class="form-label">Preço (€)</label>
                                                        <input type="number" step="0.01" name="price" id="price-{{ $product->id }}" class="form-control" required value="{{ $product->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="preco_de_producao-{{ $product->id }}" class="form-label">Custo (€)</label>
                                                        <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao-{{ $product->id }}" class="form-control" value="{{ $product->preco_de_producao }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image-{{ $product->id }}" class="form-label">Imagem</label>
                                                <input type="file" name="image" id="image-{{ $product->id }}" class="form-control">
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
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
