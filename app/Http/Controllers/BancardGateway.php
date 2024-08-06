<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BancardGateway
{
     /**
     * Clave privada de comunicacion
     *
     * @var string
     */
    private $v_private_key;

    /**
     * Clave publica de comunicacion
     *
     * @var string
     */
    private $v_public_key;

    /**
     * Url de comunicacion api de transaccion
     *
     * @var string
     */
    private $v_url;

    /**
     * Url de redireccion en caso de error
     *
     * @var string
     */
    private $v_return_error;

    /**
     * Url de redireccion en caso de exito
     *
     * @var string
     */
    private $v_return_success;

    /**
     * Moneda de transaccion
     *
     * @var string
     */
    private $v_currency = 'PYG';

    /**
     * Array a ser enviada a la api de transaccion
     *
     * @var array
     */
    private $request;

    /**
     * Array de respuesta de la api
     *
     * @var array
     */
    private $response;


    /**
     * Valor booleano para confirmar la transaccion
     *
     * @var boolean
     */
    private $transaction_process;

    /**
     * Clave para realizar una transaccion
     *
     * @var string
     */
    private $key_transaction;

    /**
     * Data error
     *
     * @var array
     */
    private $message_error;

    /**
     * Error bancard
     *
     * @var array
     */
    private $error_com;


    /**
     * Data info
     *
     * @var array
     */
    private $data;

    /**
     * ID del registro de configuracion del vPOS
     */
    private int $v_pos_config_id;

    public function __construct()
    {
        $this->setCredentials();
        $this->setReturnUrls();
        
    }

    public function setCredentials()
    {
        $this->v_url = env('DEVELOP_BANCARD_URL');
        $this->v_private_key = env('DEVELOP_BANCARD_PRIVATE_KEY');
        $this->v_public_key = env('DEVELOP_BANCARD_PUBLIC_KEY');
    }

    /**
     * Validar si la operacion fue exitosa o tuv errror
     *
     * @return  boolean $transaction_process
     */
    public function isSuccess()
    {
        return $this->transaction_process;
    }

    /**
     * Key de transaccion
     *
     * @return  string $transaction_process
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Datos del error
     *
     * @return  array $message_error
     */
    public function getErrorData()
    {
        return $this->message_error;
    }

    /**
     * Datos del error bancard
     *
     * @return  array $message_error
     */
    public function getError()
    {
        return $this->error_com;
    }

    /**
     * Obtener datos de envio a api
     *
     * @return  array $request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Obtener datos de respuesta de la api
     *
     * @return  array $response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function setReturnUrls($payment_id = null)
    {
        $this->v_return_error = $this->v_return_success = "events" . "?confirm=$payment_id";
    }

    public function setVPosConfigID($id): void
    {
        $this->v_pos_config_id = $id;
    }

    public function getVPosConfigID(): int
    {
        return $this->v_pos_config_id;
    }

    /**
     * Crea una pedido de transaccion single buy que retorna una key para invocar el frame de pago
     */
    public function create_single_buy($amount, $shop_process_id, $payment_id_encode, $v_description, $zimple = null, $phone = null, $add_data = null) {

        
        // $this->setReturnUrls($shop_process_id);
        $amount = (string)number_format($amount, 2, '.', '');
        $v_shop_process_id = (string)$shop_process_id;
        $v_single_buy_token = md5($this->v_private_key . $v_shop_process_id . $amount . $this->v_currency);
        $enlace = $this->v_url . "single_buy";
        
        if ($zimple) {
            $additional_data = $phone;
        } elseif ($add_data) {
            $additional_data = $add_data;
        } else {
            $additional_data = '';
        }

        $operation = [];
        $operation['token']             = $v_single_buy_token;
        $operation['shop_process_id']   = $v_shop_process_id;
        $operation['amount']            = $amount;
        $operation['currency']          = $this->v_currency;
        $operation['additional_data']   = $additional_data;
        $operation['description']       = $v_description;
        $operation['return_url']        = $this->v_return_success;
        $operation['cancel_url']        = $this->v_return_error;
        if ($zimple)
            $operation['zimple']        = 'S';

       

        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation"  => $operation
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);

        if ($resp) {
            $response = (object)$resp;
            $this->response = $resp;

            if ($response->status == 'success') {
                $this->transaction_process = true;
                $this->data = $response->process_id;
            } else {
                $this->transaction_process = false;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * Realiza una peticion a la api con el process_id para confirmar una operacion.
     * Al momento de realizar la operacion puede surgir dos clases de errores, cuando no se puede obtener
     * los datos de confirmacion por error via api de bancard o por un error de comunicacion
     *
     * @param  integer $shop_process_id
     */
    public function confirmSingleBuy($shop_process_id)
    {
        $v_shop_process_id = (string)$shop_process_id;
        $v_single_buy_get_confirmation = md5($this->v_private_key . $v_shop_process_id . "get_confirmation");
        $enlace = $this->v_url . "single_buy/confirmations";


        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation" => array(
                "token" => $v_single_buy_get_confirmation,
                "shop_process_id" => $v_shop_process_id
            )
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);
        $response = (object)$resp;
        $this->response = $response;

        //Validar que no exista error de comunicacion
        if ($resp) {

            //Comunicacion exitosa
            if ($response->status == 'success') {
                $this->transaction_process = true;
                $this->data = (object)$response->confirmation;

                //Transaccion aprobada
                if ($this->data->response_code == "00") {
                    $this->transaction_process = true;
                } else {
                    //Transaccion rechazada
                    $this->transaction_process = false;
                    $err['reason_cancel'] = $this->reason_cancel($this->data->response_code);
                    $err['response_description'] = $this->reason_cancel($this->data->response_description);
                    $err['code'] = $this->data->response_code;
                    $this->message_error = $err;
                }
            } else {
                //Ocurrio un error y no se pudo obtener los datos de confirmacion
                $this->transaction_process = false;
                $this->error_com = true;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $this->error_com = true;
            $err['error'] = 'Error de conexion con Bancard';
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * Recibe el codigo de error de una transaccion y retorna el motivo
     *
     * @param string $code
     * @return string $motivo
     */
    private function reason_cancel($code)
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

    /**
     * Confirma el token que recibimos en el cuerpo de confirmacion de una transaccion
     *
     */
    public function confirmTokenSingleBuy($shop_process_id, $amount, $token)
    {
        return true;
        $v_single_confirm_token = md5($this->v_private_key . $shop_process_id . "confirm" . $amount . $this->v_currency);
        if ($token === $v_single_confirm_token) {
            return true;
        }
        return false;
    }

    /**
     * Invocar a un nuevo catastro de tarjeta, retorna un key process_id para levantar un iframe de bancard
     *
     */
    public function newCard($user_id, $card_id, $cell_phone, $email)
    {
        $v_user_id = (string)$user_id;
        $v_card_id = (string)$card_id;
        $v_new_card_token = md5($this->v_private_key . $v_card_id . $v_user_id . "request_new_card");
        $enlace = $this->v_url . "cards/new";

        $operation = [];
        $operation['token']             = $v_new_card_token;
        $operation['card_id']           = (int)$card_id;
        $operation['user_id']           = (int)$user_id;
        $operation['user_cell_phone']   = (string)$cell_phone;
        $operation['user_mail']         = (string)$email;
        // $operation['return_url']        = route('cards.index');
        //  $operation['return_url']        = $this->$v_return_success."/add/card";

        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation"  => $operation
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);

        if ($resp) {
            $response = (object)$resp;
            $this->response = $response;

            if ($response->status == 'success') {
                $this->transaction_process = true;
                $this->data = $response->process_id;
            } else {
                $this->transaction_process = false;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * Recuperar Tarjetas catastradas de un usuario (users_cards)
     *
     */
    public function listCardUser($user_id)
    {
        $v_user_id = (string)$user_id;
        //md5/SHA256(private_key + user_id + "request_user_cards”)
        $v_request_user_card = md5($this->v_private_key . $v_user_id . "request_user_cards");
        $enlace = $this->v_url . "users/$v_user_id/cards";

        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation" => array(
                "token" => $v_request_user_card
            )
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);
        $response = (object)$resp;
        $this->response = $response;

        //Validar que no exista error de comunicacion
        if ($resp) {

            //Comunicacion exitosa
            if ($response->status == 'success') {
                $this->transaction_process = true;
                $this->data = $response->cards;
            } else {
                //Ocurrio un error y no se pudo obtener los datos de confirmacion
                $this->transaction_process = false;

                $err_list = $response->messages;
                $err_str = '';
                foreach ($err_list as $key => $value) {
                    $err_str .= $value->dsc . PHP_EOL;
                }
                $this->message_error = $err_str;
                Log::error($err_list);
                Log::error(json_encode($response));
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * Pago con token(charge)
     *
     */
    public function createPayToken($shop_process_id, $amount, $number_of_payments, $alias_token, $description)
    {
        $v_shop_process_id = (string)$shop_process_id;
        $amount = (string)number_format($amount, 2, '.', '');
        //md5/SHA256(private_key + shop_process_id + "charge" + amount + currency + alias_token)
        $token = md5($this->v_private_key . $v_shop_process_id . "charge" . $amount . $this->v_currency . $alias_token);
        $enlace = $this->v_url . "charge";


        $operation = [];
        $operation['token']                 = $token;
        $operation['shop_process_id']       = (int)$shop_process_id;
        $operation['amount']                = $amount;
        $operation['number_of_payments']    = (int)$number_of_payments;
        $operation['currency']              = $this->v_currency;
        $operation['additional_data']       = "";
        $operation['description']           = $description;
        $operation['alias_token']           = $alias_token;

        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation"  => $operation
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);
        $response = (object)$resp;
        $this->response = $response;

        //Validar que no exista error de comunicacion
        if ($resp) {

            //Comunicacion exitosa
            if ($response->status == 'success') {
                $this->transaction_process = true;
                $this->data = (object)$response->confirmation;

                //Transaccion aprobada
                if ($this->data->response_code == "00") {
                    $this->transaction_process = true;
                } else {
                    //Transaccion rechazada
                    $this->transaction_process = false;
                    $err['reason_cancel'] = $this->reason_cancel($this->data->response_code);
                    $err['response_description'] = $this->reason_cancel($this->data->response_description);
                    $err['code'] = $this->data->response_code;
                    $this->message_error = $err;
                }
            } else {
                //Ocurrio un error y no se pudo obtener los datos de confirmacion
                $this->transaction_process = false;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $err['error'] = 'Error de conexion con Bancard';
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * Eliminar tarjeta catastrada
     *
     */
    public function deleteCard($user_id, $alias_token)
    {
        //md5/SHA256(private_key + "delete_card" + user_id + alias_token)
        $token = md5($this->v_private_key . "delete_card" . $user_id . $alias_token);
        $enlace = $this->v_url . "users/$user_id/cards";


        $operation = [];
        $operation['token']             = $token; //String (32)
        $operation['alias_token']       = $alias_token; //String (255)


        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation"  => $operation
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace, 'DELETE');
        $response = (object)$resp;
        $this->response = $response;

        //Validar que no exista error de comunicacion
        if ($resp) {

            //Comunicacion exitosa
            if ($response->status == 'success') {
                $this->transaction_process = true;
            } else {
                //Ocurrio un error y no se pudo obtener los datos de confirmacion
                $this->transaction_process = false;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $err['error'] = 'Error de conexion con Bancard';
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /**
     * La transaccion se cancela en bancard
     */
    public function transactionRollback($shop_process_id)
    {
        $shop_process_id = (string)$shop_process_id;
        $token = md5($this->v_private_key . $shop_process_id . "rollback" . "0.00");
        $enlace = $this->v_url . "single_buy/rollback";

        $data = json_encode(array(
            "public_key" => $this->v_public_key,
            "operation" => array(
                "token" => $token,
                "shop_process_id" => $shop_process_id
            )
        ));

        $this->request = $data;
        $resp = $this->sendData($data, $enlace);
        $response = (object)$resp;
        $this->response = $response;

        //Validar que no exista error de comunicacion
        if ($resp) {

            //Comunicacion exitosa
            if ($response->status == 'success') {
                $this->transaction_process = true;
            } else {
                //Ocurrio un error y no se pudo obtener los datos de confirmacion
                $this->transaction_process = false;
                $this->message_error = $response->messages;
            }
        } else {
            //Ocurrio un error de comunicacion
            $this->transaction_process = false;
            $err['error'] = 'Error de conexion con Bancard';
            $this->message_error = 'Error de conexion con Bancard';
        }
    }

    /*
    * Recibe enlace y los datos Json a ser enviados y retorna la respuesta recibida
    */
    public function sendData($data, $url, $opt = 'POST')
    {
        // abrimos la sesión cURL
        $ch = curl_init($url);

        // indicamos el tipo de petición
        if ($opt == 'POST')
            curl_setopt($ch, CURLOPT_POST, 1);

        if ($opt == 'DELETE')
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');


        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //Agregamos los encabezados del contenido
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        //Cerramos la sesion
        curl_close($ch);
        $result =  json_decode($result);
        return $result;
    }
}
