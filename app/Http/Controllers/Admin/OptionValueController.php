<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OptionValuesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use Str;

class OptionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Option $option, OptionValuesDataTable $dataTable)
    {
        return $dataTable
            ->render('admin.option_values.option_values', ['option' => $option]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'preview_config' => 'required|in:'.implode(',', [Option::PREVIEW_NAME, Option::PREVIEW_NONE, Option::PREVIEW_HTML, Option::PREVIEW_FIXED_IMAGE, Option::PREVIEW_PRODUCT_IMAGE]),
            'color_config' => 'required|in:'.implode(',', [Option::COLOR_DEFAULT, Option::COLOR_CUSTOM]),
        ]);

        $option_value = new OptionValue;
        $option_value->name = $request->name;
        $slug = Str::slug($request->name);
        $option_value->slug = OptionValue::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $option_value->option_id = $request->option_id;
        $option_value->preview_config = $request->preview_config;
        $option_value->color_config = $request->color_config;
        $option_value->color = $request->color;
        $option_value->html = $request->html;

        if ($option_value->save()) {
            if ($option_value->preview_config == Option::PREVIEW_FIXED_IMAGE) {
                $option_value->upload_option_value_image($request->file('image'));
            }

            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OptionValue  $option_value
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionValue $option_value)
    {
        return view('admin.option_values.edit-option_value')->with([
            'option' => $option_value->option,
            'option_value' => $option_value,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\OptionValue  $option_value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionValue $option_value)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'preview_config' => 'required|in:'.implode(',', [Option::PREVIEW_NAME, Option::PREVIEW_NONE, Option::PREVIEW_HTML, Option::PREVIEW_FIXED_IMAGE, Option::PREVIEW_PRODUCT_IMAGE]),
            'color_config' => 'required|in:'.implode(',', [Option::COLOR_DEFAULT, Option::COLOR_CUSTOM]),
        ]);

        $option_value->name = $request->name;
        $slug = Str::slug($request->name);
        $option_value->slug = OptionValue::where('slug', $slug)->where('id', '!=', $option_value->id)->count() ? $slug.'-'.uniqid() : $slug;
        $option_value->preview_config = $request->preview_config;
        $option_value->color_config = $request->color_config;
        $option_value->color = $request->color;
        $option_value->html = $request->html;

        if ($option_value->save()) {
            if ($option_value->preview_config == Option::PREVIEW_FIXED_IMAGE) {
                $option_value->upload_option_value_image($request->file('image'));
            }

            return redirect()->route('option_values', $option_value->option)->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OptionValue  $option_value
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionValue $option_value)
    {
        if ($option_value->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function areas(OptionValue $option_value)
    {
        $areas = [];
        foreach ($option_value->areas as $area) {
            $areas[$area->slug] = $area->name;
        }

        return json_encode($areas);
    }
}
