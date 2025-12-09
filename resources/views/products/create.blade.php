@extends('layouts.app')

@section('title', 'Adicionar Produto')

@section('content')
    <h1>Adicionar Produto</h1>

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

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantidade</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Preço (€)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="preco_de_producao" class="form-label">Preço de Produção (€)</label>
            <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control">
        </div>

        <div class="mb-3">
            <label for="min_quantity" class="form-label">Quantidade Mínima</label>
            <input type="number" name="min_quantity" id="min_quantity" class="form-control">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Selecione uma categoria --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagem</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
