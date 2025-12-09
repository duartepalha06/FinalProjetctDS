<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FuncionarioController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.funcionarios.index', compact('users'));
    }

    public function show(User $user)
    {
        // Total revenue and cost for this user (consider only decreases = sales)
        $totals = DB::table('stock_histories')
            ->join('products', 'products.id', '=', 'stock_histories.product_id')
            ->where('stock_histories.user_id', $user->id)
            ->where('stock_histories.quantity_changed', '<', 0)
            ->selectRaw('COALESCE(SUM(-stock_histories.quantity_changed * products.price),0) as revenue, COALESCE(SUM(-stock_histories.quantity_changed * products.preco_de_producao),0) as cost')
            ->first();

        $profit = (float) $totals->revenue - (float) $totals->cost;

        // Profit by category
        $byCategory = DB::table('stock_histories')
            ->join('products', 'products.id', '=', 'stock_histories.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('stock_histories.user_id', $user->id)
            ->where('stock_histories.quantity_changed', '<', 0)
            ->selectRaw('categories.name as category, COALESCE(SUM(-stock_histories.quantity_changed * products.price),0) as revenue, COALESCE(SUM(-stock_histories.quantity_changed * products.preco_de_producao),0) as cost')
            ->groupBy('categories.name')
            ->get();

        $labels = $byCategory->pluck('category')->toArray();
        $categoryProfit = $byCategory->map(function ($row) {
            return (float) $row->revenue - (float) $row->cost;
        })->toArray();

        return view('admin.funcionarios.show', [
            'user' => $user,
            'revenue' => (float) $totals->revenue,
            'cost' => (float) $totals->cost,
            'profit' => $profit,
            'labels' => $labels,
            'categoryProfit' => $categoryProfit,
        ]);
    }

    public function destroy(User $user)
    {
        // Prevent deleting admins
        if ($user->role === 'admin') {
            return redirect()->route('funcionarios.index')->withErrors(['error' => 'Não é possível apagar um administrador.']);
        }

        // Optional: prevent deleting yourself
        if (auth()->id() === $user->id) {
            return redirect()->route('funcionarios.index')->withErrors(['error' => 'Não pode apagar o seu próprio utilizador.']);
        }

        $user->delete();
        return redirect()->route('funcionarios.index')->with('success', 'Funcionário apagado com sucesso.');
    }
}
