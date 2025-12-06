@extends('layouts.app')

@section('title', 'Alertas')

@section('content')
    <div class="mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h1>🔔 Alertas</h1>
            </div>
            <div class="col-md-6 text-end">
                @if ($alerts->count() > 0)
                    <form action="{{ route('alerts.markAllAsRead') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Marcar Todos como Lido</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Alertas Não Lidos -->
    @if ($alerts->count() > 0)
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Alertas Pendentes ({{ $alerts->count() }})</h5>
            </div>
            <div class="card-body">
                @foreach ($alerts as $alert)
                    <div class="alert alert-{{ $alert->type }} alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">{{ $alert->title }}</h5>
                        <p class="mb-2">{{ $alert->message }}</p>
                        <small class="text-muted">{{ $alert->created_at->format('d/m/Y H:i') }}</small>

                        <div class="mt-2">
                            <form action="{{ route('alerts.markAsRead', $alert) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">Marcar como Lido</button>
                            </form>
                            <form action="{{ route('alerts.delete', $alert) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-info">
            ✓ Não há alertas pendentes! Tudo está bem.
        </div>
    @endif

    <!-- Alertas Lidos -->
    @if ($readAlerts->count() > 0)
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Histórico de Alertas</h5>
            </div>
            <div class="card-body">
                @foreach ($readAlerts as $alert)
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert" style="opacity: 0.7;">
                        <h6 class="alert-heading mb-1">{{ $alert->title }}</h6>
                        <small>{{ $alert->message }} - {{ $alert->created_at->format('d/m/Y H:i') }}</small>
                        <form action="{{ route('alerts.delete', $alert) }}" method="POST" class="d-inline float-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
