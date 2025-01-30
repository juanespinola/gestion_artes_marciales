<?php

namespace App\Http\Controllers;

use App\Models\RequestAutorization;
use App\Models\TypeMembership;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


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
                        ->with('association', 'typerequest')
                        ->get();
                    return response()->json($data, 200);
                }

                $data = RequestAutorization::where([
                    ['federation_id', $user->federation_id],
                    ['association_id', $user->association_id]
                ])
                ->with('association', 'typerequest')
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
        try {
        
            $validation = Validator::make(
                $request->all(), 
                [
                    'requested_by' => 'required|string',
                    // 'request_type_id' => 'required|integer',
                    // 'request_text' => 'required|string',
                ],
                [
                    'requested_by.required' => ':attribute: is Required',
                    // 'request_type_id.required' => ':attribute: is Required',
                    // 'request_text.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            
            if($request->input('athlete_id')) {
                
                $haveMemberShip = RequestAutorization::where('athlete_id', $request->input('athlete_id'))
                        ->where('request_text', 'like','%Solicitud de Membresia%') 
                        ->get();
                
                if($haveMemberShip->count() > 0){
                    return response()->json(["messages" => "Ya tiene una membresia activa o se encuentra en pendiente de aprobación", "data" => "membresia_activa"], 200);
                }

                $obj = RequestAutorization::create([
                    'requested_by' => $request->input('requested_by'),
                    'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                    'request_text' => $request->input('request_text'),
                    'status' => 'pendiente',
                    'athlete_id' => $request->input('athlete_id'),
                    'federation_id' => $request->input('federation_id'),
                    'association_id' => $request->input('association_id'),
                ]);
            } else {
                $obj = RequestAutorization::create([
                    'requested_by' => $request->input('requested_by'),
                    'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                    'request_type_id' => $request->input('request_type_id'),
                    'request_text' => $request->input('request_text'),
                    'status' => 'pendiente',
                    'federation_id' => auth()->user()->federation_id,
                    'association_id' => auth()->user()->association_id,
                ]);
            }

            return response()->json($obj, 201);

        } catch (\Throwable $th) {
            throw $th;
        }
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
    public function edit($id)
    {
        try {
            $data = RequestAutorization::findOrFail($id);
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
        
            $validation = Validator::make(
                $request->all(), 
                [      
                    'date_response' => 'required|date',
                    // 'response_text' => 'required|string',
                ],
                [
                    'date_response.required' => ':attribute: is Required',
                    // 'request_text.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }


            $obj = RequestAutorization::findOrFail($id);
            if($request->input('athlete_id')){
                $obj->update([
                    'approved_by' => $request->input('approved_by'),
                    'rejected_by' => $request->input('rejected_by'),
                    // 'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                    'date_response' => $request->input('date_response') ? Carbon::parse($request->input('date_response'))->format('Y-m-d') : null,
                    'request_text' => $request->input('request_text'),
                    'response_text' => $request->input('response_text'),
                    'status' => $request->input('status'),
                    'athlete_id' => $request->input('athlete_id'),
                ]);

                if( $request->input('status') == 'aprobado'){
                    return $this->generateMemberShipFee($request);
                }
                return response()->json(["messages" => "Registro Actualizado Correctamente", "data" => $obj] , 201);

            } else {
                $obj->update([
                    'approved_by' => $request->input('approved_by'),
                    'rejected_by' => $request->input('rejected_by'),
                    // 'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                    'date_response' => $request->input('date_response') ? Carbon::parse($request->input('date_response'))->format('Y-m-d') : null,
                    'request_text' => $request->input('request_text'),
                    'response_text' => $request->input('response_text'),
                    'status' => $request->input('status'),
                    
                ]);
                return response()->json(["messages" => "Registro Actualizado Correctamente", "data" => $obj] , 201);
            }

            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestAutorization $requestAutorization)
    {
        //
    }


    private function generateMemberShipFee(Request $request){
        try {

            $athlete_id = $request->input('athlete_id');
            $federation_id = $request->input('federation_id');
            $association_id = $request->input('association_id');

            $existMembership = Membership::where('athlete_id',$athlete_id)
                    ->where('federation_id', $federation_id)
                    ->where('association_id', $association_id)
                    ->get();

            if($existMembership->isNotEmpty()){
                return response()->json(["messages" => "El atleta cuenta con Membresia", "data" => "membresia_activa"], 200);
            }

            $typeMembership = TypeMembership::where('status', true)
                ->first();

            if($typeMembership){

                // Obtener la última cuota registrada para el atleta y la membresía
                    $lastFee = Membership::where('type_membership_id', $typeMembership->id)
                    ->where([
                        ['athlete_id', $athlete_id],
                        ['federation_id', $federation_id],
                        ['association_id', $association_id],
                    ])
                    ->orderBy('end_date_fee', 'desc')
                    ->first();

                // Definir la fecha de inicio de las nuevas cuotas
                $startDate = $lastFee ? Carbon::parse($lastFee->end_date_fee)->addDay() : Carbon::now();

                // Generar y guardar las 12 cuotas
                for ($i=1; $i <= $typeMembership->total_number_fee; $i++) { 
                    $start_date_fee = $startDate->copy()->addDays($i * 30);
                    $end_date_fee = $start_date_fee->copy()->addDays(29); 

                    $membership = Membership::create([
                        'description' => "Cuota Asociación #".$i,
                        'number_fee' => $i,
                        'start_date_fee' => $start_date_fee->format('Y-m-d h:i:s'),
                        'end_date_fee' => $end_date_fee->format('Y-m-d h:i:s'),
                        'status' => 'pendiente',
                        'amount_fee' => $typeMembership->price,
                        'payment_date_fee' => null,
                        'type_membership_id' => $typeMembership->id,
                        'athlete_id' => 1,
                        'federation_id' => 1,
                        'association_id' => 2,
                    ]);
                }
            } else {
                return response()->json(["messages" => "No se encuentra el tipo de membresia", "data" => "type_membreship"], 400);
            }


            return response()->json(["messages" => "Cuotas Generadas Correctamente",  "data" => "fee_membership"], 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
