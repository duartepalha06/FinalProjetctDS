@extends('layouts.app')

@section('title', 'Alertas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Alertas</h1>
        @if ($alerts->count() > 0)
            <form action="{{ route('alerts.markAllAsRead') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Marcar Todos como Lido</button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Alertas Não Lidos -->
    @if ($alerts->count() > 0)
        <div class="card mb-4" style="border-left: 5px solid #ffc107;">
            <div class="card-header" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529;">
                <h5 class="mb-0">Alertas Pendentes ({{ $alerts->count() }})</h5>
            </div>
            <div class="card-body">
                @foreach ($alerts as $alert)
                    <div class="alert alert-{{ $alert->type }} d-flex justify-content-between align-items-start" role="alert">
                        <div>
                            <h5 class="alert-heading mb-1">{{ $alert->title }}</h5>
                            <p class="mb-2">{{ $alert->message }}</p>
                            <small class="text-muted">{{ $alert->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0 ms-3">
                            <form action="{{ route('alerts.markAsRead', $alert) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Marcar como Lido</button>
                            </form>
                            <form action="{{ route('alerts.delete', $alert) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Não há alertas pendentes! Tudo está bem.
        </div>
    @endif

    <!-- Alertas Lidos -->
    @if ($readAlerts->count() > 0)
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); color: white;">
                <h5 class="mb-0">Histórico de Alertas</h5>
            </div>
            <div class="card-body">
                @foreach ($readAlerts as $alert)
                    <div class="alert alert-secondary d-flex justify-content-between align-items-center" role="alert" style="opacity: 0.8;">
                        <div>
                            <h6 class="alert-heading mb-1">{{ $alert->title }}</h6>
                            <small>{{ $alert->message }} - {{ $alert->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <form action="{{ route('alerts.delete', $alert) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
