<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionImport;
use App\Models\Question;
use App\Models\SubjectTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\SUpport\Str;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectTest $subjectTest, Request $request)
    {
        if ($request->ajax()) {
            $question = Question::with('subject_test')->where('test_id', $subjectTest->id)->select();
            return datatables()->of($question)
                ->addIndexColumn()
                ->addColumn('action', function ($query) use ($subjectTest) {
                    return $this->getActionColumn($query, $subjectTest->id, 'admin');
                })
                ->addColumn('notes', function ($query) {
                    return $query->answer()->count() < 4 ? 'Jawaban kurang dari 4 pilihan' : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $duringTest = $subjectTest->status == self::STATUS_TEST_PLANNED || $subjectTest->status == self::STATUS_TEST_ERROR;

        return view('page.admin-dashboard.subject.test.question.index', compact('subjectTest', 'duringTest'));
    }

    public function getActionColumn($data, $subjectTestId = '', $prefix = 'admin')
    {
        $subjectTest = $data->subject_test;
        $beforeStart = $subjectTest->status == self::STATUS_TEST_PLANNED || $subjectTest->status == self::STATUS_TEST_ERROR;
        $ident = Str::random(10);
        $editBtn = route('admin.test.question.edit', [$subjectTestId, $data->id]);
        $deleteBtn = route('admin.test.question.destroy', [$subjectTestId, $data->id]);
        $answerBtn = route('admin.test.answer.index', [$subjectTestId, $data->id]);
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Edit</a>';
        $buttonAction .= '<a href="' . $answerBtn . '" class="' . self::CLASS_BUTTON_INFO . '">Jawaban</a>';
        if($beforeStart){
            $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        }
        return $buttonAction;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubjectTest $subjectTest)
    {
        $data = [
            'title' => "Membuat Pertanyaan",
            'url' => route('admin.test.question.store', $subjectTest->id),
            'home' => route('admin.test.question.index', $subjectTest->id),
        ];
        return view('page.admin-dashboard.subject.test.question.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectTest $subjectTest, Request $request)
    {
        $request->validate([
            'question' => 'required',
            'image' => 'sometimes|max:2064|mimes:png,jpg,jpeg'
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = $image->storeAs('public/question', $image->hashName(), 'public');
            $request->merge(['image' => asset('storage/public/question/' . $image->hashName())]);
        }

        Question::create(array_merge($request->all(), [
            'test_id' => $subjectTest->id
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
            'title' => "Memperbarui Pertanyaan",
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

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $path = $image->storeAs('public/question', $image->hashName(), 'public');
            $request->merge(['image' => asset('storage/public/question/' . $image->hashName())]);
        }

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

    public function upload_index(SubjectTest $subjectTest)
    {
        $data = [
            'title' => "Membuat Pertanyaan (Upload)",
            'url' => route('admin.test.question.upload.store', $subjectTest->id),
            'home' => route('admin.test.question.index', $subjectTest->id),
        ];
        return view('page.admin-dashboard.subject.test.question.upload', compact('data'));
    }

    public function upload_store(SubjectTest $subjectTest, Request $request)
    {
        try {
            $request->validate([
                'file' => 'mimes:xlsx'
            ]);

            Excel::import(new QuestionImport($subjectTest), $request->file('file'));

            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('success', 'Question Uploaded Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('error', $th->getMessage());
        }
    }

    public function destroy_all(SubjectTest $subjectTest)
    {
        try {
            $subjectTest->question()->delete();
            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('success', 'Question Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.test.question.index', $subjectTest->id)->with('error', $th->getMessage());
        }
    }
}
