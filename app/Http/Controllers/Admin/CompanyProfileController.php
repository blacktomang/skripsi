<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $singleData = CompanyProfile::first();

        // company-profile.blade
        return view('pages.dashboard.settings.company-profile', [
            'data' => $singleData
        ]);
    }

    public function getCompanyData()
    {
        $singleData = CompanyProfile::first();

        return $this->successResponse($singleData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'no_telp' => 'required',
                'email' => 'required',
                'whatsapp' => 'required',
                'desc' => 'required',
                'alamat' => 'required'
            ]);

            $staging = $request->all();


            // Jika data sudah ada
            if (CompanyProfile::first()) {
                // update data
                $model = CompanyProfile::first()
                    ->update($staging);
            } else //jika data belum ada
            {
                // Buat data
                $model = CompanyProfile::create($staging);
            }
            return redirect()->back()->with('success', 'Company profile is successfully updated!');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $companyProfile
     * @return \Illuminate\Http\Response
     */
    public function show(Request $companyProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $companyProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $companyProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $companyProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Request $companyProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $companyProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $companyProfile)
    {
        //
    }
}
