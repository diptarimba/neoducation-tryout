<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubjectTest;
use App\Models\UserTest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function ready_test(UserTest $userTest)
    {
        $testStart = Carbon::parse($userTest->subject_test->start_at);
        $testEnd = Carbon::parse($userTest->subject_test->end_at);
        $now = Carbon::now();
        if (is_null($userTest->start_at) && $now->between($testStart, $testEnd)) {
            $data = [
                "home" => route('user.test.start.index', $userTest->id),
                'url' => route('user.test.start.store', $userTest->id),
                'title' => 'Start Test',
            ];

            return view('page.user-dashboard.subject.test.ready', compact('userTest', 'data'));
        } else if (!is_null($userTest->start_at) && $now->between($testStart, $testEnd)) {
            return redirect()->route('user.test.start.show', $userTest->id);
        }
    }

    public function start_test(UserTest $userTest)
    {
        $userTest->load('subject_test');
        if (is_null($userTest->start_at)) {
            $userTest->update([
                'start_at' => date("Y-m-d H:i:s"),
            ]);
        }

        $testStart = Carbon::parse($userTest->subject_test->start_at);
        $testEnd = Carbon::parse($userTest->subject_test->end_at);
        $now = Carbon::now();

        if (!is_null($userTest->start_at) && $now->between($testStart, $testEnd)) {
            return redirect()->route('user.test.start.show', $userTest->id);
        }

        return redirect()->route('user.test.index')->with('error', 'Test not started yet / Test has ended');
        // return redirect()->route('user.test.question', $userTest->id);

        // return view('page.user-dashboard.subject.test.start', compact('userTest'));
    }

    public function show_test(UserTest $userTest)
    {
        // dd($userTest);
        $userTest->load('subject_test.question.answer');
        if (!is_null($userTest->end_at) && !is_null($userTest->score)) {
            return redirect()->route('user.test.index');
        }
        $test = [];
        foreach ($userTest->subject_test->question as $key => $value) {
            $each = [];
            $each['id'] = $value->id;
            $each['question'] = $value->question;
            $each['image'] = $value->image;
            foreach ($value->answer as $key2 => $value2) {
                $each['answer'][$value2->id] = $value2->answer;
            }
            array_push($test, $each);
        }
        // $test = [];
        // foreach ($userTest->subject_test->question as $key => $value) {
        //     $test = [];
        //     $test[$value->id]['question'] = $value->question;
        //     $test[$value->id]['image'] = $value->image;
        //     foreach($value->answer as $key2 => $value2){
        //         $test[$value->id]['answer'][$value2->id] = $value2->answer;
        //     }
        // }
        $test_data = json_encode([
            "test_id" => $userTest->id,
            "test_title" => $userTest->subject_test->name,
            "test_start_at" => $userTest->subject_test->start_at,
            "test_end_at" => $userTest->subject_test->end_at,
            "test_question" => $test,
        ]);

        $data = [
            'title' => 'Start Test',
            'home' => route('user.test.start.index', $userTest->id),
        ];

        // dd(json_encode($data));
        return view('page.user-dashboard.subject.test.show', compact('userTest', 'data', 'test_data'));
    }

    public function store_test(Request $request, UserTest $userTest)
    {
        if ($request->ajax()) {
            if ($request->has('ended')) {
                try {
                    //code...
                    $userTest->load('subject_test.question');
                    $allQuestionId = $userTest->subject_test->question->pluck('id');
                    foreach($allQuestionId as $each){
                        $userTest->user_answer()->firstOrCreate([
                                'question_id' => $each
                            ]);
                    }
                    $questionCount = $userTest->subject_test->question->count();
                    $correctAnswer = $userTest->user_answer()->whereHas('answer', function($query){
                        $query->where('is_true', '1');
                    })->count();
                    $score = ($correctAnswer / $questionCount) * 100;
                    $userTest->update([
                        'end_at' => date("Y-m-d H:i:s"),
                        'score' => $score
                    ]);
                    return response()->json(['success' => true]);
                } catch (\Throwable $th) {
                    return response()->json(['error' => $th->getMessage()], 400);
                }
            }
            try {
                $request->validate([
                    'question_id' => 'required|exists:questions,id',
                    'answer_id' => 'required|exists:answers,id',
                ]);

                $userTest->user_answer()->updateOrCreate([
                    'question_id' => $request->question_id
                ], ['answer_id' => $request->answer_id]);

                return response()->json(['success' => true]);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()], 400);
            }
        }
    }

}
