<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class WebsettingController extends Controller
{
    public function index()
    {
        $singleData = WebSetting::first();

        return view('pages.dashboard.settings.index', [
            'data' => $singleData
        ]);
    }

    public function getSettingsData()
    {
        $singleData = WebSetting::first();

        return response()->json($singleData);
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
            'hero_file' => 'required|mimetypes:image/png,image/jpeg,image/svg|max:200240',
            'hero_title' => 'required',
            'hero_desc' => 'required',
            'about' => 'required',
        ]);
        $staging = $request->all();
        $websetting = WebSetting::first();
        $video = null;
        if ($request->file('hero_file')) {
            // $request['hero_file'] = $request->file('hero_file')->store('web-setting');
            $video = $this->uploadImageAction->uploadAndGetFileName($request->hero_file, WebSetting::FILE_PATH);
        }

        // Jika data sudah ada
        if ($websetting) {
            // update data
            $video = $websetting->hero_file;
            if ($request->file('hero_file')) $this->deleteImageAction->destroy(WebSetting::FILE_PATH, $websetting->hero_file);
            $websetting
                ->update([
                    'hero_file' => $video,
                    'hero_title' => $request['hero_title'],
                    'hero_desc' => $request['hero_desc'],
                    'about' => $request['about'],
                ]);
        } else //jika data belum ada
        {
            // Buat data
            $model = WebSetting::create([
                'hero_file' => $video,
                'hero_title' => $request['hero_title'],
                'hero_desc' => $request['hero_desc'],
                'about' => $request['about'],
            ]);
        }
        // dd($model);
        return redirect()->route('web-settings')
            ->with('success', 'Web settings updated successfully');
    }
}
