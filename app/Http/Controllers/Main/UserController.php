<?php

namespace App\Http\Controllers\Main;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function delete_profile_picture(){
        return Auth::user()->delete_file('profile_picture');
    }

    public function edit()
    {
        return view('main.users.account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if(!isset($request->password) || !Hash::check($request->password, $user->password))
            return response()->json('كلمة المرور غير صحيحة.', 500);

        $request->validate([
            'name' => 'required|min:2|max:255',
            'username' => 'required|min:2|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,'.$user->id,
            'profile_picture' => 'image|max:8192',
            'country' => 'exists:countries,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country_id = $request->country;

        $user->upload_profile_picture($request->file('profile_picture'));

        if($user->save()){
            return response()->json('تم تحديث البيانات بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'new_password' => 'required|min:8|confirmed',
            'password' => 'required',
        ]);

        if(Hash::check($request->password, $user->password)){
            $user->password = Hash::make($request->new_password);
        
            if($user->save())
                return response()->json('تم تحديث كلمة المرور!', 200);

            return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
        } else {
            return response()->json('كلمة المرور غير صحيحة.', 500);
        }
    }
}
