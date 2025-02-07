<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class PaymentController extends Controller
{
   
   /**
     * Forma de pago
     */
    private $gateway_payment;

    /**
     * Tipo de pago
     */
    private $type_payment;

    /**
     * Process
     */
    private $process;

    /**
     * data
     */
    private $data;

    /**
     * data error
     */
    private $data_error;

    /**
     * sale
     */
    private $payment_id;

    /**
     * athlete_id
     */
    private $athlete_id;


    public function __construct() {
    }
    /**
     * Setear forma de pago
     */
    public function gatewayPayment($gateway_payment)
    {
        $this->gateway_payment = $gateway_payment;
        return $this;
    }

    /**
     * Setear tipo de pago
     */
    public function typePayment($type)
    {
        $this->type_payment = $type;
        return $this;
    }


    /**
     * Retornar opeacion fallida o con exito
     */
    public function isSuccess()
    {
        return $this->process;
    }

    /**
     * Retornar opeacion fallida o con exito
     */
    public function getError()
    {
        return $this->data_error;
    }

    /**
     * Retornar opeacion fallida o con exito
     */
    public function getData()
    {
        return $this->data;
    }

    public function setAthleteId($athlete_id)
    {
        $this->athlete_id = $athlete_id;
        return $this;
    }


    public static function reason_cancel($code)
    {
        $motivo = 'Motivo Desconocido';
        $data_err = [
            '0' => 'APROBADA',
            '2' => 'CONSULTE SU EMISOR - CONDICION ESPECIAL',
            '3' => 'NEGOCIO INVALIDO',
            '4' => 'RETENGA TARJETA',
            '5' => 'NO APROBADO',
            '6' => 'ERROR DE SISTEMA',
            '7' => 'RECHAZO POR CONTROL DE SEGURIDAD',
            '8' => 'TRANSACCION FALLBACK RECHAZADA',
            '12' => 'TRANSACCION INVALIDA',
            '13' => 'MONTO INVALIDO',
            '14' => 'TARJETA INEXISTENTE',
            '15' => 'EMISOR INEXISTENTE, NO HABILITADO P/NEGOC',
            '17' => 'CANCELADO POR EL CLIENTE',
            '19' => 'INTENTE OTRA VEZ',
            '22' => 'SOSPECHA DE MAL FUNCIONAMIENTO',
            '33' => 'TARJETA VENCIDA',
            '34' => 'POSIBLE FRAUDE - RETENGA TARJETA',
            '35' => 'LLAME PROCESADOR/ADQUIRENTE',
            '36' => 'TARJETA/CUENTA BLOQUEADA POR LA ENTIDAD',
            '37' => 'MES NACIMIENTO INCORRECTO-TARJ.BLOQUEADA',
            '38' => '3 CLAVES EQUIVOCADAS - TARJETA BLOQUEADA',
            '39' => 'NO EXISTE CUENTA DE TARJETA DE CREDITO',
            '40' => 'TIPO DE TRANSACCION NO SOPORTADA',
            '41' => 'TARJETA PERDIDA - RETENGA TARJETA',
            '42' => 'NO APROBADO - NO EXISTE CUENTA UNIVERSAL',
            '43' => 'TARJETA ROBADA - RETENGA TARJETA',
            '45' => 'NO EXISTE LA CUENTA ',
            '55' => 'CLAVE INVALIDA',
            '46' => 'EMISOR/BANCO NO RESPONDIO EN 49 SEGUNDOS',
            '49' => 'OPERACION NO ACEPTADA EN CUOTAS',
            '51' => 'NO APROBADA-INSUF.DE FONDOS',
            '54' => 'TARJETA VENCIDA',
            '55' => 'CLAVE INVALIDA',
            '57' => 'NO APROBADA - TARJETA INADECUADA',
            '58' => 'NO HABILITADA PARA ESTA TERMINAL',
            '59' => 'NO APROBADO - POSIBLE FRAUDE',
            '60' => 'NO APROBADO - CONSULTE PROCESADOR ADQUIR',
            '61' => 'EXCEDE MONTO LIMITE',
            '62' => 'NO APROBADA - TARJETA RESTRINGIDA',
            '63' => 'VIOLACION DE SEGURIDAD',
            '65' => 'EXCEDE CANTIDAD DE OPERACIONES',
            '66' => 'LLAMAR SEGURIDAD DEL PROCESADOR ADQUIR.',
            '70' => 'NEGOCIO INHABILITADO POR FALTA DE PAGO',
            '71' => 'OPERACIÓN YA EXTORNADA',
            '72' => 'FECHA INVALIDA',
            '73' => 'CODIGO DE SEGURIDAD INVALIDO',
            '92' => 'EMISOR DESCONECTADO - PROBLEMAS EN LINEA',
            '94' => 'TRANSACCION DUPLICADA - NO APROBADO'
        ];

        foreach ($data_err as $key => $value) {
            if ($key == $code) {
                $motivo =  $value;
            }
        }

        return $motivo;
    }

    public static function reason_error_rollback($str)
    {
        $motivo = 'Motivo Desconocido';
        $data_err = [
            'InvalidJsonError'              => 'Error en el JSON enviado',
            'UnauthorizedOperationError'    => 'Las credenciales enviadas no tienen permiso para la operación rollback',
            'ApplicationNotFoundError'      => 'No existen permisos para las credenciales enviadas',
            'InvalidPublicKeyError'         => 'Existe un error sobre la clave pública enviada',
            'InvalidTokenError'             => 'El token se generó en forma incorrecta',
            'InvalidOperationError'         => 'El JSON enviado no es válido. No cumple con los tipos o limites definidos.',
            'BuyNotFoundError'              => 'No existe el proceso de compra seleccionado',
            'PaymentNotFoundError'          => 'No existe un pedido de pago para el proceso seleccionado. Esto quiere decir que el cliente no pagó este pedido y deberá tomarse como una respuesta correcta para dichas situaciones.',
            'AlreadyRollbackedError'        => 'Ya existe un pedido de rollback previo',
            'PosCommunicationError'         => 'Existen problemas de comunicación con el componente de petición de rollback',
            'TransactionAlreadyConfirmed'   => 'Transacción Cuponada (Confirmada en el extracto del cliente)',
        ];

        foreach ($data_err as $key => $value) {
            if ($key == $str) {
                $motivo =  $value;
            }
        }

        return $motivo;
    }


     /**
     * Se crear una compra temporal, que retonar el id de la tabla Sale, con ese dato
     * se realizan las operaciones con la plataforma de pago o de forma gratuita.
     */
    public function createPayment(Request $request)
    {
        try {

            // TODO: necesitamos cambiar el estado de lo que se pago, por ejemplo inscripcion
            
            $payment_gateway = $request->input('payment_gateway');
            $inscription_id = $request->input('inscription_id') ? $request->input('inscription_id') : null;
            $membership_id = $request->input('membership_id') ? $request->input('membership_id') : null;
            $federation_id = $request->input('federation_id');
            $association_id = $request->input('association_id');
            $payment_for = $request->input('payment_for'); // si el pago es para membresia o para inscripcion
            $total_payment = $request->input('total_payment');
            $json_request = $request->input('json_request');
            $athlete_id = $request->input('athlete_id');

            $type_payment = 'single_buy';

            $msj_status = '';
            $status = false;
            $data = null;

            //aqui necesitamos colocar los datos del pago, por ejemplo el precio y que se va a pagar
            if($inscription_id) {
                $existPayment = Payment::where('inscription_id', $inscription_id)
                    ->first();

                if($existPayment) {
                    return response()->json(["messages" => "Pago existente", "data" => $existPayment], 200);
                }
            }

            if($membership_id) {
                $existPayment = Payment::where('membership_id', $membership_id)
                    ->first();

                if($existPayment) {
                    return response()->json(["messages" => "Pago existente", "data" => $existPayment], 200);
                }
            }


            if ($payment_gateway == 'transferencia') {
                $status = true;

                // Crear la compra a ser procesada
                $payment = Payment::create([
                    'inscription_id' => $inscription_id,
                    'membership_id' => $membership_id,
                    'payment_gateway' => $payment_gateway,
                    'status' => 'confirmado',
                    'federation_id' => $federation_id,
                    'association_id' => $association_id,
                    'athlete_id' => $athlete_id,
                    'json_request' => json_encode($json_request),
                ]);


                $obj = new \StdClass;
                $obj->process = $status;
                $obj->data_error = "Ocurrió un error que no sabemos";

                return response()->json(["messages" => "Pago creado correctamente", "data" => $obj], 200);

            } else if ($payment_gateway == 'vpos') {
                $status = true;

                // Crear la compra a ser procesada
                $payment = Payment::create([
                    'inscription_id' => $inscription_id,
                    'membership_id' => $membership_id,
                    'payment_gateway' => $payment_gateway,
                    'status' => 'pendiente',
                    'federation_id' => $federation_id,
                    'association_id' => $association_id,
                    'athlete_id' => $athlete_id,
                ]);
                $payment_id = $payment->id;
                // HASHEAR ID DE PEDIDO
                $payment_id_encode = Hashids::encode($payment_id);

                //STAGING CONFIGURATION
                $bancard = new BancardGateway;

                if ($type_payment == 'single_buy' || $type_payment == 'zimple') {
                    //2 y 3
                    $zimple = ($type_payment == 'zimple') ? 'S' : null;
                    $description_payment = ($payment_for == 'membresia') ? "Pago de Membresia" : "Pago de Inscripcion";
                    $bancard->create_single_buy(
                        $total_payment,
                        $payment_id,
                        $payment_id_encode,
                        $description_payment,
                        $zimple,
                        $payment_for
                    );
                    
                    if ($bancard->isSuccess()) {
                        $data =  $bancard->getData();
                    } else {
                        $bancard_error = $bancard->getErrorData();
                        $msj_status = '(BX002) Ocurrio un error al intentar obtener el codigo de procesamiento';
                        $status = false;
                    }
                }
            } 


            $this->process = $status;
            $this->data = $data;
            $this->data_error = $msj_status;

            $obj = new \StdClass;
            $obj->process = $this->process;
            $obj->process_id = $this->data;
            $obj->data_error = $this->data_error;

           return response()->json(["messages" => "Pago creado correctamente", "data" => $obj], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["messages" => "Epaaaa"], 400);
        }
    }


    public static function rollbackPaymentBancard($payment_id)
    {
        $operation = new \StdClass;
        $operation->status = false;
        $operation->msj = 'No hubo registro';
    
        try {
            DB::beginTransaction();

            $bancard = new BancardGateway();

            $bancard->transactionRollback($payment_id);

            $payment = Payment::findById($payment_id);
            // aca hacemos el update de ese pago
            $payment->json_rollback = json_encode($bancard->getResponse());

            if ($bancard->isSuccess()) {
                $operation->status = true;
                $payment->status = 'cancelado';

            } else {
                $operation->status = false;
                $err = $bancard->getErrorData();
                $operation->msj = $err[0]->dsc;
            }
            // $transaction->save();

            DB::commit();
        } catch (\Exception $e) {
            $operation->status = false;
            $operation->msj = $e->getMessage();

            DB::rollback();
        }

        return $operation;
    }


    private static function confirmPayment($payment_id, $response, $request)
    {
        #REGISTRAR REQUEST
        $payment = new Payment;
        $payment->payment_id = $payment_id;
        $payment->json_response = json_encode($response);
        $payment->json_request = json_encode($request);
        $payment->status = 'confirmado';
        $payment->save();

        return ["messages" => "Pago Confirmado Correctamente"];
    }


    /**
     * Registra el response de bancard y cancela la venta
     * Llama a operacion de rollback bancard
     */
    private static function rejectPayment($payment_id, $response, $request)
    {
        #REGISTRAR REQUEST
        $payment = Payment::findOrFail($payment_id);
        $payment->payment_id = $payment_id;
        $payment->json_response = json_encode($response);
        $payment->json_request = json_encode($request);
        $payment->status = 'cancelado';
        $payment->save();

        return ["messages" => "Pago Cancelado Correctamente"];
    }


    public static function confirmPaymentBancard()
    {
        // $status = 'OK';
        
        $operation = (object)request()->operation;
        $shop_process_id = $operation->shop_process_id; 
        $amount = $operation->amount;
        $token = $operation->token;
        

        try {
            $bancard = new BancardGateway;

            $response_varchar = (string)$operation->response;
            $response_code = (string)$operation->response_code;

            if ($response_varchar === 'S' &&  $response_code === '00') {
                $status = self::confirmPayment($shop_process_id, $operation, null);
                return response()->json($status, 200);
            } else {
                self::rejectPayment($shop_process_id, $operation, null);
                $status = self::reason_cancel($response_code);
                return response()->json($status, 200);
            }
           
        } catch (\Exception $e) {
            return response()->json(['messages' => $e->getMessage()], 400);
        }
    }


    

}
