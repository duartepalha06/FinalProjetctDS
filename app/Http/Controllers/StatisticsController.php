<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $total = DB::table('products')
            ->selectRaw('COALESCE(SUM(price * quantity), 0) as revenue, COALESCE(SUM(preco_de_producao * quantity), 0) as cost')
            ->first();

        $profit = (float) $total->revenue - (float) $total->cost;

        $categories = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.active', true)
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
        ]);
    }
}
