<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OptionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Str;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OptionsDataTable $dataTable)
    {
        return $dataTable->render('admin.options.options');
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
            'name' => 'required|min:1|max:255',
            'categories' => 'required|min:1',
            'categories.*' => 'exists:categories,id',
            'preview_config' => 'required|in:'.implode(',', [Option::PREVIEW_NAME, Option::PREVIEW_NONE, Option::PREVIEW_HTML, Option::PREVIEW_FIXED_IMAGE, Option::PREVIEW_PRODUCT_IMAGE]),
            'color_config' => 'required|in:'.implode(',', [Option::COLOR_DEFAULT, Option::COLOR_CUSTOM]),
        ]);

        $option = new Option;
        $option->name = $request->name;
        $slug = Str::slug($request->name);
        $option->slug = Option::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $option->categories = $request->categories;
        $option->preview_config = $request->preview_config;
        $option->color_config = $request->color_config;

        if ($option->save()) {
            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        return view('admin.options.edit-option')->with('option', $option);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'categories' => 'required|min:1',
            'categories.*' => 'exists:categories,id',
            'preview_config' => 'required|in:'.implode(',', [Option::PREVIEW_NAME, Option::PREVIEW_NONE, Option::PREVIEW_HTML, Option::PREVIEW_FIXED_IMAGE, Option::PREVIEW_PRODUCT_IMAGE]),
            'color_config' => 'required|in:'.implode(',', [Option::COLOR_DEFAULT, Option::COLOR_CUSTOM]),
        ]);

        $option->name = $request->name;
        $slug = Str::slug($request->name);
        $option->slug = Option::where('slug', $slug)->where('id', '!=', $option->id)->count() ? $slug.'-'.uniqid() : $slug;
        $option->categories = $request->categories;
        $option->preview_config = $request->preview_config;
        $option->color_config = $request->color_config;

        if ($option->save()) {
            return redirect()->route('options')->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        if ($option->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
