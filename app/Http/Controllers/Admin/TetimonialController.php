<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TetimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();
        $query->when('keyword', function ($sub) use ($request) {
            $keyword = $request->keyword;
            $sub->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%");
            });
        });
        $testimonial = $query->paginate(10);
        if ($request->wantsJson()) {
            return view('pages.dashboard.testimonial.pagination', compact('testimonial'))->render();
        }
        return view('pages.dashboard.testimonial.index', compact('testimonial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testimonial.create');
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
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'required'
        ]);
        try {
            $file_name = $request->foto->getClientOriginalName();
            $foto = $request->foto->storeAs('public/testimonial', $file_name);

            $testimonial = Testimonial::create([
                'foto' => $foto,
                'name' => $request->name,
                'jabatan' => $request->jabatan,
                'deskripsi' => $request->deskripsi,

            ]);
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Testimonial $testimonial->name berhasil dibuat!"
                ]
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Gagal',
                    'body' =>
                    json_encode($th)
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
        $testimonial = Testimonial::find($id);
        if (!$testimonial) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Testimonial dengan id $id tidak ditemukan."
            ]
        ], 404);
        return response()->json(['data' => $testimonial], 200);
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
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'required'
        ]);
        $foto = "";

        $testimonial = Testimonial::find($id);

        if (!$testimonial) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "Testimonial dengan id $id tidak ditemukan."
            ]
        ], 404);

        if ($request->foto) {
            (new ImageTrait())->delete($testimonial->foto);
            $file_name = $request->foto->getClientOriginalName();
            $foto = $request->foto->storeAs('public/testimonial', $file_name);
        } else {
            $foto = $testimonial->foto;
        }

        $testimonial->update([
            'foto' => $foto,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,

        ]);
        return response()->json([
            'status' => true,
            'message' => [
                'head' => 'Berhasil',
                'body' => "Testimonial $testimonial->name berhasil diupdate!"
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
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                return $this->errorResponse("Not found", 404);
            }
            $this->removeImage($testimonial->foto);

            if (Storage::delete($testimonial->foto)) {
                $testimonial->delete();
            }

            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Berhasil',
                    'body' => "Testimonial $testimonial->name berhasil dihapus!"
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

    public function removeImage($path)
    {

        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        } else {
            // dd('File does not exists.');
        }
    }
}