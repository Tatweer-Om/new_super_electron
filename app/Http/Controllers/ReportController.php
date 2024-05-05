<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Account;
use App\Models\Expense;
use App\Models\PosOrder;
use App\Models\Posinvodata;
use App\Models\Settingdata;
use Illuminate\Http\Request;
use App\Models\Expense_Category;
use App\Models\PosPayment;
use Illuminate\Support\Facades\DB;
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


//expense_report

public function expense_report(Request $request){
    $user = Auth::user();
    $permit = $user->permit_type;
    $permit_array = json_decode($permit, true);
    $shop = Settingdata::first();
    $invo = Posinvodata::first();



    $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
    $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');
    $cat_id = !empty($request['expense_cat']) ? $request['expense_cat'] : "";


     $query = Expense::whereDate('expense_date', '>=', $sdata)
                 ->whereDate('expense_date', '<=', $edata);
    if (!empty($request['expense_cat'])) {
        $query->where('category_id', $request['expense_cat']);
    }

    $expenses = $query->get();


    $expense_cat = Expense_Category::all();

    if (in_array('2', $permit_array)) {
        return view('reports.expense_report', compact('permit_array', 'shop', 'invo', 'expenses', 'expense_cat' , 'edata' , 'sdata' ,'cat_id' ));
    } else {
        return redirect()->route('home');
    }
}


//sales_report
public function sales_report(Request $request){
    $user = Auth::user();
    $permit = $user->permit_type;
    $permit_array = json_decode($permit, true);
    $shop = Settingdata::first();
    $invo = Posinvodata::first();

    $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
    $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

    $account_ids = !empty($request['payment_method']) ? explode(',', $request['payment_method']) : [];

    $accounts = Account::where('account_type', 1)->get();

    $order = PosOrder::whereDate('created_at', '>=', $sdata)
                     ->whereDate('created_at', '<=', $edata);

    if (!empty($account_ids)) {
        $order->where(function ($query) use ($account_ids) {
            foreach ($account_ids as $account_id) {
                $query->orWhere('account_id', $account_id);
            }
        });
    }

    $orders = $order->get();

    if (in_array('2', $permit_array)) {
        return view('reports.sales_report', compact('permit_array', 'shop', 'orders', 'invo', 'accounts', 'edata', 'sdata'));
    } else {
        return redirect()->route('home');
    }
}






//sales_report
// public function supplier_report(Request $request){
//     $user = Auth::user();
//     $permit = $user->permit_type;
//     $permit_array = json_decode($permit, true);
//     $shop = Settingdata::first();
//     $invo = Posinvodata::first();



//     $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
//     $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

//     $account_id = !empty($request['payment_method']) ? $request['payment_method'] : "";


//     $accounts = Account:: where('account_type', 1)->get();
//     $order = PosOrder::whereBetween('created_at', [$sdata, $edata]);
//     $orders= $order->get();


//     if (in_array('2', $permit_array)) {
//         return view('reports.sales_report', compact('permit_array', 'shop', 'orders', 'invo', 'accounts', 'edata' , 'sdata'  ));
//     } else {
//         return redirect()->route('home');
//     }
// }





}
