<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.images']);

        return view('admin.orders.show', compact('order'));
    }

    public function requestInfo(Request $request, Order $order)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:1000']);

        $order->update([
            'status'      => 'info_requested',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Customer has been asked to provide their information.');
    }

    public function confirm(Order $order)
    {
        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Order confirmed.');
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled.');
    }
}
