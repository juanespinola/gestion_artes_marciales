<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\EntryCategory;
use App\Models\TariffInscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
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
            if($request->BearerToken()){
                // $user = auth()->user();
                // if (!$user->hasPermissionTo("association.access")) {
                //     return response()->json(['Unauthorized, you don\'t have access.'],400);
                // }

                $data = Inscription::all()
                        ->load('athlete', 'tariff_inscription.entry_category.belt')
                        ->groupBy(['tariff_inscription.entry_category.gender','tariff_inscription.entry_category.belt.color', 'tariff_inscription.entry_category.name'])
                        ->sortByDesc('tariff_inscription.entry_category.belt.color');
                        
                
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

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Inscription::with(['tariff_inscription'])->findOrFail($id);

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


    public function setEntryForRegistratioAthlete(Request $request) {
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

                if($validation->fails()){
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                // $entry_category = EntryCategory::where([
                //     ["min_age", "<=", Carbon::parse($athlete->birthdate)->age], // edad del athleta del auth
                //     ["max_age", ">=", Carbon::parse($athlete->birthdate)->age], // edad del athleta del auth
                //     ["min_weight", "<=", $request->input('weight')],
                //     ["max_weight", ">=", $request->input('weight')],
                //     ["belt_id", "=", $athlete->belt_id],
                //     ["gender", "=", $athlete->gender],
                // ]);
                
                // if($request->input('clothes')){
                //     $entry_category->where("clothes", "=", $request->input('clothes'));
                // }
                
                // obtenemos el objeto por eso el first
                // $entry_category_id = $entry_category
                //                         ->first()
                //                         ->id;
                
                // $tariff_inscription_id = TariffInscription::where('entry_category_id', $entry_category_id)
                //         ->first()
                //         ->id;

                // // Verificamos si el atleta ya tiene una inscripción con el mismo tariff_inscription_id
                $existing_inscription = Inscription::where([
                    ['athlete_id', '=', $athlete->id],
                    ['tariff_inscription_id', '=',  $value['tariff_inscription']['id'] ]
                ])->first();

                if ($existing_inscription) {
                    return response()->json(["messages" => "El atleta ya tiene una inscripción con esta Categoría.", "response" => false], 400);
                }

                // Verificamos si el atleta ya tiene una inscripción 
                // $existing_inscription = DB::table('inscriptions')
                //     ->join('tariff_inscriptions', 'tariff_inscriptions.id', '=', 'inscriptions.tariff_inscription_id')
                //     ->join('entry_categories', 'tariff_inscriptions.entry_category_id', '=', 'entry_categories.id')
                //     ->where('entry_categories.name', '<>', 'absoluto')
                //     ->select('*')
                    
                //     ->get();

                // $existing_inscription = Inscription::with('tariff_inscription.entry_category')
                // ->where([
                    // ['athlete_id', '=', $athlete->id],
                    // ['tariff_inscription["entry_category"]["name"]', '<>', strtolower('absoluto')]
                // ])
                // ->whereHas('tariff_inscription', function (Builder $query){
                //     $query->whereHas('entry_category', function (Builder $query){
                //         $query->where(['name' ,'==', 'Absoluto']);
                //     });
                // })
                // ->first();
   
                // if ($existing_inscription) {
                //     return response()->json(["messages" => "El atleta ya tiene una inscripción a este evento.", "response" => false], 400);
                // }

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



    // para el payment_id, en caso de que sea transferencia, se debe seleccionar el item
}
