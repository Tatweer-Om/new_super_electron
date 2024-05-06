<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Store;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Product;
use App\Models\PosOrder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\PosPayment;
use App\Models\Posinvodata;
use App\Models\Settingdata;
use Illuminate\Http\Request;
use App\Models\Purchase_bill;
use App\Models\PaymentExpense;
use App\Models\PosOrderDetail;
use App\Models\Expense_Category;
use App\Models\Localrepairproduct;
use App\Models\Localrepairservice;
use App\Models\MaintenancePayment;
use App\Models\MaintenancePaymentExpense;
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

    $account_id = !empty($request['payment_method']) ? $request['payment_method'] : "";



    $accounts = Account::where('account_type', 1)->get();

    $order = PosOrder::whereDate('created_at', '>=', $sdata)
                     ->whereDate('created_at', '<=', $edata);

    if (!empty($account_id)) {
        $order->where('account_id', $account_id );

    }

    $orders = $order->get();

    if (in_array('2', $permit_array)) {
        return view('reports.sales_report', compact('permit_array', 'shop', 'orders', 'invo', 'accounts', 'account_id', 'edata', 'sdata'));
    } else {
        return redirect()->route('home');
    }
}



// supplier_report
    public function supplier_report(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');
        $suppliers= Supplier::all();
        $supplier_id= !empty($request['supplier_id']) ? $request['supplier_id'] : "";
        $supplier = Supplier::find($supplier_id);
        $purchases = Purchase::where('supplier_id', $supplier_id)
        ->whereBetween('purchase_date', [$sdata, $edata])
        ->get();

        foreach ($purchases as $purchase) {
            $purchase->purchase_bill = Purchase_bill::where('purchase_id', $purchase->id)->first();
            $purchase->remaining_amount = $purchase->purchase_bill ? $purchase->purchase_bill->remaining_price : 0;
            $purchase->grand_total = $purchase->purchase_bill ? $purchase->purchase_bill->grand_total : 0;
        }

        $purchasesall = $purchases->toArray();

        if (in_array('2', $permit_array)) {
            return view('reports.supplier_report', compact('permit_array', 'purchasesall', 'supplier_id', 'suppliers', 'shop',  'invo',  'edata' , 'sdata'  ));
        } else {
            return redirect()->route('home');
        }
    }

    //most_sold_item

    public function most_sold(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');
        $stores= Store::all();
        $store_id= !empty($request['store_id']) ? $request['store_id'] : null;
        $store = Store::find($store_id);
        $most_selling_products = PosOrderDetail::select(
            'product_id',
            'item_barcode',

            DB::raw('SUM(item_quantity) as total_quantity_sold'),
            DB::raw('SUM(item_price * item_quantity) as total_sales'),
            DB::raw('SUM(item_profit * item_quantity) as total_profit'),
            DB::raw('SUM(item_discount_price * item_quantity) as total_discount'),
            DB::raw('SUM(item_tax * item_quantity) as total_tax')
        )
        ->where('store_id', $store_id)
        ->whereBetween('created_at', [$sdata, $edata])
        ->groupBy('product_id', 'item_barcode')
        ->orderByDesc('total_quantity_sold')
        ->get();



        return view('reports.most_sold_item', compact('permit_array', 'most_selling_products', 'store_id', 'shop', 'invo', 'sdata', 'stores', 'edata'));
    }

    public function profit_expense(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $posorder = PosOrder::whereBetween('created_at', [$sdata, $edata])->get();
        $totalSales = $posorder->sum('total_amount');
        $orderProfit = $posorder->sum('total_profit');

        $expense = Expense::whereBetween('expense_date', [$sdata, $edata])->get();
        $generalExpense = $expense->sum('amount');

        $posExpense = PaymentExpense::whereBetween('created_at', [$sdata, $edata])->get();
        $posExpenseTotal = $posExpense->sum('account_tax_fee');

        $maintenanceExpense = MaintenancePaymentExpense::whereBetween('created_at', [$sdata, $edata])->get();
        $maintenanceExpenseTotal = $maintenanceExpense->sum('account_tax_fee');

        $services = Localrepairservice::whereBetween('created_at', [$sdata, $edata])->get();
        $serviceCost = $services->sum('cost');

        $products = Localrepairproduct::whereBetween('created_at', [$sdata, $edata])->get();
        $repairCost = 0;
        foreach ($products as $pro){
            $item= Product::where('id', $pro->product_id)->first();
            $cost= $pro->cost;
            $purchase_price= $item->purchase_price;
            $profit = $cost - $purchase_price;
            $repairCost += $profit;
        }

        $totalCost = $serviceCost + $repairCost;
        $totalExpense = $generalExpense + $posExpenseTotal + $maintenanceExpenseTotal;

        $grandProfit =  $orderProfit + $serviceCost + $repairCost;
        $finalProfit = $grandProfit - $totalExpense;

        return view('reports.profit_and_expense_report', compact(
            'permit_array',
            'shop',
            'invo',
            'sdata',
            'edata',
            'totalSales',
            'orderProfit',
            'generalExpense',
            'posExpenseTotal',
            'maintenanceExpenseTotal',
            'serviceCost',
            'repairCost',
            'totalCost',
            'totalExpense',
            'finalProfit'
        ));
    }


}
