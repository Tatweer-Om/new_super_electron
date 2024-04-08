<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mockery\Undefined;
use App\Models\Account;
use App\Models\Product;
use App\Models\Category;

use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Repairing;
use App\Models\Workplace;
use App\Models\PosPayment;
use App\Models\University;
use App\Models\PendingOrder;
use App\Models\Product_imei;
use Illuminate\Http\Request;
use App\Models\PaymentExpense;
use App\Models\PosOrderDetail;
use App\Models\PendingOrderDetail;


use App\Models\Product_qty_history;
 
use App\Models\Localmaintenance;
use App\Models\Localmaintenancebill;
use App\Models\MaintenancePaymentExpense;
use App\Models\MaintenancePayment; 
 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PosController extends Controller
{
    public function index (){
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();
        $orders = PosOrder::latest()->take(15)->get();
        $categories = Category::all();
        $count_products = Product::all()->count();

        // account
        $view_account = Account::where('account_type', 1)->get();
        if ($permit_array && in_array('23', $permit_array)) {

            return view ('pos_pages.pos', compact('categories', 'count_products',
         'active_cat', 'universities', 'workplaces' , 'view_account',
         'orders','permit_array'));
        } else {

            return redirect()->route('home');
        }

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

    public function get_pro_imei (Request $request){


        $barcode = $request['barcode'];

        $products_data = Product::where('barcode', $barcode)->first();
        $products_imei = Product_imei::where('barcode', $barcode)
                                    ->where('replace_status', 1)->get();


        $data = [
            'product_imei' => $products_imei,
            'stock_image' => $products_data['stock_image'],
            'product_name' => $products_data['product_name'],
            'sale_price' => $products_data['sale_price'],

        ];
        return response()->json($data);

    }

    public function order_list(Request $request){

        $product_barcode = $request->input('product_barcode');
        $product_quantity = $request->input('quantity');
        $product = Product::where('barcode', $product_barcode)->first();
        $imeis = Product_imei::where('barcode', $product->barcode)->distinct()->pluck('imei')->toArray();








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
        $title = $product->product_name;
        if(empty($title))
        {
            $title = $product->product_name_ar;
        }
        $product_name = $title;
        $product_image = $product->stock_image;
        $product_barcode = $product->barcode;
        $product_id = $product->id;
        $product_min_price = $product->min_sale_price;
        $product_tax = 0;
        if(!empty($product->tax))
        {
            $product_tax = $product->tax;
        }

        $warranty_type ="";

        if($product->warranty_type!=3)
        {
            if ($product->warranty_type == 1) {
                $warranty_type = trans('messages.shop_lang', [], session('locale')).' : '.$product->warranty_days.' '. trans('messages.days_lang', [], session('locale'));
            } elseif ($product->warranty_type == 2) {
                $warranty_type = trans('messages.agent_lang', [], session('locale')).' : '.$product->warranty_days.' '. trans('messages.days_lang', [], session('locale'));
            }
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
            'popup'=>!empty($imeis[0]),
            'warranty_type' => $warranty_type

        ]);

    }

    public function product_autocomplete(Request $request) {
        $term = $request->input('term');

        $products = Product::where('barcode', 'like', '%' . $term . '%')
                                ->orWhere('product_name', 'like', '%' . $term . '%')
                                ->get()
                                ->toArray();
        $response = [];
        if(!empty($products))
        {
            foreach ($products as $product) {
                // if($product['check_imei']==1)
                // {

                //     $products_imei = Product_imei::where('barcode', $product['barcode'])
                //                     ->get()
                //                     ->toArray();
                //     // $imeis = explode(',', $products_imei['imei']);


                //     foreach ($products_imei as $imei) {

                //         $response[] = [
                //             'label' => $product['barcode'] . '+' . $imei['imei']. '+' .$product['product_name'] ,
                //             'value' => $product['barcode'] . '+' . $imei['imei']. '+' .$product['product_name'] ,
                //             'imei' => $imei['imei'],
                //         ];
                //     }
                // }
                // else
                // {
                $response[] = [
                    'label' => $product['product_name'].'+'.$product['barcode'],
                    'value' => $product['barcode'] . '+' . $product['product_name'],
                    'barcode' => $product['barcode'],
                ];

                // }
            }
        }
        // else
        // {
        //     $products = Product_imei::where('imei', 'like', '%' . $term . '%')
        //                         ->get()
        //                         ->toArray();

        //     foreach ($products as $product) {


        //         $products_data = Product::where('barcode', $product['barcode'])->first();
        //         $response[] = [
        //             'label' => $products_data['product_name'] . '+' . $products_data['barcode'] . '+' . $product['imei'],
        //             'value' => $products_data['barcode'] . '+' . $products_data['product_name'] . '+' . $product['imei'],
        //             'barcode' => $products_data['barcode'],
        //         ];



        //     }
        // }

        return response()->json($response);
    }

    // get product type
    public function get_product_type(Request $request) {
        $barcode = $request->input('barcode');

        $products = Product::where('barcode',$barcode)->first();
        $check_imei = 2;
        if(!empty($products))
        {
            if($products->check_imei==1)
            {
                $check_imei =1 ;
            }
        }
        return response()->json(['check_imei' => $check_imei]);
    }

//customer_part

public function add_customer_repair(Request $request){

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
        exit;
    }
    $customer_phone = $request['customer_phone'];
    $existingCustomer = Customer::where('customer_phone', $customer_phone)->first();
    if ($existingCustomer) {

        return response()->json(['customer_id' => '', 'status' => 3]);
        exit;
    }

    $customer->customer_id = genUuid() . time();
    $customer->customer_name = $request['customer_name'];
    $customer->customer_phone = $request['customer_phone'];
    $customer->customer_email = $request['customer_email'];
    $customer->national_id = $request['national_id'];
    $customer->customer_number = $request['customer_number'];
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

    $return_value =$request['customer_number'] . ': ' . $request['customer_name'] . ' (' . $request['customer_phone'] . ')';
    return response()->json(['customer_id' => $return_value, 'status' => 1]);


}

