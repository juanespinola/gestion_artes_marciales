<?php

namespace App\Http\Controllers;

use App\Models\TypeRequest;
use Illuminate\Http\Request;

class TypeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if($request->BearerToken()){
                $user = auth()->user();
                // if (!$user->hasPermissionTo("typesevent.access")) {
                //     return response()->json(['Unauthorized, you don\'t have access.'],400);
                // }

                $data = TypeRequest::where('federation_id', $user->federation_id)
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeRequest $typeRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeRequest $typeRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeRequest $typeRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeRequest $typeRequest)
    {
        //
    }
}
