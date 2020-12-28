<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function subscribe()
    {
        return view('store-dashboard.subscriptions.subscripe');
    }
}
