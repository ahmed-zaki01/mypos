<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Cat;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
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

    public function store(Request $request)
    {
    } // end of store

    public function edit(Order $order)
    {
    } // end of edit

    public function update(Request $request, Client $client, Order $order)
    {
    } // end of update


    public function destroy(Client $client, Order $order)
    {
    } // end of destroy

}
