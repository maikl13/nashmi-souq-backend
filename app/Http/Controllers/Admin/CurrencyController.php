<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\DataTables\CurrenciesDataTable;
use Str;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrenciesDataTable $dataTable)
    {
        return $dataTable->render('admin.currencies.currencies');
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
            'symbol' => 'required|min:2|max:255',
            'code' => 'required|min:2|max:255',
        ]);

        $currency = new Currency;
        $currency->name = $request->name;
        $currency->code = strtoupper($request->code);
        $currency->symbol = $request->symbol;
        $slug = Str::slug($request->code);
        $currency->slug = Currency::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;

        if($currency->save()){
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit-currency')->with('currency', $currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'symbol' => 'required|min:2|max:255',
            'code' => 'required|min:2|max:255',
        ]);

        $currency->name = $request->name;
        $currency->code = strtoupper($request->code);
        $currency->symbol = $request->symbol;
        $slug = Str::slug($request->code);
        $currency->slug = Currency::where('slug', $slug)->where('id', '!=', $currency->id)->count() ? $slug.'-'.uniqid() : $slug;

        if($currency->save()){
            return redirect()->route('currencies')->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        if( $currency->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
