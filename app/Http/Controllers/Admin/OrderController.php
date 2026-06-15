<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Haal alle bestellingen op (behalve de afgebroken 'pending' winkelwagens), nieuwste bovenaan
        $orders = Order::with('user')
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Haal order op inclusief items
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,shipped,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status succesvol bijgewerkt!');
    }
}
