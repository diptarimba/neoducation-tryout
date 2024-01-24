<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'user_id',
        'score',
        'start_at',
        'end_at'
    ];

    public function subject_test()
    {
        return $this->belongsTo(SubjectTest::class, 'test_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user_answer()
    {
        return $this->hasMany(UserAnswer::class, 'user_test_id', 'id');
    }

}
