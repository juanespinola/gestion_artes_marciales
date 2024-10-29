<?php

namespace App\Http\Controllers\Auth\Athlete;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\FederationsAthletes;
use App\Models\MinorAuthorization;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'
                // , 'confirmed'
            ],
            'birthdate' => ['required', 'date'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $athlete = Athlete::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthdate' => $data['birthdate'],
            'document' => $data['document'],
            'gender' => $data['gender'],
            'is_minor' => $this->isMinor($data['birthdate']),
            'country_id' => $data['country_id'],
            'type_document_id' => $data['type_document_id'],
            'city_id' => $data['city_id'],
            'academy_id' => $data['academy_id'],
            'belt_id' => $data['belt_id'],
            'phone' => $data['phone'],
        ]);

        // TODO:falta agregar la federacion y associacion
        $federationAthletes = FederationsAthletes::create([
            'athlete_id' => $athlete->id,
            'federation_id' => $data['federation_id'],
            'association_id' => $data['association_id']
        ]);

        if($this->isMinor($data['birthdate'])){
            MinorAuthorization::create([
                'athlete_id' => $athlete->id,
                'federation_id' => $data['federation_id']
            ]);
        }

        return $athlete;
        // return auth('athletes')->loginUsingId($athlete->id);
        // if( auth('athletes')->loginUsingId($athlete->id)){
                   
        //     $user = auth('athletes')->user();                
            
        //     $user->city = $user->city()->first();
        //     $user->country = $user->country()->first();
        //     $user->typeDocument = $user->typeDocument()->first();

        //     $federationOfUser = $user->federation($data['federation_id'])->with('association')->first();

        //     $user->federation = $federationOfUser;
        

        //     if($user->type !== 'athlete'){
        //         return response()->json(['message' => ' Usuario no es Atleta'], 400);
        //     }
        //     $token = $user->createToken('my-app-token')->plainTextToken;
        //     $response = [
        //         'user' => $user,
        //         'token' => $token,
        //     ];

        //     activity('login')
        //         ->causedBy($user)
        //         ->withProperties(['ip' => request()->ip()])
        //         ->log('Athlete Login');
            

        //     return response()->json($response, 200);
        // } else {
        //     return response()->json(['message' => 'Ocurrió un error'], 400);
        // }
    }

    private function isMinor($birthdate) {
        return Carbon::parse($birthdate)->age < 18;
    }
}
