<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'image',
        'question'
    ];

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //     $model->{$model->getKeyName()} = Uuid::uuid4()->toString(); // Atur nilai UUID saat pembuatan
        // });

        static::deleting(function($parent) {
            $parent->answer()->delete();
            $parent->user_answer()->delete();
        });
    }

    public function subject_test()
    {
        return $this->belongsTo(SubjectTest::class, 'test_id', 'id');
    }

    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function user_answer()
    {
        return $this->hasMany(UserAnswer::class, 'question_id', 'id');
    }
}
