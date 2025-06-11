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
            // if ($request->BearerToken()) {
            $matchBrackets = MatchBracket::with('bracket', 'athleteOne', 'athleteTwo')
                ->where([
                    ['entry_category_id', $request->input('entry_category_id')],
                    ['event_id', $request->input('event_id')],
                ])
                ->orderBy('id')
                ->get()
                ->groupBy('bracket.number_phase') // Agrupamos por fase
                ->map(function ($group) {
                    return [
                        'number_phase' => $group->first()->bracket->number_phase,
                        'phase' => $group->first()->bracket->phase,
                        'matches' => $group
                    ];
                })
                ->values()
                ->toArray();

            $threeBracket = $this->generateBracketTree($matchBrackets);
            // $data = $this->groupTreeByPhase($threeBracket);


            return response()->json($threeBracket, 200);

            // }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function generateBracketTree(array $phases): ?array
    {
        $phaseMap = [];

        // Indexamos por número de fase
        foreach ($phases as $phase) {
            $phaseMap[$phase['number_phase']] = $phase['matches'];
        }

        // Función recursiva para construir el árbol
        $buildTree = function ($phaseNumber, $step, $parent = null) use (&$buildTree, $phaseMap) {
            if (!isset($phaseMap[$phaseNumber])) {
                return null;
            }

            $matches = $phaseMap[$phaseNumber];

            $match = collect($matches)->first(function ($m) use ($step) {
                return $m['bracket']['step'] === $step;
            });

            if (!$match) {
                return null;
            }

            $name = isset($match['athlete_one'], $match['athlete_two'])
                ? $match['athlete_one']['name'] . ' vs ' . $match['athlete_two']['name']
                : 'Esperando ganador (Fase ' . $match['bracket']['phase'] . ')';

            $children = [];

            if ($phaseNumber > 1) {
                $prevStepA = ($step - 1) * 2 + 1;
                $prevStepB = ($step - 1) * 2 + 2;

                $childA = $buildTree($phaseNumber - 1, $prevStepA, $match);
                $childB = $buildTree($phaseNumber - 1, $prevStepB, $match);

                if ($childA) $children[] = $childA;
                if ($childB) $children[] = $childB;
            }

            return [
                'phase' => $match['bracket']['phase'],
                'name' => $name,
                'match' => $match,
                'parent' => $parent, // ← Aquí se incluye el padre
                'children' => $children,
            ];
        };

        $maxPhase = max(array_keys($phaseMap));

        return $buildTree($maxPhase, 1);
    }

    function groupTreeByPhase(array $tree): array
    {
        $grouped = [];

        // Función recursiva para recorrer el árbol
        $traverse = function ($node) use (&$grouped, &$traverse) {
            $phase = $node['phase'];

            // Si no existe el grupo de esta fase, lo creamos
            if (!isset($grouped[$phase])) {
                $grouped[$phase] = [];
            }

            // Copiamos el nodo sin children por ahora
            $currentNode = $node;
            $currentNode['children'] = []; // Evitamos duplicar hijos

            // Lo agregamos al grupo correspondiente
            $grouped[$phase][] = $currentNode;

            // Ahora procesamos los children de forma recursiva
            foreach ($node['children'] as $child) {
                $traverse($child);
            }
        };

        $traverse($tree);

        return $grouped;
    }

    public function checkMathBracket(Request $request)
    {
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


    public function generateMatchBrackets(Request $request)
    {
        try {
            $athletes = $request->input('athlete');
            $type_bracket = $request->input('type_bracket'); // 'round_robin', 'single_elimination', 'double_elimination'
            $event_id = $request->input('event_id');
            $quadrilateral = $request->input('quadrilateral');
            $entry_category_id = $request->input('entry_category_id');
            $match_timer = $request->input('match_timer');
            $date = now();

            $data = $this->generateMatchBracketsByType($athletes, $type_bracket, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $data], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function generateMatchBracketsByType($athletes, $type_bracket, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer)
    {
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

    private function calcularFases($numeroAtletas)
    {
        return ceil(log($numeroAtletas, 2));
    }

    private function singleEliminationBracketWithoutBronceFight($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer)
    {
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
        $athletesForRound = ceil(count($athletes) / 2);
        for ($phase = 2; $phase <= $numberPhase; $phase++) {
            $athletesForRound = ceil($athletesForRound / 2);
            for ($i = 0; $i < $athletesForRound; $i++) {
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

    private function DoubleElimination($athletes, $event_id, $quadrilateral, $date, $entry_category_id, $match_timer)
    {
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
                        'step' => floor($i / 2) + 1,
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
                        'step' => floor($i / 2) + 1,
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

    private function roundRobin($athletes, $evento_id, $quadrilateral, $date, $entry_category_id, $match_timer)
    {
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

    private function getNamePhase($phase, $numberPhase)
    {
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

    public function finishMatchBracket(Request $request)
    {
        $match_bracket = MatchBracket::findOrFail($request->input('match_bracket_id'));

        // Actualizar los datos del combate
        $match_bracket->update([
            'score_one_athlete'  => $request->input('score_one_athlete'),
            'score_two_athlete'  => $request->input('score_two_athlete'),
            'athlete_id_winner'  => $request->input('athlete_id_winner'),
            'athlete_id_loser'   => $request->input('athlete_id_loser'),
            'match_timer'        => $request->input('match_timer'),
            'victory_type_id'    => $request->input('victory_type_id'),
        ]);

        // Marcar el bracket como finalizado
        Bracket::where('match_bracket_id', $match_bracket->id)->update(['status' => 'finalizado']);

        // Generar el siguiente enfrentamiento
        $next = $this->generateNextPhase($match_bracket);

        return response()->json(['message' => 'Resultado actualizado correctamente', 'data' => $next]);
        // return response()->json(['message' => 'Resultado actualizado correctamente', 'data' => $match_bracket]);
    }

    private function generateNextPhase($match_bracket)
    {
        // Obtener el Bracket actual
        $bracket = Bracket::where('match_bracket_id', $match_bracket->id)->firstOrFail();

        // Buscar el siguiente combate en la siguiente fase con espacio libre
        $nextMatchBracket = MatchBracket::join('brackets', 'match_brackets.id', '=', 'brackets.match_bracket_id')
            ->where('brackets.number_phase', $bracket->number_phase + 1)
            ->where('brackets.status', 'pendiente')
            ->where(function ($query) {
                $query->whereNull('match_brackets.one_athlete_id')
                    ->orWhereNull('match_brackets.two_athlete_id');
            })
            ->orderBy('brackets.step') // Asegurar que se asigna al primer combate disponible
            ->select('match_brackets.*')
            ->first();

        // return $nextMatchBracket;
        if ($nextMatchBracket) {
            if (is_null($nextMatchBracket->one_athlete_id)) {
                $nextMatchBracket->one_athlete_id = $match_bracket->athlete_id_winner;
            } else {
                $nextMatchBracket->two_athlete_id = $match_bracket->athlete_id_winner;
            }
            $nextMatchBracket->save();
        }
    }
}
