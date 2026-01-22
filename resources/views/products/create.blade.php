@extends('layouts.app')

@section('title', 'Adicionar Produto')

@section('content')
    <h1 class="mb-4">Adicionar Produto</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Selecione uma categoria --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantidade</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required value="{{ old('quantity') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="min_quantity" class="form-label">Quantidade Mínima</label>
                            <input type="number" name="min_quantity" id="min_quantity" class="form-control" value="{{ old('min_quantity') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="price" class="form-label">Preço (€)</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control" required value="{{ old('price') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="preco_de_producao" class="form-label">Preço de Produção (€)</label>
                            <input type="number" step="0.01" name="preco_de_producao" id="preco_de_producao" class="form-control" value="{{ old('preco_de_producao') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Imagem</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
