<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Validator;

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

        $user = User::where('phone', $request->phone)->first();

        if(!$user)
            $user = User::where('phone_national', $request->phone)->first();

        if(!$user){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(location()->code)] ]);
            if(!$validator->fails())
                $user = User::where('phone', phone($request->phone, location()->code)->formatE164())->first();
        }

        if(!$user){
            $validator = Validator::make($request->all(), ['phone' => ['phone:'.strtoupper(country()->code)] ]);
            if(!$validator->fails())
                $user = User::where('phone', phone($request->phone, country()->code)->formatE164())->first();
        }

        if($user){
            $user->generate_otp();
            $user->send_otp(true);
            return redirect()->route('login')->withInput(['phone' => $user->phone_national])->with('reset', true);
        } else {
            return redirect()->back()->with('failure', 'رقم الهاتف غير مسجل لدينا!');
        }
    }
}
