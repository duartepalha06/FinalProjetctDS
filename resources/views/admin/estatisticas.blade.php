@extends('layouts.app')

@section('title', 'Estatísticas')

@section('content')
    <h1>Estatísticas</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Receita</h5>
                <p class="fs-4">{{ number_format($totalRevenue, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Custo</h5>
                <p class="fs-4">{{ number_format($totalCost, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Lucro</h5>
                <p class="fs-4 text-success">{{ number_format($totalProfit, 2, ',', '.') }} €</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Resumo Total</h5>
                <canvas id="totalChart" width="400" height="250"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Lucro por Categoria</h5>
                <canvas id="categoryChart" width="400" height="250"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const totalCtx = document.getElementById('totalChart').getContext('2d');
        const totalData = {
            labels: ['Receita', 'Custo', 'Lucro'],
            datasets: [{
                label: 'Valores (€)',
                data: [{{ $totalRevenue }}, {{ $totalCost }}, {{ $totalProfit }}],
                backgroundColor: ['#28a745', '#6c757d', '#ffc107']
            }]
        };

        new Chart(totalCtx, {
            type: 'bar',
            data: totalData,
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryLabels = {!! json_encode($categoryLabels) !!};
        const categoryProfit = {!! json_encode($categoryProfit) !!};

        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Lucro (€)',
                    data: categoryProfit,
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
@endsection
