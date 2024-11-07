<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Repairing;
use Illuminate\Http\Request;
use App\Models\PaymentExpense;
use App\Models\Localmaintenance;
use App\Models\Localrepairproduct;
use App\Models\Localrepairservice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\MaintenancePaymentExpense;

class HomeController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $permit = User::find($user->id)->permit_type;
    $permit_array = json_decode($permit, true);

    $total_customers = Customer::count();
    $total_products = Product::count();
    $total_local_repairing = Localmaintenance::count();
    $total_supplier = Supplier::count();
    $total_brands = Brand::count();
    $total_cat = Category::count();
    $total_Purchase_invoices = Purchase::count();
    $total_sales_invoices= PosOrder::count();
    $recent_products = Product::orderBy('created_at', 'desc')->take(5)->get();
    $orders = PosOrder::orderBy('created_at', 'desc')->where('restore_status', 0)->take(8)->get();


    $year = date('Y'); // This automatically gets the current year

    // Initialize arrays for monthly profit and expense
    $monthlyProfitData = [];
    $monthlyExpenseData = [];

    // Fetch data for each month (from 1 to 12)
    for ($month = 1; $month <= 12; $month++) {
        // Profit for the month
        $posOrders = PosOrder::whereYear('created_at', $year)
                             ->whereMonth('created_at', $month)
                             ->get();

        $orderProfit = $posOrders->sum('total_profit');

        $serviceCost = Localrepairservice::whereYear('created_at', $year)
                                         ->whereMonth('created_at', $month)
                                         ->sum('cost');


                                        //end
                                        $products = Localrepairproduct::whereYear('created_at', $year)
                                        ->whereMonth('created_at', $month)->get();
                                        $repairCost = 0;
                                        foreach ($products as $pro){
                                            $item= Product::where('id', $pro->product_id)->first();
                                            $cost= $pro->cost;
                                            $purchase_price= $item->purchase_price;
                                            $profit = $cost - $purchase_price;
                                            $repairCost += $profit;
                                        }
                                        //start

        $inspection_cost = Localmaintenance::whereYear('created_at', $year)
                                          ->whereMonth('created_at', $month)
                                          ->sum('inspection_cost');

        $grandProfit = $orderProfit + $serviceCost + $repairCost + $inspection_cost;
        $monthlyProfitData[$month] = ['grand_profit' => $grandProfit];

        // Expense for the month
        $generalExpense = Expense::whereYear('expense_date', $year)
                                 ->whereMonth('expense_date', $month)
                                 ->sum('amount');

        $posExpense = PaymentExpense::whereYear('created_at', $year)
                                    ->whereMonth('created_at', $month)
                                    ->sum('account_tax_fee');

        $maintenanceExpense = MaintenancePaymentExpense::whereYear('created_at', $year)
                                                     ->whereMonth('created_at', $month)
                                                     ->sum('account_tax_fee');

        $monthlyExpenseData[$month] = [
            'total_expense' => $generalExpense + $posExpense + $maintenanceExpense,
        ];
    }

    // Calculate final profit for each month (profit - expense)
    $finalMonthlyData = [];
    foreach ($monthlyProfitData as $month => $profitData) {
        $totalExpense = $monthlyExpenseData[$month]['total_expense'] ?? 0;
        $finalProfit = $profitData['grand_profit'] - $totalExpense;

        $finalMonthlyData[$month] = [
            'grand_profit' => $profitData['grand_profit'],
            'total_expense' => $totalExpense,
            'final_profit' => $finalProfit,
        ];
    }



    return view('dashboard.home', compact(
        'permit_array',
        'total_customers',
        'total_products',
        'total_local_repairing',
        'total_supplier',
        'total_brands',
        'total_cat',
        'total_Purchase_invoices',
        'total_sales_invoices',
        'finalMonthlyData',
        'year',
        'orders',
        'recent_products'
    ));
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
