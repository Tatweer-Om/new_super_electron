<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Account;
use App\Models\Address;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ministry;
use App\Models\PosOrder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warranty;
use App\Models\Repairing;
use App\Models\Workplace;
use App\Models\PosPayment;
use App\Models\Technician;
use App\Models\University;
use App\Models\Nationality;
use App\Models\Posinvodata;
use App\Models\Settingdata;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use App\Models\Purchase_bill;
use App\Models\RepairProduct;
use App\Models\RepairService;
use App\Models\PaymentExpense;
use App\Models\PosOrderDetail;
use App\Models\Expense_Category;
use App\Models\Localmaintenance;
use Mockery\ReceivedMethodCalls;
use App\Models\Localrepairproduct;
use App\Models\Localrepairservice;
use App\Models\MaintenancePayment;
use Illuminate\Support\Facades\DB;
use App\Models\Product_qty_history;
use App\Models\Localmaintenancebill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\MaintenancePaymentExpense;

class ReportController extends Controller
{

public function index(){

    $user = Auth::user();
    $permit = User::find($user->id)->permit_type;
    $permit_array = json_decode($permit, true);
    if ($permit_array && in_array('26', $permit_array)) {

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
    $report_name = trans('messages.expense_report_lang', [], session('locale'));

    if (in_array('26', $permit_array)) {
        return view('reports.expense_report', compact('permit_array', 'report_name', 'shop', 'invo', 'expenses', 'expense_cat' , 'edata' , 'sdata' ,'cat_id' ));
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
        if ($account_id == 'point') {
            $order->whereRaw("FIND_IN_SET('0', account_id)");
        } elseif (!empty($account_id)) {
            $order->whereRaw("FIND_IN_SET($account_id, account_id)");
        }

    }

    $orders = $order->get();
    $report_name = trans('messages.sales_report_lang', [], session('locale'));

    if (in_array('26', $permit_array)) {
        return view('reports.sales_report', compact('permit_array', 'report_name', 'shop', 'orders', 'invo', 'accounts', 'account_id', 'edata', 'sdata'));
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
        ->whereDate('purchase_date', '>=', $sdata)
        ->whereDate('purchase_date', '<=', $edata)
        ->get();


        foreach ($purchases as $purchase) {
            $purchase->purchase_bill = Purchase_bill::where('purchase_id', $purchase->id)->first();
            $purchase->remaining_amount = $purchase->purchase_bill ? $purchase->purchase_bill->remaining_price : 0;
            $purchase->grand_total = $purchase->purchase_bill ? $purchase->purchase_bill->grand_total : 0;
        }

        $report_name = trans('messages.supplier_report_lang', [], session('locale'));
        $purchasesall = $purchases->toArray();

        if (in_array('26', $permit_array)) {
            return view('reports.supplier_report', compact('permit_array', 'report_name', 'purchasesall', 'supplier_id', 'suppliers', 'shop',  'invo',  'edata' , 'sdata'  ));
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
        ->whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)
        ->groupBy('product_id', 'item_barcode')
        ->orderByDesc('total_quantity_sold')
        ->get();
        $report_name = trans('messages.most_sold_lang', [], session('locale'));

        if (in_array('26', $permit_array)) {
            return view('reports.most_sold_item', compact('permit_array', 'report_name', 'most_selling_products', 'store_id', 'shop', 'invo', 'sdata', 'stores', 'edata'));
        } else {
            return redirect()->route('home');
        }


    }

    public function profit_expense(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $posorder = PosOrder::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
        $totalSales = $posorder->sum('total_amount');
        $orderProfit = $posorder->sum('total_profit');

        $expense = Expense::whereDate('expense_date', '>=', $sdata)
        ->whereDate('expense_date', '<=', $edata)
        ->get();
        $generalExpense = $expense->sum('amount');

        $posExpense = PaymentExpense::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
        $posExpenseTotal = $posExpense->sum('account_tax_fee');

        $maintenanceExpense = MaintenancePaymentExpense::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
        $maintenanceExpenseTotal = $maintenanceExpense->sum('account_tax_fee');
        $local_maint = Localmaintenance::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
        $inspection_cost= $local_maint->sum('inspection_cost');
        $services = Localrepairservice::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
        $serviceCost = $services->sum('cost');

        $products = Localrepairproduct::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();
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

        $grandProfit =  $orderProfit + $serviceCost + $repairCost + $inspection_cost;
        $finalProfit = $grandProfit - $totalExpense;
        $report_name = trans('messages.profit_expense_lang', [], session('locale'));

        if (in_array('26', $permit_array)) {
            return view('reports.profit_and_expense_report', compact(
                'permit_array',
                'shop',
                'invo',
                'sdata',
                'edata',
                'report_name',
                'totalSales',
                'orderProfit',
                'generalExpense',
                'posExpenseTotal',
                'maintenanceExpenseTotal',
                'serviceCost',
                'repairCost',
                'inspection_cost',
                'totalCost',
                'totalExpense',
                'finalProfit'
            ));
        } else {
            return redirect()->route('home');
        }


    }


    public function category_sale(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $category= Category::all();
        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $category_id= !empty($request['category_id']) ? $request['category_id'] : "";


        $query = DB::table('pos_order_details')
        ->join('products', 'pos_order_details.product_id', '=', 'products.id')
        ->select('products.category_id',
                 DB::raw('SUM(pos_order_details.item_quantity) as quantity'),
                 DB::raw('SUM(pos_order_details.item_quantity * pos_order_details.item_price) as total_sale'),
                 DB::raw('SUM(pos_order_details.item_profit) as total_profit'))
        ->whereDate('pos_order_details.created_at', '>=', $sdata)
        ->whereDate('pos_order_details.created_at', '<=', $edata)
        ->groupBy('products.category_id');

    if (!empty($category_id)) {
        $query->where('products.category_id', $category_id);
    }

    $category_sale = $query->get();
    $report_name = trans('messages.category_sale_lang', [], session('locale'));



    if (in_array('26', $permit_array)) {
        return view('reports.category_sale', compact(
            'permit_array',
            'shop',
            'invo',
            'sdata',
            'edata',
            'category',
            'category_sale',
            'category_id',
            'report_name',
        ));
    } else {
        return redirect()->route('home');
    }


    }


    public function brand_sale(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $brand= Brand::all();
        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $brand_id= !empty($request['brand_id']) ? $request['brand_id'] : "";


        $query = DB::table('pos_order_details')
        ->join('products', 'pos_order_details.product_id', '=', 'products.id')
        ->select('products.brand_id',
                 DB::raw('SUM(pos_order_details.item_quantity) as quantity'),
                 DB::raw('SUM(pos_order_details.item_quantity * pos_order_details.item_price) as total_sale'),
                 DB::raw('SUM(pos_order_details.item_profit) as total_profit'))
                 ->whereDate('pos_order_details.created_at', '>=', $sdata)
                 ->whereDate('pos_order_details.created_at', '<=', $edata)
                 ->groupBy('products.brand_id');

    if (!empty($brand_id)) {
        $query->where('products.brand_id', $brand_id);
    }

    $brand_sale = $query->get();
    $report_name = trans('messages.brand_sale_lang', [], session('locale'));



    if (in_array('26', $permit_array)) {
        return view('reports.brand_sale', compact(
            'permit_array',
            'shop',
            'invo',
            'sdata',
            'edata',
            'brand',
            'brand_sale',
            'brand_id',
            'report_name',
        ));
    } else {
        return redirect()->route('home');
    }


    }


    public function customer_point(Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $customers = Customer::orderByDesc('points')->get();

        $customer_id = !empty($request->customer_id) ? $request->customer_id : "";
        $points_history= PointHistory::where('customer_id', $customer_id)->get();

        $query = Customer::query();

        if (!empty($customer_id)) {
            $query->where('id', $customer_id);
        }

        $customer_data = $query->get();
        $report_name = trans('messages.customer_point_lang', [], session('locale'));



        if (in_array('26', $permit_array)) {
            return view('reports.customer_point', compact(
                'permit_array',
                'shop',
                'invo',
                'customers',
                'customer_id',
                'customer_data',
                'report_name',
                'points_history',
            ));
        } else {
            return redirect()->route('home');
        }
    }

    public function points_history(Request $request) {
        $customer_id = $request->customer_id;
        $customer_name = Customer::where('id', $customer_id)->value('customer_name');
        $points_history = PointHistory::where('customer_id', $customer_id)->get();
        return response()->json(['points_history' => $points_history, 'customer_name'=>$customer_name]);
    }

    public function maint_report_warranty (Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $customers = Customer::orderByDesc('points')->get();

        $customer_id = !empty($request->customer_id) ? $request->customer_id : "";
        $points_history= PointHistory::where('customer_id', $customer_id)->get();

        $query = Customer::query();

        if (!empty($customer_id)) {
            $query->where('id', $customer_id);
        }

        $customer_data = $query->get();
        $report_name = trans('messages.customer_point_lang', [], session('locale'));




        if (in_array('26', $permit_array)) {
            return view('reports.customer_point', compact(
                'permit_array',
                'shop',
                'invo',
                'customers',
                'customer_id',
                'customer_data',
                'report_name',
                'points_history',
            ));
        } else {
            return redirect()->route('home');
        }

    }


    public function local_repair(Request $request){

        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $local_repairs = Localmaintenance::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();

        $reports = [];

        foreach($local_repairs as $repair){

            $method= MaintenancePayment::where('referemce_no', $repair->reference_no)->first();
            $account_name = "";
            $payment_method="";
            if(!empty($method)){
                $payment_method= $method->account_id;
                $account= Account::where('id', $payment_method)->first();
                $account_name= $account->account_name;
            }
            // $payment_method= $method->account_id;
            // $account= Account::where('id', $payment_method)->first();
            // $account_name= $account->account_name;

            $ref_no = $repair->reference_no;
            $id= $repair->id;
            $discount=0;
            if($repair->total_discount > 0)
            {
                $discount= $repair->total_discount;
            }

            $model= $repair->product_model;


            $inspection_cost = $repair->inspection_cost;
            $receive_date = $repair->receive_date;
            $product= $repair->product_name;
            $deliver_date = $repair->deliver_date;
            $tech_ids = explode(',', $repair->technician_id);
            $tech = Technician::whereIn('id', $tech_ids)->pluck('technician_name');
            $technician= $tech->implode(', ');
            $repairing_type = $repair->repairing_type;
            $repairing = ($repairing_type == 1) ? 'Repair' : 'Inspection';

            $status = $repair->status;
            switch($status){
                case 1:
                    $status = 'Received';
                    break;
                case 4:
                    $status = 'Ready';
                    break;
                case 5:
                    $status = 'Delivered';
                    break;
            }

            $customer = Customer::where('id', $repair->customer_id)->first();
            $customer_name = $customer->customer_name;
            $customer_no = $customer->customer_number;

            $payment = Localmaintenancebill::where('reference_no', $ref_no)->first();

            $grand_total = $payment ? $payment->grand_total : 0;

            $product_data = Localrepairproduct::where('reference_no', $ref_no)
                                    ->join('products', 'localrepairproducts.product_id', '=', 'products.id')
                                    ->selectRaw('IFNULL(products.product_name_ar, products.product_name) AS product_name, SUM(products.purchase_price) AS total_purchase_price')
                                    ->groupBy('products.product_name_ar', 'products.product_name')
                                    ->get();

                                    $product_names = $product_data->pluck('product_name')->implode(', ');
                                    $product_purchase = $product_data->sum('total_purchase_price');
                                    $product_prices = Localrepairproduct::where('reference_no', $ref_no)->sum('cost');



            $service_names = Localrepairservice::where('reference_no', $ref_no)
                                                ->join('services', 'localrepairservices.service_id', '=', 'services.id')
                                                ->pluck('services.service_name')
                                                ->implode(', ');

            $service_cost_total = Localrepairservice::where('reference_no', $ref_no)->sum('cost');


            $detail= $product_prices - $product_purchase;
            $profit = $detail  +  $inspection_cost +  $service_cost_total;

            $reports[] = [
                'ref_no' => $ref_no,
                'profit'=>$profit,
                'inspection_cost' => $inspection_cost,
                'receive_date' => $receive_date,
                'deliver_date' => $deliver_date,
                'technician' => $technician,
                'model'=>$model,
                'repairing' => $repairing,
                'status' => $status,
                'customer_name' => $customer_name,
                'customer_no' => $customer_no,
                'grand_total' => $grand_total,
                'product_names' => $product_names,
                'id'=>$id,
                'product_prices' => $product_prices,
                'service_names' => $service_names,
                'service_cost_total' => $service_cost_total,
                'product'=>$product,
                'discount'=>$discount,
                'payment_method'=>$payment_method,
                'account_name'=>$account_name,
            ];

        }



        $report_name = trans('messages.local_repair_lang', [], session('locale'));


        if (in_array('26', $permit_array)) {

        return view('reports.local_repair_report', compact(
            'permit_array',
            'shop',
            'invo',
            'sdata',
            'edata',
            'report_name',
            'reports'
        ));
        } else {
            return redirect()->route('home');
        }
    }


    public function warranty_repair(Request $request){

        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $warranty_repairs = Repairing::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)
        ->get();

        $reports = [];

        foreach($warranty_repairs as $repair){

            $invo_no= $repair->invoice_no;

            $ref_no = $repair->reference_no;
            $id= $repair->id;
            $warranty = Warranty::where('id', $repair->warranty_id)->first();
            $product = Product::where('id', $warranty->product_id)->first();
            $product_name = $product->product_name ?? '';
            $product_name_ar = $product->product_name_ar ?? '';

            if ($product_name && $product_name_ar) {
                $product_name = "$product_name\n$product_name_ar";
            } elseif ($product_name_ar) {
                $product_name = $product_name_ar;
            }

            $product_barcode= $product->barcode ?? '';


            $warranty_type= $warranty->warranty_type;
            $warranty_start_date = PosOrder::where('order_no', $warranty->order_no)->value('created_at');
            $warranty_days = $warranty->warranty_days;
            $current_date = now();
            $days_difference = $current_date->diffInDays($warranty_start_date);
            $remaining_warranty_days = $warranty_days - $days_difference;
            $validity = $warranty_start_date->addDays($warranty_days)->format('Y-m-d');



            $receive_date = $repair->receive_date;
            $product= $repair->product_name;
            $deliver_date = $repair->deliver_date;
            $replace_status= $repair->replace_status;
            $replace = ($replace_status == 1) ? 'Not Replaced' : 'Replaced';
            $technician = Technician::where('id', $repair->technician_id)->value('technician_name');
            $repairing_type = $repair->repairing_type;
            $repairing = ($repairing_type == 1) ? 'Repair' : 'Inspection';

            $status = $repair->status;
            switch($status){
                case 1:
                    $status_text = 'Received';
                    break;
                case 2:
                    $status_text = 'Send to Agent';
                    break;
                case 3:
                    $status_text = 'Received from Agent';
                    break;
                case 4:
                    $status_text = 'Ready';
                    break;
                case 5:
                    $status_text = 'Delivered';
                    break;
                default:
                    $status_text = 'Unknown';
            }



            $customer = Customer::where('id', $repair->customer_id)->first();
            $customer_name = $customer->customer_name;
            $customer_no = $customer->customer_number;
            $product_data = RepairProduct::where('reference_no', $ref_no)
                                    ->join('products', 'repair_products.product_id', '=', 'products.id')
                                    ->selectRaw('IFNULL(products.product_name_ar, products.product_name) AS product_name, SUM(products.purchase_price) AS total_purchase_price')
                                    ->groupBy('products.product_name_ar', 'products.product_name')
                                    ->get();

                                    $product_names = $product_data->pluck('product_name')->implode(', ');
                                    $product_prices = Repairproduct::where('reference_no', $ref_no)->sum('cost');



            $service_names = RepairService::where('reference_no', $ref_no)
                                                ->join('services', 'repair_services.service_id', '=', 'services.id')
                                                ->pluck('services.service_name')
                                                ->implode(', ');

            $service_cost_total = Repairservice::where('reference_no', $ref_no)->sum('cost');


            $expense = $product_prices +  $service_cost_total ;

            $reports[] = [
                'ref_no' => $ref_no,
                'expense' => $expense,
                'product_name'=>$product_name,
                'receive_date' => $receive_date,
                'deliver_date' => $deliver_date,
                'technician' => $technician,
                'repairing' => $repairing,
                'status' => $status_text,
                'warranty_type'=>$warranty_type,
                'warranty_days'=> $warranty_days,
                'remaining_warranty_days'=> $remaining_warranty_days,
                'validity'=>$validity,
                'customer_name' => $customer_name,
                'customer_no' => $customer_no,
                'product_names' => $product_names,
                'id'=>$id,
                'product_prices' => $product_prices,
                'service_names' => $service_names,
                'service_cost_total' => $service_cost_total,
                'product'=>$product,
                'replace'=>$replace,
                'invo_no'=>$invo_no,
                'product_barcode'=>$product_barcode,
            ];
        }



        $report_name = trans('messages.warranty_repair_lang', [], session('locale'));



        if (in_array('26', $permit_array)) {

            return view('reports.warranty_repair', compact(
                'permit_array',
                'shop',
                'invo',
                'sdata',
                'edata',
                'report_name',
                'reports'
            ));
            } else {
                return redirect()->route('home');
            }
    }


    public function stock_report (Request $request){
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
       $product= Product::all();




        $report_name = trans('messages.customer_point_lang', [], session('locale'));




        if (in_array('26', $permit_array)) {
            return view('reports.stock_report', compact(
                'permit_array',
                'shop',
                'invo',
               'product',
                'report_name',

            ));
        } else {
            return redirect()->route('home');
        }

    }



    //warranty_products




    public function warranty_products(Request $request){

        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $warranty = Warranty::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->get();

        $reports = [];

        foreach($warranty as $warr){

            $product = Product::where('id', $warr->product_id)->first();
            $product_name = $product->product_name ?? '';
            $product_name_ar = $product->product_name_ar ?? '';

            if ($product_name && $product_name_ar) {
                $product_name = "$product_name\n$product_name_ar";
            } elseif ($product_name_ar) {
                $product_name = $product_name_ar;
            }

            $product_barcode = $product->barcode ?? '';
            $warranty_type= $warr->warranty_type;
            $warranty_days = $warr->warranty_days;
            $id= $product->id;




            $customer = Customer::where('id', $warr->customer_id)->first();
            $customer_name = $customer->customer_name;
            $customer_no = $customer->customer_number;

            $reports[] = [

                'product_name'=>$product_name,
                'warranty_type'=>$warranty_type,
                'warranty_days'=> $warranty_days,
                'customer_name' => $customer_name,
                'customer_no' => $customer_no,
                'product_barcode'=>$product_barcode,
                'id'=>$id,

            ];
        }


        $report_name = trans('messages.warranty_products_lang', [], session('locale'));
        if (in_array('26', $permit_array)) {

            return view('reports.warr_products', compact(
                'permit_array',
                'shop',
                'invo',
                'sdata',
                'edata',
                'report_name',
                'reports'
            ));
            } else {
                return redirect()->route('home');
            }
    }


    public function damage_products(Request $request){

        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
        $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

        $history = Product_qty_history::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)
        ->where('source', 'damage')
        ->get();


        $reports = [];

        foreach($history as $pro){

            $product = Product::where('id', $pro->product_id)->first();
            $product_name = $product->product_name ?? '';
            $product_name_ar = $product->product_name_ar ?? '';
            if ($product_name && $product_name_ar) {
                $product_name = "$product_name\n$product_name_ar";
            } elseif ($product_name_ar) {
                $product_name = $product_name_ar;
            }

            $product_barcode = $product->barcode ?? '';
            $id= $product->id;
            $pre_qty = $pro->previous_qty ?? '';
            $damage_qty = $pro->given_qty ?? '';
            $new_qty = $pro->new_qty ?? '';
            $reason = $pro->notes ?? '';

            $reports[] = [

                'product_name'=>$product_name,
                'product_barcode'=>$product_barcode,
                'id'=>$id,
                'damage_qty'=>$damage_qty,
                'new_qty'=>$new_qty,
                'pre_qty'=>$pre_qty,
                'reason'=>$reason,

            ];
        }

        $report_name = trans('messages.damage_products_lang', [], session('locale'));
        if (in_array('26', $permit_array)) {
            return view('reports.damage_products', compact(
                'permit_array',
                'shop',
                'invo',
                'sdata',
                'edata',
                'report_name',
                'reports'
            ));
            } else {
                return redirect()->route('home');
            }
    }

