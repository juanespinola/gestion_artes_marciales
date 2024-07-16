<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bracket;
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
        // 'one_athlete_id',
        // 'two_athlete_id',
        // 'event_id',
    ];

    public function bracket()  {
        // return $this->belongsTo(Bracket::class, 'id', 'match_bracket_id');      
        return $this->hasOne(Bracket::class);
    }

    public static function groupBrackets($event_id) {
        return DB::table('brackets')
        ->select('brackets.number_phase' , 'brackets.phase')
        ->join('match_brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        ->groupBy(['brackets.phase', 'brackets.number_phase'])
        ->orderBy('brackets.number_phase')
        ->where('event_id', $event_id)
        ->get();
    }

    public function athleteOne() {
        return $this->belongsTo(Athlete::class, 'one_athlete_id', 'id');   
    }

    public function athleteTwo() {
        return $this->belongsTo(Athlete::class, 'two_athlete_id', 'id');   
    }
}
