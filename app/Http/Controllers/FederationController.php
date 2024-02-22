<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = [
            (object)[ 
                'title' => 'Id',
                'key' => 'id', 
                'active' => true, 
                'order' => 'asc', 
                'visible' => true,
                'ignore' => false
            
            ],
            (object)[ 'title' => 'Descripcion','key' => 'description' ]
        ];
        $columns = [
            (object)[ 'title' => 'Id','key' => 'id', 'active' => true, 'order' => 'asc', 'visible' => true ],
            (object)[ 'title' => 'Descripcion','key' => 'description', 'active' => true, 'order' => 'asc', 'visible' => true ]
        ];
        $entity = "federation";
        $order = true;
        return view('tabla', compact(['headers', 'columns', 'entity', 'order']));
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
    public function show(Federation $federation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Federation $federation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Federation $federation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Federation $federation)
    {
        //
    }
}
