<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\SubscriptionsDataTable;

class SubscriptionController extends Controller
{
    public function index(SubscriptionsDataTable $dataTable)
    {
        return $dataTable->render('store-dashboard.subscriptions.subscriptions');
    }

    public function subscribe()
    {
        return view('store-dashboard.subscriptions.subscribe');
    }
}
