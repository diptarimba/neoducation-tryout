<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionImport implements ToModel, WithHeadingRow, WithGroupedHeadingRow, PersistRelations, SkipsEmptyRows
{

    public function __construct(public $subjectTest)
    {
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $question = new Question([
            'image' => $row['image'],
            'question' => $row['question'],
            'test_id' => $this->subjectTest->id
        ]);
        $question->save();

        $answers = [];
        foreach ($row['options'] as $key => $each) {
            $answers[] = new Answer([
                'answer' => $each,
                'is_true' => $key == 0 ? true : false
            ]);
        }

        $question->answer()->saveMany($answers);

        return $question;
    }

    public function rules(): array
    {
        return [
            'image' => [
                'sometimes',
                'string',
            ],
            'question' => [
                'required',
                'string'
            ],
            'options' => [
                'required',
                'array',
                'min:4'
            ],
            'options.*' => [
                'required',
                'string'
            ],
        ];
    }
}
