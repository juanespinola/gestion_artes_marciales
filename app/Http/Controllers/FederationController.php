<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

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

        // try {
        //     // Obtén los parámetros de la solicitud
        //     $limit = $request->input('limit', 10); // Valor predeterminado de 10 si no se proporciona
        //     $page = $request->input('page', 1);   // Página predeterminada de 1 si no se proporciona
        //     $orderby = $request->input('orderby', 'id'); // Campo de orden predeterminado si no se proporciona
        //     $order = $request->input('order', 'asc'); // Dirección de orden predeterminada si no se proporciona

        //     // Construye la consulta
        //     $query = Federation::query();
        //     // Aplica orden
        //     $query->orderBy($orderby, $order);

        //     // Aplica límite
        //     if($limit){
        //         $query->take($limit);
        //     }

        //     // Realiza la paginación
        //     $data = $query->paginate($limit, ['*'], 'page', $page)->onEachSide(0);
        //     // $data = $this->paginate($query->get(), 2, 1)->onEachSide(0);
        //     return response()->json($data, 200);
        // } catch (\Throwable $th) {
        //     throw $th;
        //     return response()->json($th, 400);
        // }
        try {
            $data = Federation::get();
            return response()->json($data, 200);
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
        try {
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'description' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = Federation::create([
                'description' => $request->input('description'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Federation::findOrFail($id);
            return response()->json($data, 200);
    
        } catch (\Throwable $th) {
            throw $th;
        }
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
    public function update(Request $request, $id)
    {
        try {
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'description' => 'required|string',
                ],
                [
                    'description.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            $obj = Federation::findOrFail($id);
            $obj->update([
                'description' => $request->input('description'),
                'email' => $request->input('email'),
                'status' => $request->has('status') ? $request->input('status') : true,
                'phone_number' => $request->input('phone_number'),
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $obj = Federation::findOrFail($id);
            $obj->delete();
    
            return response()->json($obj, 200);

        }  catch (\Throwable $th) {
            // throw $th;
            return response()->json($th, 400);
        } 
    }

    public function update_authorities(Request $request, $id)
    {
        try {

            $obj = Federation::findOrFail($id);
            $obj->update([
                'president' => $request->input('president'),
                'vice_president' => $request->input('vice_president'),
                'treasurer' => $request->input('treasurer'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update_contacts(Request $request, $id)
    {
        try {

            $obj = Federation::findOrFail($id);
            $obj->update([
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'facebook' => $request->input('facebook'),
                'whatsapp' => $request->input('whatsapp'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
            ]);

            return response()->json($obj, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    private function paginate($data, $page, $limit) {
        // Puedes ajustar la cantidad de elementos por página según tus necesidades
        // $page = LengthAwarePaginator::resolveCurrentPage();

        
        $currentItems = $data->slice(($page - 1) * $limit, $limit)->all();

        $options = [
            // 'path' => ''
        ];
        
        
        return new LengthAwarePaginator(
            $currentItems, 
            $data->count(), 
            $limit, 
            $page, 
            $options);
    }

    // funcion para obtener federacion sin token, para login de athleta
    public function getFederations(){
        return Federation::where('status', true)->get();
    }

}
