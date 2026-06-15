<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.orders.index');
        }

        $orders = auth()->user()->orders()->with('items.product')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function store()
    {
        if (auth()->user()->isAdmin()) {
            return back()->with('error', 'Admins cannot place orders.');
        }

        $user = auth()->user();
        $cartItems = $user->cart()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $order = $user->orders()->create(['status' => 'pending']);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $user->cart()->delete();

        return redirect()->route('orders.index')->with('success', 'Your order has been placed successfully!');
    }

    public function updateInfo(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:50',
            'customer_address' => 'required|string|max:1000',
        ]);

        $order->update([
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'customer_address' => $request->customer_address,
        ]);

        return back()->with('success', 'Your information has been submitted.');
    }
}
