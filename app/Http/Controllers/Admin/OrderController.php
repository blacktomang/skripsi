<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::query();
        $query->with('user');
        $query->when('keyword', function ($sub) use ($request) {
            $keyword = $request->keyword;
            $sub->where(function ($q) use ($keyword) {
                // $q->where('name', 'LIKE', "%$keyword%");
            });
        });
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $orders = $query->paginate(10);
        if ($request->wantsJson()) {
            return view('pages.dashboard.orders.pagination', compact('orders'))->render();
        }
        return view('pages.dashboard.orders.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataOrder = ['user_name' => '', 'details' => []];

        $data = Order::with(['user', 'details.product'])->find($id);
        $dataOrder['code'] = $data->code ?? '';
        $dataOrder['user_name'] = $data->user->name ?? '';
        $dataOrder['phone'] = $data->user->phone_number ?? '';

        foreach ($data->details as $key => $value) {
            $d = [];
            $d['product_name'] = $value->product->name ?? '';
            $d['price'] = $value->price;
            $d['amount'] = $value->amount;
            $d['foto'] = storage_path($value->product->photos[0]->value ?? '');
            array_push($dataOrder['details'], $d);
        }

        if (!$data)  return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Order dengan id $id tidak ditemukan."
            ]
        ], 404);
        return response()->json(['data' => $dataOrder], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Gagal',
                'body' => "order tidak dapat ditemukan!"
            ]
        ], 404);
        $order->update(['status' => $request->status]);
        return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Berhasil',
                'body' => "status berhasil diupdate"
            ]
        ], 200);
    }
}
