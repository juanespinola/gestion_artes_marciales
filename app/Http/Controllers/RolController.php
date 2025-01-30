<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;


class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = Role::all()->load('permissions');
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
                    'name' => 'required|string',
                ],
                [
                    'name.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Role::create([
                'name' => $request->input('name'),
                'guard_name' => "admins"
            ]);
            $obj->givePermissionTo($request->input('rolePermissionArray'));


            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $roles = Role::findOrFail($id)->load('permissions');
            $permissions = Permission::latest()->get();

            $data = new \stdClass();
            $data->roles = $roles;
            $data->permissions = $permissions;
            
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
                ],
                [
                    'name.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Role::findOrFail($id);
            $obj->update([
                'name' => $request->input('name'),
            ]);
            // $obj->revokePermissionTo($request->input('rolePermissionArray'));
            $obj->givePermissionTo($request->input('rolePermissionArray'));

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
        
            $obj = Role::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}


// select r."name" , p."name" , p.group_name 
// from roles r
// join role_has_permissions rhp on r.id = rhp.role_id 
// join permissions p on rhp.permission_id = p.id 
