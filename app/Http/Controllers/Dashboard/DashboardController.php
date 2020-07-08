<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Cat;
use App\Client;
use App\Order;
use App\Product;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data['cats'] = Cat::count();
        $data['products'] = Product::count();
        $data['clients'] = Client::count();
        $data['users'] = User::whereRoleIs('admin')->count();

        $data['sales_data'] = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum'),
        )->groupBy('month')->get();

        return view('dashboard.index')->with($data);
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('login'));
    }
}
