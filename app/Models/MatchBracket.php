<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MatchBracket extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'event_id',
        'victory_type_id',
        'one_athlete_id',
        'two_athlete_id',
        'quadrilateral', // nro de cuadrilatero
        'match_date',
        'match_time',
        "match_timer",
        'score_one_athlete',
        'score_two_athlete',
        "athlete_id_winner",
        "athlete_id_loser",
        "entry_category_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function bracket() {
        return $this->hasOne(Bracket::class);
    }

     // Relación con Athlete
    public function athleteOne() {
        return $this->belongsTo(Athlete::class, 'one_athlete_id', 'id');   
    }

     // Relación con Athlete
    public function athleteTwo() {
        return $this->belongsTo(Athlete::class, 'two_athlete_id', 'id');   
    }

    public function typeVictory() {
        return $this->belongsTo(TypesVictory::class, 'victory_type_id', 'id');   
    }

    public function entry_category() {
        return $this->belongsTo(EntryCategory::class);
    }



    public static function groupBrackets($event_id, $entry_category_id) {
        return DB::table('brackets')
        ->select('brackets.number_phase' , 'brackets.phase')
        ->join('match_brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        ->groupBy(['brackets.phase', 'brackets.number_phase'])
        ->orderBy('brackets.number_phase')
        ->where('event_id', $event_id)
        ->where('match_brackets.entry_category_id', $entry_category_id)
        ->get();
    }

}
