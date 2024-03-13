<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\Workplace;
use App\Models\PosPayment;
use App\Models\University;
use Illuminate\Http\Request;
use App\Models\PaymentExpense;
use App\Models\PosOrderDetail;


use Illuminate\Support\Facades\File;

class PosController extends Controller
{
    public function index (){

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();

        $categories = Category::all();
        $count_products = Product::all()->count();

        // account
        $view_account = Account::where('account_type', 1)->get();
        return view ('pos_pages.pos', compact('categories', 'count_products', 'active_cat', 'universities', 'workplaces' , 'view_account'));
    }

    public function cat_products (Request $request){

        $cat_id = $request['cat_id'];

        if($cat_id=="all")
        {
            $cat_products = Product::all();
            $category_name= 'all';
        }
        else
        {

            $cat_products = Product::where('category_id', $cat_id)->get();
            $cat_name = Category::where('id', $cat_id)->first();
            $category_name = $cat_name->category_name;
        }


        $data = [
            'category_name' => $category_name,
            'products' => $cat_products,
        ];
        return response()->json($data);

    }

    public function order_list(Request $request){

        $product_barcode = $request->input('product_barcode');
        $product_quantity = $request->input('quantity');
        $product = Product::where('barcode', $product_barcode)->first();

        if (!$product) {
            return response()->json([
                'error'=> trans('messages.product_not_available_lang', [], session('locale')),
                'error_code' => 404
            ], 404);
        }

        $flag=1;
        if ($product->quantity<$product_quantity){

            $flag=2;
        }

        $is_bulk=0;
        if ($product_quantity>=$product->bulk_quantity && !empty($product->bulk_quantity)){

            $product_price = $product->bulk_price;
            $is_bulk=1;
        }

        else
        {
            $product_price = $product->sale_price;
        }
        $product_name = $product->product_name;
        $product_image = $product->stock_image;
        $product_barcode = $product->barcode;
        $product_id = $product->id;
        $product_min_price = $product->min_sale_price;
        $product_tax = 0;
        if(!empty($product->tax))
        {
            $product_tax = $product->tax;
        }

        return response()->json([
            'product_name' => $product_name,
            'product_barcode' => $product_barcode,
            'id' => $product_id,
            'product_image' => $product_image,
            'product_price' => $product_price,
            'product_min_price' => $product_min_price,
            'product_tax' => $product_tax,
            'is_bulk' => $is_bulk,
            'error_code' => $flag,
        ]);
    }

    public function product_autocomplete(Request $request){

        $term = $request->input('term');
        $products = Product::where('product_name', 'like', '%' . $term . '%')
                       ->orWhere('barcode', 'like', '%' . $term . '%')
                       ->get();

    $response = [];
    foreach ($products as $product) {
        $response[] = [
            'label' => $product->product_name . ' (' . $product->barcode . ')',
            'value' => $product->product_name .'+'. $product->barcode,
            'barcode' => $product->barcode
        ];
    }

    return response()->json($response);
    }

//customer_part

public function add_customer(Request $request){

    $customer = new Customer();
    $customer_img_name="";
    if ($request->file('customer_image')) {
        $folderPath = public_path('images/customer_images');
        if (!File::isDirectory($folderPath)) {
            File::makeDirectory($folderPath, 0777, true, true);
        }
        $customer_img_name = time() . '.' . $request->file('customer_image')->extension();
        $request->file('customer_image')->move(public_path('images/customer_images'), $customer_img_name);
    }

    $nationalId = $request->input('national_id');
    $existingCustomer = Customer::where('national_id', $nationalId)->first();

    if ($existingCustomer) {

        return response()->json(['customer_id' => '', 'status' => 2]);
    }

    $customer->customer_id = genUuid() . time();
    $customer->customer_name = $request['customer_name'];
    $customer->customer_phone = $request['customer_phone'];
    $customer->customer_email = $request['customer_email'];
    $customer->national_id = $request['national_id'];
    $customer->customer_detail = $request['customer_detail'];
    $customer->student_id = $request['student_id'];
    $customer->student_university = $request['student_university'];
    $customer->teacher_university = $request['teacher_university'];
    $customer->employee_id = $request['employee_id'];
    $customer->employee_workplace = $request['employee_workplace'];
    $customer->customer_type = $request['customer_type'];
    $customer->customer_image = $customer_img_name;
    $customer->added_by = 'admin';
    $customer->user_id = '1';
    $customer->save();
    return response()->json(['customer_id' => $customer->id, 'status' => 1]);


}

//customer autocomplte
public function customer_autocomplete(Request $request)
    {
        $term = $request->input('term');

        $customers = Customer::where('customer_name', 'like', "%{$term}%")
            ->orWhere('customer_phone', 'like', "%{$term}%")
            ->get(['customer_name', 'customer_phone']);

            foreach ($customers as $customer) {
                $response[] = [
                    'label' => $customer->customer_name . ' (' . $customer->customer_phone . ')',
                    'value' => $customer->customer_name .'+'. $customer->customer_phone,
                    'phone' => $customer->customer_phone
                ];
            }

        return response()->json($response);
    }

