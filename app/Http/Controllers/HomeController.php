<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function index(){

        return view ('dashboard.home');
    }
    public function switchLanguage($locale)
    {
        app()->setLocale($locale);
        config(['app.locale' => $locale]);

        // You can store the chosen locale in session for persistence
        session(['locale' => $locale]);
        // echo app()->getLocale(); exit();
        return redirect()->back(); // or any other redirect you want
    }
}
