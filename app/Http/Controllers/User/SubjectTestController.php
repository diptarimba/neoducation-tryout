<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubjectTest;
use App\Models\UserTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectTestController extends Controller
{
    public function index_enroll()
    {
        $data = $this->createMetaPageData(null, 'Subject Test', 'test.enroll', 'user');
        return view('page.user-dashboard.subject.test.enroll', compact('data'));
    }

    public function store_enroll(Request $request)
    {
        try {
            $request->validate([
                'enrolled_code' => 'required|exists:subject_tests,enrolled_code'
            ]);

            $subjectTest = SubjectTest::where('enrolled_code', $request->enrolled_code)->whereDoesntHave('user_test', function($query){
                $query->where('user_id', auth()->user()->id);
            })->first();
            if (is_null($subjectTest)){
                throw new \Exception('Test Not Found / Was Already Taken');
            }
            $subjectTest->user_test()->create([
                'user_id' => auth()->user()->id
            ]);
            return redirect()->route('user.test.enroll.index')->with('success', 'Test Enrolled Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('user.test.enroll.index')->with('error', $th->getMessage());
        }

    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $userTest = UserTest::with('subject_test')->where('user_id', auth()->user()->id)->select();
            return datatables()->of($userTest)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionCustom($query);
            })
            ->addColumn('schedule', function($query){
                $testStart = Carbon::parse($query->subject_test->start_at);
                $testEnd = Carbon::parse($query->subject_test->end_at);
                return $testStart->format('d M Y H:i') . ' - ' . $testEnd->format('d M Y H:i');
            })
            ->addColumn('score', function($query){
                return $query->start_at == null && $query->score == null ? 'Belum Mulai' : $query->score;
            })
            ->make(true);
        }

        return view('page.user-dashboard.subject.test.index');
    }

    public function getActionCustom($data)
    {


        $ident = Str::random(10);
        $testStart = Carbon::parse($data->subject_test->start_at);
        $testEnd = Carbon::parse($data->subject_test->end_at);
        $now = Carbon::now();
        $buttonAction = "";

        if ($now->between($testStart, $testEnd)){
            if (is_null($data->score) && is_null($data->start_at) && is_null($data->end_at)){
                $startBtn = route('user.test.start.index', $data->subject_test->id);
                $buttonAction = '<a href="' . $startBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Start</a>';
            } else if (!is_null($data->start_at) && is_null($data->end_at) && is_null($data->score)) {
                $backToTestBtn = route('user.test.start.index', $data->subject_test->id);
                $buttonAction = '<a href="' . $backToTestBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Continue</a>';
            }
        }

        if ($now > $testEnd){
            $classementBtn = route('user.test.classement', $data->subject_test->id);
            $buttonAction = '<a href="' . $classementBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">Classement</a>';
        }

        return $buttonAction;
    }

    public function finish_test(Request $request, SubjectTest $subjectTest)
    {
        if ($request->ajax())
        {
            $userTest = UserTest::with('user')->where('test_id', $subjectTest->id)->orderby('score', 'desc')->select();
            return datatables()->of($userTest)
            ->addIndexColumn()
            ->make(true);
        }
        return view('page.user-dashboard.subject.test.classement', compact('subjectTest'));
    }

}
