<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTest;
use Illuminate\Http\Request;

class SubjectTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->all())
        {
            $subjectTest = SubjectTest::select();
            return datatables()->of($subjectTest)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'test');
            })
            ->make(true);
        }

        return view('page.admin-dashboard.subject.test.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Subject Test', 'test');
        $subject = Subject::pluck('name', 'id');
        return view('page.admin-dashboard.subject.test.create-edit', compact('data', 'subject'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subject_id' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'enrolled_code' => 'required'
        ]);

        $data = array_merge($request->all(), [
            'start_at' => strtotime($request->start_at),
            'end_at' => strtotime($request->end_at),
            'created_by_id' => auth()->user()->id
        ]);

        SubjectTest::create($data);

        return redirect()->route('admin.test.index')->with('success', 'Test Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectTest $subjectTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectTest $subjectTest)
    {
        $data = $this->createMetaPageData($subjectTest->id, 'Subject Test', 'test');
        return view('page.admin-dashboard.subject.test.create-edit', compact('data', 'subjectTest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubjectTest $subjectTest)
    {
        $request->validate([
            'name' => 'required',
            'subject_id' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'enrolled_code' => 'required'
        ]);

        $data = array_merge($request->all(), [
            'start_at' => strtotime($request->start_at),
            'end_at' => strtotime($request->end_at),
            'created_by_id' => auth()->user()->id
        ]);

        $subjectTest->update($data);

        return redirect()->route('admin.test.index')->with('success', 'Test Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectTest $subjectTest)
    {
        try {
            $subjectTest->delete();
            return redirect()->route('admin.test.index')->with('success', 'Test Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.test.index')->with('error', $th->getMessage());
        }
    }
}
