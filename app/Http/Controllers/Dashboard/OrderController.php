<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);
        // dd($orders);
        return view('dashboard.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $products = $order->products()->get();
        return view('dashboard.orders._show', compact(['products', 'order']));
    }

    public function destroy(Order $order)
    {
        // restore the stock
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->pivot->quantity + $product->stock
            ]);
        }

        $order->delete();
        session()->flash('status', 'Order deleted successfully!');
        return redirect(route('dashboard.orders.index'));
    }
}
