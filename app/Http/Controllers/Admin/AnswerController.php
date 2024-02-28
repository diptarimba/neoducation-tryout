<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\SubjectTest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
                $query->where('questions.id', $question->id);
            })->select();
            return datatables()->of($answer)
            ->addIndexColumn()
            ->addColumn('is_true', function($query){
                return $query->is_true ? 'Benar' : 'Tidak';
            })
            ->addColumn('action', function($query) use ($subjectTest, $question){
                return $this->getActionColumn($query, $subjectTest->id, $question->id);
            })
            ->make(true);
        }

        return view('page.admin-dashboard.subject.test.answer.index', compact('subjectTest', 'question'));
    }

    public function getActionColumn($data, $subjectTestId = '', $questionId = '')
    {
        $ident = Str::random(10);
        $editBtn = route('admin.test.answer.edit', [$subjectTestId, $questionId, $data->id]);
        $deleteBtn = route('admin.test.answer.destroy', [$subjectTestId, $questionId, $data->id]);
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Edit</a>';
        $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        return $buttonAction;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubjectTest $subjectTest, Question $question)
    {
        $question->load('answer');
        $answerCount = $question->answer()->count();
        if ($answerCount >= 4) {
            return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Sudah tersedia 4 jawaban');
        }
        $data = [
            'title' => "Create Question Data",
            'url' => route('admin.test.answer.store', [$subjectTest->id, $question->id]),
            'home' => route('admin.test.answer.index', [$subjectTest->id, $question->id]),
        ];
        return view('page.admin-dashboard.subject.test.answer.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectTest $subjectTest, Question $question, Request $request)
    {
        $request->validate([
            'answer' => 'required',
            'is_true' => 'sometimes'
        ]);

        $requestIsTrue = $request->is_true == 'on';

        // ketika ada yang di set true, maka yang sudah ter set true, akan dikembalikan ke false
        if ($requestIsTrue) {
            $this->helperSetAnswerToFalse($question->id);
        } else {
            // ketika ada yang di set false, seminimalnya sudah ada jawaban yang sudah dijadikan true
            $checkTrue = $this->helperGetCorrectAnswerExceptId($question->id, null);
            if (!$checkTrue) {
                return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Please create correct answer first');
            }
        }

        // create new answer
        Answer::create(array_merge($request->all(), [
            'is_true' => $requestIsTrue,
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
            'home' => route('admin.test.answer.index', [$subjectTest->id, $question->id]),
        ];
        return view('page.admin-dashboard.subject.test.answer.create-edit', compact('data', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectTest $subjectTest, Question $question, Answer $answer, Request $request)
    {

        $request->validate([
            'answer' => 'required',
            'is_true' => 'sometimes'
        ]);

        $isTrue = $request->is_true == 'on';

        // ketika ada yang di set true, maka yang sudah ter set true, akan dikembalikan ke false
        if ($isTrue) {
            $this->helperSetAnswerToFalse($question->id);
        } else {
            // ketika ada yang di set false, seminimalnya sudah ada jawaban yang sudah dijadikan true
            $checkTrue = $this->helperGetCorrectAnswerExceptId($question->id, $answer->id);
            if (!$checkTrue) {
                return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Please choose correct answer first');
            }
        }

        $answer->update(array_merge($request->all(), [
            'is_true' => $isTrue
        ]));

        return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('success', 'Answer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectTest $subjectTest, Question $question, Answer $answer)
    {
        try {
            $checkTrue = $this->helperGetCorrectAnswerExceptId($question->id, $answer->id);
            if (!$checkTrue) {
                return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', 'Please choose correct answer first before delete the correct answer');
            }
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
        $checkTrue = $checkTrue->where('is_true', true);
        return $checkTrue->first();

    }

    public function destroy_all(SubjectTest $subjectTest, Question $question)
    {
        try {
            $question->answer()->delete();
            return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('success', 'All Answer Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.test.answer.index', [$subjectTest->id, $question->id])->with('error', $th->getMessage());
        }
    }
}
