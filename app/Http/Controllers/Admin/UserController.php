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
        if ($request->ajax()) {
            $search = $request->search['value'];
            $user = User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
                ->when($request->start_date !== null, function ($query) use ($request) {
                    return $query->where('created_at', '>=', $request->start_date);
                })
                ->when($request->end_date !== null, function ($query) use ($request) {
                    return $query->where('created_at', '<=', $request->end_date);
                })
                ->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(school) LIKE ?', ['%' . strtolower($search) . '%']);
                })
                ->select();
            return datatables()->of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query, 'user');
                })
                ->addColumn('registered_at', function ($query) {
                    return $query->created_at->diffForHumans();
                })
                ->rawColumns(['action', 'registered_at'])
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
        // $data = $this->createMetaPageData($user, 'User', 'user');
        $data = [
            'title' => 'Update User',
            'url' => route('admin.user.password', $user->id),
            'home' => route('admin.user.index'),
        ];
        return view('page.admin-dashboard.user.create-edit', compact('data', 'user'));
    }

    public function reset_password(User $user)
    {
        $user->update([
            'password' => bcrypt(config('password.default')),
        ]);

        return redirect()->route('admin.user.edit', $user->id)->with('success', 'User Password Reset Successfully');
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
