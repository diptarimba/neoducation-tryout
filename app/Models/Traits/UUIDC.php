<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

trait UUIDC {
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString(); // Atur nilai UUID saat pembuatan
        });
    }
}