    public function customer_purchase(Request $request)
    {
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $universities = University::all();
        $nationalities = Nationality::all();
        $ministries = Ministry::all();
        $customers = Customer::all();

        $sdata = $request->input('date_from', date('Y-m-d'));
        $edata = $request->input('to_date', date('Y-m-d'));

        $customer_id = null;
        $customer_ids = [];
        $customer_id = "";
        $university_id = "";
        $nationality_id = "";
        $ministry_id = "";

        // Calculate the total number of customers
        $total_customers = Customer::count();

        if (!empty($request->input('customer_id'))) {
            $customer_id = $request->input('customer_id');
        } elseif (!empty($request->input('university_id'))) {
            $university_id = $request->input('university_id');
            $customers = Customer::where('student_university', $university_id)->get();
            $customer_id = $customers->pluck('id')->toArray();
        } elseif (!empty($request->input('ministry_id'))) {
            $ministry_id = $request->input('ministry_id');
            $customers = Customer::where('ministry_id', $ministry_id)->get();
            $customer_id = $customers->pluck('id')->toArray();
        } elseif (!empty($request->input('nationality_id'))) {
            $nationality_id = $request->input('nationality_id');
            $customers = Customer::where('nationality_id', $nationality_id)->get();
            $customer_id = $customers->pluck('id')->toArray();
        }
        else
        {
            $customers = Customer::get();
            $customer_id = $customers->pluck('id')->toArray();
        }

        // Calculate the number of customers that meet the specific condition
        $filtered_customers_count = is_array($customer_id) ? count($customer_id) : 0;

        if(empty($customer_id)){
            $filtered_customers_count = 0;
        }

        $percentage_of_customers = $total_customers > 0 ? ($filtered_customers_count / $total_customers) * 100 : 0;
        $percent=number_format($percentage_of_customers, 3);


        $orders = [];
        if (!empty($customer_id)) {
            if (is_array($customer_id)) {
                foreach ($customer_id as $id) {
                    $ordersQuery = PosOrder::selectRaw('customer_id, count(*) as total_orders, sum(total_amount) as total_purchases')
                        ->whereDate('created_at', '>=', $sdata)
                        ->whereDate('created_at', '<=', $edata)
                        ->where('customer_id', $id)
                        ->groupBy('customer_id')
                        ->orderBy('total_purchases', 'asc');


                    $order = $ordersQuery->first();
                    if (!is_null($order)) {
                        $orders[] = $order;
                    }
                }
            } else {
                $ordersQuery = PosOrder::selectRaw('customer_id, count(*) as total_orders, sum(total_amount) as total_purchases')
                    ->whereDate('created_at', '>=', $sdata)
                    ->whereDate('created_at', '<=', $edata)
                    ->where('customer_id', $customer_id)
                    ->groupBy('customer_id')
                    ->orderBy('total_purchases', 'asc');


                $order = $ordersQuery->first();
                if (!is_null($order)) {
                    $orders[] = $order;
                }
            }
        } else {
            $ordersQuery = PosOrder::selectRaw('customer_id, count(*) as total_orders, sum(total_amount) as total_purchases')
                ->whereDate('created_at', '>=', $sdata)
                ->whereDate('created_at', '<=', $edata)
                ->groupBy('customer_id')
                ->orderBy('total_purchases', 'asc');

            $orders = $ordersQuery->get();
        }

        $total_purch= 0;
        $total_sale= PosOrder::sum('total_amount');
        $all_orders = [];
        foreach ($orders as $order) {


            $customer = Customer::find($order->customer_id);
            $customer_number = "";
            $customer_name = "";
            $customer_ids = "";
            $university_name = "";
            $ministry_name = "";
            $nationality_name = "";
            $phone = "";
            $address = "";
            $type = "";

            if (!is_null($customer)) {
                $customer_name = $customer->customer_name;
                $phone = $customer->customer_phone;
                $type = $customer->customer_type;

                if ($type == 1) {
                    $type = 'Student';
                } elseif ($type == 3) {
                    $type = 'Employee';
                } elseif ($type == 4) {
                    $type = 'General';
                }

                $addr = $customer->address;
                $address = Address::where('id', $addr)->value('area_name');
                $customer_number = $customer->customer_number;
                $customer_ids = $customer->id;
                $uni = $customer->student_university ?? '';
                $university = University::find($uni);
                $university_name = $university ? $university->university_name : '';

                $mini = $customer->ministry_id ?? '';
                $ministry = Ministry::find($mini);
                $ministry_name = $ministry ? $ministry->ministry_name : '';

                $nation = $customer->nationality_id ?? '';
                $nationality = Nationality::find($nation);
                $nationality_name = $nationality ? $nationality->nationality_name : '';
            }

                $total_purch += $order->total_purchases;




            $all_orders[] = [
                'customer_name' => $customer_name,
                'customer_number' => $customer_number,
                'phone' => $phone,
                'address' => $address,
                'type' => $type,
                'university_name' => $university_name,
                'customer_id' => $customer_ids,
                'nationality_name' => $nationality_name,
                'ministry_name' => $ministry_name,
                'total_orders' => $order->total_orders,
                'total_purchases' => $order->total_purchases,

            ];



        }

        $percentage_of_purchase = $total_sale > 0 ? ($total_purch / $total_sale) * 100 : 0;
        $percentage=number_format($percentage_of_purchase, 3);

        $report_name = trans('messages.customer_point_lang', [], session('locale'));

        if (in_array('26', $permit_array)) {
            return view('reports.customer_purchases', compact(
                'permit_array',
                'shop',
                'sdata',
                'edata',
                'invo',
                'customers',
                'customer_id',
                'report_name',
                'all_orders',
                'universities',
                'ministries',
                'ministry_id',
                'nationalities',
                'nationality_id',
                'university_id',
                'percent',
                'percentage',
                'total_purch',
                'filtered_customers_count'
            ));
        } else {
            return redirect()->route('home');
        }
    }




