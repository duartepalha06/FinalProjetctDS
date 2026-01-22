<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use App\Models\Product;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockHistory::with('product', 'user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $histories = $query->paginate(20);
        // Mantém o parâmetro de pesquisa na paginação
        if ($request->filled('search')) {
            $histories->appends(['search' => $request->input('search')]);
        }

        return view('stock-history.index', compact('histories'));
    }

    public function productHistory(Product $product)
    {
        $histories = StockHistory::where('product_id', $product->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('stock-history.product', compact('product', 'histories'));
    }

    public function record($productId, $quantityBefore, $quantityAfter, $action, $reason = null)
    {
        $quantityChanged = $quantityAfter - $quantityBefore;

        StockHistory::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'quantity_changed' => $quantityChanged,
            'action' => $action,
            'reason' => $reason,
        ]);
    }
}
