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
        return Auth::user()->delete_profile_picture();
    }

    public function edit()
    {
        return view('main.users.account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if(!isset($request->password) || !Hash::check($request->password, $user->password))
        	return redirect()->back()->with('failure', "كلمة المرور غير صحيحة.");

        $request->validate([
            'name' => 'required|min:2|max:255',
            'username' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'profile_picture' => 'image|max:8192',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->upload_profile_picture($request->file('profile_picture'));
        if($user->save()){
        	return redirect()->back()->with('success', "تم تحديث البيانات بنجاح.");
        }

        return redirect()->back()->with('failure', "حدث خطأ ما! من فضلك حاول مجددا.");
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
        
            if($user->save()){
                return response()->json('تم حفظ البيانات بنجاح.', 200);
            } else {
                return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
            }
        } else {
        	return redirect()->back()->with('failure', "Password is not Correct.");
        }
        return redirect()->back()->with('success', "Password changed successfully.");
    }
}
