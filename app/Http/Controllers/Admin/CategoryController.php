<?php

namespace App\Http\Controllers\Admin;

use Str;
use App\Models\Brand;
use App\Models\Option;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\CategoriesDataTable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.categories.categories');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'category' => 'nullable|exists:categories,id',
            'image' => 'image|max:8192',
            'icon' => 'required|min:3',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $slug = Str::slug($request->name);
        $category->slug = Category::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $category->icon = $request->icon;
        $category->category_id = $request->category ? $request->category : null;

        if($category->save()){
            $category->upload_category_image($request->file('image'));
            $category->update_tree();
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit-category')->with('category', $category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'category' => 'nullable|exists:categories,id',
            'image' => 'image|max:8192',
            'icon' => 'required|min:3',
        ]);

        $category->name = $request->name;
        $slug = Str::slug($request->name);
        $category->slug = Category::where('slug', $slug)->where('id', '!=', $category->id)->count() ? $slug.'-'.uniqid() : $slug;
        $category->icon = $request->icon;
        $category->category_id = $request->category != $category->id ? $request->category : null;

        if($category->save()){
            $category->upload_category_image($request->file('image'));
            $category->update_tree();
            return redirect()->route('categories')->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if( $category->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function delete_category_image(Category $category){
        return $category->delete_file('image');
    }

    public function sub_categories(Category $category){
        $sub_categories = array();
        foreach ($category->all_children() as $child) {
            $prefix = '';
            for ($i=2; $i < $child->level(); $i++) { $prefix .= '___'; }
            $sub_categories[$child->slug] = $prefix .' '. $child->name;
        }
        return json_encode($sub_categories);
    }
    
    public function category_options(Category $category)
    {
        $options = Option::whereJsonContains('categories', "{$category->id}");

        while ($category->parent) {
            $category = $category->parent;
            $options = $options->orWhereJsonContains('categories', "{$category->id}");
        }

        $options = $options->get();
        
        if(count($options))
            return view('store-dashboard.products.partials.options-select', ['options' => $options]);

        return false;
    }
    
    public function category_options_list(Category $category)
    {
        $options = Option::whereJsonContains('categories', "{$category->id}");

        while ($category->parent) {
            $category = $category->parent;
            $options = $options->orWhereJsonContains('categories', "{$category->id}");
        }

        $options = $options->get();
        
        if(count($options))
            return response()->json($options, 200);

        return false;
    }

    public function brands(Category $category)
    {
        $brands = Brand::whereJsonContains('categories', "{$category->id}");

        while ($category->parent) {
            $category = $category->parent;
            $brands = $brands->orWhereJsonContains('categories', "{$category->id}");
        }

        $brands = $brands->get();
        
        if(count($brands))
            return view('main.listings.partials.brands-select', ['brands' => $brands]);

        return false;
    }
}
