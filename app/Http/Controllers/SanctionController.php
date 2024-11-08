<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanction;
use Illuminate\Support\Facades\Validator;

class SanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $athlete_id)
    {
        try {
            if($request->BearerToken()){
                
                $data = Sanction::where("athlete_id", $athlete_id)
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
        // if($request->input('athlete_id')){

        //     try {
        //         if($request->BearerToken()){
                    
        //             $data = Sanction::where("athlete_id", $request->input('athlete_id'))
        //                 ->get();
        //             return response()->json($data, 200);
        //         }

        //     } catch (\Throwable $th) {
        //         throw $th;
        //     }
        // }
        
        
        try {
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'description' => 'required|string',
                    'comments' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: is Required',
                    'comments.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Sanction::create([
                'athlete_id' => $request->input('athlete_id'),
                'description' => $request->input('description'),
                'comments' => $request->input('comments'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = Sanction::findOrFail($id);
            return response()->json($data, 200);
    
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
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'description' => 'required|string',
                    'comments' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: is Required',
                    'comments.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Sanction::findOrFail($id);
            $obj->update([
                'athlete_id' => $request->input('athlete_id'),
                'description' => $request->input('description'),
                'comments' => $request->input('comments'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $obj = Sanction::findOrFail($id);
            $obj->delete();
    
            return response()->json($obj, 200);

        }  catch (\Throwable $th) {
            throw $th;
        } 
    }
}
