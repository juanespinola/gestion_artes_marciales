<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $headers = [
        //     (object)[ 
        //         'title' => 'Id',
        //         'key' => 'id', 
        //         'active' => true, 
        //         'order' => 'asc', 
        //         'visible' => true,
        //         'ignore' => false
            
        //     ],
        //     (object)[ 'title' => 'Descripcion','key' => 'description' ]
        // ];
        // $columns = [
        //     (object)[ 'title' => 'Id','key' => 'id', 'active' => true, 'order' => 'asc', 'visible' => true ],
        //     (object)[ 'title' => 'Descripcion','key' => 'description', 'active' => true, 'order' => 'asc', 'visible' => true ]
        // ];
        // $entity = "federation";
        // $order = true;
        // return view('tabla', compact(['headers', 'columns', 'entity', 'order']));

        try {
            // Obtén los parámetros de la solicitud
            $limit = $request->input('limit', 5); // Valor predeterminado de 10 si no se proporciona
            $page = $request->input('page', 1);   // Página predeterminada de 1 si no se proporciona
            $sortBy = $request->input('sortBy', 'id'); // Campo de orden predeterminado si no se proporciona
            $order = $request->input('order', 'asc'); // Dirección de orden predeterminada si no se proporciona

            // Construye la consulta
            $query = Federation::query();
            // Aplica orden
            $query->orderBy($sortBy, $order);

            // Aplica límite
            $query->take($limit);

            // Realiza la paginación
            $data = $query->paginate($limit, ['*'], 'page', $page);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json($th, 400);
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
