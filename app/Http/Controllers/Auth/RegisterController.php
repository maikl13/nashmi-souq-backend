<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/login';

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
        $validator = Validator::make($data, [ 'phone' => ['phone:AUTO,'.$data['phone_phoneCode']] ]);

        if($validator->fails()) return $validator;

        $data['phone'] = phone($data['phone'], $data['phone_phoneCode'])->formatE164();

        return Validator::make($data, [
            'phone' => ['required', 'string', 'max:255', 'unique:users', 'phone:AUTO,'.$data['phone_phoneCode']],
        ],['phone' => 'من فضلك قم بإدخال رقم هاتف صحيح']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $uid = uniqid();
        $otp = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
        
        $user = User::create([
            'name' => 'User_'.$uid,
            'username' => $uid,
            'phone' => phone($data['phone'], $data['phone_phoneCode'])->formatE164(),
            'phone_national' => phone($data['phone'], $data['phone_phoneCode'])->formatForMobileDialingInCountry($data['phone_phoneCode']),
            'phone_country_code' => $data['phone_phoneCode'],
            'password' => Hash::make($otp),
            'otp' => $otp,
        ]);

        if($user) $user->send_otp();
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // prevent after registeration login
        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath())->withInput(['phone' => $user->phone_national])->with('registered', true);
    }
}
