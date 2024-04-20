<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
