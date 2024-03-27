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
            $user = Auth::user();
            if (!$user->hasPermissionTo("user.access")) {
                return response()->json(['Unauthorized, you don\'t have access.'],400);
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
                if (!$user->hasPermissionTo("edit user")) {
                    return response()->json(['Unauthorized, you don\'t have access.'],400);
                }
                $validation = Validator::make(
                    $request->all(), 
                    [
                        'description' => 'required|string',
                    ],
                    [
                        'description.required' => ':attribute: is Required',
                    ]
                );

                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                
                $obj = User::create([
                    'description' => $request->input('description'),
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
                    'description' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = User::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
            ]);

            return response()->json($obj, 201);
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
    
            return response()->json($obj, 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
