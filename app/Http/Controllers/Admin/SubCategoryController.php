<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\DataTables\SubCategoriesDataTable;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, SubCategoriesDataTable $dataTable)
    {
        return $dataTable
                ->render('admin.sub-categories.sub-categories', ['category' => $category]);
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
            'image' => 'image|max:8192'
        ]);

        $sub_category = new SubCategory;
        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug( $request->name );
        $sub_category->category_id = $request->category_id;

        if($sub_category->save()){
            $sub_category->image = $sub_category->upload_category_image($request->image);
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $sub_category)
    {
        return view('admin.sub-categories.edit-sub-category')->with([
            'category' => $sub_category->category,
            'sub_category' => $sub_category
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'image' => 'image|max:8192'
        ]);

        $sub_category->name = $request->name;
        $sub_category->slug = Str::slug( $request->name );

        if($sub_category->save()){
            $sub_category->image = $sub_category->upload_category_image($request->image);
            return redirect()->route('sub-categories', $sub_category->category)->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $sub_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $sub_category)
    {
        if( $sub_category->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function delete_category_image(SubCategory $sub_category){
        return $sub_category->delete_category_image();
    }
}
