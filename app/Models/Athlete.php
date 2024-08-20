<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Federation;
use App\Models\Association;
use App\Models\FederationsAthletes;
use App\Models\MatchBracket;
use App\Models\Bracket;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use DB;


class Athlete extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        "academy_id",
        "city_id",
        "country_id",
        'belt_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    // protected $appends = ['eventmatchbrackets'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

  
    
    // protected $with = ['federation'];
    public function federation($federation_id) {
        return $this->belongsToMany(Federation::class, FederationsAthletes::class, 'athlete_id', 'federation_id')
                    ->wherePivot('federation_id', $federation_id);
    }

    public function academy() {
        return $this->belongsTo(Academy::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function typeDocument() {
        return $this->belongsTo(TypeDocument::class);
    }

    public function belt() {
        return $this->belongsTo(Belt::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function matchBrackets()
    {
        return $this->hasMany(MatchBracket::class, 'one_athlete_id')
            ->orWhere('two_athlete_id', $this->id);
        // return $this->hasMany(MatchBracket::class)
        //     ->where(function ($query) {
        //         $query->where('one_athlete_id', $this->id)
        //             ->orWhere('two_athlete_id', $this->id);
        //     });
    }

    // Relación con Bracket a través de MatchBracket
    // public function brackets()
    // {
    //     return $this->hasManyThrough(
    //         Bracket::class, 
    //         MatchBracket::class, 
    //         'one_athlete_id', 
    //         'match_bracket_id'
    //     )
    //     ->orWhereHas('matchBrackets', function ($query) {
    //         $query->where('two_athlete_id', $this->id);
    //     });
    // }

    public static function getAthleteWinLoseInformation() {
        return Athlete::select(
            'athletes.id',
            'athletes.name',
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) as Wins'),
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END) as Losses'),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_winner AND b.phase = 'Final' THEN 1 ELSE 0 END) as gold"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Final' THEN 1 ELSE 0 END) as silver"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Semifinal' THEN 1 ELSE 0 END) as bronze"),
            'athletes.profile_image'
        )
        ->join('match_brackets as mb', function($join) {
            $join->on('athletes.id', '=', 'mb.one_athlete_id')
                 ->orOn('athletes.id', '=', 'mb.two_athlete_id');
        })
        ->join('brackets as b', 'mb.id', '=', 'b.match_bracket_id')
        ->groupBy('athletes.id', 'athletes.name')
        ->orderBy('athletes.id')
        ->get();
    }

    public static function getAthleteEventWinLoseInformation($id) {
        
        return Athlete::select(
            'e.description',
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) as Wins'),
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END) as Losses'),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_winner AND b.phase = 'Final' THEN 1 ELSE 0 END) as gold"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Final' THEN 1 ELSE 0 END) as silver"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Semifinal' THEN 1 ELSE 0 END) as bronze"),
            'e.id as event_id'
        )
        ->join('match_brackets as mb', function($join) {
            $join->on('athletes.id', '=', 'mb.one_athlete_id')
                 ->orOn('athletes.id', '=', 'mb.two_athlete_id');
        })
        ->join('brackets as b', 'mb.id', '=', 'b.match_bracket_id')
        ->join('events as e', 'mb.event_id', '=', 'e.id')
        ->where('athletes.id', $id)
        ->groupBy('athletes.id', 'athletes.name', 'e.description', 'e.id')
        ->orderBy('athletes.id')
        ->get();
    }

    public static function getAthleteInformation($id) {
        return Athlete::select(
                'athletes.id',
                'athletes.name',
                'athletes.profile_image',
                'athletes.birthdate',
                'co.description as country',
                'be.color as belt',
            )
            ->join('belts as be', 'be.id', '=', 'athletes.belt_id')
            ->join('countries as co', 'co.id', '=', 'athletes.country_id')
            ->where('athletes.id', $id)
            ->first();
    }


    public static function getAthleteProfileWinLose($athlete_id) {
            return  Athlete::with([
                'country',
                'belt',
                'inscriptions.event',
                'inscriptions.tariff_inscription.entry_category.matchBracket' => function ($query) use ($athlete_id) {
                    $query->where(function ($q) use ($athlete_id) {
                        $q->where('one_athlete_id', $athlete_id)
                          ->orWhere('two_athlete_id', $athlete_id);
                    });
                },                
                'inscriptions.tariff_inscription.entry_category.matchBracket.brackets',
                'inscriptions.tariff_inscription.entry_category.matchBracket.typeVictory',
                'inscriptions.tariff_inscription.entry_category.matchBracket.athleteOne',
                'inscriptions.tariff_inscription.entry_category.matchBracket.athleteTwo',
                ])    
                
            ->findOrFail($athlete_id);
    }

    
}
