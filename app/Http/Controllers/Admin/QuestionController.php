<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\SubjectTest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectTest $subjectTest, Request $request)
    {
        if ($request->ajax())
        {
            $question = Question::select();
            return datatables()->of($question)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'Question', 'question');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.subject.test.question.index', compact('subjectTest'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubjectTest $subjectTest)
    {
        $data = $this->createMetaPageData($subjectTest->id, 'Question', 'question');
        return view('page.admin-dashboard.subject.test.question.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectTest $subjectTest, Request $request)
    {
        $request->validate([
            'question' => 'required',
        ]);

        Question::create(array_merge($request->all(), [
            'subject_test_id' => $subjectTest->id
        ]));

        return redirect()->route('admin.test.question.index', $subjectTest->id)->with('success', 'Question Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectTest $subjectTest, Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectTest $subjectTest, Question $question)
    {
        $data = [
            'title' => "Create Question Data",
            'url' => route('admin.test.question.update', [$subjectTest->id, $question->id]),
            'home' => route('admin.test.question.index', $subjectTest->id),
        ];

        return view('page.admin-dashboard.subject.test.question.create-edit', compact('data', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectTest $subjectTest, Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required'
        ]);

        $question->update($request->all());

        return redirect()->route('admin.test.question.index', $subjectTest->id)->with('success', "Question Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectTest $subjectTest, Question $question)
    {
        try {
            $question->delete();
            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('success', 'Question Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('error', $e->getMessage());
        }
    }
}