    // add pos order
    public function add_pos_order(Request $request)
    {

        $item_count = $request->input('item_count');
        $grand_total = $request->input('grand_total');
        $cash_payment = $request->input('cash_payment');
        $discount_type = $request->input('discount_type');
        $discount_by = $request->input('discount_by');
        $total_tax = $request->input('total_tax');
        $total_discount = $request->input('total_discount');
        $cash_back = $request->input('cash_back');
        $payment_method = $request->input('payment_method');
        $product_id = $request->input('produt_id');
        $item_barcode = $request->input('item_barcode');
        $item_tax = $request->input('item_tax');
        $item_quantity = $request->input('item_quantity');
        $item_price = $request->input('item_price');
        $item_total = $request->input('item_total');
        $item_discount = $request->input('item_discount');


        // pos order
        $pos_order = new PosOrder;

        $pos_order->customer_id= 3;
        $pos_order->item_count= $item_count;
        $pos_order->total_amount = $grand_total;
        $pos_order->paid_amount = $cash_payment;
        $pos_order->discount_type = $discount_type;
        $pos_order->discount_by = $discount_by;
        $pos_order->total_tax = $total_tax;
        $pos_order->total_discount = $total_discount;
        $pos_order->cash_back = $cash_back;
        $pos_order->store_id= 3;
        $pos_order->user_id= 1;
        $pos_order->added_by= 'admin';
        $pos_order->save();
        // pos order detail
        $pos_order_detail = new PosOrderDetail();
        $array = json_decode($product_id);
        for ($i=0; $i <count($array) ; $i++) {
            if($discount_type==1)
            {
                $discount_amount = $item_discount[$i];
                if ($item_price[$i] != 0) {

                    $discount_percent = intval($item_discount[$i]) * 100 / floatval($item_price[$i]);
                }
                else{
                    $discount_percent = 0;
                }

            }
            else
            {
                $discount_amount = $item_total[$i]/100*$item_discount[$i];
                $discount_percent = $item_discount[$i];
            }
            $pos_order_detail->product_id= $product_id[$i];
            $pos_order_detail->item_barcode = $item_barcode[$i];
            $pos_order_detail->item_quantity = $item_quantity[$i];
            $pos_order_detail->item_price = $item_price[$i];
            $pos_order_detail->item_total = $item_total[$i];
            $pos_order_detail->item_tax = $item_tax[$i];
            $pos_order_detail->item_discount_percent = $discount_percent;
            $pos_order_detail->item_discount_price = $discount_amount;
            $pos_order_detail->user_id= 1;
            $pos_order_detail->added_by= 'admin';
            $pos_order_detail_saved= $pos_order_detail->save();
        }

        // payment pos

        $pos_payment = new PosPayment();

        $pos_payment->paid_amount= $cash_payment;
        $pos_payment->total = $grand_total;
        $pos_payment->remaining_amount = $grand_total-$cash_payment;
        $pos_payment->account_id = $payment_method;
        $pos_payment->account_reference_no = "";
        $pos_payment->user_id= 1;
        $pos_payment->added_by= 'admin';
        $pos_payment_saved= $pos_payment->save();

        // get payment method data

        $account_data = Account::where('account_id', $payment_method)->first();
        if($account_data->account_status!=1)
        {
            // payment expense
            $payment_expense = new PaymentExpense();

            $account_tax_fee = $cash_payment / 100 * $account_data->commission;
            $payment_expense->total_amount= $grand_total;
            $payment_expense->account_tax = $account_data->commission;
            $payment_expense->account_tax_fee = $account_tax_fee;
            $payment_expense->account_id = $payment_method;
            $payment_expense->account_reference_no = "";
            $payment_expense->user_id= 1;
            $payment_expense->added_by= 'admin';
            $payment_expense_saved  =$payment_expense->save();
        }


        if ($pos_order_detail_saved && $pos_payment_saved && $payment_expense_saved) {

            return response()->json(['status' => 1]);
        } else {

            return response()->json(['status' => 2]);
        }

    }




}
