<?php

namespace App\Http\Controllers\Api;

use Str;
use Auth;
use App\Models\Listing;
use App\Models\Category;
use App\Models\State;
use App\Models\Area;
use App\Models\FeaturedListing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Validator;

class ListingsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type.*' => 'nullable|in:'.Listing::TYPE_SELL.','.Listing::TYPE_BUY.','.Listing::TYPE_EXCHANGE.','.Listing::TYPE_JOB.','.Listing::TYPE_RENT,
            'categories.*' => 'nullable|exists:categories,id',
            'sub_categories.*' => 'nullable|exists:categories,id',
            'states.*' => 'nullable|exists:states,id',
            'areas.*' => 'nullable|exists:areas,id',
        ]);
        
        $listings = Listing::query()->apilocalized()->active();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;
        $states = empty($request->states) || $request->states == [null] ? [] : $request->states;
        $areas = empty($request->areas) || $request->areas == [null] ? [] : $request->areas;
        $types = empty($request->type) || $request->type == [null] ? [] : $request->type;
        
        //search
        /*if($request->q && !empty($request->q)) 
            $listings = $listings->search($request->q)->featuredOrFixedFirst();*/
        // filter by type
      
        //$listings = $listings->where('type', $request->type);

        // filter by category
        if( !empty($categories) || !empty($sub_categories) ){
            $listings = $listings->where(function($query) use ($categories, $sub_categories){
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            })->featuredOrFixedFirst();
        }

        // filter by location
        if( !empty($states) || !empty($areas) ){
            $listings = $listings->Where(function($query) use ($states, $areas){
                $query->whereIn('state_id', $states)
                    ->orWhereIn('area_id', $areas);
            });
        }
        
        if( !empty($types)){
            $listings = $listings->Where(function($query) use ($types){
                $query->whereIn('type', $types);
                    
            });
        }

        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }
    
    public function search_listings(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'q' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 401);
        }

        $listings = Listing::query()->apilocalized()->active();
        $listings = $listings->search($request->q)->featuredOrFixedFirst();
        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }
    
    public function related_listings($id) 
    {
        $listing = Listing::find($id);
        $listings = Listing::where('category_id', $listing->category_id)->localized()->active()->featuredFirst()->where('listings.id', '!=', $listing->id);
    
        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->limit(10)->get();
      
        return response()->json(['data' => $listings]);
    }
    
    public function category_listings($id){
        $listings = Listing::where('category_id', $id)->apilocalized()->active()->featuredFirst();
    
        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);

        return response()->json(['data' => $listings]);
    }
    
    public function sub_category_listings($id) 
    {
        $listings = Listing::where('sub_category_id', $id)->apilocalized()->active()->featuredFirst();
    
        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);
      
        return response()->json(['data' => $listings]);
    }
    
    public function user_listings($id) 
    {
        $listings = Listing::where('user_id', $id)->active()->featuredFirst();

        $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);
      
        return response()->json(['data' => $listings]);
    }
    
    public function country_listings($code) 
    {
       $country = Country::where('code', $code)->first();

       if($country){
            $listings = Listing::whereIn('state_id', $country->states()->pluck('id')->toArray())->active()->featuredFirst();
            $listings = $listings->with(['user', 'comments', 'state', 'area', 'category', 'sub_category'])->latest()->paginate(15);
            return response()->json(['data' => $listings]);
       } else {
           return response()->json(['data' => 'لا يوجد بلد بهذا الكود']);
       }
    }
}
