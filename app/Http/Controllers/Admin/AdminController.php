<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            $user = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('school', 'like', '%' . $search . '%');
                })
                ->select();
            return datatables()->of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query, 'admin');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('page.admin-dashboard.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Admin', 'admin');
        return view('page.admin-dashboard.admin.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone' => 'required'
        ]);

        $user = User::create(array_merge($request->all(), [
            'password' => bcrypt($request->password),
            'dob' => Carbon::now()->subYears(20)->format('Y-m-d'),
            'school' => 'Admin',
            'picture' => asset('assets-dashboard/images/placeholder.png')
        ]));
        $user->assignRole('admin');
        return redirect()->route('admin.admin.index')->with('success', 'Admin created successfully');
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
        $data = $this->createMetaPageData($user->id, 'Admin', 'admin');
        return view('page.admin-dashboard.admin.create-edit', compact('data', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'sometimes',
            'phone' => 'required'
        ]);

        $user->update(array_merge($request->all(), [
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'dob' => $user->dob,
            'school' => $user->school,
            'picture' => $user->picture
        ]));

        return redirect()->route('admin.admin.index')->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if(User::role('admin')->count() <= 1){
                return redirect()->route('admin.admin.index')->with('error', 'Last Admin cannot be deleted');
            }
            $user->delete();
            return redirect()->route('admin.admin.index')->with('success', 'Admin Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.admin.index')->with('error', $th->getMessage());
        }
    }
}
