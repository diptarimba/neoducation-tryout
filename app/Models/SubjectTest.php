<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class SubjectTest extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'created_by_id',
        'subject_id',
        'enrolled_code'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString(); // Atur nilai UUID saat pembuatan
        });

        static::deleting(function($parent) {
            $parent->question()->delete();
            $parent->user_test()->delete();
        });
    }

    public function question()
    {
        return $this->hasMany(Question::class, 'test_id', 'id');
    }

    public function user_test()
    {
        return $this->hasMany(UserTest::class, 'test_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
