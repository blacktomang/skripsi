<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();
        $query->when('keyword', function ($sub) use ($request) {
            $keyword = $request->keyword;
            $sub->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%$keyword%");
                $q->orWhere('description', 'LIKE', "%$keyword%");
            });
        });

        $news = $query->orderBy('id')->cursorPaginate(10);
        if ($request->wantsJson()) {
            return response()->json([
                'render' => view('pages.main.news.pagination', compact('news'))->render(),
                'next' => $news->nextPageUrl(),
            ]);
        }
        return view('pages.main.news.index', compact('news'));
    }

    public function detail($slug)
    {
        $news = News::where('slug', $slug)->first();
        return view('pages.main.news.detail', compact('news'));
    }
}
