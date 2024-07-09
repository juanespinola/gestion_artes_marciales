<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bracket extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_bracket_id',
        'phase',
        'number_phase',
        'step',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
