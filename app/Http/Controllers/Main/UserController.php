<?php

namespace App\Http\Controllers\Main;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $stores = User::whereNotNull('store_name')->orderBy('store_logo', 'desc')->paginate(18);
        return view('main.users.stores')->with('stores', $stores);
    }

    public function delete_profile_picture(){
        return Auth::user()->delete_profile_picture();
    }
    public function delete_store_banner(){
        return Auth::user()->delete_store_banner();
    }
    public function delete_store_logo(){
        return Auth::user()->delete_store_logo();
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

    public function update_store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'store_name' => 'required|min:2|max:255',
            'store_slogan' => 'nullable|min:20|max:255',
            'store_website' => 'nullable|url|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_address' => 'nullable|max:1000',
            'store_description' => 'nullable|max:3000',
            'social.*' => 'nullable|url',
            'store_banner' => 'nullable|image|max:8192',
            'store_logo' => 'nullable|image|max:8192',
        ]);

        $user->store_name = $request->store_name;
        $user->store_slogan = $request->store_slogan;
        $user->store_website = $request->store_website;
        $user->store_email = $request->store_email;
        $user->store_address = $request->store_address;
        $user->store_description = $request->store_description;

        $social_links = [];
        foreach ($request->social as $social_link)
            if($social_link) $social_links[] = $social_link;
        $user->store_social_accounts = json_encode($social_links);

        $user->upload_store_banner($request->file('store_banner'));
        $user->upload_store_logo($request->file('store_logo'));

        if($user->save()){
            return response()->json('تم تحديث بيانات المتجر بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function show(User $user)
    {
        return view('main.users.profile')->with('user', $user);
    }
}
