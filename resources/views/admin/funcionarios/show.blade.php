@extends('layouts.app')

@section('title', 'Funcionário - ' . $user->name)

@section('content')
    <style>
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e9ecef;
            height: 100%;
        }

        .stats-card.revenue {
            border-left: 5px solid #28a745;
        }

        .stats-card.cost {
            border-left: 5px solid #6c757d;
        }

        .stats-card.profit {
            border-left: 5px solid #0d6efd;
        }

        .stats-card h5 {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stats-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .stats-card.profit .value {
            color: #28a745;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e9ecef;
        }

        .chart-card h5 {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
    </style>

    <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary mb-4">Voltar</a>

    <h1 class="mb-4">{{ $user->name }}</h1>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card revenue">
                <h5>Receita</h5>
                <p class="value mb-0">{{ number_format($revenue, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card cost">
                <h5>Custo</h5>
                <p class="value mb-0">{{ number_format($cost, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card profit">
                <h5>Lucro</h5>
                <p class="value mb-0">{{ number_format($profit, 2, ',', '.') }} €</p>
            </div>
        </div>
    </div>

    <div class="chart-card">
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
                    backgroundColor: '#0d6efd',
                    borderRadius: 8
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endsection
