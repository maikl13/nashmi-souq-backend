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


    public function privacy_policy()
    {
        return view('main.page')->with([
            'title' => 'سياسة الخصوصية',
            'content' => setting('privacy')
        ]);
    }

    public function terms_and_conditions()
    {
        return view('main.page')->with([
            'title' => 'الشروط و الأحكام',
            'content' => setting('terms')
        ]);
    }

    public function about()
    {
        return view('main.page')->with([
            'title' => 'من نحن',
            'content' => setting('about')
        ]);
    }

    public function safety()
    {
        return view('main.page')->with([
            'title' => 'قواعد السلامة',
            'content' => setting('safety')
        ]);
    }

    // User in not active
    public function deactivated()
    {
        return auth()->user()->is_active() ? redirect()->route('home') : view('main.deactivated');
    }
}
