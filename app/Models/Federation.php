<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Federation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'description',
        'status',
        'email',
        'phone_number',
        'president',
        'vice_president',
        'treasurer',
        'facebook',
        'whatsapp',
        'twitter',
        'instagram',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}


