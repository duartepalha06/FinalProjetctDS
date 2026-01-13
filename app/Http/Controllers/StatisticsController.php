<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('products');
        
        if ($startDate && $endDate) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }

        $total = $query
            ->selectRaw('COALESCE(SUM(price * quantity), 0) as revenue, COALESCE(SUM(preco_de_producao * quantity), 0) as cost')
            ->first();

        $profit = (float) $total->revenue - (float) $total->cost;

        $categoriesQuery = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.active', true);

        if ($startDate && $endDate) {
            $categoriesQuery->whereBetween(DB::raw('DATE(products.created_at)'), [$startDate, $endDate]);
        }

        $categories = $categoriesQuery
            ->selectRaw('categories.name as category, COALESCE(SUM(products.price * products.quantity),0) as revenue, COALESCE(SUM(products.preco_de_producao * products.quantity),0) as cost')
            ->groupBy('categories.name')
            ->get();

        $categoryLabels = $categories->pluck('category')->toArray();
        $categoryRevenue = $categories->pluck('revenue')->map(fn($v) => (float) $v)->toArray();
        $categoryCost = $categories->pluck('cost')->map(fn($v) => (float) $v)->toArray();
        $categoryProfit = array_map(function ($r, $c) { return $r - $c; }, $categoryRevenue, $categoryCost);

        return view('admin.estatisticas', [
            'totalRevenue' => (float) $total->revenue,
            'totalCost' => (float) $total->cost,
            'totalProfit' => $profit,
            'categoryLabels' => $categoryLabels,
            'categoryRevenue' => $categoryRevenue,
            'categoryCost' => $categoryCost,
            'categoryProfit' => $categoryProfit,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function exportData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $filename = 'estatisticas_' . date('Y-m-d_H-i-s') . '.csv';

        $callback = function() use ($startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Relatório de Estatísticas de Vendas']);
            fputcsv($file, []);

            if ($startDate && $endDate) {
                fputcsv($file, ['Período', 'De ' . $startDate . ' até ' . $endDate]);
            } else {
                fputcsv($file, ['Período', 'Todos os dados']);
            }
            fputcsv($file, []);

            // Totals
            $query = DB::table('products');
            
            if ($startDate && $endDate) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            }

            $total = $query
                ->selectRaw('COALESCE(SUM(price * quantity), 0) as revenue, COALESCE(SUM(preco_de_producao * quantity), 0) as cost')
                ->first();

            $profit = (float) $total->revenue - (float) $total->cost;

            fputcsv($file, ['Resumo Total']);
            fputcsv($file, ['Descrição', 'Valor']);
            fputcsv($file, ['Total Receita', number_format($total->revenue, 2, ',', '')]);
            fputcsv($file, ['Total Custo', number_format($total->cost, 2, ',', '')]);
            fputcsv($file, ['Total Lucro', number_format($profit, 2, ',', '')]);
            fputcsv($file, []);

            // Categories
            $categoriesQuery = DB::table('products')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('categories.active', true);

            if ($startDate && $endDate) {
                $categoriesQuery->whereBetween(DB::raw('DATE(products.created_at)'), [$startDate, $endDate]);
            }

            $categories = $categoriesQuery
                ->selectRaw('categories.name as category, COALESCE(SUM(products.price * products.quantity),0) as revenue, COALESCE(SUM(products.preco_de_producao * products.quantity),0) as cost')
                ->groupBy('categories.name')
                ->get();

            fputcsv($file, ['Lucro por Categoria']);
            fputcsv($file, ['Categoria', 'Receita', 'Custo', 'Lucro']);

            foreach ($categories as $category) {
                $profit = $category->revenue - $category->cost;
                fputcsv($file, [
                    $category->category,
                    number_format($category->revenue, 2, ',', ''),
                    number_format($category->cost, 2, ',', ''),
                    number_format($profit, 2, ',', '')
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}

