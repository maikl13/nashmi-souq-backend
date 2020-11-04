<?php

namespace App\Http\Controllers\Main;

use Str;
use Auth;
use App\Models\Listing;
use App\Models\Category;
use App\Models\State;
use App\Models\Area;
use App\Models\FeaturedListing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:'.Listing::TYPE_SELL.','.Listing::TYPE_BUY.','.Listing::TYPE_EXCHANGE.','.Listing::TYPE_JOB.','.Listing::TYPE_RENT,
            'categories.*' => 'nullable|exists:categories,id',
            'sub_categories.*' => 'nullable|exists:categories,id',
            'states.*' => 'nullable|exists:states,id',
            'areas.*' => 'nullable|exists:areas,id',
        ]);

        $listings = Listing::query()->localized()->active();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;
        $states = empty($request->states) || $request->states == [null] ? [] : $request->states;
        $areas = empty($request->areas) || $request->areas == [null] ? [] : $request->areas;

        //search
        if($request->q && !empty($request->q)) 
            $listings = $listings->search($request->q)->featured();
        // filter by type
        if($request->type && !empty($request->type)) 
            $listings = $listings->where('type', $request->type);

        // filter by category
        if( !empty($categories) || !empty($sub_categories) ){
            $listings = $listings->Where(function($query) use ($categories, $sub_categories){
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            });
        }

        // filter by location
        if( !empty($states) || !empty($areas) ){
            $listings = $listings->Where(function($query) use ($states, $areas){
                $query->whereIn('state_id', $states)
                    ->orWhereIn('area_id', $areas);
            });
        }
        $params = $request->all();
        if(isset($params['page'])) unset($params['page']);
        $listings = $listings->latest()->paginate(24)->appends($params);

        return view('main.listings.listings')->with('listings', $listings);
    }

    public function show(Listing $listing)
    {
        if(!$listing->is_active()) return view('main.listings.inactive');
        $listing->views = $listing->views+1;
        $listing->save();
        return view('main.listings.listing')->with('listing', $listing);
    }

    public function create()
    {
    	return view('main.listings.add-listing');
    }

    public function store(Request $request)
    {
    	$request->validate([
            'listing_title' => 'required|min:10|max:255',
    		'type' => 'required|in:1,2,3,4,5,6',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,slug',
    		'sub_category' => 'nullable|exists:categories,slug',
            'state' => 'required|exists:states,slug',
            'area' => 'nullable|exists:areas,slug',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
    	]);

    	$listing = new Listing;
        $listing->title = $request->listing_title;
        $listing->type = $request->type;
        
        if(in_array($request->type, [Listing::TYPE_SELL, Listing::TYPE_BUY, Listing::TYPE_RENT]))
            $listing->price = $request->price;

        $slug = Str::slug($request->listing_title);
        $count = Listing::where('slug', $slug)->count();
        $listing->slug = $count ? $slug.'-'.uniqid() : $slug;

    	$listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();
        $listing->address = $request->address;

        $listing->category_id = $category->id;
        $listing->sub_category_id = $sub_category ? $sub_category->id : null;
        $listing->state_id = $state->id;
        $listing->area_id = $area ? $area->id : null;

        if(in_array($request->type, [Listing::TYPE_JOB, Listing::TYPE_JOB_REQUEST])){
            $data = [];
            if($request->age) $data['age'] = $request->age;
            if($request->gender) $data['gender'] = $request->gender;
            if($request->qualification) $data['qualification'] = $request->qualification;
            if($request->skills) $data['skills'] = $request->skills;
            $listing->data = json_encode($data);
        }

        if($listing->save()){
            $listing->upload_listing_images($request->images);
            return response()->json(['redirect' => route('account').'#my-listing'] , 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function edit(Listing $listing)
    {
        $this->authorize('edit', $listing);

        return view('main.listings.edit-listing')->with('listing', $listing);
    }

    public function update(Listing $listing, Request $request)
    {
        $this->authorize('delete', $listing);
        
        $request->validate([
            'listing_title' => 'required|min:10|max:255',
            'type' => 'required|in:1,2,3,4,5,6',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,slug',
            'sub_category' => 'nullable|exists:categories,slug',
            'state' => 'required|exists:states,slug',
            'area' => 'nullable|exists:areas,slug',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
        ]);

        $listing->title = $request->listing_title;
        $listing->type = $request->type;

        $listing->price = null;
        if(in_array($request->type, [Listing::TYPE_SELL, Listing::TYPE_BUY, Listing::TYPE_RENT]))
            $listing->price = $request->price;

        $slug = Str::slug($request->listing_title);
        $listing->slug = Listing::where('slug', $slug)->where('id', '!=', $listing->id)->count() ? $slug.'-'.uniqid() : $slug;

        $listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();

        $listing->category_id = $category->id;
        $listing->sub_category_id = $sub_category ? $sub_category->id : null;
        $listing->state_id = $state->id;
        $listing->area_id = $area ? $area->id : null;
        $listing->address = $request->address;

        if(in_array($request->type, [Listing::TYPE_JOB, Listing::TYPE_JOB_REQUEST])){
            $data = [];
            if($request->age) $data['age'] = $request->age;
            if($request->gender) $data['gender'] = $request->gender;
            if($request->qualification) $data['qualification'] = $request->qualification;
            if($request->skills) $data['skills'] = $request->skills;
            $listing->data = json_encode($data);
        }

        if($listing->save()){
            $listing->upload_listing_images($request->images);
            return response()->json(['redirect' => route('account').'#my-listing'] , 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        if($listing->delete()){
            return response()->json('تم حذف الإعلان بنجاح' , 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function delete_listing_image(Request $request, Listing $listing){
        $this->authorize('delete', $listing);
        return $listing->delete_file('images', $request->key);
    }

    public function promote(Request $request)
    {
        // dd($request->request);
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'tier' => 'required|between:1,20'
        ]);
        $listing = Listing::where('id', $request->listing_id)->first();
        $price = round(exchange(setting('tier'.$request->tier), 'USD', currency()->code), 1);

        $this->authorize('edit', $listing);
        if($listing->is_featured() && $request->tier <= 8)
            return response()->json('تم ترقية الإعلان بالفعل للعضوية المميزة من قبل', 500);

        if($listing->is_fixed() && $request->tier >= 9)
            return response()->json('الاعلان مثبت بالفعل', 500);

        if(empty( setting('tier'.$request->tier) ))
            return response()->json('حدث خطأ ما! قم بتحديث الصفحة و حاول مجددا.', 500);

        if(Auth::user()->payout_balance() < $price)
            return response()->json('عفوا رصيدك الحالي لا يكفي لإتمام العملية.', 500);

        $featured_listing = new FeaturedListing;
        $featured_listing->listing_id = $listing->id;
        $featured_listing->tier = $request->tier;
        $featured_listing->expired_at = \Carbon\Carbon::now()->addDays($featured_listing->period());

        $featured_listing->price = $price;
        $featured_listing->currency_id = currency()->id;

        $transaction = $featured_listing->payment_init($price, currency());

        if($successfull_transaction = $featured_listing->pay_from_wallet($transaction)){
            $featured_listing->transaction_id = $transaction->id;
            if($featured_listing->save()){
                if($request->tier <= 8)
                    return response()->json('تم ترقية إعلانك لإعلان مميز بنجاح.', 200);
                return response()->json('تم تثبيت إعلانك بنجاح.', 200);
            }
        } else {
            return response()->json('حدث خطأ ما! من فضلك تأكد من وجود رصيد كاف و حاول مجددا.', 500);
        }


        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
