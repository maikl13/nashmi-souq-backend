<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;


class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing()
    {
      $prices=[
                    [
                        'name' => 'شهري',
                        'price' => ceil(exchange(setting('monthly_subscription'), 'USD', currency_api()->code)).' '.currency_api()->symbol,
                    ], [
                        'name' => 'نصف سنوي',
                        'price' => ceil(exchange(setting('half_year_subscription'), 'USD', currency_api()->code)).' '.currency_api()->symbol,
                        'discount' => setting('monthly_subscription') ? round((1-((setting('half_year_subscription')/6)/setting('monthly_subscription')))*100, 1) : 0
                    ], [
                        'name' => 'سنوي',
                        'price' => ceil(exchange(setting('yearly_subscription'), 'USD', currency_api()->code)).' '.currency_api()->symbol,
                        'discount' => setting('yearly_subscription') ? round((1-((setting('yearly_subscription')/12)/setting('monthly_subscription')))*100, 1) : 0
                    ]
                ];
      
        return response()->json(['data'=>$prices],200);
       
    }
    
    
   
    public function create_update_store(Request $request){
         $user = Auth::user();
        
        
          $validator = Validator::make($request->all(), [
              'store_name' => 'required|min:2|max:30',
            'store_slug' => 'required|alpha_dash|min:1|max:20|unique:users,store_slug,'.$user->id,
            'store_slogan' => 'nullable|min:20|max:255',
            'store_website' => 'nullable|url|max:255',
            'store_email' => 'nullable|email|max:255',
            'store_address' => 'nullable|max:1000',
            'store_description' => 'nullable|max:3000',
            'social.*' => 'nullable|url',
            'store_banner' => 'nullable|image|max:8192',
            'store_logo' => 'nullable|image|max:8192',
             'country' => 'exists:countries,id',
            'subscription_type' => 'in:1,2,3',
            'categories' => 'min:1',
            'categories.*' => 'exists:categories,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }

       

        $user->store_name = $request->store_name;
        $user->store_slug = $request->store_slug;
        $user->store_slogan = $request->store_slogan;
        $user->store_website = $request->store_website;
        $user->store_email = $request->store_email;
        $user->store_address = $request->store_address;
        $user->store_description = $request->store_description;
        $user->country_id = $request->country;
        $user->subscription_type = $request->subscription_type;

        $social_links = [];
        if(is_array($request->social))
            foreach ($request->social as $social_link)
                if($social_link) $social_links[] = $social_link;
        $user->store_social_accounts = json_encode($social_links);
        
        $user->store_categories = $request->categories;

        $user->upload_store_banner($request->file('store_banner'));
        $user->upload_store_logo($request->file('store_logo'));

        if($user->save()){
            if(!auth()->user()->started_trial())
                auth()->user()->start_trial();
               return response()->json(['data'=>'تم الحفظ بنجاح',
                                        'store_url'=>$user->store_url()
                                       ],200);
           
           
        }
         return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'
                                       
                                       ],500);
        
    }

   
    
   public function store_categories(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
             'categories' => 'min:1',
            'categories.*' => 'exists:categories,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        
        
        if($user->is_store()){
            $user->store_categories = $request->categories;
            if($user->save()){
               return response()->json(['data'=>'تم الحفظ بنجاح'
                                      
                                       ],200);
            }
        }
        return response()->json(['data'=>'حدث خطأ من فضلك حاول مجددا'
                                       
                                       ],500);
    }

  public function list_stores () {
    $stores = User::whereNotNull('store_name')->orderBy('store_logo', 'desc')->paginate(15);
         return response()->json(['data'=>$stores
                                      
                                       ],200);
  }
      
    
    
    
    
}
