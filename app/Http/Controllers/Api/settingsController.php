<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::get();

        return response()->json(['data' => $settings]);
    }
}
