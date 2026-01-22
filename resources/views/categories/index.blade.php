@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <style>
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .status-inactive {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
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

            .d-flex {
                flex-direction: column;
                gap: 0.5rem;
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

    <div class="d-flex justify-content-between align-items-start mb-4">
        <h1 class="mb-0">Categorias</h1>
        <div class="d-flex flex-column align-items-end">
            @if (session('success'))
                <div class="alert alert-success mb-2">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('categories.create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Criar Categoria</a>
        </div>
    </div>

    <!-- Modal de Criação de Categoria -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createCategoryModalLabel">Adicionar Nova Categoria</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="modal-body">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="mb-3">
                  <label for="name" class="form-label">Nome da Categoria</label>
                  <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @if ($categories->isEmpty())
        <div class="empty-message">
            <p>Não há categorias disponíveis.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Status</th>
                    <th style="width: 30%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->active)
                                <span class="badge badge-success">Ativa</span>
                            @else
                                <span class="badge badge-danger">Inativa</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                                                <a href="{{ route('categories.show', $category) }}" class="btn btn-info">Ver</a>
                                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $category->id }}">Editar</a>
                                                                <form action="{{ route('categories.toggle', $category) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        @if ($category->active)
                                                                                <button type="submit" class="btn btn-warning">Desativar</button>
                                                                        @else
                                                                                <button type="submit" class="btn btn-success">Ativar</button>
                                                                        @endif
                                                                </form>
                                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline delete-category-form" data-category-id="{{ $category->id }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->id }}">Eliminar</button>
                                                                </form>
                                                                <!-- Modal Confirmação Eliminar Categoria -->
                                                                <div class="modal fade" id="deleteCategoryModal-{{ $category->id }}" tabindex="-1" aria-labelledby="deleteCategoryModalLabel-{{ $category->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="deleteCategoryModalLabel-{{ $category->id }}">Confirmar Eliminação</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Tem a certeza que pretende eliminar a categoria <strong>{{ $category->name }}</strong>?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                                <button type="button" class="btn btn-danger" onclick="document.querySelector('.delete-category-form[data-category-id=\'{{ $category->id }}\']').submit();">Eliminar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal Editar Categoria -->
                                                                <div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel-{{ $category->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editCategoryModalLabel-{{ $category->id }}">Editar Categoria</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="{{ route('categories.update', $category) }}" method="POST">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="modal-body">
                                                                                    <div class="mb-3">
                                                                                        <label for="name-{{ $category->id }}" class="form-label">Nome da Categoria</label>
                                                                                        <input type="text" name="name" id="name-{{ $category->id }}" class="form-control" required value="{{ $category->name }}">
                                                                                    </div>
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