    public function customer_address(Request $request)
    {
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = $request->input('date_from', date('Y-m-d'));
        $edata = $request->input('to_date', date('Y-m-d'));
        $add_id = $request->input('add_id', '');

        $addresses = Address::all();
        $data = [];

        foreach ($addresses as $address) {
            if (!empty($add_id) && $address->id != $add_id) {
                continue;
            }

            $total_purchases = PosOrder::join('customers', 'pos_orders.customer_id', '=', 'customers.id')
                ->where('customers.address', $address->id)
                ->whereDate('pos_orders.created_at', '>=', $sdata)
                ->whereDate('pos_orders.created_at', '<=', $edata)
                ->sum('pos_orders.total_amount');

            $total_customers = Customer::where('address', $address->id)->count();
            $percentage_of_customers = number_format(($total_customers > 0 ? ($total_customers / Customer::count()) * 100 : 0), 3);

            $total_sales = PosOrder::sum('total_amount');
            $percentage_of_sales = number_format(($total_sales > 0 ? ($total_purchases / $total_sales) * 100 : 0), 3);

            $data[] = [
                'name' => $address->area_name,
                'total_customers' => $total_customers,
                'percentage_of_customers' => $percentage_of_customers,
                'total_purchases' => $total_purchases,
                'percentage_of_sales' => $percentage_of_sales,
            ];
        }

        $report_name = trans('messages.customer_point_lang', [], session('locale'));

        if (in_array('26', $permit_array)) {
            return view('reports.customer_address', compact(
                'permit_array',
                'shop',
                'invo',
                'report_name',
                'sdata',
                'edata',
                'add_id',
                'addresses',
                'data'
            ));
        } else {
            return redirect()->route('home');
        }
    }



