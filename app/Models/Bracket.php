<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Bracket extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'match_bracket_id',
        'phase',
        'number_phase',
        'step',
        'status',
    ];

    // protected $casts = [
    //     'status' => 'boolean',
    // ];
    

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


     // Relación con MatchBracket
    public function matchBrackets() {
        return $this->belongsTo(MatchBracket::class, 'match_bracket_id', 'id');
    }

     // Relación con MatchBracket
    //  public function matchBracket() {
    //     return $this->hasOne(MatchBracket::class, 'id', 'match_bracket_id');
    // }
    
    public function inscriptions() {
        return $this->hasMany(Inscription::class);
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }
}
