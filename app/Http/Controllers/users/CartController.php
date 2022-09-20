<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $carts = $this->carts();
        $total_price = $this->totalPrice($carts);
        return view('pages.main.cart', compact('carts', 'total_price'));
    }

    private function carts()
    {
        $user = Auth::user();
        $carts = $user->carts()->where('checked', 1)->with(['product'])->get();
        return $carts;
    }

    private function totalPrice($carts)
    {
        $total = 0;
        foreach ($carts as $key => $value) {
            $total += $value->product->price * $value->amount;
        }
        return $total;
    }

    public function countCart()
    {
        $user = Auth::user();
        $carts = $user->carts;
        $total = 0;

        foreach ($carts as $key => $value) {
            $total += $value->amount;
        }

        return $this->successResponse($total);
    }

    public function store(Request $request)
    {
        $request->validate(['slug' => 'required|string', 'amount' => 'required|integer']);
        try {
            $data = $request->only('slug', 'amount');
            $product = Product::where('slug', $data['slug'])->first();
            if (!$product) return $this->errorResponse("Not Found", 404);
            if ($product->stock < $request->amount) return $this->errorResponse("Mohon maaf stok produk yang diminta sudah habis, Tanyakan admin?", 400);
            $data['product_id'] = $product->id;
            $cart = Cart::where([
                ['user_id', '=', Auth::id()],
                ['product_id', '=', $product->id]
            ])->first();

            if ($cart) {
                $cart->update(['amount' => $cart->amount + $data['amount']]);
            } else {
                $data['user_id'] = Auth::id();
                Cart::create($data);
            }
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function getTotalPrice()
    {
        return $this->successResponse($this->totalPrice($this->carts()));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['amount' => 'integer', 'checked' => 'integer']);
        try {
            $cart = Cart::find($id);
            if ($request->amount) {
                $cart->update(['amount' => $request->amount]);
            } else {
                $cart->update(['checked' => $request->checked]);
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $cart = Cart::find($id);
            if ($cart && $cart->user_id == Auth::id()) {
                $cart->delete();
                return $this->successResponse();
            }
            return $this->errorResponse("Not Found", 404);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
