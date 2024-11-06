<?php

namespace App\Http\Controllers;

use App\Models\MinorAuthorization;
use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MinorAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = MinorAuthorization::where('federation_id', auth()->user()->federation_id)
                ->with(['athlete', 'user'])
                ->get();
            return response()->json($data, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MinorAuthorization $minorAuthorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = MinorAuthorization::with(['athlete', 'user'])->findOrFail($id);
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
        // tambien debemos actualizar en el perfil del atleta

        try {
            $obj = MinorAuthorization::findOrFail($id);
            $obj->update([
                'user_id' => auth()->user()->id,
                'authorized' => $request->input('authorized')
            ]);

            if($obj){
                $athlete = Athlete::findOrFail($obj->athlete_id);
                $athlete->update([
                    'minor_verified' => $request->input('authorized')
                ]);
            }

            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MinorAuthorization $minorAuthorization)
    {
        //
    }


    public function uploadDocument(Request $request) {
        
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // Example validation rules
        ]);


        if($request->hasFile('file')) {
            
            $existMinorAuthorization = MinorAuthorization::where([
                ['athlete_id', auth()->user()->id]
            ])
            ->first();

            if(isset($existMinorAuthorization) && isset($existMinorAuthorization->name_file)){
                Storage::delete($existMinorAuthorization->name_file);
                // $existMinorAuthorization->delete();
            }
            
            $name = uploadPdfNew($request->file);

            $imageUri = Storage::url($name);

            if($existMinorAuthorization){
                $existMinorAuthorization->update([
                    'athlete_id' => auth()->user()->id,
                    'name_file' => $name,
                    'route_file' => asset($imageUri),
                    'federation_id' => $request->input('federation_id'),

                ]);
                return response()->json(["messages" => "Registro Actualizado Correctamente!"], 201);
            } 

            $product_media = new MinorAuthorization;

            $product_media->athlete_id = auth()->user()->id;
            $product_media->name_file = $name;
            $product_media->route_file = asset($imageUri);
            $product_media->federation_id = $request->input('federation_id');

            $product_media->save();
          
            return response()->json(["messages" => "Registro creado Correctamente!"], 201);



        } else {
            return response()->json(["messages" => "No se registra ningun archivo para cargar"], 200);
        }
    }

    
}
