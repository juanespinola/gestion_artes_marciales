<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\BeltHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AthleteController extends Controller
{
    
    public function getProfile(Request $request){
        $data = Athlete::with('belt')
            ->findOrFail(auth()->user()->id);
        return response()->json($data, 200);
    }

    public function updateBeltHistory(Request $request){
        try {
            if($request->BearerToken()){
                $validation = Validator::make(
                    $request->all(), 
                    [
                        'belt_id' => 'required|integer',
                        'athlete_id' => 'required|integer',
                        'federation_id' => 'required|integer',

                    ],
                    [
                        'belt_id.required' => ':attribute: is Required',
                        'athlete_id.required' => ':attribute: is Required',
                        'federation_id.required' => ':attribute: is Required',
                    ]
                );
    
                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }
    
                $existBelt = BeltHistory::where([
                    ['belt_id', $request->input('belt_id')],
                    ['athlete_id', $request->input('athlete_id')],
                ])->first();
                
                if($existBelt){
                    return response()->json(["messages" => "Ya cuentas con ese cinturón"], 400);
                }

                $athlete = Athlete::findOrFail($request->input('athlete_id'));
                $athlete->update([
                    'belt_id' => $request->input('belt_id'),
                ]);

                $obj = BeltHistory::create([
                    'belt_id' => $request->input('belt_id'),
                    'athlete_id' => $request->input('athlete_id'),
                    'federation_id' => $request->input('federation_id'),
                    'achieved' => $request->input('achieved') ? Carbon::parse($request->input('achieved'))->format('Y-m-d') : null,
                    'promoted_by' => $request->input('promoted_by'),
                ]);


    
                return response()->json($obj, 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
