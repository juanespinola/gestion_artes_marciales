<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                
                if (!auth()->user()->hasPermissionTo('event.access')) {
                    return response()->json(['Unauthorized, you don\'t have access.'], 400);
                }

                if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                    $data = Event::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', null)
                    ->with(['location'])
                    ->orderBy('id', 'asc')
                    ->get();
    
                    return response()->json($data, 200);    
                }
    
                if( isset(auth()->user()->federation_id) && isset(auth()->user()->association_id) ){
                    $data = Event::where('federation_id', auth()->user()->federation_id)
                    ->where('association_id', auth()->user()->association_id)
                    ->with(['location'])
                    ->orderBy('id', 'asc')
                    ->get();
    
                    return response()->json($data, 200);    
                }

                $data = Event::with(['location'])
                    ->orderBy('id', 'asc')
                    ->get();
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
                    'description' => 'required|string',
                    'location_id' => 'required|integer',
                    'initial_date' => 'required|date',
                    'initial_time' => 'required|string',
                    // 'status_event_id' => 'required|integer',
                    'inscription_fee' => 'required|integer',
                    'available_slots' => 'required|integer',                   
                    'quantity_quadrilateral' => 'required|integer',   
                ],
                [
                    'description.required' => ':attribute: is Required',
                    'location_id.required' => ':attribute: is Required',
                    'initial_date.required' => ':attribute: is Required',
                    'initial_time.required' => ':attribute: is Required',
                    // 'status_event_id.required' => ':attribute: is Required',
                    'inscription_fee.required' => ':attribute: is Required',
                    'available_slots.required' => ':attribute: is Required',                  
                    'quantity_quadrilateral.required' => ':attribute: is Required',                  
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            // queda trabajar en las fechas, en el formateo
            $obj = Event::create([
                'description' => $request->input('description'),
                'location_id' => $request->input('location_id'),
                'initial_date' => Carbon::parse($request->input('initial_date'))->format('Y-m-d'),
                'final_date' => $request->input('final_date') ? Carbon::parse($request->input('final_date'))->format('Y-m-d') : null,
                'initial_time' => $request->input('initial_time'),
                'final_time' => $request->input('final_time'),
                'type_event_id' => $request->input('type_event_id'),
                'status_event_id' => 1, // evento estado organizando
                'inscription_fee' => $request->input('inscription_fee'),
                'total_participants' => $request->input('total_participants'),
                'available_slots' => $request->input('available_slots'),
                'quantity_quadrilateral' => $request->input('quantity_quadrilateral'),
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
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = Event::findOrFail($id);
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
                    'description' => 'required|string',
                    'location_id' => 'required|integer',
                    'initial_date' => 'required|date',
                    'initial_time' => 'required|string',
                    'type_event_id' => 'required|integer',
                    'status_event_id' => 'required|integer',
                    'inscription_fee' => 'required|integer',
                    'available_slots' => 'required|integer',                   
                    'quantity_quadrilateral' => 'required|integer',                   
                ],
                [
                    'description.required' => ':attribute: is Required',
                    'location_id.required' => ':attribute: is Required',
                    'initial_date.required' => ':attribute: is Required',
                    'initial_time.required' => ':attribute: is Required',
                    'type_event_id.required' => ':attribute: is Required',
                    'status_event_id.required' => ':attribute: is Required',
                    'inscription_fee.required' => ':attribute: is Required',
                    'available_slots.required' => ':attribute: is Required',                  
                    'quantity_quadrilateral.required' => ':attribute: is Required',                  
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Event::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
                'location_id' => $request->input('location_id'),
                'initial_date' => Carbon::parse($request->input('initial_date'))->format('Y-m-d'),
                'final_date' => $request->input('final_date') ? Carbon::parse($request->input('final_date'))->format('Y-m-d') : null,
                'initial_time' => $request->input('initial_time'),
                'final_time' => $request->input('final_time'),
                'type_event_id' => $request->input('type_event_id'),
                'status_event_id' => $request->input('status_event_id'),
                'inscription_fee' => $request->input('inscription_fee'),
                'total_participants' => $request->input('total_participants'),
                'available_slots' => $request->input('available_slots'),
                'quantity_quadrilateral' => $request->input('quantity_quadrilateral'),
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
        
            $obj = Event::findOrFail($id);
            $obj->delete();
    
            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update_event_content(Request $request, $id)  {
        try {
            $obj = Event::findOrFail($id);
            $obj->update([
                'introduction' => $request->input('introduction'),
                'content' => $request->input('content'),
                'updated_user_id' => auth()->user()->id,
            ]);
            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
