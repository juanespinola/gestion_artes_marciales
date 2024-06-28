<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaNew extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_file',
        'route_file', 
        'type',
        'new_id'
    ];

    
}
