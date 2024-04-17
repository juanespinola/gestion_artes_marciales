<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'federation_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
