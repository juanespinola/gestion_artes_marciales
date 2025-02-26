<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\TypeMembership;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipController extends Controller
{

    public function generateMemberShipFee(Request $request) {
        
        try {
            

            $athlete_id = $request->input('athlete_id');
            $federation_id = $request->input('federation_id');
            $association_id = $request->input('association_id');
            
            $existMembership = Membership::where('athlete_id', $athlete_id)
                                ->where('federation_id', $federation_id)
                                ->where('association_id', $association_id)
                                ->first();

            if(!$existMembership->isEmply()){
                return response()->json(["messages" => "El atleta cuenta con Membresia"], 200);
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

                    Membership::create([
                        'description' => "Cuota Membresia #".$i,
                        'number_fee' => $i,
                        'start_date_fee' => $start_date_fee->format('Y-m-d h:i:s'),
                        'end_date_fee' => $end_date_fee->format('Y-m-d h:i:s'),
                        'status' => 'pendiente',
                        'amount_fee' => $typeMembership->price,
                        'payment_date_fee' => null,
                        'type_membership_id' => $typeMembership->id,
                        'athlete_id' => $athlete_id,
                        'federation_id' => $federation_id,
                        'association_id' => $association_id,
                    ]);
                }
            } else {
                return response()->json(["messages" => "No se encuentra el tipo de membresia"], 400);
            }


            return response()->json(["messages" => "Cuotas Generadas Correctamente"], 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function paymentMemberShipFee($id) {

        try {
            $obj = Membership::findOrFail($id);
            $obj->update([
                'status' => 'pagado',
                'payment_date_fee' => Carbon::now()->format('Y-m-d h:i:s'),
            ]);

            return response()->json($obj, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMemberShipFee($id) {
        try {
            $obj = Membership::findOrFail($id);
            return response()->json($obj, 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
