@extends('layouts.app')

@section('title', 'Recuperar Password')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                    <div class="card border-0">
                    <div class="card-body form-container">
                        <h3 class="form-title">Recuperar Password</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit">Enviar link de recuperação</button>
                        </form>

                        <hr>
                        <p class="text-center"><a class="text-primary" href="{{ route('auth.login') }}">Voltar ao login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
