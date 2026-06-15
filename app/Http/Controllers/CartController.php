<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('products.index');
        }

        $cartItems = auth()->user()->cart()->with('product.images')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Product $product)
    {
        if (auth()->user()->isAdmin()) {
            return back()->with('error', 'Admins cannot use the shopping cart.');
        }

        if (! $product->is_available) {
            return back()->with('error', '«' . $product->name . '» is currently unavailable.');
        }

        $existing = auth()->user()->cart()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->increment('quantity');
        } else {
            auth()->user()->cart()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', '«' . $product->name . '» added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        auth()->user()->cart()
            ->where('product_id', $product->id)
            ->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        auth()->user()->cart()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
