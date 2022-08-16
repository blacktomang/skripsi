<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
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
    public function index()
    {
        $testimonial = Testimonial::all();
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

        $file_name = $request->foto->getClientOriginalName();
        $foto = $request->foto->storeAs('testimonial', $file_name);

        Testimonial::create([
            'foto' => $foto,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,

        ]);
        return redirect()->back();
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
        $this->validate($request, [
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'jabatan' => 'required',
            'deskripsi' => 'required'
        ]);

        $file_name = $request->foto->getClientOriginalName();
        $foto = $request->foto->storeAs('testimonial', $file_name);

        $testimonial = Testimonial::find($id);
        $testimonial->update([
            'foto' => $foto,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,

        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $this->removeImage($testimonial->foto);

        if (Storage::delete($testimonial->foto)) {
            $testimonial->delete();
        }

        return redirect()->back();
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
