<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $subject = Subject::select();
            return datatables()->of($subject)
            ->addIndexColumn()
            ->make(true);
        }

        return view('page.admin-dashboard.subject.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->getActionColumn(null, 'Subject', 'subject');
        return view('page.admin-dashboard.subject.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Subject::create($request->all());

        return redirect()->route('admin.subject.index')->with('success', 'Subject Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $data = $this->getActionColumn($subject->id, 'Subject', 'subject');
        return view('page.admin-dashboard.subject.create-edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $subject->update($request->all());

        return redirect()->route('admin.subject.index')->with('success', 'Subject Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return redirect()->route('admin.subject.index')->with('success', 'Subject Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.subject.index')->with('error', 'Subject Delted Failed');
        }
    }
}
