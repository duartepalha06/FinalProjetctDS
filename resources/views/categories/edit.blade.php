@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
    <h1 class="mb-4">Editar Categoria</h1>

    <div class="card" style="max-width: 500px;">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nome da Categoria</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" id="active" name="active" class="form-check-input" {{ old('active', $category->active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Categoria Ativa</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
