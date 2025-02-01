<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\EntryCategory;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // este es para el listado de admin de las personas inscriptas
        try {

            if ($request->BearerToken()) {

                // $data = EntryCategory::with([
                //             'belt',
                //             'tariff_inscription.inscriptions.athlete',
                //             'matchBracket',        
                //         ])
                //         ->where('event_id', $request->input('event_id'))
                //         ->get()
                //         ->groupBy([
                //             function ($item) {
                //                 return $item->minor_category ? 'Menores' : 'Mayores';
                //             },
                //             'gender',
                //             'belt.color', 
                //             'name'
                //         ])
                //         ->sortByDesc('belt.color');


                $data = EntryCategory::with([
                    'belt',
                    'tariff_inscription.inscriptions.athlete',
                    'matchBracket',
                    'event',
                ])
                    ->where('event_id', $request->input('event_id'))
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
    public function store(Request $request) {}

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
    public function update(Request $request, $id)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'event_weight' => 'required|integer',
                ],
                [
                    'event_weight.required' => ':attribute: is Required',
                ]
            );

            if ($validation->fails()) {
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Inscription::with(['tariff_inscription'])->findOrFail($id);

            // TODO: queda verificar cuando es absoluto
            $valid_weight = DB::table('tariff_inscriptions')
                ->join('entry_categories', 'tariff_inscriptions.entry_category_id', '=', 'entry_categories.id')
                ->where([
                    ['entry_categories.min_weight', '<=', $request->input('event_weight')],
                    ['entry_categories.max_weight', '>=', $request->input('event_weight')],
                    ['tariff_inscriptions.id', '=', $obj->tariff_inscription->id]
                ])
                ->select('*')
                ->get();

            $obj->update([
                'event_weight' => $request->input('event_weight'),
                'valid_weight' => count($valid_weight) > 0
            ]);

            return response()->json(["messages" => "Registro editado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscription $inscription)
    {
        //
    }


    public function setEntryForRegistratioAthlete(Request $request)
    {
        try {

            foreach ($request->input('selectEntryForPayment') as $key => $value) {

                $athlete = auth()->user();
                $validation = Validator::make(
                    [
                        'event_id' => $value['event_id'],
                        'athlete_id' => $athlete->id,
                        'tariff_inscription_id' =>  $value['tariff_inscription']['id']
                    ],
                    [
                        'event_id' => 'required|integer',
                        'athlete_id' => 'required|integer',
                        'tariff_inscription_id' => 'required|integer',
                    ],
                    [
                        'event_id.required' => ':attribute: is Required',
                        'athlete_id.required' => ':attribute: is Required',
                        'tariff_inscription_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                // // Verificamos si el atleta ya tiene una inscripción con el mismo tariff_inscription_id
                $existing_inscription = Inscription::where([
                    ['athlete_id', '=', $athlete->id],
                    ['tariff_inscription_id', '=',  $value['tariff_inscription']['id']]
                ])->first();

                if ($existing_inscription) {
                    return response()->json(["messages" => "El atleta ya tiene una inscripción con esta Categoría.", "response" => false], 400);
                }

                // queda realizar las funcionalidades para obtener los cinturones por atleta
                $obj = Inscription::create([
                    'event_id' => $value['event_id'],
                    'athlete_id' => $athlete->id,
                    'tariff_inscription_id' => $value['tariff_inscription']['id']
                ]);
            }
            return response()->json(["messages" => "Registro creado Correctamente!", "response" => true], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getInscription($id)
    {
        try {
            $obj = Inscription::with('event', 'tariff_inscription')
                ->findOrFail($id);
            return response()->json($obj, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
