<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = Permission::all();
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
                    'group_name'=> 'required|string',
                ],
                [
                    'name.required' => ':attribute: es Obligatorio',
                    'group_name.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Permission::create([
                'name' => $request->input('name'),
                'guard_name' => "web",
                'group_name'=>$request->input('group_name'),
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
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
            $data = Permission::findOrFail($id);
            return response()->json($data, 200);
        // }
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
                    'group_name'=> 'required|string',
                ],
                [
                    'name.required' => ':attribute: es Obligatorio',
                    'group_name.required' => ':attribute: es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Permission::findOrFail($id);
            $obj->update([
                'name' => $request->input('name'),
                'guard_name' => "admins",
                'group_name'=>$request->input('group_name'),
            ]);

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
        
            $obj = Permission::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPermissionsByGroup() {
        try {
            $permissionsByGroup = DB::table('permissions')
                ->select('group_name', DB::raw('JSON_AGG(JSON_BUILD_OBJECT(\'name\', name, \'id\', id)) as permissions'))
                ->orderBy('group_name')
                ->groupBy('group_name')
                ->get()
                ->map(function ($item) {
                    return [
                        'group_name' => $item->group_name,
                        'permissions' => json_decode($item->permissions, true)
                    ];
                })
                ->toArray();
    
            return response()->json($permissionsByGroup, 200);
        } catch(\Throwable $th) {
            throw $th;
        }
    }

    public function getPermissionsByGroupName($group_name) {
        try {
            $obj= DB::table('permissions')
                ->select('name','id')
                ->where('group_name', $group_name)
                ->get();
            return response()->json($obj, 200);
        } catch(\Throwable $th) {
            throw $th;
        }
    }
}
