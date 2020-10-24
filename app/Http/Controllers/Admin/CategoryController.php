<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\DataTables\CategoriesDataTable;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriesDataTable $dataTable)
    {
        // foreach (Category::get() as $category) $category->update_tree();
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
        foreach($category->sub_categories as $sub_category){
            $sub_categories[$sub_category->slug] = $sub_category->name;
        }
        return json_encode($sub_categories);
    }
}
