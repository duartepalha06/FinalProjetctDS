@extends('layouts.app')

@section('title', 'Estatísticas')

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Estatísticas</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            Exportar Dados
        </button>
    </div>

    @if($startDate && $endDate)
        <div class="alert alert-info mb-4">
            Dados filtrados de <strong>{{ $startDate }}</strong> até <strong>{{ $endDate }}</strong>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card revenue">
                <h5>Total Receita</h5>
                <p class="value mb-0">{{ number_format($totalRevenue, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card cost">
                <h5>Total Custo</h5>
                <p class="value mb-0">{{ number_format($totalCost, 2, ',', '.') }} €</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card profit">
                <h5>Total Lucro</h5>
                <p class="value mb-0">{{ number_format($totalProfit, 2, ',', '.') }} €</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <h5>Resumo Total</h5>
                <canvas id="totalChart" width="400" height="250"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <h5>Lucro por Categoria</h5>
                <canvas id="categoryChart" width="400" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Modal para Exportar Dados -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Exportar Dados Estatísticos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="exportForm" method="GET" action="{{ route('estatisticas.export') }}">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Data Inicial</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" value="{{ $startDate ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Data Final</label>
                            <input type="date" class="form-control" id="endDate" name="end_date" value="{{ $endDate ?? '' }}">
                        </div>
                        <small class="text-muted">Deixe vazio para exportar todos os dados</small>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('exportForm').submit()">
                        Baixar CSV
                    </button>
                </div>
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
                backgroundColor: ['#28a745', '#6c757d', '#0d6efd'],
                borderRadius: 8
            }]
        };

        new Chart(totalCtx, {
            type: 'bar',
            data: totalData,
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
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
