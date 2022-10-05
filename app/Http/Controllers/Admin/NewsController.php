<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = News::query();
        $query->when('keyword', function ($sub) use ($request) {
            $keyword = $request->keyword;
            $sub->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%$keyword%");
            });
        });
        $news = $query->orderBy('created_at', 'desc')->paginate(10);
        if ($request->wantsJson()) {
            return view('pages.dashboard.news.pagination', compact('news'))->render();
        }
        return view('pages.dashboard.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        // dd(gettype($request->photo));
        try {
            $photo = $this->uploadImageAction->uploadAndGetFileName($request->photo, News::FILE_PATH);
            $news = News::create([
                'photo' => $photo,
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,

            ]);
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Berita $news->title berhasil dibuat!"
                ]
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Gagal',
                    'body' =>
                    dd($th)
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
        $news = News::find($id);
        if (!$news) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Berita dengan id $id tidak ditemukan."
            ]
        ], 404);
        return response()->json(['data' => $news], 200);
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
        $this->validate($request, [
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);
        $photo = "";

        $news = News::find($id);

        if (!$news) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Berita dengan id $id tidak ditemukan."
            ]
        ], 404);

        if ($request->photo) {
            $deletRes = $this->deleteImageAction->deleteImageOnly(News::FILE_PATH .'/'. $news->photo);
            if(isset($deletRes[1])) throw $deletRes[1];
            $photo = $this->uploadImageAction->uploadAndGetFileName($request->photo, News::FILE_PATH);
        } else {
            $photo = $news->photo;
        }

        $news->update([
            'photo' => $photo,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,

        ]);
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => "Berita $news->title berhasil diupdate!"
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return $this->errorResponse("Not found", 404);
            }
            $deleted = $this->deleteImageAction->destroy(News::FILE_PATH, $news);
            if ($deleted[0]) {
                $news->delete();
            } else {
                throw $deleted[1];
            }
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Berita $news->title berhasil dihapus!"
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Gagal',
                    'body' => $th->getMessage()
                ]
            ], 500);
        }
    }
}
