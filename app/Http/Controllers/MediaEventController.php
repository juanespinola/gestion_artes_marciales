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
        // no estamos pudiendo recibir el file
    //    return response()->json(file($request->file('file')[0]->getClientOriginalName()), 200);
        // return response()->json(json_decode($request->rows), 200);
       
        if ($request->hasFile('file')) {
            foreach ( $request->file('file') as $key => $value) {
                // foreach ($request as $key => $value) {
                // echo "<pre>";
                // var_dump($value->getClientOriginalName());
                // echo "</pre>";

                // echo "<pre>";
                // var_dump($request['type'][$key]);
                // echo "</pre>";

                // $validation = Validator::make(
                //     $request->all(), 
                //     [
                //         'file' => 'required|mimes:jpeg,jpg,png,webp,gif',
                //         'type' => 'required|string',
                //     ],
                //     [
                //         'file.required' => ':attribute: is Required',
                //         'type.required' => ':attribute: is Required',
                //     ]
                // );
        
                // if($validation->fails()){
                //     return response()->json(["messages" => $validation->errors()], 400);
                // }
          
                $file = MediaEvent::where('type', $request['type'][$key])
                        ->where('event_id', $request['event_id'][$key])
                        ->first();
                if ($file) {
                    Storage::delete($file->route_file);
                    $file->delete();
                }

                $sizes = match($request['type'][$key]){
                    'banner_principal' => array('width' => 800, 'height' => 800),
                    'banner_secundario' => array('width' => 1500, 'height' => 400),
                };

                $upsized = !$request['type'][$key] == 'other';
                $name = uploadImage( file($value->getClientOriginalName()), $sizes, $upsized );

                $product_media = new MediaEvent;
                $product_media->route_file = "events/{$name}.jpg";
                $product_media->type = $request['type'][$key];
                $product_media->event_id = $request['event_id'][$key];
                $product_media->save();

                $imageUri = Storage::url($name);
                
            }
            // return response()->json(["messages" => "Registro creado Correctamente!", "data" => $imageUri], 201);
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
