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
            white-space: normal;
            overflow: visible;
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-info { background-color: #17a2b8; color: white; }
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }

        .actions { display: flex; gap: 8px; flex-wrap: wrap; }

        .empty-message { text-align: center; padding: 40px; color: #6c757d; }

        .success-alert { background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #155724; }

        @media (max-width: 768px) {
            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.6rem !important;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.75rem;
                min-height: 36px;
            }

            .badge {
                font-size: 0.75rem;
                padding: 4px 8px;
            }

            h1 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            table {
                font-size: 0.7rem;
            }

            th, td {
                padding: 0.4rem !important;
            }

            .btn {
                padding: 5px 8px;
                font-size: 0.65rem;
                min-height: 32px;
            }

            .badge {
                font-size: 0.65rem;
                padding: 3px 6px;
            }

            .actions {
                gap: 4px;
            }

            h1 {
                font-size: 1.1rem;
            }

            .d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-success {
                width: 100%;
            }
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

    <!-- Modal de Criação de Produto (compacto) -->
    <style>
      .modal-compact .modal-content { font-size: 0.92rem; }
      .modal-compact label, .modal-compact .form-label { font-size: 0.92rem; }
      .modal-compact input, .modal-compact textarea, .modal-compact select { font-size: 0.92rem; padding: 0.35rem 0.5rem; }
      .modal-compact .modal-title { font-size: 1.1rem; }
      .modal-compact .btn { font-size: 0.92rem; padding: 0.35rem 0.8rem; }
    </style>
    <div class="modal fade modal-compact" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
      <div class="modal-dialog">
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
                <div class="mb-2">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="mb-2">
                    <label for="quantity" class="form-label">Quantidade</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="price" class="form-label">Preço (€)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="preco_de_producao" class="form-label">Preço de Produção (€)</label>
                    <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="min_quantity" class="form-label">Quantidade Mínima</label>
                    <input type="number" name="min_quantity" id="min_quantity" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="category_id" class="form-label">Categoria</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Selecione uma categoria --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                <!-- Modal Editar Produto (compacto) -->
                                <div class="modal fade modal-compact" id="editProductModal-{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel-{{ $product->id }}" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel-{{ $product->id }}">Editar Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label for="name-{{ $product->id }}" class="form-label">Nome</label>
                                                <input type="text" name="name" id="name-{{ $product->id }}" class="form-control" required value="{{ $product->name }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="description-{{ $product->id }}" class="form-label">Descrição</label>
                                                <textarea name="description" id="description-{{ $product->id }}" class="form-control">{{ $product->description }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label for="quantity-{{ $product->id }}" class="form-label">Quantidade</label>
                                                <input type="number" name="quantity" id="quantity-{{ $product->id }}" class="form-control" required value="{{ $product->quantity }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="price-{{ $product->id }}" class="form-label">Preço (€)</label>
                                                <input type="number" step="0.01" name="price" id="price-{{ $product->id }}" class="form-control" required value="{{ $product->price }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="preco_de_producao-{{ $product->id }}" class="form-label">Preço de Produção (€)</label>
                                                <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao-{{ $product->id }}" class="form-control" value="{{ $product->preco_de_producao }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="min_quantity-{{ $product->id }}" class="form-label">Quantidade Mínima</label>
                                                <input type="number" name="min_quantity" id="min_quantity-{{ $product->id }}" class="form-control" value="{{ $product->min_quantity }}">
                                            </div>
                                            <div class="mb-2">
                                                <label for="category_id-{{ $product->id }}" class="form-label">Categoria</label>
                                                <select name="category_id" id="category_id-{{ $product->id }}" class="form-select" required>
                                                    <option value="">-- Selecione uma categoria --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="image-{{ $product->id }}" class="form-label">Imagem</label>
                                                <input type="file" name="image" id="image-{{ $product->id }}" class="form-control">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
