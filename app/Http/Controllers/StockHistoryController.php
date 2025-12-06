<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use App\Models\Product;
use Illuminate\Http\Request;

class StockHistoryController extends Controller
{
    public function index()
    {
        $histories = StockHistory::with('product', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

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
