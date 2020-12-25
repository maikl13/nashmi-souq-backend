<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function stores_pricing()
    {
        return view('store.main.pricing');
    }

    public function trial()
    {
        if(auth()->user()->is_store() && !auth()->user()->started_trial())
            auth()->user()->start_trial();

        if(auth()->user()->is_store())
            return redirect()->to('/');
        
        return view('store.main.start-store');
    }
}
