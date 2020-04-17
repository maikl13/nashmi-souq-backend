<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\DataTables\CountriesDataTable;
use Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountriesDataTable $dataTable)
    {
        return $dataTable->render('admin.countries.countries');
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
            'country_code' => 'required'
        ]);

        $country = new Country;
        $country->name = $request->name;
        $country->code = $request->country_code;
        $slug = Str::slug($request->name);
        $country->slug = Country::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;

        if($country->save()){
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit-country')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'country_code' => 'required'
        ]);

        $country->name = $request->name;
        $country->code = $request->country_code;
        $slug = Str::slug($request->name);
        $country->slug = Country::where('slug', $slug)->where('id', '!=', $country->id)->count() ? $slug.'-'.uniqid() : $slug;

        if($country->save()){
            return redirect()->route('countries')->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if( $country->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
