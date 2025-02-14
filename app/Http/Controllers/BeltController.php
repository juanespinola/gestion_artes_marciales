<?php

namespace App\Http\Controllers;

use App\Models\Belt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = Belt::where('federation_id', auth()->user()->federation_id)->get();
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
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'color' => 'required|string',
                    'color_hexadecimal' => 'required',
                ],
                [
                    'color.required' => ':attribute: es Obligatorio',
                    'color_hexadecimal.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Belt::create([
                'color' => $request->input('color'),
                'color_hexadecimal' => $request->input('color_hexadecimal'),
                'federation_id' => auth()->user()->federation_id
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Belt $belt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = Belt::findOrFail($id);
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
                    'color' => 'required|string',
                    'color_hexadecimal' => 'required',
                ],
                [
                    'color.required' => ':attribute: es Obligatorio',
                    'color_hexadecimal.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Belt::findOrFail($id);
            $obj->update([
                'color' => $request->input('color'),
                'color_hexadecimal' => $request->input('color_hexadecimal'),
                'federation_id' => auth()->user()->federation_id
            ]);

            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
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
        
            $obj = Belt::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getBelts(Request $request) {
        try {
            // if($request->BearerToken()){
                $data = Belt::where('federation_id', $request->input('federation_id'))
                    ->get();
                return response()->json($data, 200);
            // }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
