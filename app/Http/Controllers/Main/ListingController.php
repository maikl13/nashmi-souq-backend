<?php

namespace App\Http\Controllers\Main;

use Str;
use Auth;
use App\Models\Listing;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\State;
use App\Models\Area;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        return view('main.listings.listings')->with('listings', Listing::latest()->paginate(9));
    }

    public function show(Listing $listing)
    {
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
}
