<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\Promotion;


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
    
    public function delete_store_banner()
    {
         Auth::user()->delete_file('store_banner');
        return response()->json(['data'=>'تم الحذف بنجاح'
                                      
                                       ],200);
    }

    public function delete_store_logo()
    {
         Auth::user()->delete_file('store_logo');
        return response()->json(['data'=>'تم الحذف بنجاح'
                                      
                                       ],200);
    }
    
    public function store_subscriptions()
    {
         return response()->json(['data'=>auth()->user()->subscriptions()->active()],200);
        
    }
    
    public function store_products()
    {
        $products = Product::query()->where('user_id',auth()->user()->id)->latest()->paginate(15);
        return response()->json(['data'=>$products],200);
    }
    
    public function search_store_products(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'categories.*' => 'nullable|exists:categories,id',
            'sub_categories.*' => 'nullable|exists:categories,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;
        $products = Product::query()->where('user_id',auth()->user()->id);
         if($request->q && !empty($request->q)) 
            $products = $products->search($request->q);
        if( !empty($categories) || !empty($sub_categories) ){
            $products = $products->Where(function($query) use ($categories, $sub_categories){
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            });
        }
        $products=$products->latest()->paginate(15);
        return response()->json(['data'=>$products],200);
    }
    
    public function create_store_product(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'product_title' => 'required|min:2|max:255',
            'description' => 'required|min:2|max:10000',
            'category' => 'required|exists:categories,slug',
    		'sub_category' => 'nullable|exists:categories,slug',
            'images' => 'nullable',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
        
         $title = $request->product_title;
        $description = $request->description;
        $slug = Str::slug($request->product_title);
        $count = Product::withTrashed()->where('slug', $slug)->count();
        $slug = $count ? $slug.'-'.uniqid() : $slug;
        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $group = ($latest = Product::withTrashed()->orderBy('group', 'desc')->first()) ? $latest->group+1 : 1;

        if($request->units){
            foreach ($request->units as $unit) {
                $shown = isset($shown) ? false : true;
                $product = new Product;
                $product->title = $title;
                $product->slug = $slug.'-'.uniqid();
                $product->description = $description;
                $product->initial_price = $unit['initial_price'] ?? $request->price;
                $product->price = isset($unit['price']) && $unit['price'] != null ? $unit['price'] : $product->initial_price;
                $product->currency_id = $request->currency;
                $product->user_id = Auth::user()->id;
                $product->category_id = $category->id;
                $product->sub_category_id = $sub_category ? $sub_category->id : null;
                $product->group = $group;
                $product->shown = $shown;

                $option_values = array_merge($unit['option_values'], $request->option_values);
                if($option_values){
                    array_unique($option_values);
                    if (($key = array_search(null, $option_values)) !== false) unset($option_values[$key]);
                    $options = [];
                    foreach(OptionValue::whereIn('id', $option_values)->get() as $option_value){
                        $options['options'][] = $option_value->option_id;
                        $options['values'][] = $option_value->id;
                    }
                    $product->options = $options;
                }
                
                $product->save();
                $product->upload_product_images(array_merge($unit['images']??[], $request->images??[]));
            }
        } else {
            $product = new Product;
            $product->title = $request->product_title;
            $product->slug = $slug.'-'.uniqid();
            $product->description = $request->description;
            $product->initial_price = $request->initial_price;
            $product->price = isset($request->price) && $request->price != null ? $request->price : $product->initial_price;
            $product->currency_id = $request->currency;
            $product->user_id = Auth::user()->id;
            $product->category_id = $category->id;
            $product->sub_category_id = $sub_category ? $sub_category->id : null;
            $product->group = $group;
            $product->shown = true;
            
            $option_values = $request->option_values;
            if($option_values){
                array_unique($option_values);
                if (($key = array_search(null, $option_values)) !== false) unset($option_values[$key]);
                $options = [];
                foreach(OptionValue::whereIn('id', $option_values)->get() as $option_value){
                    $options['options'][] = $option_value->option_id;
                    $options['values'][] = $option_value->id;
                }
                $product->options = $options;
            }
            
            $product->save();
            $product->upload_product_images($request->images);
        }
       
        //return response()->json(['data'=>$products],200);
    }
    
    
    public function promotions(){
        $promotions=Promotion::latest()->paginate(15);
        return response()->json(['data'=>$promotions],200);
        
    }
    
    public function delete_promotions(Request $request,$id){
        $promotion=Promotion::find($id);
        if($promotion->user_id!=auth()->user()->id){
            abort(403);
        }
        else {
            $promotion->delete();
             return response()->json(['data'=>'تم الحذف بنجاح'
                                   ],200);
        }
        
    }
    
    public function create_store_promotion(Request $request){
        
        $validator = Validator::make($request->all(), [
              'url' => 'required|url',
            'image' => 'required|image|max:8192'
             ]);
      if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }
       
        $promotion = new Promotion;
        $promotion->user_id = auth()->user()->id;
        $promotion->url = $request->url;
        
        if($promotion->save()){
            $promotion->image = $promotion->upload_promotion_image($request->image);
            return response()->json(['data'=>'تم الحفظ بنجاح'
                                   ],200);
        }
         return response()->json(['data'=>'حدث خطأ من فضلك حاول لاحقا'
                                   ],500);
    }
      
    
    
    
    
    
}
