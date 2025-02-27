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
use App\Models\Ranking;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use DB;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Athlete extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        "academy_id",
        "city_id",
        "country_id",
        'belt_id',
        'type_document_id',
        'is_minor',
        'minor_verified',
        'document',
        'gender',
        'birthdate',
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

    public function inscriptions(){
        return $this->hasMany(Inscription::class);
    }

    public function matchBrackets(){
        return $this->hasMany(MatchBracket::class, 'one_athlete_id')
            ->orWhere('two_athlete_id', $this->id);
    }

    public function sanctions(){
        return $this->hasMany(Sanction::class);
    }



    public static function getAthleteWinLoseInformation() {
        return Athlete::select(
            'athletes.id',
            'athletes.name',
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) as Wins'),
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END) as Losses'),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_winner AND b.phase = 'Final' THEN 1 ELSE 0 END) as gold"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Final' THEN 1 ELSE 0 END) as silver"),
            DB::raw("SUM(CASE WHEN athletes.id = mb.athlete_id_loser AND b.phase = 'Semifinal' THEN 1 ELSE 0 END) as bronze"),
            'athletes.profile_image',
            DB::raw('(SELECT COUNT(DISTINCT event_id) FROM match_brackets 
                      WHERE match_brackets.one_athlete_id = athletes.id 
                         OR match_brackets.two_athlete_id = athletes.id) as eventparticipated')
        )
        ->join('match_brackets as mb', function($join) {
            $join->on('athletes.id', '=', 'mb.one_athlete_id')
                 ->orOn('athletes.id', '=', 'mb.two_athlete_id');
        })
        ->join('brackets as b', 'mb.id', '=', 'b.match_bracket_id')
        ->join('events as e', 'e.id', '=', 'mb.event_id')
        ->join('status_events as sa', 'sa.id', '=', 'e.status_event_id')
        ->whereRaw("LOWER(sa.description) = 'finalizado'")
        ->groupBy('athletes.id', 'athletes.name', 'athletes.profile_image') 
        ->orderBy('gold', 'desc')
        ->limit(10)
        ->get();
    }

    public static function getAthleteWinLoseDifference() {
        return Athlete::select(
            'athletes.id',
            'athletes.name',
            'athletes.profile_image',
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) as Wins'),
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END) as Losses'),
            DB::raw('(SELECT COUNT(DISTINCT event_id) FROM match_brackets 
                      WHERE match_brackets.one_athlete_id = athletes.id 
                         OR match_brackets.two_athlete_id = athletes.id) as eventparticipated'),
            DB::raw('(SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) 
                     - SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END)) as difference')
        )
        ->join('match_brackets as mb', function($join) {
            $join->on('athletes.id', '=', 'mb.one_athlete_id')
                 ->orOn('athletes.id', '=', 'mb.two_athlete_id');
        })
        ->join('brackets as b', 'mb.id', '=', 'b.match_bracket_id')
        ->join('events as e', 'e.id', '=', 'mb.event_id')
        ->join('status_events as sa', 'sa.id', '=', 'e.status_event_id')
        ->whereRaw("LOWER(sa.description) = 'finalizado'")
        ->groupBy('athletes.id', 'athletes.name', 'athletes.profile_image') 
        ->orderBy('difference', 'desc') // Ordenar por diferencia de victorias y derrotas
        ->limit(10)
        ->get();
        
    }

    public static function getAthleteMostActive() {
        return Athlete::select(
            'athletes.id',
            'athletes.name',
            'athletes.profile_image',
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) as Wins'),
            DB::raw('SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END) as Losses'),
            DB::raw('(SELECT COUNT(DISTINCT event_id) FROM match_brackets 
                      WHERE match_brackets.one_athlete_id = athletes.id 
                         OR match_brackets.two_athlete_id = athletes.id) as eventparticipated'),
            DB::raw('(SUM(CASE WHEN athletes.id = mb.athlete_id_winner THEN 1 ELSE 0 END) 
                    + SUM(CASE WHEN athletes.id = mb.athlete_id_loser THEN 1 ELSE 0 END)) as total_matches')
        )
        ->join('match_brackets as mb', function($join) {
            $join->on('athletes.id', '=', 'mb.one_athlete_id')
                 ->orOn('athletes.id', '=', 'mb.two_athlete_id');
        })
        ->join('brackets as b', 'mb.id', '=', 'b.match_bracket_id')
        ->join('events as e', 'e.id', '=', 'mb.event_id')
        ->join('status_events as sa', 'sa.id', '=', 'e.status_event_id')
        ->whereRaw("LOWER(sa.description) = 'finalizado'")
        ->groupBy('athletes.id', 'athletes.name', 'athletes.profile_image') 
        ->orderBy('total_matches', 'desc') // Ordenar por total de partidos jugados
        ->limit(10)
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
                'inscriptions.tariff_inscription.entry_category.matchBracket.bracket',
                'inscriptions.tariff_inscription.entry_category.matchBracket.typeVictory',
                'inscriptions.tariff_inscription.entry_category.matchBracket.athleteOne',
                'inscriptions.tariff_inscription.entry_category.matchBracket.athleteTwo',
                ])    
                
            ->findOrFail($athlete_id);
    }

    public static function getAthleteRanking_v1() {
        // Asignar puntos por posición
        $points = [
            'gold' => 3,
            'silver' => 2,
            'bronze' => 1,
        ];

        $results = MatchBracket::with([
            'bracket', 
            'entry_category', 
            'entry_category.belt', 
            'event',
            'entry_category.ranking.athlete',
            'entry_category.ranking' => function ($query) {
                $query->orderBy('points', 'desc')
                    ->orderBy('victories', 'desc')
                    ->orderBy('defeats', 'asc');
                }
            ])
        ->select(
            'athlete_id_winner', 
            'athlete_id_loser', 
            'brackets.phase',
            'match_brackets.event_id',
            'entry_category_id',
            'entry_categories.belt_id',
        )
        ->join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        ->join('entry_categories', 'match_brackets.entry_category_id', '=', 'entry_categories.id')
        ->whereNotNull('athlete_id_winner')
        ->get();

        // Inicializar un array para almacenar los puntos de cada atleta agrupados por evento, cinturón, y categoría
        $ranking = [];

        // Calcular puntos y agrupar
        foreach ($results as $match) {
            $phase = $match->phase;
            $eventId = $match->event_id;
            $beltId = $match->entry_category->belt_id;
            $categoryId = $match->entry_category_id;

            // Crear la llave para agrupar
            $key = "{$eventId}_{$beltId}_{$categoryId}_";

            // Inicializar el array si no existe
            if (!isset($ranking[$key])) {
                $ranking[$key] = [];
            }

            // Asignar puntos al atleta ganador
            if ($match->athlete_id_winner) {
                if (!isset($ranking[$key][$match->athlete_id_winner])) {
                    $ranking[$key][$match->athlete_id_winner] = 0;
                }
                if ($phase === 'Final') {
                    $ranking[$key][$match->athlete_id_winner] += $points['gold'];
                } 
            }

            // Asignar puntos al atleta perdedor
            if ($match->athlete_id_loser) {
                if (!isset($ranking[$key][$match->athlete_id_loser])) {
                    $ranking[$key][$match->athlete_id_loser] = 0;
                }
                if ($phase === 'Final') {
                    $ranking[$key][$match->athlete_id_loser] += $points['silver'];
                } elseif ($phase === 'Semifinal') {
                    $ranking[$key][$match->athlete_id_loser] += $points['bronze'];
                }
            }
        }

        // Ordenar el ranking dentro de cada grupo por puntos de mayor a menor
        foreach ($ranking as &$group) {
            arsort($group);
        }

        return $ranking; 
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }


    public  static function athlete_federation($federation_id, $association_id = null) {
        $data = self::join('federations_athletes as fa', 'fa.athlete_id', '=', 'athletes.id')
            ->where('federation_id', $federation_id);
        
        if($association_id){
            $data = $data->where('association_id', $association_id);
        }

        return $data;
    }
    
}
