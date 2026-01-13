@extends('layouts.app')

@section('title', 'Funcionários')

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
                padding: 0.8rem !important;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.75rem;
                min-height: 36px;
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
                padding: 0.5rem !important;
            }

            .btn {
                padding: 5px 8px;
                font-size: 0.65rem;
                min-height: 32px;
            }

            h1 {
                font-size: 1.1rem;
            }

            .actions {
                gap: 4px;
            }

            .d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>

    <h1 class="mb-4">Funcionários</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($users->isEmpty())
        <div class="empty-message">
            <p>Não há funcionários disponíveis.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th style="width: 30%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('funcionarios.show', $user) }}" class="btn btn-info">Ver Lucros</a>
                                <form action="{{ route('funcionarios.destroy', $user) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres apagar este funcionário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Apagar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
