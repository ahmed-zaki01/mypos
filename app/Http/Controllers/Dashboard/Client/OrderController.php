<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Cat;
use App\Client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');
    } // end of construct


    public function create(Client $client)
    {
        $data['client'] = $client;
        $data['cats'] = Cat::with('products')->get();
        $data['orders'] = $client->orders()->latest()->paginate(5);

        return view('dashboard.clients.orders.create')->with($data);
    } // end of create

    public function store(Request $request, Client $client)
    {

        // dd($request->all());

        $products = $request->validate([
            'products' => 'required|array',

        ])['products'];

        $this->attach_order($products, $client);

        session()->flash('status', 'Order Added successfully!');
        return redirect(route('dashboard.orders.index'));
    } // end of store

    public function edit(Client $client, Order $order)
    {
        $cats = Cat::with('products')->get();
        return view('dashboard.clients.orders.edit', compact(['client', 'order', 'cats']));
    } // end of edit

    public function update(Request $request, Client $client, Order $order)
    {

        $products = $request->validate([
            'products' => 'required|array',

        ])['products'];

        $this->detach_order($order);
        $this->attach_order($products, $client);

        session()->flash('status', 'Order Updated successfully!');
        return redirect(route('dashboard.orders.index'));
    } // end of update


    private function attach_order($products, $client)
    {

        $order = $client->orders()->create([]);
        $order->products()->attach($products);


        $totalPrice = 0;
        // update product stock, calculate total price of order
        foreach ($products as $prodId => $quantityArray) {

            $product = Product::select('id', 'sell_price', 'stock')->where('id', $prodId)->first();

            $totalPrice += $product->sell_price * $quantityArray['quantity'];

            $product->update([
                'stock' => $product->stock - $quantityArray['quantity']
            ]);
        } // end of foreach

        $order->update([
            'total_price' => $totalPrice
        ]);
    } // end of attach order method

    private function detach_order($order)
    {
        // restore the stock
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->pivot->quantity + $product->stock
            ]);
        }

        $order->delete();
    } // end of detach order method
} // end of controller
