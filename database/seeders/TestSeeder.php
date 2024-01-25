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
                                "is_true" => true
                            ],
                            [
                                "answer" => "6",
                                "is_true" => false
                            ],
                        ],
                    ],
                    [
                        "question" => "Naga berkepala 3",
                        "answer" => [
                            [
                                "answer" => "Blue Eyes White Dragon",
                                "is_true" => true
                            ],
                            [
                                "answer" => "Obelisk",
                                "is_true" => false
                            ],
                            [
                                "answer" => "White Night Dragon",
                                "is_true" => false
                            ],
                            [
                                "answer" => "Berserk Dargon",
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
            $time = Carbon::now();
            $user = User::role('admin')->first();
            $subjectTest = $subject->subject_test()->create([
                'name' => $s['test'],
                'start_at' => $time->format('Y-m-d H:i:s'),
                'end_at' => $time->addHours(5)->format('Y-m-d H:i:s'),
                'created_by_id' => $user->id,
                'subject_id' => $subject->id,
                'enrolled_code' => strtoupper(\Illuminate\Support\Str::random(10)),
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
