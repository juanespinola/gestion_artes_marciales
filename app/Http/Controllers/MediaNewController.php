<?php

namespace App\Http\Controllers;

use App\Models\MediaNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if($request->hasFile('file')) {
            
            $file = MediaNew::where([
                ['type', $request->type],
                ['new_id', $request->new_id]
            ])
            ->first();

            if(isset($file)){
                Storage::delete($file->name_file);
                $file->delete();
            }
            
            
            
            $sizes = match($request['type']){
                'banner_new_detail' => array('width' => 800, 'height' => 800),
                'banner_new_list' => array('width' => 1500, 'height' => 400),
            };

            $upsized = !$request['type'] == 'other';
            $name = uploadImageNew( $request->file, $sizes, $upsized );

            $imageUri = Storage::url($name);

            $product_media = new MediaNew;
            $product_media->name_file = $name;
            $product_media->route_file = asset($imageUri);
            $product_media->type = $request->type;
            $product_media->new_id = $request->new_id;
            $product_media->save();
          
            return response()->json(["messages" => "Registro creado Correctamente!"], 201);
        } else {
            return response()->json(["messages" => "No se registra ningun archivo para cargar"], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaNew $mediaNew)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaNew $mediaNew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaNew $mediaNew)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaNew $mediaNew)
    {
        //
    }
}
