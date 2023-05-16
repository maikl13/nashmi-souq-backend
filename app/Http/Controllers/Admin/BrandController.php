<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BrandsDataTable $dataTable, $brand = null)
    {
        if ($brand) {
            $brand = Brand::where('slug', $brand)->firstOrFail();
        }

        return $dataTable->with(compact('brand'))->render('admin.brands.brands', compact('brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'categories' => 'nullable',
            'categories.*' => 'exists:categories,id',
        ]);

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->brand_id = $request->brand_id;
        $brand->categories = is_array($request->categories) && ! $request->brand_id ? $request->categories : [];
        $slug = Str::slug($request->name);
        $brand->slug = Brand::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;

        if ($brand->save()) {
            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit-brand')->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'categories' => 'nullable',
            'categories.*' => 'exists:categories,id',
        ]);

        $brand->name = $request->name;
        $brand->categories = is_array($request->categories) && ! $brand->brand_id ? $request->categories : [];
        $slug = Str::slug($request->name);
        $brand->slug = Brand::where('slug', $slug)->where('id', '!=', $brand->id)->count() ? $slug.'-'.uniqid() : $slug;

        if ($brand->save()) {
            if ($brand->brand_id) {
                return redirect()->route('models', [$brand->parent])->with('success', 'تم تعديل البيانات بنجاح.');
            }

            return redirect()->route('brands')->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if ($brand->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function models(Brand $brand)
    {
        $brands = $brand->children;

        if (count($brands)) {
            return view('main.listings.partials.brands-select', ['brands' => $brands]);
        }

        return false;
    }
}
