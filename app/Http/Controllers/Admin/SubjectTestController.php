<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->all()) {
            $subjectTest = SubjectTest::select();
            return datatables()->of($subjectTest)
                ->addIndexColumn()
                ->addColumn('start_at', function ($query) {
                    return $query->start_at ?? '';
                })
                ->addColumn('duration', function ($query) {
                    $start = \Carbon\Carbon::parse($query->start_at);
                    $end = \Carbon\Carbon::parse($query->end_at);
                    return $start->diff($end)->format('%D:%H:%I:%S');
                })
                ->addColumn('enrolled_code', function($query){
                    return strtoupper($query->enrolled_code);
                })
                ->addColumn('question_count', function ($query) {
                    return $query->question()->count();
                })
                ->addColumn('status', function ($query) {
                    $messageStatus = [
                        self::STATUS_TEST_ENDED => ['class' => self::CLASS_BUTTON_PRIMARY, 'text' => 'Test Telah Selesai'],
                        self::STATUS_TEST_PLANNED => ['class' => self::CLASS_BUTTON_SUCCESS, 'text' => 'Test Belum Dimulai'],
                        self::STATUS_TEST_ON_GOING => ['class' => self::CLASS_BUTTON_WARNING, 'text' => 'Test Sedang Berlangsung'],
                        self::STATUS_TEST_ERROR => ['class' => self::CLASS_BUTTON_DANGER, 'text' => 'Test Mengalami Kendala']
                    ];
                    return '<span class="badge ' . $messageStatus[$query->status]['class'] . ' text-white py-1 px-3 rounded-full text-xs">'.$messageStatus[$query->status]['text'].'</span>';
                })
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query, 'test');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('page.admin-dashboard.subject.test.index');
    }

    public function getActionColumn($data, $subjectTestId = '', $prefix = 'admin')
    {
        $testStart = Carbon::parse($data->start_at);
        $testEnd = Carbon::parse($data->end_at);
        $now = Carbon::now();
        $ident = Str::random(10);
        $editBtn = route('admin.test.edit', $data->id);
        $deleteBtn = route('admin.test.destroy', $data->id);
        $questionBtn = route('admin.test.question.index', $data->id);
        $userBtn = route('admin.test.user.index', $data->id);
        $buttonAction = '';
        $buttonAction .= '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Edit</a>';
        $buttonAction .= '<a href="' . $questionBtn . '" class="' . self::CLASS_BUTTON_INFO . '">Question List</a>';
        $buttonAction .= '<a href="' . $userBtn . '" class="' . self::CLASS_BUTTON_WARNING . '">User List</a>';
        if ($now->isBefore($testStart)) {
            $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        }
        return $buttonAction;
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
            'subject_id' => 'required|exists:subjects,id',
            'start_at' => 'required',
            'end_at' => 'required',
            'enrolled_code' => 'required'
        ]);

        $data = array_merge($request->all(), [
            'created_by_id' => auth()->user()->id,
            'status' => self::STATUS_TEST_PLANNED
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
        $subject = Subject::pluck('name', 'id');
        $testStart = Carbon::parse($subjectTest->start_at);
        $now = Carbon::now();
        $beforeTest = $now->isBefore($testStart);

        return view('page.admin-dashboard.subject.test.create-edit', compact('data', 'subjectTest', 'subject', 'beforeTest'));
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

        $subjectTest->update($request->all());

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
