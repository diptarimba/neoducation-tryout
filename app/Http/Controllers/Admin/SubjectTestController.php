<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTest;
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
                    return $query->start_at ? date('d F Y H:i', $query->start_at) : '';
                })
                ->addColumn('duration', function ($query) {
                    $start = \Carbon\Carbon::parse($query->start_at);
                    $end = \Carbon\Carbon::parse($query->end_at);
                    return $start->diff($end)->format('%H:%I:%S');
                })
                ->addColumn('question_count', function ($query) {
                    return $query->question()->count();
                })
                ->addColumn('status', function ($query) {
                    if (time() >= $query->start_at && time() <= $query->end_at) {
                        return '<span class="badge ' . self::CLASS_BUTTON_PRIMARY . ' text-white py-1 px-3 rounded-full text-xs">Sedang Berlangsung</span>';
                    } else if (time() < $query->start_at) {
                        return '<span class="badge ' . self::CLASS_BUTTON_SUCCESS . '">Belum Mulai</span>';
                    } else {
                        return '<span class="badge ' . self::CLASS_BUTTON_DANGER . '">Selesai</span>';
                    }
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
        $ident = Str::random(10);
        $editBtn = route('admin.test.edit', $data->id);
        $deleteBtn = route('admin.test.destroy', $data->id);
        $questionBtn = route('admin.test.question.index', $data->id);
        $userBtn = route('admin.test.user.index', $data->id);
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Edit</a>';
        $buttonAction .= '<a href="' . $questionBtn . '" class="' . self::CLASS_BUTTON_INFO . '">Question List</a>';
        $buttonAction .= '<a href="' . $userBtn . '" class="' . self::CLASS_BUTTON_WARNING . '">User List</a>';
        $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
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
        $subject = Subject::pluck('name', 'id');
        return view('page.admin-dashboard.subject.test.create-edit', compact('data', 'subjectTest', 'subject'));
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
