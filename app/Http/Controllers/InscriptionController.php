<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\EntryCategory;
use App\Models\TariffInscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                // $user = auth()->user();
                // if (!$user->hasPermissionTo("association.access")) {
                //     return response()->json(['Unauthorized, you don\'t have access.'],400);
                // }

                $data = Inscription::with(['event', 'athlete', 'tariff_inscription'])
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
            
            $athlete = auth()->user();
            $validation = Validator::make(   
                [ 
                    'event_id' => $request->input('event_id'), 
                    'weight' => $request->input('weight'), 
                    'belt_id' => $athlete->belt_id
                ],
                [
                    'event_id' => 'required|integer',
                    'weight' => 'required|string',
                    'belt_id' => 'required|integer',
                ],
                [
                    'event_id.required' => ':attribute: is Required',
                    'weight.required' => ':attribute: is Required',
                    'belt_id.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $entry_category = EntryCategory::where([
                ["min_age", "<=", Carbon::parse($athlete->birthdate)->age], // edad del athleta del auth
                ["max_age", ">=", Carbon::parse($athlete->birthdate)->age], // edad del athleta del auth
                ["min_weight", "<=", $request->input('weight')],
                ["max_weight", ">=", $request->input('weight')],
                ["belt_id", "=", $athlete->belt_id],
                ["gender", "=", $athlete->gender],
            ]);
            
            if($request->input('clothes')){
                $entry_category->where("clothes", "=", $request->input('clothes'));
            }
            
            // obtenemos el objeto por eso el first
            $entry_category_id = $entry_category
                                    ->first()
                                    ->id;
            
            $tariff_inscription_id = TariffInscription::where('entry_category_id', $entry_category_id)
                    ->first()
                    ->id;

            // Verificamos si el atleta ya tiene una inscripción con el mismo tariff_inscription_id
            $existing_inscription = Inscription::where([
                ['athlete_id', '=', $athlete->id],
                ['tariff_inscription_id', '=', $tariff_inscription_id]
            ])->first();

            if ($existing_inscription) {
                return response()->json(["messages" => "El atleta ya tiene una inscripción con este tariff_inscription_id."], 400);
            }

            // queda realizar las funcionalidades para obtener los cinturones por atleta
            $obj = Inscription::create([
                'event_id' => $request->input('event_id'),
                'athlete_id' => auth()->user()->id,
                'weight' => $request->input('weight'),
                'tariff_inscription_id' => $tariff_inscription_id,
            ]);

            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscription $inscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscription $inscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscription $inscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscription $inscription)
    {
        //
    }
}
