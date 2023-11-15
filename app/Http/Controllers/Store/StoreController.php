<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // $stores = User::whereNotNull('store_name')->orderBy('store_logo', 'desc')->paginate(18);
        $stores = User::whereNotNull('store_name')->whereHas('products')
            ->whereHas('active_subscriptions')->inRandomOrder()->paginate(12);

        return view('main.store.stores')->with('stores', $stores);
    }

    public function home($store)
    {
        return view('store.home')->with('store', $store);
    }

    public function unavailable($store)
    {
        return view('errors.unavailable-store');
    }

    public function pricing()
    {
        return view('main.store.pricing');
    }

    public function create()
    {
        if (auth()->user()->is_store()) {
            return redirect()->to(auth()->user()->store_url().'/dashboard');
        }

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
            'store_name' => 'required|min:2|max:30',
            'store_slug' => 'required|alpha_dash|min:1|max:20|unique:users,store_slug,'.$user->id,
            'store_slogan' => 'nullable|min:20|max:255',
            'store_website' => 'nullable|url|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_phone' => 'nullable|phone:AUTO|max:255',
            'store_whatsapp' => 'nullable|phone:AUTO|max:255',
            'store_address' => 'nullable|max:1000',
            'store_description' => 'nullable|max:3000',
            'social.*' => 'nullable|url',
            'store_banner' => 'nullable|image|max:8192',
            'store_logo' => 'nullable|image|max:8192',
            // 'country' => 'exists:countries,id',
            'subscription_type' => 'in:1,2,3',
            'categories' => 'min:1',
            'categories.*' => 'exists:categories,id',
            'store_online_payments' => 'required_without:store_cod_payments',
            'store_cod_payments' => 'required_without:store_online_payments',
        ]);

        $user->store_name = $request->store_name;
        $user->store_slug = $request->store_slug;
        $user->store_slogan = $request->store_slogan;
        $user->store_website = $request->store_website;
        $user->store_email = $request->store_email;
        $user->store_phone = $request->store_phone;
        $user->store_whatsapp = $request->store_whatsapp;
        $user->store_address = $request->store_address;
        $user->store_description = $request->store_description;
        // $user->country_id = $request->country;
        $user->subscription_type = $request->subscription_type;
        $user->store_online_payments = $request->store_online_payments == 'on';
        $user->store_cod_payments = $request->store_cod_payments == 'on';

        $social_links = [];
        if (is_array($request->social)) {
            foreach ($request->social as $social_link) {
                if ($social_link) {
                    $social_links[] = $social_link;
                }
            }
        }
        $user->store_social_accounts = json_encode($social_links);

        $user->store_categories = $request->categories;

        $user->upload_store_banner($request->file('store_banner'));
        $user->upload_store_logo($request->file('store_logo'));

        if ($user->save()) {
            if (! auth()->user()->started_trial()) {
                auth()->user()->start_trial();
            }

            return redirect()->to($user->store_url().'/dashboard/store-settings')->with('success', 'تم الحفظ بنجاح');

            return back()->with('success', 'تم الحفظ بنجاح');
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

        if ($user->save()) {
            return response()->json('تم تحديث وسائل سحب الأرباح بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function categories()
    {
        if (auth()->user()->is_store()) {
            return view('main.store.categories')->with('categories', Category::whereNull('category_id')->get());
        }
    }

    public function store_categories(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'categories' => 'min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($user->is_store()) {
            $user->store_categories = $request->categories;
            if ($user->save()) {
                return redirect()->to($user->store_url().'/dashboard');
            }
        }

        return back()->with('error', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }
}
