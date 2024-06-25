<?php

namespace App\Http\Controllers\Auth\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
// use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Builder;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {   

        try {
        
            $input = $request->all();

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
                'federation_id' => 'required'
            ]);

        
            if(auth('athletes')->attempt(array('email' => $input['email'], 'password' => $input['password'] ))){
                        
                $user = auth('athletes')->user();                
                $federationOfUser = $user->federation($input['federation_id'])->first();
                $user->federation = $federationOfUser;
                
                if($user->type !== 'athlete'){
                    return response()->json(['message' => ' Usuario no es Atleta'], 400);
                }
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'user' => $user,
                    'token' => $token,
                ];

                return response()->json($response, 200);
            } else {
                return response()->json(['message' => ' E-mail o Contraseña no correcta'], 400);
            
            }
        
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}