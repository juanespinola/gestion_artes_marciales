<?php

namespace App\Http\Controllers;

use App\Models\RequestAutorization;
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
                    'request_type_id' => 'required|integer',
                    'request_text' => 'required|string',
                ],
                [
                    'requested_by.required' => ':attribute: is Required',
                    'request_type_id.required' => ':attribute: is Required',
                    'request_text.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }

            
            $obj = RequestAutorization::create([
                'requested_by' => $request->input('requested_by'),
                'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                'request_type_id' => $request->input('request_type_id'),
                'request_text' => $request->input('request_text'),
                'status' => 'pendiente',
                'federation_id' => auth()->user()->federation_id,
                'association_id' => auth()->user()->association_id,
            ]);

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
                    'response_text' => 'required|string',
                ],
                [
                    'date_response.required' => ':attribute: is Required',
                    'request_text.required' => ':attribute: is Required',
                ]
            );

            if($validation->fails()){
                return response()->json(["messages" => $validation->errors()], 400);
            }


            $obj = RequestAutorization::findOrFail($id);
            $obj->update([
                // 'requested_by' => $request->input('requested_by'),
                'approved_by' => $request->input('approved_by'),
                'rejected_by' => $request->input('rejected_by'),
                // 'date_request' => $request->input('date_request') ? Carbon::parse($request->input('date_request'))->format('Y-m-d') : null,
                'date_response' => $request->input('date_response') ? Carbon::parse($request->input('date_response'))->format('Y-m-d') : null,
                'request_text' => $request->input('request_text'),
                'response_text' => $request->input('response_text'),
                'status' => $request->input('status'),

            ]);

            return response()->json($obj, 201);
            
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
}
