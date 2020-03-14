<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('main.home');
    }

    // User in not active
    public function deactivated()
    {
        return auth()->user()->is_active() ? redirect()->route('home') : view('main.deactivated');
    }
}
