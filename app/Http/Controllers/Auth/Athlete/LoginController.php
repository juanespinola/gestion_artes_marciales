<?php

namespace App\Http\Controllers\Auth\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
// use App\Http\Resources\UserResource;

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
            ]);

        
            if(auth('athletes')->attempt(array('email' => $input['email'], 'password' => $input['password']))){
                        
                $user = auth('athletes')->user();
                
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    // 'user' => new UserResource($user),
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