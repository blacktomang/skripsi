<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function formateDate($date)
    {
        return Carbon::createFromFormat('d-m-Y', $date)->startOfDay()->format('Y-m-d');
    }
    public function index()
    {
        if (Auth::user()->role != 1) {
            return redirect('/');
        }

        $startDate = request()->get('start_date') ? $this->formateDate(request()->get('start_date')) : null;
        $endDate = request()->get('end_date') ? $this->formateDate(request()->get('end_date')) : null;

        if ($startDate && $endDate) {
            $order_unpayed = Order::where('status', 0)->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])->count();
            $order_process = Order::where('status', 1)->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])->count();
            $order_finish = Order::where('status', 2)->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])->count();
            $order_canceled = Order::where('status', 3)->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])->count();
            $grafikOrder = DB::table('orders as o')
                ->selectRaw('count(o.id) as value, month(o.created_at) as label')
                ->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])
                ->groupBy(DB::raw('month(`created_at`)'))->get();

            $grafikOrderByStatus = DB::table('orders as o')
                ->selectRaw('count(o.id) as value, o.status as status')
                ->whereBetween(DB::raw('DATE(`created_at`)'), [$startDate, $endDate])
                ->groupBy('o.status')->get();
        } else {
            $order_unpayed = Order::where('status', 0)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $order_process = Order::where('status', 1)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $order_finish = Order::where('status', 2)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $order_canceled = Order::where('status', 3)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $grafikOrder = DB::table('orders as o')
                ->selectRaw('count(o.id) as value, month(o.created_at) as label')
                ->where('o.created_at', '>=', Carbon::now()->startOfDay())
                ->groupBy(DB::raw('month(`created_at`)'))->get();

            $grafikOrderByStatus = DB::table('orders as o')
                ->selectRaw('count(o.id) as value, o.status as status')
                ->where('o.created_at', '>=', Carbon::now()->startOfDay())
                ->groupBy('o.status')->get();
        }

        return view(
            'pages.dashboard.index',
            compact(
                'order_unpayed',
                'order_process',
                'order_finish',
                'order_canceled',
                'grafikOrder',
                'grafikOrderByStatus'
            )
        );
    }
}
