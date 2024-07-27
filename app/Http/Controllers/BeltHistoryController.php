<?php

namespace App\Http\Controllers;

use App\Models\BeltHistory;
use Illuminate\Http\Request;

class BeltHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $data = BeltHistory::with('belt')
                    ->where('athlete_id', auth()->user()->id)
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(BeltHistory $beltHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeltHistory $beltHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeltHistory $beltHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeltHistory $beltHistory)
    {
        //
    }
}
