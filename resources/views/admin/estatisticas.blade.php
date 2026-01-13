@extends('layouts.app')

@section('title', 'Estatísticas')

@section('content')
    <style>
        .stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .stats-header h1 {
            margin: 0;
        }

        .export-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .export-btn:hover {
            background-color: #0b5ed7;
        }
    </style>

    <div class="stats-header">
        <h1>Estatísticas</h1>
        <button class="export-btn" data-bs-toggle="modal" data-bs-target="#exportModal">
            📊 Exportar Dados
        </button>
    </div>

    @if($startDate && $endDate)
        <div class="alert alert-info mb-4">
            📅 Dados filtrados de <strong>{{ $startDate }}</strong> até <strong>{{ $endDate }}</strong>
        </div>
    @endif

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

    <!-- Modal para Exportar Dados -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📊 Exportar Dados Estatísticos</h5>
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
                        ⬇️ Baixar CSV
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
