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
   $data = $settings->map(function ($settings) {
      $string=strip_tags($settings->value);
    $result = str_replace('&nbsp;', ' ', $string);

        return [
            'id' => $settings->id,
            'name'=>$settings->name,
            'value'=>$result,
            'updated_at'=>$settings->updated_at,
            'created_at' => $settings->created_at,
        ];
    });
        return response()->json(['data' => $data]);
    }
}
