<?php

namespace App\Models;

use App\Models\Traits\UUIDC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes, UUIDC;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'answer',
        'question_id',
        'is_true'
    ];

    protected $dates = ['deleted_at'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function user_answer()
    {
        return $this->hasMany(UserAnswer::class, 'answer_id', 'id');
    }

    /**
     * This method checks if there is a true answer for a given question.
     *
     * @param  int  $questionId  The unique identifier for the question.
     * @return bool  Returns true if a true answer exists for the question, otherwise false.
     */
    public function trueAnswer($questionId)
    {
        // Attempt to retrieve the first answer record that is marked as true for the given question ID
        $answer = $this->question()->where('question_id', $questionId)->where('is_true', true)->first();

        // Return true if an answer exists, otherwise false
        return $answer !== null;
    }
}
