<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\AdminNotificationSubmitted;

class NotificationController extends Controller
{
    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        foreach (User::all() as $user) { 
            try {
                $user->notify(new AdminNotificationSubmitted($request->notification));
            } catch (\Throwable $th) {}
        }
        return back()->with('success', 'طلبك قيد التنفيذ!');
    }
}
