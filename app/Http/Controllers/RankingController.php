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
            Ranking::updateOrInsert(
                [],
                []
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function showAllRanking()  {

        return response()->json($data, 200);
    }

  
}
