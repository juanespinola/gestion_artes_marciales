<?php

namespace App\Http\Controllers;

use App\Models\RequestAutorization;
use Illuminate\Http\Request;

class RequestAutorizationController extends Controller
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
                if($user->federation_id && !$user->association_id){
                    $data = RequestAutorization::where('federation_id', $user->federation_id)
                        ->get();
                    return response()->json($data, 200);
                }

                $data = RequestAutorization::where([
                    ['federation_id', $user->federation_id],
                    ['association_id', $user->association_id]
                ])->get();
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
    public function show(RequestAutorization $requestAutorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestAutorization $requestAutorization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestAutorization $requestAutorization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestAutorization $requestAutorization)
    {
        //
    }
}
