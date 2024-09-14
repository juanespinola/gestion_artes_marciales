<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ranking extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'athlete_id',
        'event_id',
        'entry_category_id',
        "position",
        "victories",
        'defeats',
        'gold',
        'silver',
        'bronze',
        'event_points' // si salen 1, 2 ,3 se le pone puntos
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function athlete()  {
        return $this->belongsTo(Athlete::class);
    }

    public function entry_category() {
        return $this->hasOne(EntryCategory::class);
    }

    public static function updateRanking(){
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
                $query->orderBy('event_points', 'desc')
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
        
        // Inicializar un array para almacenar los datos de ranking de cada atleta
        $ranking = [];
        
        // Calcular puntos, victorias, derrotas y medallas para cada atleta
        foreach ($results as $match) {
            $phase = $match->phase;
            $eventId = $match->event_id;
            $beltId = $match->entry_category->belt_id;
            $categoryId = $match->entry_category_id;
        
            // Crear la llave para agrupar
            $key = "{$eventId}_{$beltId}_{$categoryId}";
        
            // Inicializar el array si no existe
            if (!isset($ranking[$key])) {
                $ranking[$key] = [];
            }
        
            // Procesar al atleta ganador
            if ($match->athlete_id_winner) {
                if (!isset($ranking[$key][$match->athlete_id_winner])) {
                    $ranking[$key][$match->athlete_id_winner] = [
                        'victories' => 0,
                        'defeats' => 0,
                        'gold' => 0,
                        'silver' => 0,
                        'bronze' => 0,
                        'event_points' => 0,
                    ];
                }
        
                $ranking[$key][$match->athlete_id_winner]['victories'] += 1;
        
                if ($phase === 'Final') {
                    $ranking[$key][$match->athlete_id_winner]['gold'] += 1;
                    $ranking[$key][$match->athlete_id_winner]['event_points'] += $points['gold'];
                }
            }
        
            // Procesar al atleta perdedor
            if ($match->athlete_id_loser) {
                if (!isset($ranking[$key][$match->athlete_id_loser])) {
                    $ranking[$key][$match->athlete_id_loser] = [
                        'victories' => 0,
                        'defeats' => 0,
                        'gold' => 0,
                        'silver' => 0,
                        'bronze' => 0,
                        'event_points' => 0,
                    ];
                }
        
                $ranking[$key][$match->athlete_id_loser]['defeats'] += 1;
        
                if ($phase === 'Final') {
                    $ranking[$key][$match->athlete_id_loser]['silver'] += 1;
                    $ranking[$key][$match->athlete_id_loser]['event_points'] += $points['silver'];
                } elseif ($phase === 'Semifinal') {
                    $ranking[$key][$match->athlete_id_loser]['bronze'] += 1;
                    $ranking[$key][$match->athlete_id_loser]['event_points'] += $points['bronze'];
                }
            }
        }
        
        // Ordenar el ranking dentro de cada grupo por puntos de mayor a menor
        foreach ($ranking as &$group) {
            uasort($group, function($a, $b) {
                return $b['event_points'] <=> $a['event_points'] 
                    ?: $b['victories'] <=> $a['victories']
                    ?: $a['defeats'] <=> $b['defeats'];
            });
        }
        
        // Guardar o retornar el ranking ordenado
        foreach ($ranking as $key => $group) {
            $position = 1;
            foreach ($group as $athleteId => $data) {
                Ranking::updateOrCreate(
                    [
                        'athlete_id' => $athleteId,
                        'event_id' => explode('_', $key)[0],
                        'entry_category_id' => explode('_', $key)[2],
                    ],
                    [
                        'position' => $position,
                        'victories' => $data['victories'],
                        'defeats' => $data['defeats'],
                        'gold' => $data['gold'],
                        'silver' => $data['silver'],
                        'bronze' => $data['bronze'],
                        'event_points' => $data['event_points'],
                    ]
                );
                $position++;
            }
        }
        
        return $ranking;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults(); 
    }

}
