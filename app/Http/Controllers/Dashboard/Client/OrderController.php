<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Cat;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');
    } // end of construct

    public function index()
    {
    } // end of index

    public function create(Client $client)
    {
        $data['client'] = $client;
        $data['cats'] = Cat::with('products')->get();
        return view('dashboard.clients.orders.create')->with($data);
    } // end of create

    public function store(Request $request, Client $client)
    {

        // dd($request->all());

        $products = $request->validate([
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',
        ])['products'];

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

        session()->flash('status', 'Order Added successfully!');
        return redirect(route('dashboard.orders.index'));
    } // end of store

    public function edit(Client $client, Order $order)
    {
    } // end of edit

    public function update(Request $request, Client $client, Order $order)
    {
    } // end of update


    public function destroy(Client $client, Order $order)
    {
    } // end of destroy

}
