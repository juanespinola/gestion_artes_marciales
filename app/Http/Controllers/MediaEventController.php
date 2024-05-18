<?php

namespace App\Http\Controllers;

use App\Models\MediaEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class MediaEventController extends Controller
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
        if ($request->hasFile('file')) {
            foreach ( $request->file('file') as $key => $value) {   

                
                // $files = MediaEvent::where('event_id', $request['event_id'][$key])->get();

                // if (count($files) > 0) {
                //     Storage::delete($files[$key]->route_file);
                //     $files[$key]->delete();
                // }
         

                $sizes = match($request['type'][$key]){
                    'banner_principal' => array('width' => 800, 'height' => 800),
                    'banner_secundario' => array('width' => 1500, 'height' => 400),
                };

                $upsized = !$request['type'][$key] == 'other';
                $name = uploadImage( $value, $sizes, $upsized, $key );

                $imageUri = Storage::url($name);

                $product_media = new MediaEvent;
                $product_media->name_file = $name;
                $product_media->route_file = asset($imageUri);
                $product_media->type = $request['type'][$key];
                $product_media->event_id = $request['event_id'][$key];
                $product_media->save();
                
            }
            return response()->json(["messages" => "Registro creado Correctamente!"], 201);
        } else {
            return response()->json(["messages" => "No se registra ningun archivo para cargar"], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MediaEvent $mediaEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MediaEvent $mediaEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MediaEvent $mediaEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $event_id)
    {
        $file = MediaEvent::where('event_id', $event_id)
            ->where('type', $request->type)
            ->first();
        Storage::delete($file->route_file);
        $file->delete();
        return response()->json(['process' => true]);
    }


}
