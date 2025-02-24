<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;
use DB;

class RankingController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $data = Ranking::updateRanking();
            return response()->json(["messages" => "Ranking Actualizado", "data" => $data], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index(Request $request)
    {
        try {
            // $rankings = DB::table('rankings')
            //     ->join('entry_categories', 'rankings.entry_category_id', '=', 'entry_categories.id')
            //     ->join('belts', 'entry_categories.belt_id', '=', 'belts.id')
            //     ->join('athletes', 'rankings.athlete_id', '=', 'athletes.id')
            //     ->select(
            //         'belts.id as belt_id',
            //         DB::raw('LOWER(belts.color) as belt_color'),
            //         'entry_categories.id as category_id',
            //         DB::raw('LOWER(entry_categories.name) as category_name'),
            //         'rankings.athlete_id',
            //         'athletes.*',
            //         DB::raw('SUM(rankings.event_points) as total_points'),
            //         DB::raw('SUM(rankings.victories) as total_victories'),
            //         DB::raw('SUM(rankings.defeats) as total_defeats'),
            //         DB::raw('SUM(rankings.gold) as gold_medals'),
            //         DB::raw('SUM(rankings.silver) as silver_medals'),
            //         DB::raw('SUM(rankings.bronze) as bronze_medals')
            //     )
            //     ->groupBy(
            //         'belts.id',
            //         'belt_color',
            //         'entry_categories.id',
            //         'category_name',
            //         'rankings.athlete_id',
            //         'athletes.id'
            //     )
            //     ->orderBy('belts.id')
            //     ->orderBy('category_id')
            //     ->orderByDesc('total_points')
            //     ->get();

            $rankings = DB::table('rankings')
            ->selectRaw('
                belts.id AS belt_id, 
                LOWER(belts.color) AS belt_color, 
                entry_categories.id AS category_id, 
                LOWER(entry_categories.name) AS category_name, 
                rankings.athlete_id, 
                athletes.id AS athlete_id,
                athletes.name,
                athletes.profile_image, 
                SUM(rankings.event_points) AS total_points, 
                SUM(rankings.victories) AS total_victories, 
                SUM(rankings.defeats) AS total_defeats, 
                SUM(rankings.gold) AS gold_medals, 
                SUM(rankings.silver) AS silver_medals, 
                SUM(rankings.bronze) AS bronze_medals
            ')
            ->join('entry_categories', 'rankings.entry_category_id', '=', 'entry_categories.id')
            ->join('belts', 'entry_categories.belt_id', '=', 'belts.id')
            ->join('athletes', 'rankings.athlete_id', '=', 'athletes.id')
            ->groupBy([
                'belts.id', 
                'belts.color', 
                'entry_categories.id', 
                'entry_categories.name', 
                'rankings.athlete_id',
                'athletes.id',
                'athletes.name',
                'athletes.profile_image',
            ])
            ->orderBy('belts.id', 'asc')
            ->orderBy('category_id', 'asc')
            ->orderBy('total_points', 'desc')
            ->get();
        

            // Agrupar manualmente en PHP
            $grouped = [];

            foreach ($rankings as $ranking) {
                $beltKey = strtolower($ranking->belt_color);
                $categoryKey = strtolower($ranking->category_name);
                $athleteKey = $ranking->athlete_id;

                if (!isset($grouped[$beltKey])) {
                    $grouped[$beltKey] = [
                        // 'belt_id' => $ranking->belt_id,
                        'belt_color' => ucfirst($ranking->belt_color),
                        'categories' => []
                    ];
                }

                if (!isset($grouped[$beltKey]['categories'][$categoryKey])) {
                    $grouped[$beltKey]['categories'][$categoryKey] = [
                        // 'category_id' => $ranking->category_id,
                        'category_name' => ucfirst($ranking->category_name),
                        'athletes' => []
                    ];
                }

                // Agrupar atletas dentro de la categoría
                if (!isset($grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey])) {
                    $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey] = [
                        'athlete_id' => $ranking->athlete_id,
                        'athlete' => (object) [
                            'id' => $ranking->athlete_id,
                            'name' => $ranking->name,
                            'profile_image' => $ranking->profile_image,
                        ],
                        'total_points' => 0,
                        'total_victories' => 0,
                        'total_defeats' => 0,
                        'gold_medals' => 0,
                        'silver_medals' => 0,
                        'bronze_medals' => 0
                    ];
                }

                // Sumar los valores de cada atleta
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['total_points'] += $ranking->total_points;
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['total_victories'] += $ranking->total_victories;
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['total_defeats'] += $ranking->total_defeats;
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['gold_medals'] += $ranking->gold_medals;
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['silver_medals'] += $ranking->silver_medals;
                $grouped[$beltKey]['categories'][$categoryKey]['athletes'][$athleteKey]['bronze_medals'] += $ranking->bronze_medals;
            }

            // Convertir a array numérico en categorías y atletas
            foreach ($grouped as &$belt) {
                foreach ($belt['categories'] as &$category) {
                    $category['athletes'] = array_values($category['athletes']);
                }
                $belt['categories'] = array_values($belt['categories']);
            }

            $data = array_values($grouped);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
