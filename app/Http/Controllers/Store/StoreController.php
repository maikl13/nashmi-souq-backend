<?php

namespace App\Http\Controllers\Store;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function index()
    {
        $stores = User::whereNotNull('store_name')->orderBy('store_logo', 'desc')->paginate(18);
        return view('main.store.stores')->with('stores', $stores);
    }

    public function home($store)
    {
        return view('store.home')->with('store', $store);
    }

    public function pricing()
    {
        return view('main.store.pricing');
    }

    public function create()
    {
        if(auth()->user()->is_store())
            return redirect()->to(auth()->user()->store_url().'/dashboard');
        
        return view('main.store.new');
    }

    public function dashboard()
    {
        return view('store-dashboard.dashboard');
    }

    public function delete_banner()
    {
        return Auth::user()->delete_file('store_banner');
    }

    public function delete_logo()
    {
        return Auth::user()->delete_file('store_logo');
    }


    public function edit()
    {
        return view('store-dashboard.settings.store-settings');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'store_name' => 'required|min:2|max:255',
            'store_slug' => 'required|min:1|max:255|unique:users,store_slug,'.$user->id,
            'store_slogan' => 'nullable|min:20|max:255',
            'store_website' => 'nullable|url|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_address' => 'nullable|max:1000',
            'store_description' => 'nullable|max:3000',
            'social.*' => 'nullable|url',
            'store_banner' => 'nullable|image|max:8192',
            'store_logo' => 'nullable|image|max:8192',
            // 'country' => 'exists:countries,id',
            'subscription_type' => 'in:1,2,3',
        ]);

        $user->store_name = $request->store_name;
        $user->store_slug = $request->store_slug;
        $user->store_slogan = $request->store_slogan;
        $user->store_website = $request->store_website;
        $user->store_email = $request->store_email;
        $user->store_address = $request->store_address;
        $user->store_description = $request->store_description;
        // $user->country_id = $request->country;
        $user->subscription_type = $request->subscription_type;

        $social_links = [];
        if(is_array($request->social))
            foreach ($request->social as $social_link)
                if($social_link) $social_links[] = $social_link;
        $user->store_social_accounts = json_encode($social_links);

        $user->upload_store_banner($request->file('store_banner'));
        $user->upload_store_logo($request->file('store_logo'));

        if($user->save()){
            if(!auth()->user()->started_trial())
                auth()->user()->start_trial();
            return redirect()->to(auth()->user()->store_url().'/dashboard');
        }
        return back()->with('error', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    public function update_payout_methods(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bank_account' => 'required',
            'paypal' => 'nullable|email|max:255',
            'national_id' => 'nullable|min:14|max:14',
            'vodafone_cash' => 'nullable|phone:EG|max:255',
        ]);
        
        $user->bank_account = $request->bank_account;
        $user->paypal = $request->paypal;
        $user->national_id = $request->national_id;
        $user->vodafone_cash = $request->vodafone_cash;
        
        if($user->save()){
            return response()->json('تم تحديث وسائل سحب الأرباح بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
