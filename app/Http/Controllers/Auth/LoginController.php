<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Spatie\Activitylog\Models\Activity;

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

        
            if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
                        
                $user = Auth::user();
                
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'user' => new UserResource($user),
                    // 'user' => $user,
                    'token' => $token,
                ];

                activity('login')
                    ->causedBy($user)
                    ->withProperties(['ip' => $request->ip()])
                    ->log('Admin Login');

                return response()->json($response, 200);
            } else {
                return response()->json(['message' => ' E-mail o Contraseña no correcta'], 400);
            
            }
        
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        activity('logout')
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('Admin Logout');

        Auth::logout();

        return response()->json(["message" => "Usuario desconectado"], 200);
    }

}