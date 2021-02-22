<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\DataTables\OptionValuesDataTable;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $option_value = new OptionValue;
        $option_value->name = $request->name;
        $slug = Str::slug($request->name);
        $option_value->slug = OptionValue::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $option_value->option_id = $request->option_id;

        if($option_value->save()){
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
            'option_value' => $option_value
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OptionValue  $option_value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionValue $option_value)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $option_value->name = $request->name;
        $slug = Str::slug($request->name);
        $option_value->slug = OptionValue::where('slug', $slug)->where('id', '!=', $option_value->id)->count() ? $slug.'-'.uniqid() : $slug;

        if($option_value->save()){
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
        if( $option_value->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function areas(OptionValue $option_value){
        $areas = array();
        foreach($option_value->areas as $area){
            $areas[$area->slug] = $area->name;
        }
        return json_encode($areas);
    }
}
