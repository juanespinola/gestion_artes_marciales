<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $existingRanking = Ranking::where('athlete_id', $request->input('athlete_id'))
                        ->where('event_id', $request->input('event_id'))
                        ->where('entry_category_id', $request->input('entry_category_id'))
                        ->first();
        
            $existingPoints = $existingRanking->points ;
            $existingVictories = $existingRanking->victories;
            $existingDefeats = $existingRanking->defeats;
            // Determinar si se suma puntos y se incrementan victorias/derrotas
            if($request->input('type') == 'win'){
                $existingPoints = $existingPoints + 1;
                $existingVictories = $existingVictories + 1;
            }

            if($request->input('type') == 'lose'){
                $existingPoints = $existingPoints;
                $existingDefeats = $existingDefeats + 1;
            }

            
            // Usar updateOrInsert para actualizar o insertar los valores
            $data = Ranking::updateOrInsert(
                [
                    'athlete_id' => $request->input('athlete_id'), 
                    'event_id' => $request->input('event_id'), 
                    'entry_category_id' => $request->input('entry_category_id'),
                ],
                [
                    'position' => $request->input('position'), 
                    'points' => $existingPoints, 
                    'victories' => $existingVictories, 
                    'defeats' => $existingDefeats
                ]
            );
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function showAllRanking()  {

        return response()->json($data, 200);
    }

  
}
