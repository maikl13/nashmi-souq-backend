<?php

namespace App\Http\Controllers\Api;

use App\DataTables\CurrenciesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrenciesDataTable $dataTable)
    {
        $Currency = Currency::select(['id', 'name', 'code', 'slug'])->paginate(12);

        return response()->json(['Currency' => $Currency], 200);
    }
}
