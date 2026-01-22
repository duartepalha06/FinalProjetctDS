@extends('layouts.app')

@section('title', 'Funcionários')

@section('content')
    <h1 class="mb-4">Funcionários</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($users->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="text-muted mb-0">Não há funcionários disponíveis.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th style="width: 25%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('funcionarios.show', $user) }}" class="btn btn-info btn-sm">Ver Lucros</a>
                                            <form action="{{ route('funcionarios.destroy', $user) }}" method="POST" onsubmit="return confirm('Tens a certeza que queres apagar este funcionário?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Apagar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
