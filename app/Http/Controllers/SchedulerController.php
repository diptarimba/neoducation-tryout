<?php

namespace App\Http\Controllers;

use App\Models\SubjectTest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function start_test()
    {
        $test = SubjectTest::with('question')
        ->where('start_at', '<=', date("Y-m-d H:i:s"))
        ->where('end_at', '>', date("Y-m-d H:i:s"))
        ->where(function ($query) {
            $query->where('status', self::STATUS_TEST_PLANNED);
            $query->orWhere('status', self::STATUS_TEST_ERROR);
        });

        try {
        $hasError = false;
        foreach ($test->get() as $queryTest) {
            $anyQuestionWithoutFourAnswer = $queryTest->question->contains(function ($queryQuestion) {
                return $queryQuestion->answer()->count() !== 4;
            });

            if ($anyQuestionWithoutFourAnswer) {
                $hasError = true;
                $queryTest->update([
                    'status' => self::STATUS_TEST_ERROR,
                    'message' => 'Please fill answer option for all question',
                ]);
                continue;
            }
            $queryTest->update(['status' => self::STATUS_TEST_ON_GOING, 'message' => 'Test Started Successfully']);

        }

        if ($hasError) {
            throw new \Exception('Please fill answer option for all question', 1);
        }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Test Started Successfully'
        ]);
    }

    public function end_test()
    {
        $endAt = date("Y-m-d H:i:s");
        $test = SubjectTest::with('user_test.user_answer.answer', 'question')->where('status', self::STATUS_TEST_ON_GOING)->where('end_at', '<=', Carbon::now());
        $test->get()->each(function ($query) use ($endAt) {
            // menghitung jumlah question untuk menghitung score
            $allQuestionId = $query->question->pluck('id');
            $countQuestion = $query->question()->count();
            // menghitung score
            $query->user_test()->each(function($query) use($countQuestion, $endAt,  $allQuestionId){
                // mengisi jawaban yang tidak diisi oleh pengguna, gunanya untuk ditampilkan hasil dari jawaban
                foreach ($allQuestionId as $each) {
                    $query->user_answer()->firstOrCreate([
                        'question_id' => $each
                    ]);
                }
                // menghitung jumlah jawaban benar
                $countCorrectAnswer = $query->user_answer()->whereHas('answer', function ($q) {
                    $q->where('is_true', true);
                })->count();
                // menghitung score yang didapatkan user
                $score = ($countCorrectAnswer / $countQuestion) * 100;
                // update user test
                $query->update([
                    'end_at' => $query->end_at ?? $endAt,
                    'score' => $score
                ]);
            });
        });
        $test->update(['status' => self::STATUS_TEST_ENDED, 'message' => 'Test Ended Successfully']);
        return response()->json([
            'success' => true,
            'message' => 'Test Ended Successfully'
        ]);
    }
}
