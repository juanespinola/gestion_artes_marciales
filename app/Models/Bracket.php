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


     // Relación con MatchBracket
    public function matchBrackets() {
        return $this->belongsTo(MatchBracket::class);
    }
    
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
