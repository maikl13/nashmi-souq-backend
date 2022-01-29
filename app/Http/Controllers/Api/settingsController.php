<?php

namespace App\Http\Controllers\Api;

use Str;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Validator;

class settingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::get();

        return response()->json(['data' => $settings]);
    }
}
