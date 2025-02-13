<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\BeltHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeltHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = BeltHistory::with('belt')
                    ->where('athlete_id', auth()->user()->id)
                    ->get();
                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
                        'belt_id.required' => ':attribute: es Obligatorio',
                        'athlete_id.required' => ':attribute: es Obligatorio',
                        'federation_id.required' => ':attribute: es Obligatorio',
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

                // $athlete = Athlete::findOrFail($request->input('athlete_id'));
                // $athlete->update([
                //     'belt_id' => $request->input('belt_id'),
                // ]);

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

    /**
     * Display the specified resource.
     */
    public function show(BeltHistory $beltHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        try {
            if($request->BearerToken()){
                $data = BeltHistory::with('belt')
                    ->findOrFail($id);
                    
                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
                        'belt_id.required' => ':attribute: es Obligatorio',
                        'athlete_id.required' => ':attribute: es Obligatorio',
                        'federation_id.required' => ':attribute: es Obligatorio',
                    ]
                );
    
                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }
    
                // $existBelt = BeltHistory::where([
                //     ['belt_id', $request->input('belt_id')],
                //     ['athlete_id', $request->input('athlete_id')],
                // ])->first();
                
                // if($existBelt){
                //     return response()->json(["messages" => "Ya cuentas con ese cinturón"], 400);
                // }

                $obj = BeltHistory::findOrFail($id);
                // $athlete->update([
                //     'belt_id' => $request->input('belt_id'),
                // ]);

                $obj->update([
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeltHistory $beltHistory)
    {
        //
    }
}
