<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        $request->validate([
            'phoneoremail' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $authinticated = false;
        $remember = $request->remember ? true : false;
        
        $user = User::where('email', $request->phoneoremail)->first();
        if(Auth::attempt(['email' => $request->phoneoremail, 'password' => $request->password], $remember) ) 
            $authinticated = true;

        if(!$authinticated){
            $user = User::where('phone', $request->phoneoremail)->first();
            if(Auth::attempt(['phone' => $request->phoneoremail, 'password' => $request->password], $remember) ) 
                $authinticated = true;
        }

        if(!$authinticated){
            $user = $user ?? User::where('phone_national', $request->phoneoremail)->first();
            if(Auth::attempt(['phone_national' => $request->phoneoremail, 'password' => $request->password], $remember) )
                $authinticated = true;
        }

        if(!$authinticated){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(location()->code)] ]);
            if(!$validator->fails()){
                $phone = phone($request->phoneoremail, location()->code);
                $user = $user ?? User::where('phone', $phone)->first();
                if(Auth::attempt(['phone' => $phone, 'password' => $request->password], $remember) ) 
                    $authinticated = true;
            }
        }

        if(!$authinticated){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(country()->code)] ]);
            if(!$validator->fails()){
                $phone = phone($request->phoneoremail, country()->code);
                $user = $user ?? User::where('phone', $phone)->first();
                if(Auth::attempt(['phone' => $phone, 'password' => $request->password], $remember) ) $authinticated = true;
            }
        }

        if(!$authinticated){
            if($user && $request->password == $user->otp){
                $user->password = Hash::make($user->otp);
                $user->save();
                $this->guard()->login($user);
                $authinticated = true;
            }
        }

        if($authinticated) {
            if(Auth::user()->otp){
                Auth::user()->otp = null;
                Auth::user()->save();
            }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
    
}
