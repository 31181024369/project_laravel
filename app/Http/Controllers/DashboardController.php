<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
class DashboardController extends Controller
{
    //
    function __construct()
    {
    	$this->middleware(function($request, $next){
    		session(['module_active'=>'dashboard']);
    		return $next($request);

    	});
    }
    function show()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);

        $count_orders_process = Order::where('status',1)->count();
        $count_orders_transport = Order::where('status',2)->count();
        $count_orders_success= Order::where('status',3)->count();

        $proceeds = Order::where('status', 'LIKE',2)->sum('price');
        //return $proceeds;
        $count = [$count_orders_process, $count_orders_transport, $count_orders_success];
    	return view('admin.show', compact('orders', 'count', 'proceeds'));
    }
}
