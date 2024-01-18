<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use COM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subject = [
            [
                "name" => "Fisika",
                "test" => "Tes Fisika 1",
                "the_test" => [
                    [
                        "question" => "Berapa Jarak Tempuh Saya Ke kantor?",
                        "answer" => [
                            [
                                "answer" => "3",
                                "is_true" => false
                            ],
                            [
                                "answer" => "4",
                                "is_true" => false
                            ],
                            [
                                "answer" => "5",
                                "is_true" => false
                            ],
                            [
                                "answer" => "6",
                                "is_true" => false
                            ],
                        ],
                    ]
                ],
            ]
        ];

        foreach($subject as $s){
            $subject = \App\Models\Subject::create([
                'name' => $s['name']
            ]);
            $time = Carbon::now()->addHours(5);
            $user = User::role('admin')->first();
            $subjectTest = $subject->subject_test()->create([
                'name' => $s['test'],
                'start_at' => $time->timestamp,
                'end_at' => $time->addMinutes(40)->timestamp,
                'created_by_id' => $user->id,
                'subject_id' => $subject->id,
                'enrolled_code' => \Illuminate\Support\Str::random(10),
            ]);

            foreach($s['the_test'] as $eachQuestion){
                $question = $subjectTest->question()->create([
                    'question' => $eachQuestion['question'],
                ]);

                foreach($eachQuestion['answer'] as $a){
                    $question->answer()->create(array_merge($a, [
                        'question_id' => $question->id
                    ]));
                }

            }
        }



    }
}
