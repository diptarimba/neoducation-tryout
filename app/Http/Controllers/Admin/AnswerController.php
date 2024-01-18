<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\SubjectTest;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectTest $subjectTest, Question $question, Request $request)
    {
        if($request->ajax())
        {
            $answer = Answer::with('question')->whereHas('question', function($query) use ($question){
                $query->where('id', $question->id);
            })->select();
            return datatables()->of($answer)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'Answer', 'answer');
            })
            ->make(true);
        }

        return view('page.admin-dashboard.subject.test.answer.index', compact('subjectTest', 'question'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubjectTest $subjectTest, Question $question)
    {
        $data = [
            'title' => "Create Question Data",
            'url' => route('admin.test.answer.store', [$subjectTest->id, $question->id]),
            'home' => route('admin.test.answer.index', $subjectTest->id),
        ];
        return view('page.admin-dashboard.subject.test.answer.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectTest $subjectTest, Question $question, Request $request)
    {
        $request->validate([
            'answer' => 'required',
            'is_true' => 'required|boolean'
        ]);

        // ketika ada yang di set true, maka yang sudah ter set true, akan dikembalikan ke false
        if ($request->is_true) {
            $this->helperSetAnswerToFalse($question->id);
        } else {
            // ketika ada yang di set false, seminimalnya sudah ada jawaban yang sudah dijadikan true
            $checkTrue = $this->helperGetCorrectAnswerExceptId($question->id, null);
            if (!$checkTrue) {
                return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Please choose true answer first');
            }
        }

        // create new answer
        Answer::create(array_merge($request->all(), [
            'question_id' => $question->id
        ]));

        return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('success', 'Answer Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectTest $subjectTest, Question $question, Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectTest $subjectTest, Question $question, Answer $answer)
    {
        $data = [
            'title' => "Create Question Data",
            'url' => route('admin.test.answer.update', [$subjectTest->id, $question->id, $answer->id]),
            'home' => route('admin.test.answer.index', $subjectTest->id),
        ];
        return view('page.admin-dashboard.subject.test.answer.create-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectTest $subjectTest, Question $question, Answer $answer, Request $request)
    {
        $request->validate([
            'answer' => 'required',
            'is_true' => 'required|boolean'
        ]);

        // ketika ada yang di set true, maka yang sudah ter set true, akan dikembalikan ke false
        if ($request->is_true) {
            $this->helperSetAnswerToFalse($question->id);
        } else {
            // ketika ada yang di set false, seminimalnya sudah ada jawaban yang sudah dijadikan true
            $checkTrue = $this->helperGetCorrectAnswerExceptId($question->id, $answer->id);
            if (!$checkTrue) {
                return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Please choose true answer first');
            }
        }

        $answer->update($request->all());

        return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('success', 'Answer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectTest $subjectTest, Question $question, Answer $answer)
    {
        try {
            $answer->delete();
            return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('success', 'Answer Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', $th->getMessage());
        }
    }

    public function helperSetAnswerToFalse($questionId){
        // Update existing true answer
        Answer::whereHas('question', function($query) use ($questionId){
            $query->where('id', $questionId);
        })->where('is_true', true)->update(['is_true' => false]);
    }

    public function helperGetCorrectAnswerExceptId($questionId, $answerId){
        $checkTrue = Answer::whereHas('question', function($query) use ($questionId){
            $query->where('id', $questionId);
        });
        if ($answerId){
            $checkTrue = $checkTrue->where('id', '!=', $answerId);
        }
        $checkTrue = $checkTrue->whereFirst('is_true', true);
        return $checkTrue;

    }
}
