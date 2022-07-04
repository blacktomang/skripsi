<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home()
    {
        $products = Product::paginate(10);
        return view('pages.main.index', compact('products'));
    }

    public function products(Request $request)
    {
        $query = Product::query();
        $query->when('keyword', function ($sub) use ($request) {
            $keyword = $request->keyword;
            $sub->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%");
            });
        });
        if ($request->wantsJson()) {
            return view('pages.main.products.pagination', compact('products'))->render();
        }
        $products = $query->paginate(10);
        return view('pages.main.products.index')->with('products', $products);
    }

    public function productDetail($slug)
    {
        $product = Product::with('photos')->where('slug', $slug)->first();
        $product->makeHidden('added_by', 'created_at', 'updated_at', 'id');
        $res = $product->toArray();

        return view('pages.main.products.detail', compact('res'));
    }
}
