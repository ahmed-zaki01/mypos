<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_clients'])->only('index');
        $this->middleware(['permission:create_clients'])->only('create');
        $this->middleware(['permission:update_clients'])->only('edit');
        $this->middleware(['permission:delete_clients'])->only('destroy');
    }

    public function index(Request $request)
    {

        $clients = Client::latest()->paginate(5);

        return view('dashboard.clients.index', compact('clients'));
    } // end of index


    public function create()
    {
        return view('dashboard.clients.create');
    } //end of create

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone.0' => ['required', 'numeric', 'regex:/^(01)([0-2]|5)[0-9]{8}$/'],
            'phone.1' => ['nullable', 'numeric', 'regex:/^(01)([0-2]|5)[0-9]{8}$/'],
            'address' => 'required|string',
        ]);
        //$data['phone'] = array_filter($request->phone);

        Client::create($data);

        session()->flash('status', 'Client added successfully!');
        return redirect(route('dashboard.clients.index'));
    } // end of store

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    } // end of edit


    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone.0' => ['required', 'numeric', 'regex:/^(01)([0-2]|5)[0-9]{8}$/'],
            'phone.1' => ['nullable', 'numeric', 'regex:/^(01)([0-2]|5)[0-9]{8}$/'],
            'address' => 'required|string',
        ]);

        $client->update($data);

        session()->flash('status', 'Client updated successfully!');
        return redirect(route('dashboard.clients.index'));
    } // end of update

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('status', 'Client deleted successfully!');
        return redirect(route('dashboard.clients.index'));
    } // end of destroy
}
