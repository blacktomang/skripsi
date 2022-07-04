<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $is_admin;

    function __construct(Request $request)
    {
        $urls = explode('/', $request->url());
        $this->is_admin = $urls[count($urls) - 1] == 'admin' ? 1 : 2;
    }

    public function index(Request $request)
    {
        $query = User::query();
        $is_admin = $this->is_admin;
        $users = $query->where('role', $this->is_admin)->paginate(10);
        if ($request->wantsJson()) {
            return view('pages.dashboard.users.pagination', compact('users', 'is_admin'))->render();
        }
        if ($request->keyword) {
            $query->when('keyword', function ($sub) use ($request) {
                $keyword = $request->keyword;
                $sub->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%$keyword%");
                });
            });
            $users = $query->where('role', $this->is_admin)->paginate(10);
        }
        return view('pages.dashboard.users.index', compact('users', 'is_admin'));
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
        $user = User::find($id);
        if (!$user) return response()->json([
            'status' => false,
            'message' => [
                'head' => 'Gagal',
                'body' => "User dengan id $id tidak ditemukan."
            ]
        ], 404);
        return response()->json(['data' => $user], 200);
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
}
