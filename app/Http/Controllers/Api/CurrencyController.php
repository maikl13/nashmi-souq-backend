<?php

namespace App\Http\Controllers\Api;

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
    {   $Currency= Currency::select(['id','name','code','slug'])->paginate(12);
        return response()->json(['Currency'=>$Currency],200);
    }

   
}
