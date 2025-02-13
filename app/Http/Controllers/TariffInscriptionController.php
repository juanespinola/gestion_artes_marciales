<?php

namespace App\Http\Controllers;

use App\Models\TariffInscription;
use Illuminate\Http\Request;

class TariffInscriptionController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TariffInscription $tariffInscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data = TariffInscription::where([
                ["entry_category_id", $id]
            ])->first();
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
            $obj = TariffInscription::updateOrCreate(
                ["entry_category_id" => $id], // este es el entry_category_id
                [ 'price' => $request->input('price') ]
            );
            return response()->json(["messages" => "Registro creado Correctamente!", "data" => $obj], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TariffInscription $tariffInscription)
    {
        //
    }
}
