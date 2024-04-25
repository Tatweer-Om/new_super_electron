<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

public function index(){

    $user = Auth::user();
    $permit = User::find($user->id)->permit_type;
    $permit_array = json_decode($permit, true);
    if ($permit_array && in_array('2', $permit_array)) {

        return view('reports.reports', compact( 'permit_array' ));
    } else {

        return redirect()->route('home');
    }

}

    public function expense_report(){
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        if ($permit_array && in_array('2', $permit_array)) {

            return view('reports.expense_report', compact( 'permit_array' ));
        } else {

            return redirect()->route('home');
        }

    }
}
