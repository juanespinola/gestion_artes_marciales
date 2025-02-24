<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->BearerToken()) {

                if (!auth()->user()->hasPermissionTo('event.access')) {
                    return response()->json(['Unauthorized, you don\'t have access.'], 400);
                }

                if (isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)) {
                    $data = Event::where('federation_id', auth()->user()->federation_id)
                        ->where('association_id', null)
                        ->with('location', 'entry_category.tariff_inscription', 'type_event', 'status_event')
                        ->orderBy('id', 'asc')
                        ->get();

                    return response()->json($data, 200);
                }

                if (isset(auth()->user()->federation_id) && isset(auth()->user()->association_id)) {
                    $data = Event::where('federation_id', auth()->user()->federation_id)
                        ->where('association_id', auth()->user()->association_id)
                        ->with('location', 'entry_category.tariff_inscription', 'type_event', 'status_event')
                        ->orderBy('id', 'asc')
                        ->get();

                    return response()->json($data, 200);
                }

                $data = Event::with('location', 'entry_category.tariff_inscription', 'type_event', 'status_event')
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
                    'final_date' => 'required|date',
                    'final_time' => 'required|string',
                    // 'status_event_id' => 'required|integer',
                    'inscription_fee' => 'required|integer',
                    'available_slots' => 'required|integer',
                    'quantity_quadrilateral' => 'required|integer',
                ],
                [
                    'description.required' => ':attribute: es Obligatorio',
                    'location_id.required' => ':attribute: es Obligatorio',
                    'initial_date.required' => ':attribute: es Obligatorio',
                    'initial_time.required' => ':attribute: es Obligatorio',
                    'final_date.required' => ':attribute: es Obligatorio',
                    'final_time.required' => ':attribute: es Obligatorio',
                    // 'status_event_id.required' => ':attribute: es Obligatorio',
                    'inscription_fee.required' => ':attribute: es Obligatorio',
                    'available_slots.required' => ':attribute: es Obligatorio',
                    'quantity_quadrilateral.required' => ':attribute: es Obligatorio',
                ]
            );

            if ($validation->fails()) {
                return response()->json(["messages" => $validation->errors()], 400);
            }

            if(Carbon::parse($request->input('initial_date'))->diff(Carbon::parse($request->input('final_date')))->days <= 0 ){
                return response()->json(["messages" => "Error en fecha"], 400);
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
            $data = Event::with('entry_category.tariff_inscription', 'type_event', 'status_event')
                ->findOrFail($id);
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
                    'description.required' => ':attribute: es Obligatorio',
                    'location_id.required' => ':attribute: es Obligatorio',
                    'initial_date.required' => ':attribute: es Obligatorio',
                    'initial_time.required' => ':attribute: es Obligatorio',
                    'type_event_id.required' => ':attribute: es Obligatorio',
                    'status_event_id.required' => ':attribute: es Obligatorio',
                    'inscription_fee.required' => ':attribute: es Obligatorio',
                    'available_slots.required' => ':attribute: es Obligatorio',
                    'quantity_quadrilateral.required' => ':attribute: es Obligatorio',
                ]
            );

            if ($validation->fails()) {
                return response()->json(["messages" => $validation->errors()], 400);
            }

            if(Carbon::parse($request->input('initial_date'))->diff(Carbon::parse($request->input('final_date')))->days <= 0 ){
                return response()->json(["messages" => "Error en fecha"], 400);
            }

            $obj = Event::with('entry_category.tariff_inscription', 'type_event')->findOrFail($id);

            // Verificar si el evento es un torneo (suponiendo que el ID de torneo es 2)
            if ((empty($request->input('type_event_id')) || $request->input('type_event_id') == 1) && strtolower(optional($obj->type_event)->description) == 'torneo') {
                foreach ($obj->entry_category as $category) {
                    if (!$category->tariff_inscription) {
                        return response()->json(['messages' => "La categoría '{$category->name}' no tiene tarifa de inscripción."], 400);
                    }
                }
            } 

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
        } 
        // catch (QueryException $e) {
        //     if ($e->getCode() == "23503") { // Código de error SQL para violación de clave foránea
        //         return response()->json(['error' => 'No se puede eliminar el registro porque está relacionado con otros datos.'], 409);
        //     }
        //     return response()->json(['error' => 'Error en la base de datos.'], 500);
        // } 
        catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update_event_content(Request $request, $id)
    {
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
