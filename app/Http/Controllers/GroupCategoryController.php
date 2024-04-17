<?php

namespace App\Http\Controllers;

use App\Models\GroupCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                
                if (!auth()->user()->hasPermissionTo('groupcategory.access')) {
                    return response()->json(['Unauthorized, you don\'t have access.'], 400);
                }

                if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                    $data = GroupCategory::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', null)
                    ->with(['category', 'federation', 'association'])
                    ->get();
    
                    return response()->json($data, 200);    
                }
    
                if( isset(auth()->user()->federation_id) && isset(auth()->user()->association_id) ){
                    $data = GroupCategory::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', auth()->user()->association_id)
                    ->with(['category', 'federation', 'association'])
                    ->get();
    
                    return response()->json($data, 200);    
                }

                $data = GroupCategory::with(['category', 'federation', 'association'])->get();
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
                    'group_category' => 'required|string',
                    'initial_value' => 'required|string',
                    'final_value' => 'required|string',
                    'category_id' => 'required|integer',
                   
                ],
                [
                    'group_category.required' => ':attribute: is Required',
                    'initial_value.required' => ':attribute: is Required',
                    'final_value.required' => ':attribute: is Required',
                    'category_id.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = GroupCategory::create([
                'group_category' => $request->input('group_category'),
                'initial_value' => $request->input('initial_value'),
                'final_value' => $request->input('final_value'),
                'category_id' => $request->input('category_id'),
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
    public function show(GroupCategory $groupCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = GroupCategory::findOrFail($id);
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
                    'group_category' => 'required|string',
                    'initial_value' => 'required|string',
                    'final_value' => 'required|string',
                    'category_id' => 'required|integer',
                   
                ],
                [
                    'group_category.required' => ':attribute: is Required',
                    'initial_value.required' => ':attribute: is Required',
                    'final_value.required' => ':attribute: is Required',
                    'category_id.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = GroupCategory::findOrFail($id);
            $obj->update([
                'group_category' => $request->input('group_category'),
                'initial_value' => $request->input('initial_value'),
                'final_value' => $request->input('final_value'),
                'category_id' => $request->input('category_id'),
                'federation_id' => auth()->user()->federation_id,
                'association_id' => auth()->user()->association_id,
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
        
            $obj = GroupCategory::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
