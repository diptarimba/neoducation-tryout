<?php

namespace App\Models;

use App\Models\Traits\UUIDC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAnswer extends Model
{
    use HasFactory, SoftDeletes, UUIDC;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'question_id',
        'answer_id',
        'user_test_id'
    ];

    protected $dates = ['deleted_at'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserTest::class, 'user_test_id', 'id');
    }
}
