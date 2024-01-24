<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubjectTest;
use App\Models\UserTest;
use Illuminate\Http\Request;

class UserTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectTest $subjectTest, Request $request)
    {
        if ($request->ajax())
        {
            $user = UserTest::with('user')->where('test_id', $subjectTest->id)->whereNotNull('score')->whereNotNull('end_at')->select();
            return datatables()->of($user)
            ->addIndexColumn()
            ->make(true);
        }
        return view('page.admin-dashboard.subject.test.user.index', compact('subjectTest'));
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
    public function show(UserTest $userTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTest $userTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserTest $userTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTest $userTest)
    {
        //
    }
}
