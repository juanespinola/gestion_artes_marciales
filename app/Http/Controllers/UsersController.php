<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->BearerToken()){
            $user = auth()->user();
            if (!$user->hasPermissionTo("user.access")) {
                return response()->json(['Unauthorized, you don\'t have access.'],400);
            }

            if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                $data = User::where('federation_id', auth()->user()->federation_id)
                ->where('association_id', null)
                ->get();

                return response()->json($data, 200);    
            }

            if( isset(auth()->user()->federation_id) && isset(auth()->user()->association_id) ){
                $data = User::where('federation_id', auth()->user()->federation_id)
                ->where('association_id', auth()->user()->association_id)
                ->get();

                return response()->json($data, 200);    
            }

            $data = User::all();
            return response()->json($data, 200);
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
                $user = Auth::user();
                $association_id = $request->association_id;
                if (!$user->hasPermissionTo("user.update")) {
                    return response()->json(['Unauthorized, you don\'t have access.'],400);
                }
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

                if($association_id){
                    $obj = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => $request->input('password'),
                        'association_id' => $association_id,
                        'federation_id' => auth()->user()->federation_id,
                    ]);
                } else {
                    $obj = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => $request->input('password'),
                        'association_id' => auth()->user()->association_id ? auth()->user()->association_id : null,
                        'federation_id' => auth()->user()->federation_id,
                    ]);
    
                }

               
                foreach ($request->input('rol') as $rol) {
                    $obj->assignRole($rol["name"]);
                }
                
                return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = User::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = User::findOrFail($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
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
                'association_id' => auth()->user()->association_id ? auth()->user()->association_id : null,
                'federation_id' => auth()->user()->federation_id,
            ]);

            foreach ($request->input('rol') as $rol) {
                $obj->assignRole($rol["name"]);
            }

            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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


    public function getProfile(Request $request){
        $data = User::findOrFail(auth()->user()->id);

        return response()->json($data, 200);
    }

    public function updateProfile(Request $request){
        try {
            if($request->BearerToken()){
                $validation = Validator::make(
                    $request->all(), 
                    [
                        'name' => 'required|string',
                        'email' => 'required|string',
                    ],
                    [
                        'name.required' => ':attribute: es Obligatorio',
                        'email.required' => ':attribute: es Obligatorio',
                    ]
                );
    
                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }
    
                $obj = User::findOrFail(auth()->user()->id);
                $obj->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                ]);
    
                return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }



}
