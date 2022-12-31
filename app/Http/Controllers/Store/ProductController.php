<?php

namespace App\Http\Controllers\Store;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Str;

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

        $products = Product::query()->shown();

        $categories = empty($request->categories) || $request->categories == [null] ? [] : $request->categories;
        $sub_categories = empty($request->sub_categories) || $request->sub_categories == [null] ? [] : $request->sub_categories;

        //search
        if ($request->q && ! empty($request->q)) {
            $products = $products->search($request->q);
        }
        // filter by type
        if ($request->type && ! empty($request->type)) {
            $products = $products->where('type', $request->type);
        }

        // filter by category
        if (! empty($categories) || ! empty($sub_categories)) {
            $products = $products->Where(function ($query) use ($categories, $sub_categories) {
                $query->whereIn('category_id', $categories)
                    ->orWhereIn('sub_category_id', $sub_categories);
            });
        }

        // filter by location
        if (! empty($states) || ! empty($areas)) {
            $products = $products->Where(function ($query) use ($states, $areas) {
                $query->whereIn('state_id', $states)
                    ->orWhereIn('area_id', $areas);
            });
        }
        $params = $request->all();
        if (isset($params['page'])) {
            unset($params['page']);
        }
        $products = $products->latest()->paginate(24)->appends($params);

        return view('store.products.products')->with('products', $products);
    }

    public function show($store, Product $product)
    {
        $product->views = $product->views + 1;
        $product->save();

        return view('store.products.product')->with('product', $product);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_title' => 'required|min:2|max:255',
            'description' => 'required|min:2|max:10000',
            'category' => 'required|exists:categories,slug',
            'sub_category' => 'nullable|exists:categories,slug',
            'images' => 'nullable',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
        ]);

        $title = $request->product_title;
        $description = $request->description;
        $slug = Str::slug($request->product_title);
        $count = Product::withTrashed()->where('slug', $slug)->count();
        $slug = $count ? $slug.'-'.uniqid() : $slug;
        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $group = ($latest = Product::withTrashed()->orderBy('group', 'desc')->first()) ? $latest->group + 1 : 1;

        if ($request->units) {
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
                if ($option_values) {
                    array_unique($option_values);
                    if (($key = array_search(null, $option_values)) !== false) {
                        unset($option_values[$key]);
                    }
                    $options = [];
                    foreach (OptionValue::whereIn('id', $option_values)->get() as $option_value) {
                        $options['options'][] = $option_value->option_id;
                        $options['values'][] = $option_value->id;
                    }
                    $product->options = $options;
                }

                $product->save();
                $product->upload_product_images(array_merge($unit['images'] ?? [], $request->images ?? []));
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
            if ($option_values) {
                array_unique($option_values);
                if (($key = array_search(null, $option_values)) !== false) {
                    unset($option_values[$key]);
                }
                $options = [];
                foreach (OptionValue::whereIn('id', $option_values)->get() as $option_value) {
                    $options['options'][] = $option_value->option_id;
                    $options['values'][] = $option_value->id;
                }
                $product->options = $options;
            }

            $product->save();
            $product->upload_product_images($request->images);
        }

        return response()->json('تم الحفظ بنجاح', 200);
        // return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
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
            'product_title' => 'required|min:2|max:255',
            'description' => 'required|min:2|max:10000',
            'category' => 'required|exists:categories,slug',
            'sub_category' => 'nullable|exists:categories,slug',
            'address' => 'nullable|min:10|max:1000',
            'images.*' => 'image|max:8192',
            'price' => 'nullable|numeric',
            'currency' => 'nullable|exists:currencies,id',
        ]);

        $product->title = $request->product_title;
        $product->initial_price = $request->initial_price;
        $product->price = isset($request->price) && $request->price != null ? $request->price : $product->initial_price;
        $product->currency_id = $request->currency;
        // $slug = Str::slug($request->product_title);
        // $product->slug = optional(Product::where('slug', $slug)->first())->id != $product->id ? $slug.'-'.uniqid() : $slug;
        $product->description = $request->description;
        $product->user_id = Auth::user()->id;
        $category = Category::where('slug', $request->category)->first();
        $sub_category = Category::where('slug', $request->sub_category)->first();
        $product->category_id = $category->id;
        $product->sub_category_id = $sub_category ? $sub_category->id : null;

        $option_values = $request->option_values;
        if ($option_values) {
            array_unique($option_values);
            if (($key = array_search(null, $option_values)) !== false) {
                unset($option_values[$key]);
            }
            $options = [];
            foreach (OptionValue::whereIn('id', $option_values)->get() as $option_value) {
                $options['options'][] = $option_value->option_id;
                $options['values'][] = $option_value->id;
            }
            $product->options = $options;
        }

        if ($product->save()) {
            $product->upload_product_images($request->images);

            return redirect()->to('/dashboard/products')->with('success', 'تم الحفظ بنجاح');
        }

        return back()->with('error', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    public function destroy($store, Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->delete()) {
            return response()->json('تم حذف الإعلان بنجاح', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function delete_product_image($store, Request $request, Product $product)
    {
        $this->authorize('delete', $product);

        return $product->delete_file('images', $request->key);
    }
}
