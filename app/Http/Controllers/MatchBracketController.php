<?php

namespace App\Http\Controllers;

use App\Models\MatchBracket;
use App\Models\Bracket;
use Illuminate\Http\Request;
use DB;

class MatchBracketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = MatchBracket::with('bracket', 'athleteOne', 'athleteTwo')
                        ->where([
                            ['entry_category_id', $request->input('entry_category_id')],
                            ['event_id', $request->input('event_id')],
                        ])
                        ->orderBy('id')
                        ->get();
                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function checkMathBracket(Request $request){
        try {
            return MatchBracket::where(
                [
                    ['entry_category_id', $request->input('entry_category_id')],
                    ['event_id', $request->input('event_id')],
                ]
            )
            ->count();

        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function generateMatchBrackets(Request $request) {
        try {
            $athletes = $request->input('athlete');
            $type_bracket = $request->input('type_bracket'); // 'round_robin', 'single_elimination', 'double_elimination'
            $event_id = $request->input('event_id');
            $quadrilateral = $request->input('quadrilateral');
            $entry_category_id = $request->input('entry_category_id');
            $match_timer = $request->input('match_timer');
            $date = now();
    
            $data = $this->generateMatchBracketsByType($athletes, $type_bracket, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer);
    
            return response()->json($data, 201);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function generateMatchBracketsByType($athletes, $type_bracket, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer) {
        switch ($type_bracket) {
            case 'single_elimination':
                return $this->singleEliminationBracketWithoutBronceFight($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer);
            case 'double_elimination':
                return $this->generarDoubleElimination($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer);
            case 'round_robin':
                return $this->generarRoundRobin($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer);
            default:
                return response()->json(['error' => 'Tipo de llave no válido'], 400);
        }
    }

    private function calcularFases($numeroAtletas) {
        return ceil(log($numeroAtletas, 2));
    }
 
    private function singleEliminationBracketWithoutBronceFight($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer){
        $match_brackets = [];
        $brackets = [];

        // Mezclar athletes
        shuffle($athletes);
        $numberPhase = $this->calcularFases(count($athletes));
        $phase = 1;
        $step = 1;
        for ($i = 0; $i < count($athletes); $i += 2) {
            $participante1 = $athletes[$i]['athlete']['id'];
            $participante2 = $athletes[$i + 1]['athlete']['id'] ?? null;

            // Guardar enfrentamiento en la base de datos
            $match_bracket = MatchBracket::create([
                'event_id' => $event_id,
                'one_athlete_id' => $participante1,
                'two_athlete_id' => $participante2,
                'quadrilateral' => $quadrilateral,
                // 'date' => $date,
                'score_one_athlete' => 0,
                'score_two_athlete' => 0,
                'entry_category_id' => $entry_category_id,
                'match_timer' => $match_timer,
            ]);

            // Guardar llave en la base de datos
            $brackets[] = Bracket::create([
                'match_bracket_id' => $match_bracket->id,
                'number_phase' => $phase,
                'phase' => $this->getNamePhase($phase, $numberPhase),
                'step' => $step,
                'status' => 'pendiente',
            ]);

            $match_brackets[] = $match_bracket;
            $step++;
        }
            
        // Generar las rondas siguientes sin asignar los participantes
        $athletesForRound = ceil(count($athletes)/2);
        for ($phase = 2; $phase <= $numberPhase; $phase++) {
          $athletesForRound = ceil($athletesForRound / 2);
            for ($i=0; $i < $athletesForRound; $i++) { 
                // Guardar enfrentamiento en la base de datos
                $match_bracket = MatchBracket::create([
                    'event_id' => $event_id,
                    'one_athlete_id' => null,
                    'two_athlete_id' => null,
                    'quadrilateral' => $quadrilateral,
                    'score_one_athlete' => 0,
                    'score_two_athlete' => 0,
                    'entry_category_id' => $entry_category_id,
                    'match_timer' => $match_timer,
                ]);

                // Guardar llave en la base de datos
                $brackets[] = Bracket::create([
                    'match_bracket_id' => $match_bracket->id,
                    'number_phase' => $phase,
                    'phase' => $this->getNamePhase($phase, $numberPhase),
                    'step' => $i + 1,
                    'status' => 'pendiente'
                ]);
                
                $match_brackets[] = $match_bracket;

            }
        }

        return ['match_brackets' => $match_brackets, 'brackets' => $brackets];
    }

    private function DoubleElimination($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer) {
        $match_brackets = [];
        $brackets = [];

        shuffle($athletes);
        $numeroFases = $this->calcularFases(count($athletes));

        $phase = 1;
        $phaseLosers = 1;

        $athletesLosers = [];

        while (count($athletes) > 1 || count($athletesLosers) > 1) {
            if (count($athletes) > 1) {
                for ($i = 0; $i < count($athletes); $i += 2) {
                    $participante1 = $athletes[$i];
                    $participante2 = $athletes[$i + 1] ?? null;

                    // Guardar enfrentamiento en la base de datos
                    $match_bracket = MatchBracket::create([
                        'event_id' => $event_id,
                        'one_athlete_id' => $participante1,
                        'two_athlete_id' => $participante2,
                        'quadrilateral' => $quadrilateral,
                        // 'date' => $date,
                        'score_one_athlete' => 0,
                        'score_two_athlete' => 0,
                        'match_timer' => $match_timer,
                    ]);

                    // Guardar llave en la base de datos
                    $brackets[] = Bracket::create([
                        'match_bracket_id' => $match_bracket->id,
                        'number_phase' => $phase,
                        'phase' => $phase,
                        'step' => floor($i/2)+1,
                        'status' => 'pendiente'
                    ]);

                    $match_brackets[] = $match_bracket;

                    if ($participante2 !== null) {
                        $athletesLosers[] = $participante2; // Supongamos que el segundo participante pierde
                    }
                }

                $athletes = array_slice($athletes, 0, ceil(count($athletes) / 2));
                $phase++;
            }

            if (count($athletesLosers) > 1) {
                for ($i = 0; $i < count($athletesLosers); $i += 2) {
                    $participante1 = $athletesLosers[$i];
                    $participante2 = $athletesLosers[$i + 1] ?? null;

                      // Guardar enfrentamiento en la base de datos
                    $match_bracket = MatchBracket::create([
                        'event_id' => $event_id,
                        'one_athlete_id' => $participante1,
                        'two_athlete_id' => $participante2,
                        'quadrilateral' => $quadrilateral,
                        // 'date' => $date,
                        'score_one_athlete' => 0,
                        'score_two_athlete' => 0,
                        'match_timer' => $match_timer,
                    ]);

                    // Guardar llave en la base de datos
                    $brackets[] = Bracket::create([
                        'match_bracket_id' => $match_bracket->id,
                        'number_phase' => $phase,
                        'phase' => 'Losers ' . $phaseLosers,
                        'step' => floor($i/2)+1,
                        'status' => 'pendiente',
                    ]);

                    $match_brackets[] = $match_bracket;
                }

                $athletesLosers = array_slice($athletesLosers, 0, ceil(count($athletesLosers) / 2));
                $phaseLosers++;
            }
        }

        return ['match_brackets' => $match_brackets, 'brackets' => $brackets];
    }

    private function roundRobin($athletes, $evento_id, $quadrilateral, $date, $entry_category_id, $match_timer) {
        $match_brackets = [];
        $brackets = [];

        for ($i = 0; $i < count($athletes); $i++) {
            for ($j = $i + 1; $j < count($athletes); $j++) {
                 // Guardar enfrentamiento en la base de datos
                $match_bracket = MatchBracket::create([
                    'event_id' => $event_id,
                    'one_athlete_id' => $participante1,
                    'two_athlete_id' => $participante2,
                    'quadrilateral' => $quadrilateral,
                    // 'date' => $date,
                    'score_one_athlete' => 0,
                    'score_two_athlete' => 0,
                    'match_timer' => $match_timer,
                ]);

                // Guardar llave en la base de datos              
    
                $brackets[] = Bracket::create([
                    'match_bracket_id' => $match_bracket->id,
                    'number_phase' => 1,
                    'phase' => "Round Robin",
                    'step' => 1,
                    'status' => 'pendiente',
                ]);

                $match_brackets[] = $match_bracket;
            }
        }

        return ['match_brackets' => $match_brackets, 'brackets' => $brackets];
    }

    private function getNamePhase($phase, $numberPhase) {
        switch ($phase) {
            case $numberPhase:
                return 'Final';
            case $numberPhase - 1:
                return 'Semifinal';
            case $numberPhase - 2:
                return 'Cuartos de Final';
            default:
                return 'Eliminatorias';
        }
    }

    public function finishMatchBracket(Request $request) {
       
        $match_bracket_id = $request->input('match_bracket_id');
        $puntaje_1 = $request->input('score_one_athlete');
        $puntaje_2 = $request->input('score_two_athlete');
        $winner = $request->input('athlete_id_winner');
        $loser = $request->input('athlete_id_loser');
        $match_timer = $request->input('match_timer');
       
        $match_bracket = MatchBracket::findOrFail($match_bracket_id);
        
        $bracket = Bracket::where('match_bracket_id', $match_bracket_id)
            ->update([
                'status' => 'finalizado'
            ]);

        $match_bracket->score_one_athlete = $puntaje_1;
        $match_bracket->score_two_athlete = $puntaje_2;
        $match_bracket->athlete_id_winner = $winner;
        $match_bracket->athlete_id_loser = $loser;
        $match_bracket->match_timer = $match_timer;

        $match_bracket->save();

        // Lógica para actualizar los enfrentamientos futuros según el ganador
        $this->generateNextPhase($match_bracket, $winner);

        return response()->json(['message' => 'Resultado actualizado correctamente', 'data' => $match_bracket]);
    }

    private function generateNextPhase($match_bracket, $winner){
        $bracket = Bracket::where('match_bracket_id', $match_bracket->id)->first();
        $nextMatchBracket = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
            ->where('brackets.number_phase', $bracket->number_phase + 1)
            ->where('brackets.status', 'pendiente')    
            ->first();

        if($nextMatchBracket){

            
            if($nextMatchBracket->one_athlete_id === null){
                $nextMatchBracket->one_athlete_id = $winner;
            } elseif ($nextMatchBracket->two_athlete_id === null) {
                $nextMatchBracket->two_athlete_id = $winner;
            } else if($nextMatchBracket->one_athlete_id && $nextMatchBracket->two_athlete_id) {
                
                $nextMatchBracketStep = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
                    ->whereNull('one_athlete_id')
                    ->whereNull('two_athlete_id')
                    ->where('brackets.number_phase', $bracket->number_phase + 1)
                    ->where('brackets.status', 'pendiente')    
                    ->first();

                    if($nextMatchBracketStep->one_athlete_id === null){
                        $nextMatchBracketStep->one_athlete_id = $winner;
                    } elseif ($nextMatchBracketStep->two_athlete_id === null) {
                        $nextMatchBracketStep->two_athlete_id = $winner;
                    }
                    $nextMatchBracketStep->save();
                    return;
            } 

            

            $nextMatchBracket->save();
            return;
        }  
        // $currentNumberPhase = $bracket->number_phase;
        // $currentStep = $bracket->step;
    
        // while (true) {
        //     // Buscar el siguiente `step` dentro del mismo `number_phase`
        //     $nextMatchBracket = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        //         ->where('brackets.number_phase', $currentNumberPhase)
        //         ->where('brackets.step', $currentStep + 1)  // Busca el siguiente step
        //         ->where('brackets.status', 'pendiente')
        //         ->first();
    
        //     if ($nextMatchBracket) {
        //         // Si se encuentra un `MatchBracket` con al menos una posición vacía, asignar el ganador
        //         if ($nextMatchBracket->one_athlete_id === null) {
        //             $nextMatchBracket->one_athlete_id = $winner;
        //             $nextMatchBracket->save();
        //             break;
        //         } elseif ($nextMatchBracket->two_athlete_id === null) {
        //             $nextMatchBracket->two_athlete_id = $winner;
        //             $nextMatchBracket->save();
        //             break;
        //         } else {
        //             // Si ambos lugares están ocupados, pasa al siguiente `step`
        //             $currentStep++;
        //         }
        //     } else {
        //         // Si no hay más `steps` en el `number_phase` actual, avanzar al siguiente `number_phase`
        //         $currentNumberPhase++;
        //         $currentStep = 1; // Reiniciar el step para el nuevo `number_phase`
    
        //         // Buscar el primer `step` del nuevo `number_phase`
        //         $nextMatchBracket = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        //             ->where('brackets.number_phase', $currentNumberPhase)
        //             ->where('brackets.step', $currentStep)
        //             ->where('brackets.status', 'pendiente')
        //             ->first();
    
        //         if ($nextMatchBracket) {
        //             // Asegurarse de que el `MatchBracket` no esté vacío antes de asignar el ganador
        //             if ($nextMatchBracket->one_athlete_id === null || $nextMatchBracket->two_athlete_id === null) {
        //                 if ($nextMatchBracket->one_athlete_id === null) {
        //                     $nextMatchBracket->one_athlete_id = $winner;
        //                 } elseif ($nextMatchBracket->two_athlete_id === null) {
        //                     $nextMatchBracket->two_athlete_id = $winner;
        //                 }
        //                 $nextMatchBracket->save();
        //                 break;
        //             } else {
        //                 // Si ambos lugares están ocupados, incrementa el `step` para seguir buscando
        //                 $currentStep++;
        //             }
        //         } else {
        //             // Si no hay más enfrentamientos pendientes en ningún `number_phase`, terminar el bucle
        //             break;
        //         }
        //     }
        // }
    
        // if (!$nextMatchBracket) {
        //     return response()->json(['error' => 'No hay enfrentamientos pendientes disponibles para asignar al ganador.'], 400);
        // }

        
        // $bracket = Bracket::where('match_bracket_id', $match_bracket->id)        
        //         ->first();

        // $numberphaseStep = DB::table('brackets')
        //     ->select('number_phase', DB::raw('MAX(step) as max_step'))
        //     // ->where('number_phase', $bracket->number_phase)
        //     ->groupBy('number_phase')
        //     ->get();

        //     // echo "<pre>";
        //     // print_r($numberphaseStep);
        //     // echo "</pre>";
            
        //     foreach ($numberphaseStep as $value) {
                
        //         $nextMatchBracket = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
        //             ->where('brackets.number_phase', $value->number_phase)
        //             ->where('brackets.step', $value->max_step)
        //             ->where('brackets.status', 'pendiente')
        //             ->whereNull('one_athlete_id')
        //             ->orWhereNull('two_athlete_id')
        //             ->first();
        //             // if(){

        //             // }
                
        //         // echo "np= ".$i." step= ".$j;
        //         echo "<pre>";
        //         print_r($nextMatchBracket);
        //         echo "</pre>";
        //     }
           

    }


}
