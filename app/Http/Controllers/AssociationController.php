<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        try {
            if($request->BearerToken()){
                $user = auth()->user();
                if (!$user->hasPermissionTo("association.access")) {
                    return response()->json(['Unauthorized, you don\'t have access.'],400);
                }
                if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                    $data = Association::where('federation_id', auth()->user()->federation_id)
                    ->get();
    
                    return response()->json($data, 200);    
                }

                $data = Association::all();
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
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Association::create([
                'description' => $request->input('description'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
                'federation_id' => auth()->user()->federation_id,
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
                $data = Association::findOrFail($id);
                return response()->json($data, 200);
            // }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Association $association)
    {
        //
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
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Association::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
                'federation_id' => auth()->user()->federation_id,
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
        
            $obj = Association::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!", "data" => $obj], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update_authorities(Request $request, $id)
    {
        try {

            $obj = Federation::findOrFail($id);
            $obj->update([
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update_contacts(Request $request, $id)
    {
        try {

            $obj = Federation::findOrFail($id);
            $obj->update([
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


        // funcion para obtener federacion sin token, para login de athleta
        public function getAssociations($federation_id){
            return Association::where([
                    ['status', true],
                    ['federation_id', $federation_id]
                ])
                ->get();
        }
}
