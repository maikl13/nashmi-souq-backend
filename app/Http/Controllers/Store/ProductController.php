<?php

namespace App\Http\Controllers\Store;

use Str;
use Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\State;
use App\Models\Area;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProductsDataTable;

class ProductController extends Controller
{
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('store-dashboard.products.products');
    }

    public function list(Request $request)
    {
        $request->validate([
            'categories.*' => 'nullable|exists:categories,id',
            'sub_categories.*' => 'nullable|exists:categories,id',
        ]);

        $products = Product::query();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;

        //search
        if($request->q && !empty($request->q)) 
            $products = $products->search($request->q)->featured();
        // filter by type
        if($request->type && !empty($request->type)) 
            $products = $products->where('type', $request->type);

        // filter by category
        if( !empty($categories) || !empty($sub_categories) ){
            $products = $products->Where(function($query) use ($categories, $sub_categories){
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            });
        }

        // filter by location
        if( !empty($states) || !empty($areas) ){
            $products = $products->Where(function($query) use ($states, $areas){
                $query->whereIn('state_id', $states)
                    ->orWhereIn('area_id', $areas);
            });
        }
        $params = $request->all();
        if(isset($params['page'])) unset($params['page']);
        $products = $products->latest()->paginate(24)->appends($params);

        return view('store.products.products')->with('products', $products);
    }


    public function show($store, Product $product)
    {
        $product->views = $product->views+1;
        $product->save();
        return view('store.products.product')->with('product', $product);
    }

    public function store(Request $request)
    {
    	$request->validate([
            'product_title' => 'required|min:2|max:255',
            'description' => 'required|min:2|max:10000',
            'category' => 'required|exists:categories,slug',
    		'sub_category' => 'nullable|exists:categories,slug',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
    	]);

    	$product = new Product;
        $product->title = $request->product_title;
        
        $product->price = $request->price;
        $product->currency_id = $request->currency;

        $slug = Str::slug($request->product_title);
        $count = Product::where('slug', $slug)->count();
        $product->slug = $count ? $slug.'-'.uniqid() : $slug;

    	$product->description = $request->description;
        $product->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();

        $product->category_id = $category->id;
        $product->sub_category_id = $sub_category ? $sub_category->id : null;

        if($product->save()){
            $product->upload_product_images($request->images);
            return response()->json('تم الحفظ بنجاح', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function edit($store, Product $product)
    {
        $this->authorize('edit', $product);

        return view('store-dashboard.products.edit-product')->with('product', $product);
    }

    public function update($store, Product $product, Request $request)
    {
        $this->authorize('delete', $product);
        
        $request->validate([
            'product_title' => 'required|min:10|max:255',
            'description' => 'required|min:10|max:10000',
            'category' => 'required|exists:categories,slug',
            'sub_category' => 'nullable|exists:categories,slug',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
        ]);

        $product->title = $request->product_title;

        $product->price = $request->price;
        $product->currency_id = $request->currency;

        $slug = Str::slug($request->product_title);
        $product->slug = optional(Product::where('slug', $slug)->first())->id != $product->id ? $slug.'-'.uniqid() : $slug;

        $product->description = $request->description;
        $product->user_id = Auth::user()->id;

        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();

        $product->category_id = $category->id;
        $product->sub_category_id = $sub_category ? $sub_category->id : null;

        if($product->save()){
            $product->upload_product_images($request->images);
            return redirect()->to('/dashboard/products')->with('success', 'تم الحفظ بنجاح');
        }
        return back()->with('error', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    public function destroy($store, Product $product)
    {
        $this->authorize('delete', $product);

        if($product->delete()){
            return response()->json('تم حذف الإعلان بنجاح' , 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function delete_product_image($store, Request $request, Product $product){
        $this->authorize('delete', $product);
        return $product->delete_file('images', $request->key);
    }

}
