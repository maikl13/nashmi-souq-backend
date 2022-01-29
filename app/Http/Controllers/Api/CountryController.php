<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;

class CountryController extends Controller
{
    public function index()
    {
        $categories = Country::with(['states', 'currency'])->get();
        return response()->json(['data' => $categories],200);
    }
    
    public function areas($id)
    {
        $state = State::find($id);
        $areas = $state->areas()->get();
        return response()->json(['data' => $areas],200);
    }
}
