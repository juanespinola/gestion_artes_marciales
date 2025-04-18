<?php

namespace App\Http\Controllers;

use App\Models\EntryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EntryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $event_id)
    {
        try {
            if ($request->BearerToken()) {
                // $data = EntryCategory::all()
                // ->load('belt')
                // ->groupBy('belt.color');

                // return response()->json($data, 200);
                $data = EntryCategory::where('event_id', $event_id)
                    ->with('belt') // Asegúrate de que 'belt' es la relación correcta
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->belt->id; // Agrupa por el id del cinturón
                    })
                    ->map(function ($group, $beltId) {
                        $belt = $group->first()->belt; // Obtén los datos del cinturón del primer elemento
                        return [
                            "cinturon" => [
                                "id" => $belt->id,
                                "color" => $belt->color,
                            ],
                            // "categories" => $group->values()->toArray(),
                            "categories" => $group->map(function ($category) {
                                return [
                                    "id" => $category->id,
                                    "name" => $category->name,
                                    "min_age" => $category->min_age,
                                    "max_age" => $category->max_age,
                                    "min_weight" => $category->min_weight,
                                    "max_weight" => $category->max_weight,
                                    "belt_id" => $category->belt_id,
                                    "gender" => $category->gender,
                                    "clothes" => $category->clothes,
                                    "event_id" => $category->event_id,
                                    "minor_category" => $category->minor_category,
                                    "belt" => $category->belt,
                                    "tariff_inscription" => $category->tariff_inscription // Asegura que se incluya la relación
                                ];
                            })->values()->toArray(),
                        ];
                    })->values() // Convierte a un array sin claves
                    ->toArray();

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
                    'min_age' => 'required|integer',
                    'max_age' => 'required|integer',
                    'belt_id' => 'required|integer',
                    'gender' => 'required|string',
                ],
                [
                    'name.required' => ':attribute: es Obligatorio',
                    'min_age.required' => ':attribute: es Obligatorio',
                    'max_age.required' => ':attribute: es Obligatorio',
                    'belt_id.required' => ':attribute: es Obligatorio',
                    'gender.required' => ':attribute: es Obligatorio',
                ]
            );

            if ($validation->fails()) {
                return response()->json(["messages" => $validation->errors()], 400);
            }


            $obj = EntryCategory::create([
                'name' => $request->input('name'),
                'min_age' => $request->input('min_age'),
                'max_age' => $request->input('max_age'),
                'min_weight' => $request->input('min_weight'),
                'max_weight' => $request->input('max_weight'),
                'belt_id' => $request->input('belt_id'),
                'gender' => $request->input('gender'),
                'clothes' => $request->input('clothes'),
                'event_id' => $request->input('event_id'),
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EntryCategory $entryCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = EntryCategory::findOrFail($id);
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
                    'name' => 'required|string',
                    'min_age' => 'required|integer',
                    'max_age' => 'required|integer',
                    'belt_id' => 'required|integer',
                    'gender' => 'required|string',
                ],
                [
                    'name.required' => ':attribute: es Obligatorio',
                    'min_age.required' => ':attribute: es Obligatorio',
                    'max_age.required' => ':attribute: es Obligatorio',
                    'belt_id.required' => ':attribute: es Obligatorio',
                    'gender.required' => ':attribute: es Obligatorio',
                ]
            );

            if ($validation->fails()) {
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = EntryCategory::findOrFail($id);
            $obj->update([
                'name' => $request->input('name'),
                'min_age' => $request->input('min_age'),
                'max_age' => $request->input('max_age'),
                'min_weight' => $request->input('min_weight'),
                'max_weight' => $request->input('max_weight'),
                'belt_id' => $request->input('belt_id'),
                'gender' => $request->input('gender'),
                'clothes' => $request->input('clothes'),
                'event_id' => $request->input('event_id'),
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

            $obj = EntryCategory::findOrFail($id);
            $obj->delete();

            return response()->json(["messages" => "Registro eliminado Correctamente!"], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getEntryForRegistratioAthlete(Request $request)
    {
        try {
            if ($request->BearerToken()) {

                $athlete = auth()->user();
                $event_id = $request->input('event_id');

                $entries = EntryCategory::where([
                    ["min_age", "<=", Carbon::parse($athlete->birthdate)->age],
                    ["max_age", ">=", Carbon::parse($athlete->birthdate)->age],
                    ["belt_id", "=", $athlete->belt_id],
                    ["gender", "=", $athlete->gender],
                    ["event_id", "=", $event_id],
                ])
                    // ->with(['tariff_inscription.entry_category', 'belt'])
                    ->get();


                // $data = $entries->groupBy('belt.color')->map(function ($categories, $beltColor) {
                //     return [
                //         "belt" => $beltColor,
                //         "categories" => $categories->values(),
                //     ];
                // })->values();


                $entries_available = EntryCategory::where([
                    ["event_id", "=", $event_id],
                ])
                    ->with(['tariff_inscription.entry_category', 'belt'])
                    ->get();


                $entryCategoryAvailable = $entries_available->groupBy('belt.color')->map(function ($categories, $beltColor) {
                    return [
                        "belt" => $beltColor,
                        "categories" => $categories->values(),
                    ];
                })->values();

                // return response()->json($data, 200);
                return response()->json(['entry_athlete' => $entries, 'entry_category_available' => $entryCategoryAvailable]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
