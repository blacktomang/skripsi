<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Helpers\Base64Helper as Base64;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['details', 'details.product'])->paginate(10);
        return view('pages.main.orders.index', compact('orders'));
    }
    public function detail($id)
    {
        $decodedID = Base64::decode($id);
        $detail = Order::with('details', 'details.product')->find($decodedID);
        return view('pages.main.orders.detail', compact('detail'));
    }

    function generateCode($id, $count)
    {
        return "ORDER-" . $id . "-" . Carbon::now()->format('dmy') . "-" . $count + 1;
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $countOrder = Order::where("user_id", $user->id)->count();
            $orderCode = $this->generateCode($user->id, $countOrder);
            // dd($orderCode);
            $total = 0;
            $carts = $user->carts()->with(['product'])->where('checked', 1)->get();
            foreach ($carts as $key => $cart) {
                $total += $cart->amount * $cart->product->price;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'code' => $orderCode,
                'total' => $total
            ]);

            //create order_details and remove carts
            foreach ($carts as $key => $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product->id,
                    'amount' => $cart->amount,
                    'price' => $cart->product->price
                ]);
                $cart->delete();
            }
            DB::commit();
            return redirect('/orders/' . Base64::encode($order->id));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }
}
