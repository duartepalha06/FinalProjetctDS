@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-weight: bold;
            margin-bottom: 30px;
            color: #343a40;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            color: #343a40;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="checkbox"] {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .form-check {
            margin-top: 20px;
            padding: 12px;
            background-color: #e7f3ff;
            border-radius: 4px;
        }

        .form-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check label {
            margin-left: 8px;
            margin-bottom: 0;
            cursor: pointer;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>

    <div class="form-container">
        <h1>Editar Categoria</h1>

        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nome da Categoria</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}"
                    required
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input
                    type="checkbox"
                    id="active"
                    name="active"
                    class="form-check-input"
                    {{ old('active', $category->active) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="active">
                    Ativa
                </label>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
