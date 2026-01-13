@extends('layouts.app')

@section('title', 'Categorias')

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

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: normal;
            overflow: visible;
            min-height: 40px;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .success-alert {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #155724;
        }

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

            .actions {
                gap: 6px;
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

            .btn-create {
                width: 100%;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-start mb-4">
        <h1 class="mb-0">Categorias</h1>
        <div class="d-flex flex-column align-items-end">
            @if (session('success'))
                <div class="success-alert mb-2">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('categories.create') }}" class="btn btn-success btn-create">Criar Categoria</a>
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
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Editar</a>
                                <form action="{{ route('categories.toggle', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if ($category->active)
                                        <button type="submit" class="btn btn-warning">Desativar</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Ativar</button>
                                    @endif
                                </form>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

