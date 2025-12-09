@extends('layouts.app')

@section('title', 'Funcionário - ' . $user->name)

@section('content')
    <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary mb-3">← Voltar</a>

    <h1>{{ $user->name }}</h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Receita</h5>
                <p class="fs-4">{{ number_format($revenue, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Custo</h5>
                <p class="fs-4">{{ number_format($cost, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Lucro</h5>
                <p class="fs-4 text-success">{{ number_format($profit, 2, ',', '.') }} €</p>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-3">
        <h5>Lucro por Categoria</h5>
        <canvas id="funcChart" width="400" height="150"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('funcChart').getContext('2d');
        const labels = {!! json_encode($labels) !!};
        const profits = {!! json_encode($categoryProfit) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Lucro (€)',
                    data: profits,
                    backgroundColor: '#198754'
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>

@endsection
