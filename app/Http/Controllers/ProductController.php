<?php

namespace App\Http\Controllers;

use index;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $sort = request('sort', 'id');
        $direction = request('direction', 'asc');

        // Validar coluna para evitar SQL injection
        $validColumns = ['id', 'name', 'quantity', 'price', 'created_at'];
        if (!in_array($sort, $validColumns)) {
            $sort = 'id';
        }

        // Alternar direção se clicar na mesma coluna
        if (request('sort') === $sort) {
            $direction = $direction === 'asc' ? 'desc' : 'asc';
        } else {
            $direction = 'asc';
        }

        $products = Product::whereHas('category', function ($query) {
            $query->where('active', true);
        })->orderBy($sort, $direction)->get();

        return view('products.index', compact('products', 'sort', 'direction'));
    }

   public function create()
{
    $categories = \App\Models\Category::where('active', true)->get();
    return view('products.create', compact('categories'));
}


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'preco_de_producao' => 'nullable|numeric',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/products'), $filename);
        $data['image'] = 'storage/products/' . $filename;
    }

    $product = Product::create($data);

    // Registrar no histórico
        StockHistory::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'quantity_before' => 0,
            'quantity_after' => $product->quantity,
            'quantity_changed' => $product->quantity,
            'action' => 'created',
            'reason' => 'Produto criado',
        ]);

    return redirect()->route('products.index')
        ->with('success', 'Produto criado com sucesso!');
}


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::where('active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'preco_de_producao' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $quantityBefore = $product->quantity;
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Apagar imagem antiga se existir
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/products'), $filename);
            $data['image'] = 'storage/products/' . $filename;
        }

        $product->update($data);

        // Registrar no histórico se a quantidade mudou
        if ($quantityBefore != $product->quantity) {
            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'quantity_before' => $quantityBefore,
                'quantity_after' => $product->quantity,
                'quantity_changed' => $product->quantity - $quantityBefore,
                'action' => 'updated',
                'reason' => 'Quantidade atualizada',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto removido com sucesso!');
    }


}

