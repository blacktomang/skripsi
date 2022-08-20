<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 1) {
            return redirect('/');
        }
        $order_unpayed = Order::where('status', 0)->count();
        $order_process = Order::where('status', 1)->count();
        $order_finish = Order::where('status', 2)->count();
        $order_canceled = Order::where('status', 3)->count();

        return view(
            'pages.dashboard.index',
            compact('order_unpayed', 'order_process', 'order_finish', 'order_canceled')
        );
    }
}
