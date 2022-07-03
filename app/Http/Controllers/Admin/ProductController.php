<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // use ImageTrait;
    public function index(Request $request)
    {
        $query = Product::query();
        $products = $query->paginate(10);
        if ($request->ajax()) {
            return view('pages.dashboard.products.pagination', compact('products'))->render();
        }
        if ($request->keyword) {
            $query->when('keyword', function ($sub) use ($request) {
                $keyword = $request->keyword;
                $sub->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
            });
            $products = $query->paginate(10);
        }
        return view('pages.dashboard.products.index')->with('products', $products);
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
        $request->validate([
            'name' => 'required|string|max:12',
            'description' => 'required|string|max:300',
            'price' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['price'] = floor((float)preg_replace('/[Rp. ]/', '', $request->price));
            $data['added_by'] = Auth::id();
            $product = Product::create($data);

            if ($request->image) {
                $images = $request->image;
                $uploadTraits = new ImageTrait(Product::class, ProductImage::class, $images);
                // $uploadTraits
                $countImages = $uploadTraits->count('product_id',$product->id);
                if ($countImages > 5) {
                    return response()->json([
                        'status' => true,
                        'message' => [
                            'head' => 'Gagal',
                            'body' => 'Jumlah maksimal foto produk tidak boleh melebihi 5'
                        ]
                    ], 500);
                }

                $uploadTraits->upload('product_id',$product->id);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Product $product->name berhasil dibuat!"
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Gagal',
                    'body' => 
                    json_encode($th)
                    // env('APP_DEBUG') ? $th->getMessage() : "Product gagal dibuat!"
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Product dengan id $id tidak ditemukan."
            ]
        ], 404);
        return response()->json(['data' => $product], 200);
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
        $data = $request->except('id');
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if ($request->image) {
                $images = $request->image;
                $uploadTraits = new ImageTrait(Product::class, ProductImage::class, $images);
                $countImages = $uploadTraits->count('product_id',$product->id);
                if ($countImages >= 5) {
                    return response()->json([
                        'status' => true,
                        'message' => [
                            'head' => 'Gagal',
                            'body' => 'Jumlah maksimal foto produk tidak boleh melebihi 5'
                        ]
                    ], 500);
                }
                $uploadTraits->upload('product_id',$product->id);
            }
            $data = $request->except(['id', 'image']);
            $product->update($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Product $product->name berhasil diupdate!"
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Product gagal diupdate!"
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with('images')->find($id);
            $imageTrait = new ImageTrait();
            $imageTrait->delete($product->images);
            DB::commit();
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Product $product->name berhasil dihapus!"
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Gagal',
                    'body' => "Product gagal dihapus!"
                ]
            ], 500);
        }
    }

    public function delete_image($id)
    {
        $image = ProductImage::find($id);
        try {
            (new ImageTrait())->delete($image);
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Foto produk berhasil dihapus!"
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Gagal',
                    'body' => "Product gagal dihapus!"
                ]
            ], 500);
        }
    }
}