//customer autocomplte
    public function customer_autocomplete(Request $request)
    {
        $term = $request->input('term');

        $customers = Customer::where('customer_name', 'like', "%{$term}%")
        ->orWhere('customer_phone', 'like', "%{$term}%")
        ->get(['id', 'customer_name', 'customer_phone','customer_number']);

        foreach ($customers as $customer) {
            $response[] = [
                'label' => $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
                'value' => $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
                'phone' => $customer->customer_phone
            ];
        }

        return response()->json($response);
    }

    // add pos order
     public function add_pos_order(Request $request)
    {

        $action_type= $request->input('action_type');



        $action = 'add';
        if ($action_type == 'hold') {
            $action = 'hold';
        }

        $item_count = $request->input('item_count');
        $customer_id = $request->input('customer_id');
        $grand_total = $request->input('grand_total');
        $cash_payment = $request->input('cash_payment');
        $discount_type = $request->input('discount_type');
        $discount_by = $request->input('discount_by');
        $total_tax = $request->input('total_tax');
        $total_discount = $request->input('total_discount');
        $cash_back = $request->input('cash_back');
        $payment_method = $request->input('payment_method');

        $product_id = json_decode($request->input('product_id'));
        $item_barcode = json_decode($request->input('item_barcode'));
        $item_tax = json_decode($request->input('item_tax'));
        $item_imei = json_decode($request->input('item_imei'));
        $item_quantity = json_decode($request->input('item_quantity'));
        $item_price = json_decode($request->input('item_price'));
        $item_total = json_decode($request->input('item_total'));
        $item_discount = json_decode($request->input('item_discount'));

        // get customer id
        $customer_data = Customer::where('customer_number', $customer_id)->first();
        if($customer_data)
        {
            $customer_id = $customer_data->id;
        }

        // order no
        $order_data = PosOrder::where('return_status', '!=', 2)
                    ->orderBy('id', 'desc')
                    ->first();

        if($order_data)
        {
            $order_no_old = ltrim($order_data->order_no, '0');
        }
        else
        {
            $order_no_old=0;
        }

        $order_no = $order_no_old+1;
        $order_no = '0000000'.$order_no;
        if(strlen($order_no)!=8)
        {
           $len = (strlen($order_no)-8);
           $order_no = substr($order_no,$len);
        }
        // pos order
        $pos_order = new PosOrder;


        $pos_order->order_no= $order_no;
        $pos_order->customer_id= $customer_id;
        $pos_order->item_count= $item_count;
        $pos_order->order_type= $action;
        $pos_order->customer_id=$customer_id;
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


        for ($i=0; $i < count($product_id) ; $i++) {
            $pos_order_detail = new PosOrderDetail;
            if ($discount_type == 1) {
                $discount_amount = $item_discount[$i];
                if (floatval($item_price[$i]) != 0) {
                    $discount_percent = intval($item_discount[$i]) * 100 / floatval($item_price[$i]);
                } else {

                    $discount_percent = 0;
                }
            } else {

                if (floatval($item_total[$i]) != 0 && floatval($item_discount[$i]) != 0) {
                    $discount_amount = $item_total[$i] / 100 * $item_discount[$i];
                    $discount_percent = $item_discount[$i];
                } else {
                    $discount_amount = 0;
                    $discount_percent = 0;
                }
            }

            $pos_order_detail->order_no= $order_no;
            $pos_order_detail->order_id = $pos_order->id;
            $pos_order_detail->customer_id=$customer_id;
            $pos_order_detail->product_id= $product_id[$i];
            $pos_order_detail->item_barcode = $item_barcode[$i];
            $pos_order_detail->item_quantity = $item_quantity[$i];
            $pos_order_detail->item_price = $item_price[$i];
            $pos_order_detail->item_total = $item_total[$i];
            $pos_order_detail->item_tax = $item_tax[$i];
            $pos_order_detail->item_imei = $item_imei[$i];
            $pos_order_detail->item_discount_percent = $discount_percent;
            $pos_order_detail->item_discount_price = $discount_amount;
            $pos_order_detail->user_id= 1;
            $pos_order_detail->added_by= 'admin';
            $pos_order_detail_saved= $pos_order_detail->save();

            // minus qty and make history
            $pro_data = Product::where('id', $product_id[$i])->first();
            if(!empty($pro_data))
            {
                // replace imei data
                $current_qty = $pro_data->quantity;
                $damage_qty = $item_quantity[$i];
                $new_qty = $current_qty + $damage_qty;

                // product qty history
                $product_qty_history_save = new Product_qty_history();

                $product_qty_history_save->order_no =$order_no;
                $product_qty_history_save->product_id = $product_id[$i];
                $product_qty_history_save->barcode= $pro_data->barcode;
                $product_qty_history_save->imei= $item_imei[$i];
                $product_qty_history_save->source= 'sale';
                $product_qty_history_save->type= 2;
                $product_qty_history_save->previous_qty= $current_qty;
                $product_qty_history_save->given_qty= $damage_qty;
                $product_qty_history_save->new_qty= $new_qty;
                $product_qty_history_save->added_by = 'admin';
                $product_qty_history_save->user_id = '1';
                $product_qty_history_save->save();

                // update qty
                $pro_data->quantity=$new_qty;
                $pro_data->save();

                // delete imei
                if(!empty($item_imei[$i] && $item_imei[$i]!="undefined"))
                {
                    // delete imei
                    $pro_imei_data = Product_imei::where('imei', $item_imei[$i])->
                                                where('product_id', $product_id[$i])->first();
                    $pro_imei_data->delete();
                }
            }

            // warranty work
            if($pro_data->warranty_type!=3)
            {
                $warranty_data = Warranty::where('order_no', $order_no)
                                        ->where('product_id', $product_id[$i])
                                        ->where('item_imei', $item_imei[$i])->first();
                if($warranty_data)
                {

                }
                else
                {

                    $warranty_type='';
                    $warranty_days='';
                    if($pro_data)
                    {
                        $warranty_type = $pro_data->warranty_type;
                        $warranty_days = $pro_data->warranty_days;
                    }

                    $warranty_data = new Warranty();
                    $warranty_data->order_no = $order_no;
                    $warranty_data->order_id = $pos_order->id;
                    $warranty_data->product_id = $product_id[$i];
                    $warranty_data->customer_id=  $customer_id;
                    $warranty_data->item_barcode = $item_barcode[$i];
                    $warranty_data->quantity = $item_quantity[$i];
                    $warranty_data->purchase_price = $item_price[$i];
                    $warranty_data->total_price = $item_total[$i];
                    $warranty_data->item_imei = $item_imei[$i];
                    $warranty_data->warranty_type = $warranty_type;
                    $warranty_data->warranty_days = $warranty_days;
                    $warranty_data->user_id = '1';
                    $warranty_data->save();
                    $status = 1;
                }
            }


        }

        // payment pos

        $pos_payment = new PosPayment();
        $pos_payment->order_no= $order_no;
        $pos_payment->order_id = $pos_order->id;
        $pos_payment->customer_id=$customer_id;
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

        if(!empty($account_data ))
        {
            $opening_balance = $account_data->opening_balance;
            $new_balance = $opening_balance + $grand_total;
            $account_data->opening_balance = $new_balance;
            $account_data->save();
            if($account_data->account_status!=1)
            {
                // payment expense
                $payment_expense = new PaymentExpense();

                $account_tax_fee = $cash_payment / 100 * $account_data->commission;
                $payment_expense->total_amount= $grand_total;
                $payment_expense->order_no= $order_no;
                $payment_expense->order_id= $pos_order->id;
                $payment_expense->customer_id=$customer_id;
                $payment_expense->account_tax = $account_data->commission;
                $payment_expense->account_tax_fee = $account_tax_fee;
                $payment_expense->account_id = $payment_method;
                $payment_expense->account_reference_no = "";
                $payment_expense->user_id= 1;
                $payment_expense->added_by= 'admin';
                $payment_expense_saved  =$payment_expense->save();
            }
        }

        return response()->json(['order_no' => $order_no]);

    }



    //imei

    public function fetch_product_imeis(Request $request)
    {

        $imeis = Product_imei::where('imei', 'like', '%' . $request->term . '%')->pluck('imei')->toArray();
        return response()->json($imeis);
    }

    public function check_imei(Request $request) {
        $imei_find = $request->input('product_input');

        $get_imei = Product_imei::where('imei', $imei_find)->get();


        $found = $get_imei->isNotEmpty();

        return response()->json([
            'flag' => $found ? 1 : 0,
            'imei_records' => $get_imei->map(function($record) {
                return [
                    'imei' => $record->imei,
                    'barcode' => $record->barcode,

                ];
            })
        ]);
    }


    //hold order

    public function hold_order(Request $request){
        $orders = PosOrder::where('order_type', 'hold')->get();
    }

    public function get_return_items(Request $request) {
        $order_no = $request->input('order_no');
        $return_type = $request->input('return_type');
        $return_data = "";
        if($return_type == 1)
        {
            $repair_data = Repairing::where('reference_no', $order_no)
                                    ->where('replace_status', 1)
                                    ->where('repairing_type', 2)->first();

            if(!empty($repair_data))
            {

                $warranty_data = Warranty::where('id', $repair_data->warranty_id)->first();
                $pro_data = Product::where('id', $warranty_data->product_id)->first();
                $title = $pro_data->product_name;
                if(empty($title))
                {
                    $title =  $pro_data->product_name_ar;
                }
                $return_data = "<table class='table' style='width:100%'>
                                    <thead>
                                        <tr>
                                            <td>".trans('messages.product_name_lang', [], session('locale'))."</td>
                                            <td>".trans('messages.imei_no_lang', [], session('locale'))."</td>
                                            <td>".trans('messages.new_imei_no_lang', [], session('locale'))."</td>
                                            <td>".trans('messages.action_lang', [], session('locale'))."</td>
                                        </tr>
                                    </thead>";
                $return_data.= "    <tbody>
                                        <tr>
                                            <td>".$title."</td>
                                            <td>".$warranty_data->item_imei."</td>
                                            <td>
                                                <input type='hidden' class='form-control replace_reference_no' value='".$order_no."' name='replace_reference_no'>
                                                <input type='hidden' class='form-control old_imei' value='".$warranty_data->item_imei."' name='old_imei'>
                                                <input type='hidden' class='form-control old_product_id' value='".$warranty_data->product_id."' name='old_product_id'>
                                                <input type='text' class='form-control replaced_imei' name='replaced_imei'>
                                            </td>
                                            <td><a href='javascript:void(0);' class='btn btn-info' id='replace_item_btn'>
                                            <span class='me-1 d-flex align-items-center'></span>".trans('messages.replace_lang', [], session('locale'))."</a></td>
                                        </tr>
                                    </tbody>
                                </table>";
                $status = 1;
            }
            else
            {
                $status =2;
            }


        }

        return response()->json(['status' => $status,'return_data' => $return_data]);

    }


    // process replaced
    public function add_replace_item(Request $request) {
        $order_no = $request->input('order_no');
        $old_imei = $request->input('old_imei');
        $replaced_imei = $request->input('replaced_imei');
        $old_product_id = $request->input('old_product_id');
        $pro_imei = Product_imei::where('imei', $replaced_imei)->
                                where('product_id', $old_product_id)->first();

        if($pro_imei)
        {
            $pro_data = Product::where('id', $old_product_id)->first();
            // replace imei data
            $current_qty = $pro_data->quantity;
            $damage_qty = 1;
            $new_qty = $current_qty + $damage_qty;

            // product qty history
            $product_qty_history_save = new Product_qty_history();

            $product_qty_history_save->order_no =$order_no;
            $product_qty_history_save->product_id = $old_product_id;
            $product_qty_history_save->barcode= $pro_data->barcode;
            $product_qty_history_save->imei= $old_imei;
            $product_qty_history_save->source= 'replace_damage';
            $product_qty_history_save->type= 1;
            $product_qty_history_save->previous_qty= $current_qty;
            $product_qty_history_save->given_qty= $damage_qty;
            $product_qty_history_save->new_qty= $new_qty;
            $product_qty_history_save->added_by = 'admin';
            $product_qty_history_save->user_id = '1';
            $product_qty_history_save->save();

            // update qty
            $pro_data->quantity=$new_qty;
            $pro_data->save();

            // add imei
            $product_imei = new Product_imei();

            $product_imei->product_id=$old_product_id;
            $product_imei->barcode=$pro_data->barcode;
            $product_imei->imei=$old_imei;
            $product_imei->replace_status=2;
            $product_imei->added_by = 'admin';
            $product_imei->user_id = '1';
            $product_imei->save();

            // new imei data
            $pro_data = Product::where('id', $old_product_id)->first();
            $current_qty = $pro_data->quantity;
            $damage_qty = 1;
            $new_qty = $current_qty - $damage_qty;
            // product qty history
            $product_qty_history_save = new Product_qty_history();

            $product_qty_history_save->order_no =$order_no;
            $product_qty_history_save->product_id = $old_product_id;
            $product_qty_history_save->barcode= $pro_data->barcode;
            $product_qty_history_save->imei= $replaced_imei;
            $product_qty_history_save->source= 'replace';
            $product_qty_history_save->type= 2;
            $product_qty_history_save->previous_qty= $current_qty;
            $product_qty_history_save->given_qty= $damage_qty;
            $product_qty_history_save->new_qty= $new_qty;
            $product_qty_history_save->added_by = 'admin';
            $product_qty_history_save->user_id = '1';
            $product_qty_history_save->save();

            // update qty
            $pro_data->quantity=$new_qty;
            $pro_data->save();

            // delete imei
            $pro_imei_data = Product_imei::where('imei', $replaced_imei)->
                                where('product_id', $old_product_id)->first();
            $pro_imei_data->delete();

            // update repairing data
            $repair_data = Repairing::where('reference_no', $order_no)->first();
            $repair_data->replace_status=2;
            $repair_data->save();

            $status = 1;
        }
        else
        {
            $status = 2;
        }
        return response()->json(['status' => $status]);

    }


    // get mainteanance paymetn dataq
    public function get_maintenance_payment_data(Request $request) {
        $order_no = $request->input('order_no'); 
        $return_data = ""; 
        $repair_data = Localmaintenance::where('reference_no', $order_no)
                                ->where('status', 5)->first();

        if(!empty($repair_data))
        {

            $bill_data = Localmaintenancebill::where('reference_no', $order_no)->first();
            if($bill_data->remaining > 0)
            {
            $title = $repair_data->product_name;
            $repairing_type = "";
            if ($repair_data->repairing_type == 1) {
                $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.repair_lang', [], session('locale')) . "</span>";
            } else if ($repair_data->repairing_type == 2) {
                $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_lang', [], session('locale')) . "</span>";
            } else if ($repair_data->repairing_type == 3) {
                $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.warranty_lang', [], session('locale')) . "</span>";
            }

            $return_data = "<table class='table' style='width:100%'>
                                <thead>
                                    <tr>
                                        <td>".trans('messages.product_name_lang', [], session('locale'))."</td>
                                        <td>".trans('messages.imei_no_lang', [], session('locale'))."</td>
                                        <td>".trans('messages.repair_type_lang', [], session('locale'))."</td>
                                        <td>".trans('messages.grand_total_lang', [], session('locale'))."</td>
                                        <td>".trans('messages.action_lang', [], session('locale'))."</td>
                                    </tr>
                                </thead>";
            $return_data.= '<tbody>
                                    <tr>
                                        <td>'.$title.'</td>
                                        <td>'.$repair_data->item_imei.'</td>
                                        <td>'.$repairing_type.'</td>
                                        <td>'.$bill_data->grand_total.'</td>
                                        <td><a class="me-3  text-primary" target="_blank" href="'.url('history_local_record').'/'.$repair_data->id.'"><i class="fas fa-info"></i></a>
                                        <a class="me-3  text-primary" onclick=get_maintenance_payment("'.$bill_data->id.'")   data-bs-toggle="modal"
                                        data-bs-target="#maintenance_payment_modal"><i class="fas fa-money-check-alt"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>';
            $status = 1;
            }
            else
            {
                $status = 3;
            }
        }
        else
        {
            $status =2;
        }


         

        return response()->json(['status' => $status,'maintenance_data' => $return_data]);

    }
    public function get_maintenance_payment(Request $request) {
        $id = $request->input('id');  
        $bill_data = Localmaintenancebill::where('id', $id)->first();
        $remaining = 0;
        if(!empty($bill_data))
        {
            $remaining = $bill_data->remaining;
            $status =1;
        }
        else
        {
            $status = 2;
        }
        return response()->json(['status' => $status,'remaining' => $remaining,'reference_no' => $bill_data->reference_no]);

    }

    // add maintanance payment
    // add pos order
    public function add_maintenance_payment(Request $request)
    {

         
        $grand_total = $request->input('grand_total');
        $cash_payment = $request->input('cash_payment');
        $cash_back = $request->input('cash_back');
        $payment_method = $request->input('payment_method');
        $reference_no = $request->input('reference_no');
        $bill_id = $request->input('bill_id');
 

        // get customer id
        $repair_detail = Localmaintenance::where('reference_no', $reference_no)->first();
        

        // payment pos

        $maintenance_payment = new MaintenancePayment();
        $maintenance_payment->referemce_no= $reference_no;
        $maintenance_payment->repair_id = $repair_detail->id;
        $maintenance_payment->customer_id=$repair_detail->customer_id;
        $maintenance_payment->paid_amount= $grand_total;
        $maintenance_payment->total = $grand_total;
        $maintenance_payment->remaining_amount = 0;
        $maintenance_payment->account_id = $payment_method;
        $maintenance_payment->account_reference_no = "";
        $maintenance_payment->user_id= 1;
        $maintenance_payment->added_by= 'admin';
        $maintenance_payment->save();

        // get payment method data

        $account_data = Account::where('account_id', $payment_method)->first();

        if(!empty($account_data ))
        {
            $opening_balance = $account_data->opening_balance;
            $new_balance = $opening_balance + $grand_total;
            $account_data->opening_balance = $new_balance;
            $account_data->save();
            if($account_data->account_status!=1)
            {
                // payment expense
                $payment_expense = new MaintenancePaymentExpense();

                $account_tax_fee = $grand_total / 100 * $account_data->commission;
                $payment_expense->total_amount= $grand_total;
                $payment_expense->referemce_no= $reference_no;
                $payment_expense->repair_id = $repair_detail->id;
                $payment_expense->customer_id=$repair_detail->customer_id;
                $payment_expense->account_tax = $account_data->commission;
                $payment_expense->account_tax_fee = $account_tax_fee;
                $payment_expense->account_id = $payment_method;
                $payment_expense->account_reference_no = "";
                $payment_expense->user_id= 1;
                $payment_expense->added_by= 'admin';
                $payment_expense_saved  =$payment_expense->save();
            }
            
        }
        $bill_data = Localmaintenancebill::where('reference_no', $reference_no)->first();
        $bill_data->remaining =0;
        $bill_data->save();
         

    }
    
    //pending order

 public function add_pending_order(Request $request)
    {


        $item_count = $request->input('item_count');
        $customer_id = $request->input('customer_id');
        $grand_total = $request->input('grand_total');
        $discount_type = $request->input('discount_type');
        $discount_by = $request->input('discount_by');
        $total_tax = $request->input('total_tax');
        $total_discount = $request->input('total_discount');
        $product_id = json_decode($request->input('product_id'));
        $item_barcode = json_decode($request->input('item_barcode'));
        $item_tax = json_decode($request->input('item_tax'));
        $item_imei = json_decode($request->input('item_imei'));
        $item_quantity = json_decode($request->input('item_quantity'));
        $item_price = json_decode($request->input('item_price'));
        $item_total = json_decode($request->input('item_total'));
        $item_discount = json_decode($request->input('item_discount'));

        // get customer id
        $customer_data = Customer::where ('customer_number', $customer_id)->first();
        if($customer_data)
        {
            $customer_id = $customer_data->id;
        }

        $pend_order = new PendingOrder();

        $pend_order->customer_id=$customer_id;
        $pend_order->item_count= $item_count;
        $pend_order->total_amount = $grand_total;
        $pend_order->discount_type = $discount_type;
        $pend_order->discount_by = $discount_by;
        $pend_order->total_discount = $total_discount;
        $pend_order->total_tax = $total_tax;
        $pend_order->store_id= 3;
        $pend_order->user_id= 1;
        $pend_order->added_by= 'admin';
        $pend_order->save();

        // pos order detail


        for ($i=0; $i < count($product_id) ; $i++) {
            $pend_order_detail = new PendingOrderDetail();
            if ($discount_type == 1) {
                $discount_amount = $item_discount[$i];
                if (floatval($item_price[$i]) != 0) {
                    $discount_percent = intval($item_discount[$i]) * 100 / floatval($item_price[$i]);
                } else {

                    $discount_percent = 0;
                }
            } else {

                if (floatval($item_total[$i]) != 0 && floatval($item_discount[$i]) != 0) {
                    $discount_amount = $item_total[$i] / 100 * $item_discount[$i];
                    $discount_percent = $item_discount[$i];
                } else {
                    $discount_amount = 0;
                    $discount_percent = 0;
                }
            }


            $pend_order_detail->pend_id = $pend_order->id;
            $pend_order_detail->customer_id=$customer_id;
            $pend_order_detail->product_id= $product_id[$i];
            $pend_order_detail->item_barcode = $item_barcode[$i];
            $pend_order_detail->item_quantity = $item_quantity[$i];
            $pend_order_detail->item_price = $item_price[$i];
            $pend_order_detail->item_total = $item_total[$i];
            $pend_order_detail->item_tax = $item_tax[$i];
            $pend_order_detail->item_imei = $item_imei[$i];
            $pend_order_detail->item_discount_percent = $discount_percent;
            $pend_order_detail->item_discount_price = $discount_amount;
            $pend_order_detail->user_id= 1;
            $pend_order_detail->added_by= 'admin';
            $pend_order_detail_saved= $pend_order_detail->save();


        }

        if ($pend_order_detail_saved) {

            return response()->json(['status' => 1]);
        } else {

            return response()->json(['status' => 2]);
        }


    }

    public function hold_orders(){

        $hold_orders   = PendingOrder::orderBy('id', 'desc')->get();

        $hold_list = '';

        foreach($hold_orders as $key=>$order){
        $customer_name = Customer::where('id', $order->customer_id)->value('customer_name');


        $hold_list .='<div class="default-cover p-4 mb-4">
        <span class="badge bg-info d-inline-block mb-4">Hold - # :  ' . $order->id . '</span>
        <div class="row">
            <div class="col-sm-12 col-md-6 record mb-3">
                <table>
                    <tr class="mb-3">
                        <td>Cashier <span>:  </span></td>

                        <td class="text"> ' . $order->added_by . '</td>
                    </tr>
                    <tr>
                        <td>Customer <span>:  </span></td>

                        <td class="text">' . $customer_name . '</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12 col-md-6 record mb-3">
                <table>
                    <tr>
                        <td>Total <span>:  </span></td>

                        <td class="text"> ' . $order->total_amount . ' <span>OMR</span></td>
                    </tr>
                    <tr>
                        <td>Date <span>:  </span></td>

                        <td class="text"> ' . $order->created_at->format('j M, Y (g:i a)') . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="btn-row d-flex align-items-center justify-content-between">
            <a href="javascript:void(0);" class="btn  btn-info btn-icon  flex-fill" id="btn_hold" data-order-id=" ' . $order->id . '">Open</a>
        </div>
        </div>';
    }


        return response()->json(['hold_list' => $hold_list]);
    }


    public function get_hold_data(Request $request)
    {
        $id = $request->input('order_id');




        $pending_order = PendingOrder::find($id);

if($pending_order->customer_id){


        $customer_name = Customer::where('id', $pending_order->customer_id)->value('customer_name');
        $customer_phone = Customer::where('id', $pending_order->customer_id)->value('customer_phone');
        $customer_id = Customer::where('id', $pending_order->customer_id)->value('customer_number');
        $customer_data = $customer_id . ': ' . $customer_name . ' (' . $customer_phone . ')';
        }
        else{
            $customer_id='';
            $customer_data = '';
        }


        // $all_details= PendingOrderDetail::find($id);
        $all_details = PendingOrderDetail::where('pend_id', $id)->get();


            $order_list = '';


            foreach ($all_details as $key => $detail) {
                $product_id = $detail->product_id;
                $product = Product::find($product_id);
                $product_name = $product ? $product->product_name : 'Unknown';

                if($detail->item_imei!="" && $detail->item_imei!="undefined")
                {
                    $plus_minus='<div class="qty-item text-center">
                                    <input type="text" class="form-control text-center qty-input" name="product_quantity" value="' . $detail->item_quantity . '">
                                </div>';
                }
                else
                {
                    $plus_minus='<div class="qty-item text-center">
                                    <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i class="fas fa-minus-circle"></i></a>
                                    <input type="text" class="form-control text-center qty-input" name="product_quantity" value="' . $detail->item_quantity . '">
                                    <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i class="fas fa-plus-circle"></i></a>
                                </div>';
                }

                $order_list .= '
                    <div class="product-list item_list d-flex align-items-center justify-content-between list_' . $detail->item_barcode . '">
                        <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                            <input type="hidden" value="' . $detail->item_imei . '" class="imei imei_' . $detail->item_imei . '">
                            <input type="hidden" name="stock_ids" value="' . $detail->product_id . '" class="stock_ids product_id_' . $detail->product_id . '">
                            <input type="hidden" name="product_tax" value="' . $detail->item_tax . '" class="tax tax_' . $detail->item_barcode . '">
                            <input type="hidden" name="product_discount" value="0" class="discount discount_' . $detail->item_barcode . '">
                            <input type="hidden" value="' . $detail->product_min_price . '" class="min_price min_price_' . $detail->item_barcode . '">
                            <input type="hidden" value="' . $product_name . '" class="product_name product_name_' . $detail->item_barcode . '">
                            <input type="hidden" value="' . $detail->item_price . '" class="price price_' . $detail->item_barcode . '">

                            <input type="hidden" name="product_barcode" value="' . $detail->item_barcode . '" class="barcode barcode_' . $detail->item_barcode . '">
                            <div class="info">
                                <h6><a href="javascript:void(0);">' . $product_name . '</a></h6>
                                <span>' . $detail->item_barcode . '</span>
                            </div>
                        </div>
                        <div class="">
                            <span name="product_barcode" class=badge bg-warning show_pro_price_' . $detail->item_barcode . '">' . $detail->item_price . '</span>
                        </div>
                        <div class="">
                            <span name="product_total" class="badge bg-warning"><span class="total_price total_price_' . $detail->item_barcode . '">
                        </div>
                        '.$plus_minus.'
                        <div class="d-flex align-items-center action">
                            <a class="btn-icon edit-icon me-2 " href="#" data-bs-toggle="modal" onclick="edit_product(' . $detail->item_barcode . ')" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>
                            <a class="btn-icon delete-icon confirm-text " id="delete-item" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>';
                    $detail->delete();
            }

            if($pending_order){
            $pending_order->delete();
            }
            return response()->json(['order_list' => $order_list, 'customer_data'=>$customer_data,'customer_number' =>$customer_id]);

        }







}
