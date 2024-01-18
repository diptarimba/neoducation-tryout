<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function subject_test()
    {
        return $this->hasMany(SubjectTest::class, 'subject_id', 'id');
    }
}
