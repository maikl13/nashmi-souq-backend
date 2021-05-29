<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function sendResetLinkEmail(Request $request)
    {
        // $request->validate([
        //     'phone' => 'phone:AUTO,EG'
        // ]);
        
        $user = User::where('email', $request->phoneoremail)->first();
        if($user) {
            $response = $this->broker()->sendResetLink(['email' => $request->phoneoremail]);
    
            return $response == Password::RESET_LINK_SENT
                        ? $this->sendResetLinkResponse($request, $response)
                        : $this->sendResetLinkFailedResponse($request, $response);
        }

        if(!$user)
            $user = User::where('phone', $request->phoneoremail)->first();

        if(!$user)
            $user = User::where('phone_national', $request->phoneoremail)->first();

        if(!$user){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(location()->code)] ]);
            if(!$validator->fails())
                $user = User::where('phone', phone($request->phoneoremail, location()->code)->formatE164())->first();
        }

        if(!$user){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(country()->code)] ]);
            if(!$validator->fails())
                $user = User::where('phone', phone($request->phoneoremail, country()->code)->formatE164())->first();
        }


        if($user){
            $user->generate_otp();
            $user->send_otp(true);

            return redirect()->route('login')->withInput(['phoneoremail' => $user->phoneoremail])->with('resetbyotp', true);
        } else {
            return redirect()->back()->with('failure', 'بيانات الاعتماد غير مسجلة لدينا!');
        }
    }
}
