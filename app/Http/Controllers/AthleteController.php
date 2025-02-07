<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\BeltHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Membership;
use App\Models\TypeMembership;
use App\Models\Inscription;
use App\Models\Payment;
use DB;

class AthleteController extends Controller
{

    public function getProfile(Request $request)
    {
        $data = Athlete::with('belt')
            ->findOrFail(auth()->user()->id);
        return response()->json($data, 200);
    }


    public function updateProfile(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required|string',
                        'email' => 'required|string',
                        'document' => 'required|string',
                        'phone' => 'required|string',
                        'gender' => 'required|string',
                        'birthdate' => 'required|date',
                        'country_id' => 'required|integer',
                        'city_id' => 'required|integer',
                        'type_document_id' => 'required|integer',
                        'belt_id' => 'required|integer',
                    ],
                    [
                        'name.required' => ':attribute: is Required',
                        'email.required' => ':attribute: is Required',
                        'document.required' => ':attribute: is Required',
                        'phone.required' => ':attribute: is Required',
                        'gender.required' => ':attribute: is Required',
                        'birthdate.required' => ':attribute: is Required',
                        'country_id.required' => ':attribute: is Required',
                        'city_id.required' => ':attribute: is Required',
                        'type_document_id.required' => ':attribute: is Required',
                        'belt_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $obj = Athlete::findOrFail(auth()->user()->id);
                $obj->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'document' => $request->input('document'),
                    'phone' => $request->input('phone'),
                    'gender' => $request->input('gender'),
                    'birthdate' => $request->input('birthdate'),
                    'country_id' => $request->input('country_id'),
                    'city_id' => $request->input('city_id'),
                    'type_document_id' => $request->input('type_document_id'),
                    'belt_id' => $request->input('belt_id'),
                    'academy_id' => $request->input('academy_id'),
                ]);

                return response()->json($obj, 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateBeltHistory(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'belt_id' => 'required|integer',
                        'athlete_id' => 'required|integer',
                        'federation_id' => 'required|integer',

                    ],
                    [
                        'belt_id.required' => ':attribute: is Required',
                        'athlete_id.required' => ':attribute: is Required',
                        'federation_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $existBelt = BeltHistory::where([
                    ['belt_id', $request->input('belt_id')],
                    ['athlete_id', $request->input('athlete_id')],
                ])->first();

                if ($existBelt) {
                    return response()->json(["messages" => "Ya cuentas con ese cinturón"], 400);
                }

                $athlete = Athlete::findOrFail($request->input('athlete_id'));
                $athlete->update([
                    'belt_id' => $request->input('belt_id'),
                ]);

                $obj = BeltHistory::create([
                    'belt_id' => $request->input('belt_id'),
                    'athlete_id' => $request->input('athlete_id'),
                    'federation_id' => $request->input('federation_id'),
                    'achieved' => $request->input('achieved') ? Carbon::parse($request->input('achieved'))->format('Y-m-d') : null,
                    'promoted_by' => $request->input('promoted_by'),
                ]);



                return response()->json($obj, 201);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getAthleteMembershipFee(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'athlete_id' => 'required|integer',
                        'federation_id' => 'required|integer',
                        'association_id' => 'required|integer',

                    ],
                    [
                        'athlete_id.required' => ':attribute: is Required',
                        'federation_id.required' => ':attribute: is Required',
                        'association_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $athlete_id = $request->input('athlete_id');
                $federation_id = $request->input('federation_id');
                $association_id = $request->input('association_id');

                $memberships = Membership::where([
                    ['athlete_id', $athlete_id],
                    ['federation_id', $federation_id],
                    ['association_id', $association_id],
                    ['status', '<>', 'pagado']
                ])
                    ->orderBy('end_date_fee', 'asc')
                    ->get();

                return response()->json($memberships, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteMembershipFeePayment(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'athlete_id' => 'required|integer',
                        'federation_id' => 'required|integer',
                        'association_id' => 'required|integer',

                    ],
                    [
                        'athlete_id.required' => ':attribute: is Required',
                        'federation_id.required' => ':attribute: is Required',
                        'association_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $athlete_id = $request->input('athlete_id');
                $federation_id = $request->input('federation_id');
                $association_id = $request->input('association_id');

                $memberships = Membership::where([
                    ['athlete_id', $athlete_id],
                    ['federation_id', $federation_id],
                    ['association_id', $association_id],
                    ['status', 'pagado']
                ])
                    ->orderBy('end_date_fee', 'asc')
                    ->get();

                return response()->json($memberships, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAthleteInscriptionPayment(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'athlete_id' => 'required|integer',
                    ],
                    [
                        'athlete_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $athlete_id = $request->input('athlete_id');
                // $federation_id = $request->input('federation_id');
                // $association_id = $request->input('association_id');

                $inscriptions = Inscription::with('event', 'tariff_inscription')
                    ->where([
                        ['athlete_id', $athlete_id]
                    ])
                    ->get();

                return response()->json($inscriptions, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function getAthleteParticipatedEvents(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'athlete_id' => 'required|integer',
                    ],
                    [
                        'athlete_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $athlete_id = $request->input('athlete_id');
                // $federation_id = $request->input('federation_id');
                // $association_id = $request->input('association_id');

                $inscriptions = Inscription::with('event', 'tariff_inscription')
                    ->where([
                        ['athlete_id', $athlete_id],
                        ['status', 'pagado']
                    ])
                    ->get();

                return response()->json($inscriptions, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function index(Request $request)
    {
        try {
            if ($request->BearerToken()) {

                // if (!auth()->user()->hasPermissionTo('groupcategory.access')) {
                //     return response()->json(['Unauthorized, you don\'t have access.'], 400);
                // }

                // if(isset(auth()->user()->federation_id) && !isset(auth()->user()->association_id)){
                //     $data = Athlete::with(['federation', 'association'])
                //     ->where('federation_id', auth()->user()->federation_id)
                //     ->where('association_id', null)
                //     ->get();

                //     return response()->json($data, 200);    
                // }

                // if( isset(auth()->user()->federation_id) && isset(auth()->user()->association_id) ){
                //     $data = Athlete::with(['federation', 'association'])
                //     ->where('federation_id', auth()->user()->federation_id)
                //     ->where('association_id', auth()->user()->association_id)
                //     ->get();

                //     return response()->json($data, 200);    
                // }

                $data = Athlete::athlete_federation(auth()->user()->federation_id)
                    ->with(['academy', 'country', 'city', 'belt'])
                    ->get();
                return response()->json($data, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMinorAuthorization(Request $request)
    {

        return Athlete::findOrFail(auth()->user()->id);
    }


    public function getPayments(Request $request)
    {
        try {
            if ($request->BearerToken()) {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'athlete_id' => 'required|integer',
                        'federation_id' => 'required|integer',
                        'association_id' => 'required|integer',

                    ],
                    [
                        'athlete_id.required' => ':attribute: is Required',
                        'federation_id.required' => ':attribute: is Required',
                        'association_id.required' => ':attribute: is Required',
                    ]
                );

                if ($validation->fails()) {
                    return response()->json(["messages" => $validation->errors()], 400);
                }

                $athlete_id = $request->input('athlete_id');
                $federation_id = $request->input('federation_id');
                $association_id = $request->input('association_id');

                $memberships = Payment::where([
                    ['athlete_id', $athlete_id],
                    ['federation_id', $federation_id],
                    ['association_id', $association_id],
                    ['status', 'confirmado']
                ])
                    ->with('inscription.tariff_inscription', 'membership')
                    ->get();

                return response()->json($memberships, 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
