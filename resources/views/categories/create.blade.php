@extends('layouts.app')

@section('title', 'Adicionar Categoria')

@section('content')
    <h1 class="mb-4">Adicionar Nova Categoria</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width: 500px;">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Nome da Categoria</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
