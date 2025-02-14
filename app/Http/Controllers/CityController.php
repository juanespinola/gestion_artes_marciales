<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $country_id)
    {
        try {
            if($request->BearerToken()){
                $data = City::where('country_id', $country_id)
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
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'description' => 'required|string',
                    'status' => 'required',
                    'country_id' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                    'status.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = City::create([
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'country_id' => $request->input('country_id'),
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = City::findOrFail($id);
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
                    'status' => 'required',
                    'country_id' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                    'status.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = City::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'country_id' => $request->input('country_id'),
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
        
            $obj = City::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getCities(Request $request)
    {
        try {
            if($request->input('city_id')){
                $data = City::findOrFail($request->input('city_id'));
                return response()->json($data, 200);
            }
            if($request->input('country_id')){
                $data = City::where('country_id', $request->input('country_id'))
                    ->get();
                return response()->json($data, 200);
            }
            $data = City::get();
            return response()->json($data, 200);
           
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
