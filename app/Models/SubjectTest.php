<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'created_by_id',
        'subject_id',
        'enrolled_code'
    ];

    public function question()
    {
        return $this->hasMany(Question::class, 'subject_id', 'id');
    }

    public function user_test()
    {
        return $this->hasMany(UserTest::class, 'test_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
}
