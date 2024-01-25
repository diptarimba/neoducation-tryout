<?php

namespace App\Models;

use App\Models\Traits\UUIDC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHome extends Model
{
    use HasFactory, UUIDC;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'home'
    ];
}
