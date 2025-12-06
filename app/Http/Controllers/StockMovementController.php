<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('stock-movements.index', compact('movements'));
    }

    public function productMovements(Product $product)
    {
        $movements = StockMovement::where('product_id', $product->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalEntradas = StockMovement::where('product_id', $product->id)
            ->where('type', 'entrada')
            ->sum('quantity');

        $totalSaidas = StockMovement::where('product_id', $product->id)
            ->where('type', 'saida')
            ->sum('quantity');

        return view('stock-movements.product', compact('product', 'movements', 'totalEntradas', 'totalSaidas'));
    }

    public function createMovement(Product $product)
    {
        return view('stock-movements.create', compact('product'));
    }

    public function storeMovement(Request $request, Product $product)
    {
        $request->validate([
            'type' => 'required|in:entrada,saida',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        // Verificar se tem stock suficiente para saída
        if ($request->type === 'saida') {
            if ($product->quantity < $request->quantity) {
                return back()->withErrors(['quantity' => 'Stock insuficiente!']);
            }
        }

        // Criar movimento
        StockMovement::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        // Atualizar quantidade do produto
        if ($request->type === 'entrada') {
            $product->increment('quantity', $request->quantity);
        } else {
            $product->decrement('quantity', $request->quantity);
        }

        // Registrar no histórico (se existir a tabela)
        if (class_exists('App\Models\StockHistory')) {
            \App\Models\StockHistory::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'quantity_before' => $request->type === 'entrada'
                    ? $product->quantity - $request->quantity
                    : $product->quantity + $request->quantity,
                'quantity_after' => $product->quantity,
                'quantity_changed' => $request->type === 'entrada'
                    ? $request->quantity
                    : -$request->quantity,
                'action' => 'movement',
                'reason' => $request->description ?? ($request->type === 'entrada' ? 'Entrada de stock' : 'Saída de stock'),
            ]);
        }

        return redirect()->route('stock-movements.product', $product)
            ->with('success', ucfirst($request->type) . ' de stock registada com sucesso!');
    }
}
