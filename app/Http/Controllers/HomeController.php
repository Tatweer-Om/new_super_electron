<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function index(){

        $user= Auth::user();

        $permit = User::find($user->id)->permit_type;

        $permit_array = json_decode($permit, true);

        return view ('dashboard.home', compact('permit_array'));
    }
    public function switchLanguage($locale)
    {
        app()->setLocale($locale);
        config(['app.locale' => $locale]);
        // You can store the chosen locale in session for persistence
        session(['locale' => $locale]);

        return redirect()->back(); // or any other redirect you want
    }
}
