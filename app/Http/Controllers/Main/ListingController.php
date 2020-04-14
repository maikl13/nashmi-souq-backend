<?php

namespace App\Http\Controllers\Main;

use Str;
use Auth;
use App\Models\Listing;
use App\Models\Category;
use App\Models\SubCategory;
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
            'sub_categories.*' => 'nullable|exists:sub_categories,id',
            'states.*' => 'nullable|exists:states,id',
            'areas.*' => 'nullable|exists:areas,id',
        ]);

        $listings = Listing::query();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;
        $states = empty($request->states) || $request->states == [null] ? [] : $request->states;
        $areas = empty($request->areas) || $request->areas == [null] ? [] : $request->areas;

        //search
        if($request->q && !empty($request->q)) 
            $listings = $listings->search($request->q);
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
            'title' => 'required|min:10|max:255',
    		'type' => 'required|in:1,2,3,4,5',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,slug',
    		'sub_category' => 'nullable|exists:sub_categories,slug',
            'state' => 'required|exists:states,slug',
            'area' => 'nullable|exists:areas,slug',
            'images.*' => 'image|max:8192',
    	]);

    	$listing = new Listing;
        $listing->title = $request->title;
        $listing->type = $request->type;

        $slug = Str::slug($request->title);
        $count = Listing::where('slug', $slug)->count();
        $listing->slug = $count ? $slug.'-'.uniqid() : $slug;

    	$listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = SubCategory::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();

        $listing->category_id = $category->id;
        $listing->sub_category_id = $sub_category ? $sub_category->id : null;
        $listing->state_id = $state->id;
    	$listing->area_id = $area ? $area->id : null;

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
            'title' => 'required|min:10|max:255',
            'type' => 'required|in:1,2,3,4,5',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,slug',
            'sub_category' => 'nullable|exists:sub_categories,slug',
            'state' => 'required|exists:states,slug',
            'area' => 'nullable|exists:areas,slug',
            'images.*' => 'image|max:8192',
        ]);

        $listing->title = $request->title;
        $listing->type = $request->type;

        $slug = Str::slug($request->title);
        $count = Listing::where('slug', $slug)->count();
        $listing->slug = $count ? $slug.'-'.uniqid() : $slug;

        $listing->description = $request->description;
        $listing->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = SubCategory::where('slug', $request->sub_category)->first();
        $state = State::where('slug', $request->state)->first();
        $area = Area::where('slug', $request->area)->first();

        $listing->category_id = $category->id;
        $listing->sub_category_id = $sub_category ? $sub_category->id : null;
        $listing->state_id = $state->id;
        $listing->area_id = $area ? $area->id : null;

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
        return $listing->delete_listing_image($request->key);
    }

    public function promote(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'tier' => 'required|between:1,8'
        ]);
        $listing = Listing::where('id', $request->listing_id)->first();

        $this->authorize('edit', $listing);

        if($listing->is_featured())
            return response()->json('تم ترقية الإعلان بالفعىل للعضوية المميزة من قبل', 500);

        if(empty( setting('tier'.$request->tier) ))
            return response()->json('حدث خطأ ما! قم بتحديث الصفحة و حاول مجددا.', 500);

        if(Auth::user()->current_balance() < setting('tier'.$request->tier) )
            return response()->json('عفوا رصيدك الحالي لا يكفي لإتمام العملية.', 500);

        $featured_listing = new FeaturedListing;
        $featured_listing->listing_id = $listing->id;
        $featured_listing->price = setting('tier'.$request->tier);
        $featured_listing->tier = $request->tier;

        if($featured_listing->save())
            return response()->json('تم ترقية الإعلان لإعلان مميز.', 200);

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
