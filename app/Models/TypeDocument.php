<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
