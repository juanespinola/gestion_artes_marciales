<?php

namespace App\Http\Controllers;

use App\Models\Belt;
use Illuminate\Http\Request;

class BeltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                
                // if (!auth()->user()->hasPermissionTo('event.access')) {
                //     return response()->json(['Unauthorized, you don\'t have access.'], 400);
                // }

                $data = Belt::where('federation_id', auth()->user()->federation_id)->get();
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
    public function show(Belt $belt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Belt $belt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Belt $belt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Belt $belt)
    {
        //
    }
}
