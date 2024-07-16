<?php

namespace App\Http\Controllers;

use App\Models\TypesVictory;
use Illuminate\Http\Request;

class TypesVictoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = TypesVictory::all();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TypesVictory $typesVictory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypesVictory $typesVictory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypesVictory $typesVictory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypesVictory $typesVictory)
    {
        //
    }
}
