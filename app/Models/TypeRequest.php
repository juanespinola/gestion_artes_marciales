<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'federation_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
