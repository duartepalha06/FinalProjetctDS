<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Alert;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('quantity', '>', 0)
            ->whereHas('category', function ($query) {
                $query->where('active', true);
            })
            ->get();
        return view('shop.index', compact('products'));
    }

    public function decreaseQuantity(Product $product)
    {
        if ($product->quantity > 0) {
            $quantityBefore = $product->quantity;
            $product->decrement('quantity');

            // Registrar no hist\u00f3rico
            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'quantity_before' => $quantityBefore,
                'quantity_after' => $product->quantity,
                'quantity_changed' => -1,
                'action' => 'decreased',
                'reason' => 'Compra realizada na loja',
            ]);

            // Verificar se chegou ao m\u00ednimo
            if ($product->min_quantity && $product->quantity <= $product->min_quantity) {
                // Verifica se j\u00e1 existe um alerta n\u00e3o lido para este produto
                $existingAlert = Alert::where('product_id', $product->id)
                    ->where('read', false)
                    ->where('type', 'warning')
                    ->first();

                if (!$existingAlert) {
                    Alert::create([
                        'product_id' => $product->id,
                        'title' => 'Stock Baixo - ' . $product->name,
                        'message' => "O produto '{$product->name}' atingiu a quantidade m\u00ednima! Quantidade atual: {$product->quantity} un.",
                        'type' => 'warning'
                    ]);
                }
            }

            return back()->with('success', 'Quantidade reduzida com sucesso!');
        }

        return back()->withErrors(['error' => 'Produto sem stock!']);
    }
}
