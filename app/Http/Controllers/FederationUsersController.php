<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FederationUsersController extends Controller
{
    public function index(){
        try {
            $data = User::with('federation')
            ->whereNotNull('federation_id')
            ->whereNull('association_id')
            ->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            if($request->BearerToken()){
             
                $validation = Validator::make(
                    $request->all(), 
                    [
                        'name' => 'required|string',
                        'email' => 'required|string',
                        'password' => 'required|string',
                        'rol' => 'required',
                    ],
                    [
                        'name.required' => ':attribute: es Obligatorio',
                        'email.required' => ':attribute: es Obligatorio',
                        'password.required' => ':attribute: es Obligatorio',
                        'rol.required' => ':attribute: es Obligatorio',
                    ]
                );

                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $obj = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'association_id' => null,
                    'federation_id' =>  $request->federation_id,
                ]);

               
                foreach ($request->input('rol') as $rol) {
                    $obj->assignRole($rol["name"]);
                }
                
                return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function edit(string $id)
    {
        try {
            $data = User::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, string $id)
    {
        try {
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'name' => 'required|string',
                    'email' => 'required|string',
                    // 'password' => 'required|string',
                    'rol' => 'required',
                    

                ],
                [
                    'name.required' => ':attribute: es Obligatorio',
                    'email.required' => ':attribute: es Obligatorio',
                    // 'password.required' => ':attribute: es Obligatorio',
                    'rol.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = User::findOrFail($id);
            $obj->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                // 'password' => $request->input('password'),
                'association_id' => null,
                'federation_id' => $request->federation_id,
            ]);

            foreach ($request->input('rol') as $rol) {
                $obj->assignRole($rol["name"]);
            }

            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(string $id)
    {
        try {
        
            $obj = User::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
