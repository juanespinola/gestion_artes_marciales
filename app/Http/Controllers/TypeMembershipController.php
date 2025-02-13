<?php

namespace App\Http\Controllers;

use App\Models\TypeMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->BearerToken()) {

                if (isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)) {
                    $data = TypeMembership::where('federation_id', auth()->user()->federation_id)
                        ->where('association_id', null)
                        ->orderBy('id', 'asc')
                        ->get();

                    return response()->json($data, 200);
                }

                if (isset(auth()->user()->federation_id) && isset(auth()->user()->association_id)) {
                    $data = TypeMembership::where('federation_id', auth()->user()->federation_id)
                        ->where('association_id', auth()->user()->association_id)
                        ->orderBy('id', 'asc')
                        ->get();
                    return response()->json($data, 200);
                }

                // $data = TypeMembership::where("athlete_id", $athlete_id)
                //     ->get();
                // return response()->json($data, 200);
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
                    'price' => 'required|integer',
                    'total_number_fee' => 'required|integer',
                    'status' => 'required',
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                    'price.required' => ':attribute: es Obligatorio',
                    'total_number_fee.required' => ':attribute: es Obligatorio',
                    'status.required' => ':attribute: es Obligatorio',
                           
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            // queda trabajar en las fechas, en el formateo
            $obj = TypeMembership::create([
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'total_number_fee' => $request->input('total_number_fee'),
                'status' => $request->input('status'),
                'federation_id' => auth()->user()->federation_id,
                'association_id' => auth()->user()->association_id,
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeMembership $typeMembership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = TypeMembership::findOrFail($id);
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
                    'price' => 'required|integer',
                    'total_number_fee' => 'required|integer',
                    'status' => 'required',
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                    'price.required' => ':attribute: es Obligatorio',
                    'total_number_fee.required' => ':attribute: es Obligatorio',
                    'status.required' => ':attribute: es Obligatorio',
                           
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = TypeMembership::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'total_number_fee' => $request->input('total_number_fee'),
                'status' => $request->input('status'),
                'federation_id' => auth()->user()->federation_id,
                'association_id' => auth()->user()->association_id,
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
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
        
            $obj = TypeMembership::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
