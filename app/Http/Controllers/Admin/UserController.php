<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $search = $request->search['value'];
            $user = User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('school', 'like', '%' . $search . '%');
            })
            ->select();
            return datatables()->of($user)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'user');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = $this->createMetaPageData($user, 'User', 'user');
        return view('page.admin-dashboard.user.create-edit', compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'User Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.user.index')->with('error', $th->getMessage());
        }
    }
}