    public function customer_type(Request $request)
    {
        $user = Auth::user();
        $permit = $user->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $sdata = $request->input('date_from', date('Y-m-d'));
        $edata = $request->input('to_date', date('Y-m-d'));

        $customer_type = $request->input('customer_type', '');



        $customer_gender = $request->input('customer_gender', '');

        $customer_age = $request->input('customer_age', '');


        // Get customer IDs from posorders table
        $customerIds = PosOrder::whereDate('created_at', '>=', $sdata)
        ->whereDate('created_at', '<=', $edata)->distinct()->pluck('customer_id');

        $data = [];

        // Query customer details based on customer IDs from posorders table
        $customers = Customer::whereIn('id', $customerIds);


        if (!empty($customer_type)) {
           $customers->where('customer_type', $customer_type);
        }


        if (!empty($customer_gender)) {
            $customers->where('gender', $customer_gender);
        }

        if (!empty($customer_age)) {
            $customers->whereRaw($this->getAgeQuery($customer_age));
        }

        $customersData = $customers->get();


        foreach ($customersData as $customer) {


            $total_purchases = PosOrder::where('customer_id', $customer->id)
                ->whereDate('created_at', '>=', $sdata)
                ->whereDate('created_at', '<=', $edata)
                ->sum('total_amount');


            $total_orders = PosOrder::where('customer_id', $customer->id)
                ->whereDate('created_at', '>=', $sdata)
                ->whereDate('created_at', '<=', $edata)
                ->count();

                $customer_type= $customer->customer_type;
                if( $customer_type==1){
                    $customer_type= 'Student';
                }
                elseif($customer_type==3){
                    $customer_type= 'Employee';
                }
                else{
                    $customer_type= 'General Customer';
                }

              $customer_gender=  $customer->gender;
              if(  $customer_gender==1){
                $customer_gender= 'Male';
              }
              else{
                $customer_gender= 'Female';
              }

                $customer_birth = $customer->dob;
                $birthdate = new DateTime($customer_birth);
                $current_date = new DateTime('now');
                $age = $current_date->diff($birthdate)->y;



            $data[] = [
                'customer_id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'phone' => $customer->customer_phone,
                'customer_type' => $customer_type,
                'dob' => $customer->dob,
                'customer_number' => $customer->customer_number,
                'total_orders' => $total_orders,
                'total_purchases' => $total_purchases,
                'customer_gender'=>$customer_gender,
                'age'=>$age,

            ];
        }



        $total_customers = count($customersData);
        $percentage_of_customers = number_format(($total_customers > 0 ? ($total_customers / Customer::count()) * 100 : 0), 3);

        $total_sales = PosOrder::sum('total_amount');
        // $percentage_of_sales = number_format(($total_sales > 0 ? ($total_purchases / $total_sales) * 100 : 0), 3);



        $report_name = trans('messages.customer_type_lang', [], session('locale'));

        if (in_array('26', $permit_array)) {
            return view('reports.customer_type', compact(
                'permit_array',

                'shop',
                'invo',
                'report_name',
                'sdata',
                'edata',
                'data',
                'customer_type',
                'customer_gender',
                'customer_age',
                'total_customers',
                'total_sales',

                'percentage_of_customers'
            ));
        } else {
            return redirect()->route('home');
        }
    }


/**
 * Generate the raw SQL for the age group query
 *
 * @param int $ageGroup
 * @return string
 */
private function getAgeQuery($ageGroup)
{
    $now = Carbon::now();
    switch ($ageGroup) {
        case 1:
            return "DATEDIFF('$now', dob) / 365 < 19";
        case 2:
            return "DATEDIFF('$now', dob) / 365 BETWEEN 20 AND 29";
        case 3:
            return "DATEDIFF('$now', dob) / 365 BETWEEN 30 AND 39";
        case 4:
            return "DATEDIFF('$now', dob) / 365 BETWEEN 40 AND 49";
        case 5:
            return "DATEDIFF('$now', dob) / 365 BETWEEN 50 AND 59";
        case 6:
            return "DATEDIFF('$now', dob) / 365 >= 60";
        default:
            return "1=1"; // No filter
    }
}

public function income_report(Request $request){


    $user = Auth::user();
    $permit = $user->permit_type;
    $permit_array = json_decode($permit, true);
    $shop = Settingdata::first();
    $invo = Posinvodata::first();
    $sdata = !empty($request['date_from']) ? $request['date_from'] : date('Y-m-d');
    $edata = !empty($request['to_date']) ? $request['to_date'] : date('Y-m-d');

    $posorder = PosOrder::whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)->get();

