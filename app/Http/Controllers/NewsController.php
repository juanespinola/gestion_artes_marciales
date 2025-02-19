<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                
                // if (!auth()->user()->hasPermissionTo('event.access')) {
                //     return response()->json(['Unauthorized, you don\'t have access.'], 400);
                // }

                if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                    $data = News::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', null)
                    ->get();
    
                    return response()->json($data, 200);    
                }
    
                if( isset(auth()->user()->federation_id) && isset(auth()->user()->association_id) ){
                    $data = News::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', auth()->user()->association_id)
                    ->get();
    
                    return response()->json($data, 200);    
                }

                $data = News::all();
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
                    'title' => 'required|string',
                    'content' => 'required|string',
                ],
                [
                    'title.required' => 'Titulo es Obligatorio',
                    'content.required' => 'Contenido es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = News::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'created_user_id' => auth()->user()->id,
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
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = News::findOrFail($id);
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
                    'title' => 'required|string',
                    'content' => 'required|string',
                ],
                [
                    'title.required' => 'Titulo es Obligatorio',
                    'content.required' => 'Contenido es Obligatorio',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = News::findOrFail($id);
            $obj->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'status' => $request->input('status'),
                'updated_user_id' => auth()->user()->id,
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
            $obj = News::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!", "data" => $obj], 200);

        } catch (QueryException $e) {

            if ($e->getCode() == "23503") { // PostgreSQL: Error de clave foránea
                return response()->json([
                    'messages' => 'No se puede eliminar el registro porque está relacionado con otros datos.'
                ], 409); // Código 409 (Conflicto)
            }
            
            if ($e->getCode() == "23000") { // Código general de restricción de clave foránea
                $errorMessage = $e->getMessage();
    
                if (str_contains($errorMessage, '1451')) { // No se puede eliminar porque tiene registros relacionados
                    return response()->json([
                        'messages' => 'No se puede eliminar el registro porque está relacionado con otros datos.'
                    ], 409);
                }
    
                if (str_contains($errorMessage, '1452')) { // No se puede insertar/actualizar porque la clave foránea no existe
                    return response()->json([
                        'messages' => 'No se puede crear o actualizar el registro porque la clave foránea no existe.'
                    ], 400);
                }
            }
    
            return response()->json([
                'messages' => 'Error en la base de datos.',
                'code' => $e->getCode()
            ], 500);

        }  catch (\Throwable $th) {
            throw $th;
        } 
    }
}