    $visa = PosPayment::where('account_id', 1)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $bank = PosPayment::where('account_id', 2)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $cash = PosPayment::where('account_id', 3)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $points = PosPayment::where('account_id', 0)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');



    $totalSales = $posorder->sum('total_amount');
    $orderProfit = $posorder->sum('total_profit');
    $orderdiscount= $posorder->sum('total_discount');

    $expense = Expense::whereDate('expense_date', '>=', $sdata)
    ->whereDate('expense_date', '<=', $edata)
    ->get();
    $generalExpense = $expense->sum('amount');

    $posExpense = PaymentExpense::whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)->get();
    $posExpenseTotal = $posExpense->sum('account_tax_fee');

    $maintenanceExpense = MaintenancePaymentExpense::whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)->get();
    $maintenanceExpenseTotal = $maintenanceExpense->sum('account_tax_fee');
    $local_maint = Localmaintenancebill::whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)->get();
    $grand_total= $local_maint->sum('grand_total');




    $discount= Localmaintenance::whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)->get();
    $total_discount= $discount->sum('total_discount');

    $maint_visa = MaintenancePayment::where('account_id', 1)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $maint_bank = MaintenancePayment::where('account_id', 2)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $maint_cash = MaintenancePayment::where('account_id', 3)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');
    $maint_points = MaintenancePayment::where('account_id', 0)
    ->whereDate('created_at', '>=', $sdata)
    ->whereDate('created_at', '<=', $edata)
    ->sum('paid_amount');

    $results = localmaintenancebill::join('localmaintenances', 'localmaintenancebills.reference_no', '=', 'localmaintenances.reference_no')
    ->join('maintenance_payments', 'localmaintenancebills.reference_no', '=', 'maintenance_payments.referemce_no')
    ->whereDate('localmaintenancebills.created_at', '>=', $sdata)
    ->whereDate('localmaintenancebills.created_at', '<=', $edata)
    ->whereDate('localmaintenances.created_at', '>=', $sdata)
    ->whereDate('localmaintenances.created_at', '<=', $edata)
    ->whereDate('maintenance_payments.created_at', '>=', $sdata)
    ->whereDate('maintenance_payments.created_at', '<=', $edata)
    ->select('localmaintenancebills.*', 'localmaintenances.*', 'maintenance_payments.*')
    ->get();


    // $inspection_cost= $local_maint->sum('inspection_cost');
    // $services = Localrepairservice::whereDate('created_at', '>=', $sdata)
    // ->whereDate('created_at', '<=', $edata)->get();
    // $serviceCost = $services->sum('cost');

    // $products = Localrepairproduct::whereDate('created_at', '>=', $sdata)
    // ->whereDate('created_at', '<=', $edata)->get();
    // $repairCost = 0;
    // foreach ($products as $pro){
    //     $item= Product::where('id', $pro->product_id)->first();
    //     $cost= $pro->cost;
    //     $purchase_price= $item->purchase_price;
    //     $profit = $cost - $purchase_price;
    //     $repairCost += $profit;
    // }

    // $totalCost = $serviceCost + $repairCost;
    // $totalExpense = $generalExpense + $posExpenseTotal + $maintenanceExpenseTotal;

    // $grandProfit =  $orderProfit + $serviceCost + $repairCost + $inspection_cost;
    // $finalProfit = $grandProfit - $totalExpense;

    $total_income = $grand_total + $totalSales;
    $overall_discount =  $total_discount +  $orderdiscount;
        $total_cash= $cash + $maint_cash;
        $total_visa= $visa + $maint_visa;
        $total_points= $points + $maint_points;
        $total_bank= $bank +$maint_bank;

    $report_name = trans('messages.profit_expense_lang', [], session('locale'));

    if (in_array('26', $permit_array)) {
        return view('reports.income_report', compact(
            'permit_array',
            'shop',
            'total_income',
            'overall_discount',
            'total_cash',
            'total_visa',
            'total_points',
            'total_bank',
            'invo',
            'sdata',
            'edata',
            'report_name',
            'totalSales',
            'orderProfit',
            'visa',
            'bank',
            'cash',
            'points',
            'maint_visa',
            'maint_bank',
            'maint_cash',
            'maint_points',
            'orderdiscount',
            'posorder',
            'grand_total',
            'total_discount',
            'results'
        ));
    } else {
        return redirect()->route('home');
    }

}



}
