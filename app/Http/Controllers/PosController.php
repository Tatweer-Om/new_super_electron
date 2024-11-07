<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use Mockery\Undefined;
use App\Models\Account;
use App\Models\Address;
use App\Models\Product;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Ministry;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Repairing;
use App\Models\Workplace;
use App\Models\PosPayment;
use App\Models\University;
use App\Models\Nationality;
use App\Models\Posinvodata;
use App\Models\Settingdata;
use App\Models\PendingOrder;
use App\Models\PointHistory;
use App\Models\Product_imei;
use Illuminate\Http\Request;
use App\Models\PaymentExpense;
use App\Models\PosOrderDetail;
use App\Models\Localmaintenance;
use App\Models\DrawCustomer;
use App\Models\DrawSingle;
use App\Models\Draw;
use App\Models\Localrepairproduct;


use App\Models\MaintenancePayment;

use App\Models\PendingOrderDetail;



use App\Models\Product_qty_history;
use Illuminate\Support\Facades\Log;
use App\Models\Localmaintenancebill;
use App\Models\Localrepairservice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\MaintenancePaymentExpense;

class PosController extends Controller
{
    public function index (){
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();
        $ministries = Ministry::all();
        $nationality = Nationality::all();
        $address = Address::all();
        $orders = PosOrder::latest()->take(10)->get();
        $categories = Category::all();

        $count_products = Product::all()->count();
        $quick_sale = Product::where('quick_sale', 1)->get();

        // account
        $view_account = Account::where('account_type', 1)
                    ->orderByRaw('CASE WHEN account_status = 1 THEN 1 ELSE 0 END') // Sort by account_status = 1 at the end
                    ->get();
        if ($permit_array && in_array('23', $permit_array)) {

            return view ('pos_pages.pos2', compact('user','categories', 'count_products',
         'active_cat', 'universities', 'workplaces' , 'view_account',
         'orders','permit_array', 'quick_sale', 'ministries', 'nationality', 'address'));
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

            $cat_products = Product::where('category_id', $cat_id)
                            ->where('product_type', 1)->get();
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

        $products_data = Product::where('barcode', $barcode)
                            ->where('product_type', 1)->first();
        $products_imei = Product_imei::where('barcode', $barcode)
                            ->where('replace_status', 1)
                            // ->groupBy('imei')  // Ensure distinct rows based on 'imei' column
                            ->get();

        $product_name = $products_data->product_name;
        if(empty($product_name))
        {
            $product_name = $products_data->product_name_ar;
        }

        $data = [
            'product_imei' => $products_imei,
            'stock_image' => $products_data['stock_image'],
            'product_name' => $product_name,
            'sale_price' => $products_data['sale_price'],

        ];
        return response()->json($data);

    }

    public function order_list(Request $request){

        $product_barcode = $request->input('product_barcode');
        $product_quantity = $request->input('quantity');
        $imei = $request->input('imei');
        $product = Product::where('barcode', $product_barcode)
                            ->where('product_type', 1)->first();
        $imei_serial = "";
        if($imei != "undefined" && $imei !="")
        {
            $imeis = Product_imei::where('barcode', $product->barcode)->distinct()->pluck('imei')->toArray();
            if($product->imei_serial_type == 2)
            {
                $imei_serial = trans('messages.serial_no_lang', [], session('locale'));
            }
            else
            {
                $imei_serial = trans('messages.imei_#_lang', [], session('locale'));
            }
        }

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
        // titles
        $title_name = "";
        if(!empty($product->product_name))
        {
            $title_name = $product->product_name;
        }
        $title_name_ar = "";
        if(!empty($product->product_name_ar))
        {
            $title_name_ar = $product->product_name_ar;
        }



        //
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
            'warranty_type' => $warranty_type,
            'title_name' => $title_name,
            'title_name_ar' => $title_name_ar,
            'imei_serial' => $imei_serial

        ]);

    }

    public function product_autocomplete(Request $request) {
        $term = $request->input('term');

        $products = Product::where(function($query) use ($term) {
            $query->where('barcode', 'like', '%' . $term . '%')
                  ->orWhere('product_name', 'like', '%' . $term . '%')
                  ->orWhere('product_name_ar', 'like', '%' . $term . '%');
        })
        ->where('product_type', 1)
        ->get()
        ->toArray();
        $response = [];
        if(!empty($products))
        {
            foreach ($products as $product) {

                $product_name = $product['product_name'];
                if(empty($product_name))
                {
                    $product_name = $product['product_name_ar'];
                }
                $response[] = [
                    'label' => $product_name.'+'.$product['barcode'],
                    'value' => $product['barcode'] . '+' . $product_name,
                    'barcode' => $product['barcode'],
                ];



            }
        }



        return response()->json($response);
    }

    // get product type
    public function get_product_type(Request $request) {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $barcode = $request->input('barcode');
        $products = Product::where('barcode',$barcode)->first();
        $check_imei = 2;
        $barcode_imei = "";
        $imei = "";
        if(!empty($products))
        {
            if($products->check_imei==1)
            {
                $check_imei =1 ;
            }
        }
        else
        {
            $product_imei = Product_imei::where('imei',$barcode)->first();
            if(!empty($product_imei))
            {
                $check_imei =3 ;
                $imei = $product_imei->imei;
                $barcode_imei = $product_imei->barcode;
            }
        }
        return response()->json(['check_imei' => $check_imei,'imei' => $imei,'barcode' => $barcode_imei]);
    }

//customer_part

public function add_customer_repair(Request $request){

    $user_id = Auth::id();
    $data= User::where('id', $user_id)->first();
    $user= $data->username;

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

    if(!empty($nationalId)){
            $existingCustomer = Customer::where('national_id', $nationalId)->first();
            if ($existingCustomer) {
                return response()->json(['customer_id' => '', 'status' => 2]);
                exit();
            }
    }
    $existingCustomer = Customer::where('customer_phone', $request['customer_phone'])->first();
    if ($existingCustomer) {

        return response()->json(['customer_id' => '', 'status' => 3]);
        exit;
    }
    $existingCustomer = Customer::where('customer_number', $request['customer_number'])->first();
    if ($existingCustomer) {

        return response()->json(['customer_id' => '', 'status' => 3]);
        exit;
    }

    $customer->customer_id = genUuid() . time();
    $customer->customer_name = $request['customer_name'];
    $customer->customer_phone = $request['customer_phone'];
    $customer->customer_email = $request['customer_email'];
    $customer->customer_number = $request['customer_number'];
    $customer->dob = $request['dob'];
    $customer->gender = $request['gender'];
    $customer->nationality_id = $request['nationality_id'];
    $customer->address = $request['address_id'];
    $customer->national_id = $request['national_id'];
    $customer->customer_detail = $request['customer_detail'];
    $customer->student_id = $request['student_id'];
    $customer->student_university = $request['student_university'];
    $customer->teacher_university = $request['teacher_university'];
    $customer->employee_id = $request['employee_id'];
    $customer->employee_workplace = $request['employee_workplace'];
    $customer->ministry_id = $request['ministry_id'];
    $customer->customer_type = $request['customer_type'];
    $customer->customer_image = $customer_img_name;
    $customer->added_by = $user;
    $customer->user_id = $user_id;
    $customer->save();
    // customer add sms
    $params = [
        'customer_id' => $customer->id,
        'sms_status' => 1
    ];
    $sms = get_sms($params);
    sms_module($request['customer_phone'], $sms);

    $return_value =$request['customer_number'] . ': ' . $request['customer_name'] . ' (' . $request['customer_phone'] . ')';
    return response()->json(['customer_id' => $return_value, 'status' => 1,'customer_number' => $request['customer_number']]);

}

public function add_address(Request $request){

    $user_id = Auth::id();
    $data= User::where('id', $user_id)->first();
    $user= $data->username;

    $address = new Address();
    $address->area_name = $request['address_name'];
    $address->added_by = $user;
    $address->save();
    // address
    $address_datas = Address::all();
    $address_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
    ';
    foreach ($address_datas as $key => $add) {
        $selected = "";
        if($add->id == $address->id);
        {
            $selected = "selected ='true'";
        }
        $address_data.='<option '.$selected.' value="'.$add->id.'" >'.$add->area_name.'</option>';
    }
    return response()->json(['address_data' => $address_data , 'status' => 1]);

}

//customer autocomplte
    public function customer_autocomplete(Request $request)
    {
        $term = $request->input('term');

        $customers = Customer::where('customer_name', 'like', "%{$term}%")
        ->orWhere('customer_phone', 'like', "%{$term}%")
        ->get(['id', 'customer_name', 'customer_phone','customer_number']);
        $response = [];
        foreach ($customers as $customer) {
            $response[] = [
                'label' => $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
                'value' => $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
                'phone' => $customer->customer_phone,
            ];
        }

        return response()->json($response);
    }

    public function get_customer_data(Request $request)
    {
        $customer_number = $request->input('customer_number');

        $get_draw_name = "";
        $get_draw_price = "";
        $customer_name = "";
        $points = "";
        $total_omr = "";
        $points_from = "";
        $amount_to = "";
        $get_offer_name = "";
        $get_offer_pros = "";
        $offer_discount = "";
        $offer_id = "";
        if(!empty($customer_number))

        {
            $customer = Customer::where('customer_number', $customer_number)->first();
            $customer_name = $customer->customer_name;
            $points = $customer->points;
            $get_draw_data = get_draw_name($customer->id);
            if(!empty($get_draw_data))
            {
                $get_draw_name = $get_draw_data[0];
                $get_draw_price = $get_draw_data[1];
            }

            $get_offer_data= get_offer_name($customer->id);
            $get_offer_name = $get_offer_data[0];
            $get_offer_pros = $get_offer_data[1];
            $offer_discount = $get_offer_data[2];
            $offer_id = $get_offer_data[3];

            // get amount from point
            $points=$customer->points;
            $point_manager=Point::first();
            $total_omr=0;
            $points_from=0;
            $amount_to=0;

            if(!empty($point_manager) && !empty($customer->points))
            {
                $points_from=$point_manager->points;
                $amount_to=$point_manager->omr;
                if($point_manager->points > 0 && $point_manager->omr > 0)
                {
                    $one_point_value=$points/$point_manager->points;
                    $total_omr=$one_point_value*$point_manager->omr ;
                }
                else
                {
                    $one_point_value= $points;
                    $total_omr=$one_point_value;

                }
            }
        }


        $response = [
            'draw_name' => $get_draw_name,
            'get_draw_price' => $get_draw_price,
            'customer_name' => $customer_name,
            'points' => $points,
            'points_amount' => $total_omr,
            'points_from' => $points_from,
            'amount_to' => $amount_to,
            'offer_name' => $get_offer_name,
            'offer_pros' => $get_offer_pros,
            'offer_discount' => $offer_discount,
            'offer_id' => $offer_id,
        ];


        return response()->json($response);
    }

    // add pos order
    public function add_pos_order(Request $request)
    {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

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
        $offer_id = $request->input('offer_id');
        $offer_discount = $request->input('offer_discount');
        $cash_back = $request->input('cash_back');
        $payment_method = json_decode($request->input('payment_method'));
        $product_id = json_decode($request->input('product_id'));
        $item_barcode = json_decode($request->input('item_barcode'));
        $item_tax = json_decode($request->input('item_tax'));
        $item_imei = json_decode($request->input('item_imei'));
        $item_quantity = json_decode($request->input('item_quantity'));
        $item_price = json_decode($request->input('item_price'));
        $item_total = json_decode($request->input('item_total'));
        $item_discount = json_decode($request->input('item_discount'));
        $offer_discount_amount = json_decode($request->input('offer_discount_amount'));
        $offer_discount_percent = json_decode($request->input('offer_discount_percent'));
        $warranty_status=0;
        $not_available=0;
        $order_no="";
        $finish_name="";
        for ($i=0; $i < count($product_id) ; $i++) {
            $pro_data = Product::where('id', $product_id[$i])->first();
            if(!empty($item_imei[$i] && $item_imei[$i]!="undefined"))
            {
                // delete imei
                $pro_imei_data = Product_imei::where('imei', $item_imei[$i])->
                                            where('product_id', $product_id[$i])->first();
                if(empty($pro_imei_data)){
                    $pro_name="";
                    if(!empty($pro_data))
                    {
                        $pro_name = $pro_data->product_name;
                        if(empty($pro_name))
                        {
                            $pro_name = $pro_data->product_name_ar;
                        }
                    }
                    $finish_name.=$pro_name.', ';
                    $not_available++;
                    continue;
                }
            }
            else
            {
                if(!empty($pro_data))
                {
                    if($pro_data->quantity <=0)
                    {
                        $pro_name="";
                        if(!empty($pro_data))
                        {
                            $pro_name = $pro_data->product_name;
                            if(empty($pro_name))
                            {
                                $pro_name = $pro_data->product_name_ar;
                            }
                        }
                        $finish_name.=$pro_name.', ';
                        $not_available++;
                        continue;
                    }
                }
            }
        }


        $earn_points= 0;
        if($not_available<=0)
        {
            // get customer id
            $customer_contact = "";
            $customer_data = Customer::where('customer_number', $customer_id)->first();
            if($customer_data)
            {
                $customer_id = $customer_data->id;
                $customer_contact = $customer_data->customer_phone;
            }

            // order no
            $order_data = PosOrder::where('return_status', '!=', 2)->where('restore_status', 0)
                        ->orderBy('id', 'desc')
                        ->first();
            // $order_data = PosOrder::where('return_status', '!=', 2)->orderBy('id', 'desc')
            // ->first();


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
            $pos_order->paid_amount = $grand_total + abs($cash_back);
            $pos_order->discount_type = $discount_type;
            $pos_order->discount_by = 1;
            $pos_order->total_tax = $total_tax;
            $pos_order->total_discount = $total_discount;
            $pos_order->offer_id = $offer_id;
            $pos_order->offer_discount = $offer_discount;
            $pos_order->cash_back = $cash_back;
            $pos_order->store_id= 3;
            $pos_order->user_id= $user_id;
            $pos_order->added_by= $user;
            $pos_order->save();

            // pos order detail

            $total_profit =0;
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

                // profit
                $pro_data = Product::where('id', $product_id[$i])->first();
                $profit =  ($item_total[$i]- $offer_discount_amount[$i] - $discount_amount) - ($item_quantity[$i]*$pro_data->total_purchase);

                $total_profit = $total_profit + $profit;

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
                $pos_order_detail->item_profit = $profit;
                $pos_order_detail->item_discount_percent = $discount_percent;
                $pos_order_detail->item_discount_price = $discount_amount;
                $pos_order_detail->offer_discount_percent = $offer_discount_percent[$i];
                $pos_order_detail->offer_discount_amount = $offer_discount_amount[$i];
                $pos_order_detail->user_id= $user_id;
                $pos_order_detail->added_by= $user;
                $pos_order_detail_saved= $pos_order_detail->save();

                // minus qty and make history
                $pro_data = Product::where('id', $product_id[$i])->first();
                if(!empty($pro_data))
                {

                    // replace imei data
                    $current_qty = $pro_data->quantity;
                    $damage_qty = $item_quantity[$i];
                    $new_qty = $current_qty - $damage_qty;

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
                    $product_qty_history_save->added_by = $user;
                    $product_qty_history_save->user_id = $user_id;
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
                    $warranty_status++;
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
                        $warranty_data->user_id = $user_id;
                        $warranty_data->save();
                        $status = 1;
                    }
                }


            }

            // payment pos

            // Sort the array based on the value of "cash_data"
            usort($payment_method, function($a, $b) {
                // If "cash_data" is 1, move the element to the end
                if ($a->cash_data == 1 && $b->cash_data != 1) {
                    return 1;
                }
                // If "cash_data" is not 1, keep the current order
                return 0;
            });
            $total_paid_till = 0;
            $total_without_points = 0;
            $total_with_points = 0;
            $remaining_final = $grand_total;
            $all_payment_methods ="";
            $pay_met = 1;
            foreach ($payment_method as $key => $pay) {
                if($pay_met == count ($payment_method))
                {
                    $all_payment_methods.=$pay->checkbox;
                }
                else
                {
                    $all_payment_methods.=$pay->checkbox.',';
                }
                $pay_met++;
                if($pay->cash_data==1)
                {
                    $paid_amount_final = $grand_total - $total_paid_till;
                    $total_without_points = $total_without_points + $paid_amount_final;
                }
                else
                {
                    $paid_amount_final = $pay->input;
                    if($pay->checkbox != 0)
                    {
                        $total_without_points = $total_without_points + $paid_amount_final;
                    }
                    else
                    {
                        $total_with_points =  $paid_amount_final;
                    }
                }
                $remaining_final = $remaining_final - $paid_amount_final;
                $pos_payment = new PosPayment();
                $pos_payment->order_no= $order_no;
                $pos_payment->order_id = $pos_order->id;
                $pos_payment->customer_id=$customer_id;
                $pos_payment->paid_amount= $paid_amount_final;
                $pos_payment->total = $grand_total;
                $pos_payment->remaining_amount = $remaining_final;
                $pos_payment->account_id = $pay->checkbox;
                $pos_payment->account_reference_no = "";
                $pos_payment->user_id= $user_id;
                $pos_payment->added_by= $user;
                $pos_payment_saved= $pos_payment->save();


                // get payment method data

                $account_data = Account::where('id', $pay->checkbox)->first();

                if(!empty($account_data ))
                {
                    $opening_balance = $account_data->opening_balance;
                    $new_balance = $opening_balance + $paid_amount_final;
                    $account_data->opening_balance = $new_balance;
                    $account_data->save();
                    if($account_data->account_status!=1)
                    {
                        if(!empty($account_data->commission) && $account_data->commission > 0)
                        {
                            // payment expense
                            $payment_expense = new PaymentExpense();

                            $account_tax_fee = $paid_amount_final / 100 * $account_data->commission;
                            $payment_expense->total_amount= $paid_amount_final;
                            $payment_expense->order_no= $order_no;
                            $payment_expense->order_id= $pos_order->id;
                            $payment_expense->customer_id=$customer_id;
                            $payment_expense->account_tax = $account_data->commission;
                            $payment_expense->account_tax_fee = $account_tax_fee;
                            $payment_expense->accoun_id = $pay->checkbox;
                            $payment_expense->account_reference_no = "";
                            $payment_expense->user_id= $user_id;
                            $payment_expense->added_by= $user;
                            $payment_expense_saved  =$payment_expense->save();
                        }

                    }
                }






            if($pay->checkbox == 0 && !empty($customer_id))
            {
                    // points system
                $customer_data = Customer::where('id', $customer_id)->first();
                $points = 0;
                if(!empty($customer_data->points))
                {
                    $points=$customer_data->points;
                }
                $point_manager=Point::first();
                $sales_made=0;
                $sales_eq_points=0;
                $points_earned=0;
                $points_eq_amount=0;
                $point_percent =0;
                if(!empty($point_manager))
                {
                    $sales_made =$point_manager['pos_amount'];
                    $sales_eq_points =$point_manager['points_pos'];
                    $points_earned =$point_manager['points'];
                    $points_eq_amount =$point_manager['omr'];
                    $point_percent =$point_manager['point_percent'];
                }
                $sales_amount=$pay->input;
                $s1 = $sales_amount/$sales_made;
                $p1 = $s1*$sales_eq_points;
                $new_points = $points-$p1;
                $customer_data->points= $new_points;
                $customer_data->save();
                // history points
                $point_history = new PointHistory();
                $point_history->order_no= $order_no;
                $point_history->order_id= $pos_order->id;
                $point_history->customer_id=$customer_id;
                $point_history->account_id = $pay->checkbox;
                $point_history->amount = $pay->input;
                $point_history->points = $p1;
                $point_history->type = 2;
                $point_history->point_percent = $point_percent;
                $point_history->user_id= $user_id;
                $point_history->added_by= $user;
                $point_history->save();
                // sms for points
                $params = [
                    'order_no' => $order_no ,
                    'sms_status' => 12,
                    'points' => $p1
                ];
                $sms = get_sms($params);
                sms_module($customer_data->customer_phone, $sms);
            }
            $total_paid_till = $total_paid_till + $pay->input;
        }

        // add point
        $point_percent =0;
        if($total_without_points > 0 && !empty($customer_id))
        {
            // points system
            $customer_data = Customer::where('id', $customer_id)->first();
            $points = 0;
            if(!empty($customer_data->points))
            {
                $points=$customer_data->points;
            }

            $point_manager=Point::first();
            $sales_made=0;
            $sales_eq_points=0;
            $points_earned=0;
            $points_eq_amount=0;
            $point_percent =0;
            if(!empty($point_manager))
            {
                $sales_made =$point_manager['pos_amount'];
                $sales_eq_points =$point_manager['points_pos'];
                $points_earned =$point_manager['points'];
                $points_eq_amount =$point_manager['omr'];
                $point_percent =$point_manager['point_percent'];
            }

            $sales_amount = $total_profit / 100 * $point_percent;
            if($total_with_points > 0)
            {
                $sales_amount = $sales_amount - ($total_with_points / 100 * $point_percent) ;
            }

            // $sales_amount=$pay->input;

            $s1 = 0; // default value
            if ($sales_made > 0) {
                $s1 = $sales_amount / $sales_made;
            }

            $p1 = $s1*$sales_eq_points;
            $earn_points = $p1;
            $new_points = $points+$p1;
            $customer_data->points= $new_points;
            $customer_data->save();
            // history points
            $point_history = new PointHistory();
            $point_history->order_no= $order_no;
            $point_history->order_id= $pos_order->id;
            $point_history->customer_id=$customer_id;
            // $point_history->account_id = $pay->checkbox;
            $point_history->amount = $sales_amount;
            $point_history->points = $p1;
            $point_history->type = 1;
            $point_history->point_percent = $point_percent;
            $point_history->user_id= $user_id;
            $point_history->added_by= $user;
            $point_history->save();


        }

        // udpate order
        $pos_order = PosOrder::where('order_no', $order_no)->first();
        $pos_order->total_profit= $total_profit;
        $pos_order->point_percent=  $point_percent;
        $pos_order->save();
        // add draw if avaiable

        $todayDate = date('Y-m-d');
        $draw_data = Draw::where('status', 1)->first();
        if(!empty($customer_id))
        {
            if(!empty($draw_data))
            {
                $closestDraw = DrawSingle::where('draw_id', $draw_data->id) // Specify the draw ID
                                   ->where('status', 1) // Filter by status
                                //    ->whereDate('draw_date', '>=', $todayDate) // Filter by draw date greater than or equal to today
                                   ->orderBy('draw_date', 'asc') // Order by draw date ascending
                                   ->first(); // Get the first result
                if(!empty($closestDraw))
                {
                    $total_draw = $grand_total / $draw_data->amount;
                    $final_draw_total = intval($total_draw);
                    if($final_draw_total > 0)
                    {
                        $collect_luckydraw = "";
                        for ($i=0; $i < $final_draw_total ; $i++) {
                            $draw_customer_data = DrawCustomer::where('draw_id', $draw_data->id)
                                       ->where('draw_single_id', $closestDraw->id)
                                       ->orderBy('id', 'desc') // Order by draw date ascending
                                       ->first(); // Get the first result
                            if(!empty($draw_customer_data))
                            {
                                $luckydraw_no = $draw_customer_data->luckydraw_no + 1;
                            }
                            else
                            {
                                $luckydraw_no = 1;
                            }
                            // collect luckydraw_no
                            $luckydraw_coupons = '0000000'.$luckydraw_no;
                            if(strlen($luckydraw_coupons)!=8)
                            {
                                $len = (strlen($luckydraw_coupons)-8);
                                $luckydraw_coupons = substr($luckydraw_coupons,$len);
                            }
                            $collect_luckydraw .=$luckydraw_coupons.", ";

                            //
                            $draw_customer = new DrawCustomer;
                            $draw_customer->order_no= $order_no;
                            $draw_customer->order_id= $pos_order->id;
                            $draw_customer->customer_id= $customer_id;
                            $draw_customer->draw_id= $draw_data->id;
                            $draw_customer->luckydraw_no= $luckydraw_no;
                            $draw_customer->draw_single_id=$closestDraw->id;
                            $draw_customer->draw_date = $closestDraw->draw_date;
                            $draw_customer->gift = $closestDraw->gift;
                            $draw_customer->user_id= $user_id;
                            $draw_customer->added_by= $user;
                            $draw_customer->save();
                        }
                        // draw sms
                        if(!empty($collect_luckydraw))
                        {
                            $params_coupons = [
                                'order_no' => $order_no,
                                'collect_luckydraw' => $collect_luckydraw,
                                'draw_name' => $draw_data->draw_name,
                                'draw_date' => $closestDraw->draw_date,
                                'gift' => $closestDraw->gift,
                                'sms_status' => 13,
                            ];
                        }


                    }

                }
            }
        }
        //

        // udpate order
        $pos_order = PosOrder::where('order_no', $order_no)->first();
        $pos_order->account_id= $all_payment_methods;
        $pos_order->save();

            // customer add sms
            if(!empty($customer_id))
            {
                if($warranty_status>0)
                {
                    $params = [
                        'order_no' => $order_no ,
                        'sms_status' => 3,
                        'points' => $earn_points,
                    ];
                    $sms = get_sms($params);
                    sms_module($customer_contact, $sms);
                }

                else
                {
                    $params = [
                        'order_no' => $order_no ,
                        'sms_status' => 2,
                        'points' => $earn_points,
                    ];
                    $sms = get_sms($params);
                    sms_module($customer_contact, $sms);
                }
                if(!empty($collect_luckydraw))
                {
                    $sms = get_sms($params_coupons);
                    sms_module($customer_contact, $sms);
                }
            }

        }
        //
        return response()->json(['order_no' => $order_no,'not_available'=>$not_available,'finish_name'=>$finish_name]);

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

    // restore item
    public function get_restore_items(Request $request) {
        $order_no = $request->input('order_no');
        $order_nos = "";
        $restore_type = $request->input('restore_type');
        $restore_data = "";
        if($restore_type == 1)
        {
            $customer_data = Customer::where('customer_phone', $order_no);
            if ($customer_data->count() > 0)
            {
                $cus_data= $customer_data->first();
                $order_data = PosOrder::where('customer_id', $cus_data->id)
                                        ->where('restore_status', 0)->get();

                if ($order_data->count() > 0)
                {
                    foreach ($order_data as $key => $value) {
                        $payment_data = PosPayment::where('order_no', $value->order_no)->get();

                        $account_name = '';
                        foreach ($payment_data as $key => $pay) {
                            if($pay->account_id == 0)
                            {
                                $account_name .= trans('messages.points_lang', [], session('locale')).', ';
                            }
                            else
                            {
                                $acc = Account::where('id', $pay->account_id)->first();
                                if($acc)
                                {
                                    $account_name .= $acc->account_name.', ';
                                }
                            }
                        }
                        $restore_data = "<table class='table' style='width:100%'>
                                            <thead>
                                                <tr>
                                                    <td>".trans('messages.order_no_lang', [], session('locale'))."</td>
                                                    <td>".trans('messages.grand_total_lang', [], session('locale'))."</td>
                                                    <td>".trans('messages.payment_method_lang', [], session('locale'))."</td>
                                                    <td>".trans('messages.created_by_lang', [], session('locale'))."</td>
                                                    <td>".trans('messages.created_at_lang', [], session('locale'))."</td>
                                                </tr>
                                            </thead>";
                        $restore_data.= '<tbody>
                                                <tr onclick=get_order_items("'.$value->order_no.'")>
                                                    <td>'.$value->order_no.'</td>
                                                    <td>'.$value->total_amount.'</td>
                                                    <td>'.$account_name.'</td>
                                                    <td>'.$value->created_at.'</td>
                                                    <td>'.$value->added_by.'</td>
                                                </tr>
                                            </tbody>
                                        </table>';
                    }


                    $status = 1;
                }
                else
                {
                    $status =2;
                }
            }
            else
            {
                $status =2;
            }
        }
        else if($restore_type == 2)
        {
            $item_status=1;
            $order_detail = PosOrderDetail::where('order_no', $order_no)
                            ->where('restore_status', 0)->get();

            if ($order_detail->count() > 0)
            {
                $restore_data = "<table class='table' style='width:100%'>
                                        <thead>
                                            <tr>
                                                <td><input type='checkbox' class='all_restore_item'> ".trans('messages.product_name_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.imei_no_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.price_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.quantity_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.discount_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.total_price_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.return_qty_lang', [], session('locale'))."</td>
                                            </tr>
                                        </thead>
                                        <tbody>";
                foreach ($order_detail as $key => $value) {
                    $pro_data = Product::where('id', $value->product_id)->first();

                    $pro_name =$pro_data->product_name;
                    if(empty($pro_name))
                    {
                        $pro_name =$pro_data->product_name_ar;
                    }
                    $readonly="";
                    if(!empty($value->item_imei))
                    {
                        $readonly="readonly='true'";
                    }
                    $totalQuantity = PosOrderDetail::where('order_no2', $order_no)
                                            ->where('restore_status', 1)
                                            ->where('item_barcode', $value->item_barcode)
                                            ->sum('item_quantity');

                    $total_qty =$totalQuantity+$value->item_quantity;
                    if($total_qty>0)
                    {
                        $discount_s =0;
                        if($value->item_discount_price>0)
                        {
                            $discount_s = $value->item_discount_price;
                        }
                        $restore_data.= '
                                        <tr>
                                            <td><input type="checkbox" class="restore_item" value="'.$value->id.'"> '.$pro_name.'('.$value->item_barcode.')'.'</td>
                                            <td>'.$value->item_imei.'</td>
                                            <td>'.$value->item_price.'</td>
                                            <td class="real_qty">'.$total_qty.'</td>
                                            <td>'.$discount_s.'</td>
                                            <td>'.$value->item_total-$discount_s.'</td>
                                            <td><input type="text" class="form-control return_qty" style="width:50px" '.$readonly.' value="'.$total_qty.'"></td>
                                        </tr>';
                                        $item_status=2;
                    }
                }
                if($item_status==1)
                {
                    $restore_data.= '<tr>
                                        <td colspan="7" class="text-center">'.trans('messages.item_not_found_lang', [], session('locale')).'</td>
                                        </tr>';
                }
                else{
                    $restore_data.='</tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td>
                                            <a href="javascript:void(0);" id="restore_item_btn" class="btn btn-success">
                                              '.trans('messages.submit_lang', [], session('locale')).'
                                            </a>
                                        </td>

                                    </tr>;
                                </tfoot>
                            </table>';
                }
                $status = 1;
                $order_nos = $order_no;
            }
            else
            {
                $status =2;
            }
        }
        else if($restore_type == 3)
        {
            $item_status=1;
            $order_detail = PosOrderDetail::where('item_imei', $order_no)->where('restore_status', 0)->get();

            if ($order_detail->count() > 0)
            {
                $restore_data = "<table class='table' style='width:100%'>
                                        <thead>
                                            <tr>
                                                <td><input type='checkbox' class='all_restore_item'> ".trans('messages.product_name_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.imei_no_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.price_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.quantity_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.total_price_lang', [], session('locale'))."</td>
                                                <td>".trans('messages.return_qty_lang', [], session('locale'))."</td>
                                            </tr>
                                        </thead>
                                        <tbody>";
                foreach ($order_detail as $key => $value) {
                    $order_nos = $value->order_no;
                    $pro_data = Product::where('id', $value->product_id)->first();

                    $pro_name =$pro_data->product_name;
                    if(empty($pro_name))
                    {
                        $pro_name =$pro_data->product_name_ar;
                    }
                    $readonly="";
                    if(!empty($value->item_imei))
                    {
                        $readonly="readonly='true'";
                    }
                    $totalQuantity = PosOrderDetail::where('order_no2', $order_nos)
                                            ->where('restore_status', 1)
                                            ->where('item_barcode', $value->item_barcode)
                                            ->sum('item_quantity');
                    $total_qty =$totalQuantity+$value->item_quantity;
                    if($total_qty>0)
                    {
                        $restore_data.= '
                                        <tr>
                                            <td><input type="checkbox" class="restore_item" value="'.$value->id.'"> '.$pro_name.'('.$value->item_barcode.')'.'</td>
                                            <td>'.$value->item_imei.'</td>
                                            <td>'.$value->item_price.'</td>
                                            <td class="real_qty">'.$total_qty.'</td>
                                            <td>'.$value->item_total.'</td>
                                            <td><input type="text" class="form-control return_qty" style="width:50px" '.$readonly.' value="'.$total_qty.'"></td>
                                        </tr>';
                        $item_status=2;
                    }
                }
                if($item_status==1)
                {
                    $restore_data.= '<tr>
                                        <td colspan="6" class="text-center">'.trans('messages.item_not_found_lang', [], session('locale')).'</td>
                                        </tr>';
                }
                else{
                    $restore_data.='</tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td>
                                            <a href="javascript:void(0);" id="restore_item_btn" class="btn btn-success">
                                              '.trans('messages.submit_lang', [], session('locale')).'
                                            </a>
                                        </td>

                                    </tr>;
                                </tfoot>
                            </table>';
                }

                $status = 1;
            }
            else
            {
                $status =2;
            }
        }

        return response()->json(['status' => $status,'restore_data' => $restore_data,'order_no'=>$order_nos]);

    }

    // add restore item
    // add pos order
    public function add_restore_item(Request $request)
    {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $order_no = $request->input('order_no');
        $restoreItems = $request->input('restore_item');
        $restoreReturnQtys = $request->input('restore_return_qty');
        $order_data = PosOrder::where('order_no', $order_no)->first();
        // pos order detail

        $new_bill="";
        for ($i=1; $i <100 ; $i++) {
            $order_data_count = PosOrder::where('order_no', $order_no.'-RESTORE'.$i)->count();
            if($order_data_count<=0)
            {
                $new_bill=$order_no.'-RESTORE'.$i;
                break;
            }
        }
        $total_profit =0;
        $grand_total = 0;
        $total_tax = 0;
        $total_discount =0;
        for ($i=0; $i < count($restoreItems) ; $i++) {

            $pos_order_detail = new PosOrderDetail;

            $pos_detail_data = PosOrderDetail::where('id', $restoreItems[$i])->first();

            $item_total = $pos_detail_data->item_price * $restoreReturnQtys[$i];

            $discount_amount=$pos_detail_data->item_discount_price/$pos_detail_data->item_quantity;
            if (floatval($item_total) > 0) {
                $discount_percent = intval($discount_amount) * 100 / floatval($pos_detail_data->item_price);
            } else {

                $discount_percent = 0;
            }
            // profit
            $pro_data = Product::where('id', $pos_detail_data->product_id)->first();
            $offer_discount_amount = $pos_detail_data->offer_discount_percent /100 * floatval($pos_detail_data->item_price);
            $profit =  ($item_total- $offer_discount_amount - $discount_amount) - ($restoreReturnQtys[$i]*$pro_data->total_purchase);
            $total_discount+=  $offer_discount_amount + $discount_amount;
            $total_profit = $total_profit + $profit;
            if($pro_data->tax > 0)
            {
                $total_tax+= $item_total /100 * $pro_data->tax;
            }

            $grand_total+= $item_total - $offer_discount_amount - $discount_amount;
            $pos_order_detail->order_no= $new_bill;
            $pos_order_detail->order_no2= $order_no;
            $pos_order_detail->order_id= $order_no;
            $pos_order_detail->customer_id=$order_data->customer_id;
            $pos_order_detail->product_id= $pos_detail_data->product_id;
            $pos_order_detail->item_barcode = $pos_detail_data->item_barcode;
            $pos_order_detail->item_quantity = '-'.$restoreReturnQtys[$i];
            $pos_order_detail->item_price = $pos_detail_data->item_price;
            $pos_order_detail->item_total = '-'.$item_total;
            $pos_order_detail->item_tax = $pos_detail_data->item_tax;
            $pos_order_detail->item_imei = $pos_detail_data->item_imei;
            $pos_order_detail->item_profit = '-'.$profit;
            $pos_order_detail->item_discount_percent = $discount_percent;
            $pos_order_detail->item_discount_price = '-'.$discount_amount;
            $pos_order_detail->offer_discount_percent = $pos_detail_data->offer_discount_percent;
            $pos_order_detail->offer_discount_amount = '-'.$offer_discount_amount;
            $pos_order_detail->restore_status= 1;
            $pos_order_detail->user_id= $user_id;
            $pos_order_detail->added_by= $user;
            $pos_order_detail_saved= $pos_order_detail->save();

            // minus qty and make history
            $pro_data = Product::where('id', $pos_detail_data->product_id)->first();
            if(!empty($pro_data))
            {

                // replace imei data
                $current_qty = $pro_data->quantity;
                $damage_qty = $restoreReturnQtys[$i];
                $new_qty = $current_qty + $damage_qty;

                // product qty history
                $product_qty_history_save = new Product_qty_history();

                $product_qty_history_save->order_no =$new_bill;
                $product_qty_history_save->product_id = $pos_detail_data->product_id;
                $product_qty_history_save->barcode= $pro_data->barcode;
                $product_qty_history_save->imei= $pos_detail_data->item_imei;
                $product_qty_history_save->source= 'restore sale';
                $product_qty_history_save->type= 1;
                $product_qty_history_save->previous_qty= $current_qty;
                $product_qty_history_save->given_qty= $damage_qty;
                $product_qty_history_save->new_qty= $new_qty;
                $product_qty_history_save->added_by = $user;
                $product_qty_history_save->user_id = $user_id;
                $product_qty_history_save->save();

                // update qty
                $pro_data->quantity=$new_qty;
                $pro_data->save();

                // delete imei
                if(!empty($pos_detail_data->item_imei && $pos_detail_data->item_imei!="undefined"))
                {

                    //add imei
                    $pro_imei_data_save = new Product_imei();


                    $pro_imei_data_save->product_id = $pos_detail_data->product_id;
                    $pro_imei_data_save->barcode= $pos_detail_data->item_barcode;
                    $pro_imei_data_save->imei= $pos_detail_data->item_imei;
                    $pro_imei_data_save->added_by = $user;
                    $pro_imei_data_save->user_id = $user_id;
                    $pro_imei_data_save->save();

                }
            }

            // warranty work
            $warranty_data = Warranty::where('order_no', $order_no)
                              ->where('product_id', $pos_detail_data->product_id)
                              ->where('item_imei', $pos_detail_data->item_imei)
                              ->delete();


        }
        // get custom,er data


        $item_count = count($request->input('restore_item'));
        $customer_id = $order_data->customer_id;
        $grand_total = '-'.$grand_total;
        $discount_type = $order_data->discount_type;
        $discount_by = $order_data->discount_by;
        $total_tax = '-'.$total_tax;
        $total_discount = '-'.$total_discount;
        $offer_id = $order_data->offer_id;
        $offer_discount = $order_data->offer_discount;
        $cash_back = $grand_total;
        $jsonString = '[{"checkbox":"3","input":"3","cash_data":1}]';
        $payment_method = json_decode($jsonString);



        $earn_points= 0;
        $not_available= 0;
        $finish_name= "";
        // if($not_available<=0)
        // {
            // get customer id
            $customer_contact = "";
            $customer_data = Customer::where('customer_number', $customer_id)->first();
            if($customer_data)
            {
                $customer_id = $customer_data->id;
                $customer_contact = $customer_data->customer_phone;
            }

            // pos order
            $pos_order = new PosOrder;


            $pos_order->order_type= 1;
            $pos_order->order_no= $new_bill;
            $pos_order->order_no2= $order_no;
            $pos_order->item_count= $item_count;
            $pos_order->customer_id=$customer_id;
            $pos_order->total_amount = $grand_total;
            $pos_order->paid_amount = $grand_total;
            $pos_order->discount_type = $discount_type;
            $pos_order->discount_by = 1;
            $pos_order->total_tax = $total_tax;
            $pos_order->total_discount = $total_discount;
            $pos_order->offer_id = $offer_id;
            $pos_order->offer_discount = $offer_discount;
            $pos_order->cash_back = $cash_back;
            $pos_order->store_id= 3;
            $pos_order->restore_status= 1;
            $pos_order->user_id= $user_id;
            $pos_order->added_by= $user;
            $pos_order->save();
            $pos_order_id = $pos_order->id;


            // payment pos

            // Sort the array based on the value of "cash_data"
            usort($payment_method, function($a, $b) {
                // If "cash_data" is 1, move the element to the end
                if ($a->cash_data == 1 && $b->cash_data != 1) {
                    return 1;
                }
                // If "cash_data" is not 1, keep the current order
                return 0;
            });
            $total_paid_till = 0;
            $total_without_points = 0;
            $total_with_points = 0;
            $remaining_final = abs($grand_total);
            $all_payment_methods ="";
            $pay_met = 1;
            foreach ($payment_method as $key => $pay) {
                if($pay_met == count ($payment_method))
                {
                    $all_payment_methods.=$pay->checkbox;
                }
                else
                {
                    $all_payment_methods.=$pay->checkbox.',';
                }
                $pay_met++;
                if($pay->cash_data==1)
                {
                    $paid_amount_final = abs($grand_total) - $total_paid_till;
                    $total_without_points = $total_without_points + $paid_amount_final;
                }
                else
                {
                    $paid_amount_final = $pay->input;
                    if($pay->checkbox != 0)
                    {
                        $total_without_points = $total_without_points + $paid_amount_final;
                    }
                    else
                    {
                        $total_with_points =  $paid_amount_final;
                    }
                }
                $remaining_final = $remaining_final - $paid_amount_final;
                $pos_payment = new PosPayment();
                $pos_payment->order_no= $new_bill;
                $pos_payment->order_no2= $order_no;
                $pos_payment->order_id = $pos_order->id;
                $pos_payment->customer_id=$customer_id;
                $pos_payment->paid_amount= '-'.$paid_amount_final;
                $pos_payment->total = $grand_total;
                $pos_payment->remaining_amount = $remaining_final;
                $pos_payment->account_id = $pay->checkbox;
                $pos_payment->account_reference_no = "";
                $pos_payment->user_id= $user_id;
                $pos_payment->added_by= $user;
                $pos_payment_saved= $pos_payment->save();


                // get payment method data

                $account_data = Account::where('id', $pay->checkbox)->first();

                if(!empty($account_data ))
                {
                    $opening_balance = $account_data->opening_balance;
                    $new_balance = $opening_balance - $paid_amount_final;
                    $account_data->opening_balance = $new_balance;
                    $account_data->save();
                    if($account_data->account_status!=1)
                    {
                        if(!empty($account_data->commission) && $account_data->commission > 0)
                        {
                            // payment expense
                            $payment_expense = new PaymentExpense();

                            $account_tax_fee = $paid_amount_final / 100 * $account_data->commission;
                            $payment_expense->total_amount= '-'.$paid_amount_final;
                            $payment_expense->order_no= $new_bill;
                            $payment_expense->order_no2= $order_no;
                            $payment_expense->order_id= $pos_order->id;
                            $payment_expense->customer_id=$customer_id;
                            $payment_expense->account_tax = $account_data->commission;
                            $payment_expense->account_tax_fee = '-'.$account_tax_fee;
                            $payment_expense->accoun_id = $pay->checkbox;
                            $payment_expense->account_reference_no = "";
                            $payment_expense->user_id= $user_id;
                            $payment_expense->added_by= $user;
                            $payment_expense_saved  =$payment_expense->save();
                        }

                    }
                }







            $total_paid_till = $total_paid_till + $pay->input;
        }


        // udpate order
        $pos_order = PosOrder::where('order_no', $new_bill)->first();
        $pos_order->total_profit= '-'.$total_profit;
        // $pos_order->point_percent=  $point_percent;
        $pos_order->account_id=  $all_payment_methods;
        $pos_order->save();

        // udpate order
        PosOrderDetail::where('order_no', $new_bill)
            ->update(['order_id' => $pos_order->id]);
        // add draw if avaiable



        return response()->json(['order_no' => $order_no,'not_available'=>$not_available,'finish_name'=>$finish_name,'new_bill'=>$new_bill]);


    }


    // process replaced
    public function add_replace_item(Request $request) {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
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
            $product_qty_history_save->added_by = $user;
            $product_qty_history_save->user_id = $user_id;
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
            $product_imei->added_by = $user;
            $product_imei->user_id = $user_id;
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
            $product_qty_history_save->added_by = $user;
            $product_qty_history_save->user_id = $user_id;
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
                                        <td>'.$repair_data->imei_no.'</td>
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
        $local_maintenance_data = Localmaintenance::where('reference_no', $bill_data['reference_no'])->first();
        $remaining = 0;
        $discount = 0;
        $customer_name = "";
        $points = 0;
        $total_omr =0;
        if(!empty($bill_data))
        {
            $remaining = $bill_data->remaining;
            $discount = $local_maintenance_data->total_discount;
            $status =1;
            if(!empty($local_maintenance_data['customer_id']))
            {
                $customer_data = Customer::where('id', $local_maintenance_data['customer_id'])->first();
                if(!empty($customer_data))
                {
                    $customer_name = $customer_data['customer_name'];
                    $points = $customer_data['points'];

                    $point_manager=Point::first();
                    $total_omr=0;
                    $points_from=0;
                    $amount_to=0;

                    if(!empty($point_manager) && !empty($points))
                    {
                        $points_from=$point_manager->points;
                        $amount_to=$point_manager->omr;
                        if($point_manager->points > 0 && $point_manager->omr > 0)
                        {
                            $one_point_value=$points/$point_manager->points;
                            $total_omr=$one_point_value*$point_manager->omr ;
                        }
                        else
                        {
                            $one_point_value= $points;
                            $total_omr=$one_point_value;

                        }
                    }
                }
            }
        }
        else
        {
            $status = 2;
        }

        return response()->json(['status' => $status,'remaining' => $remaining,'reference_no' => $bill_data->reference_no,'discount'=>$discount,'customer_name'=>$customer_name,'points'=>$points,'points_amount'=>$total_omr]);

    }

    // add maintanance payment
    // add pos order
    public function add_maintenance_payment(Request $request)
    {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $grand_total = $request->input('grand_total');
        $cash_payment = $request->input('cash_payment');
        $cash_back = $request->input('cash_back');
        $payment_method = $request->input('payment_method');
        $reference_no = $request->input('reference_no');
        $bill_id = $request->input('bill_id');
        $payment_method = json_decode($request->input('payment_method'));


        // get customer id
        $repair_detail = Localmaintenance::where('reference_no', $reference_no)->first();
        $discount=0;
        if(!empty($repair_detail->total_discount))
        {
            $discount =$repair_detail->total_discount;
        }

        // get_profit
        // get total cost and profit
        $totalCost = Localrepairproduct::where('reference_no', $reference_no)->sum('cost');
        $productIds = Localrepairproduct::where('reference_no', $reference_no)->pluck('product_id');
        // Step 2: Sum the total_purchase column for these product IDs
        $totalPurchase = Product::whereIn('id', $productIds)->sum('total_purchase');
        $totalserviceprofit = Localrepairservice::where('reference_no', $reference_no)->sum('cost');

        $total_profit = ($totalCost - $totalPurchase)+$totalserviceprofit-$discount;


        // payment pos

            // Sort the array based on the value of "cash_data"
            usort($payment_method, function($a, $b) {
                // If "cash_data" is 1, move the element to the end
                if ($a->cash_data == 1 && $b->cash_data != 1) {
                    return 1;
                }
                // If "cash_data" is not 1, keep the current order
                return 0;
            });
            $payment_method = array_filter($payment_method, function($item) {
                return isset($item->input) && $item->input !== '' && $item->input >= 0;
            });
                    // Extract the checkbox values
            $checkboxValues = array_map(function($item) {
            return $item->checkbox;
            }, $payment_method);

            // Convert to comma-separated string
            $all_methods = implode(',', $checkboxValues);
            $total_paid_till = 0;
            $total_without_points = 0;
            $total_with_points = 0;
            $remaining_final = $grand_total;
            $all_payment_methods ="";
            $pay_met = 1;
            foreach ($payment_method as $key => $pay) {
                if($pay_met == count ($payment_method))
                {
                    $all_payment_methods.=$pay->checkbox;
                }
                else
                {
                    $all_payment_methods.=$pay->checkbox.',';
                }
                $pay_met++;
                if($pay->cash_data==1)
                {
                    $paid_amount_final = $grand_total - $total_paid_till;
                    $total_without_points = $total_without_points + $paid_amount_final;
                }
                else
                {
                    $paid_amount_final = $pay->input;
                    if($pay->checkbox != 0)
                    {
                        $total_without_points = $total_without_points + $paid_amount_final;
                    }
                    else
                    {
                        $total_with_points =  $paid_amount_final;
                    }
                }
                $remaining_final = $remaining_final - $paid_amount_final;
                $maintenance_payment = new MaintenancePayment();
                $maintenance_payment->referemce_no= $reference_no;
                $maintenance_payment->repair_id = $repair_detail->id;
                $maintenance_payment->customer_id=$repair_detail->customer_id;
                $maintenance_payment->paid_amount= $paid_amount_final;
                $maintenance_payment->total = $grand_total;
                $maintenance_payment->remaining_amount = $remaining_final;
                $maintenance_payment->account_id = $pay->checkbox;
                $maintenance_payment->account_reference_no = "";
                $maintenance_payment->user_id= $user_id;
                $maintenance_payment->added_by= $user;
                $maintenance_payment->save();


                // get payment method data

                $account_data = Account::where('id', $pay->checkbox)->first();

                if(!empty($account_data ))
                {
                    $opening_balance = $account_data->opening_balance;
                    $new_balance = $opening_balance + $paid_amount_final;
                    $account_data->opening_balance = $new_balance;
                    $account_data->save();
                    if($account_data->account_status!=1)
                    {
                        if(!empty($account_data->commission) && $account_data->commission > 0)
                        {
                            // payment expense
                            $payment_expense = new MaintenancePaymentExpense();

                            $account_tax_fee = $grand_total / 100 * $account_data->commission;
                            $payment_expense->total_amount= $paid_amount_final;
                            $payment_expense->referemce_no= $reference_no;
                            $payment_expense->repair_id = $repair_detail->id;
                            $payment_expense->customer_id=$repair_detail->customer_id;
                            $payment_expense->account_tax = $account_data->commission;
                            $payment_expense->account_tax_fee = $account_tax_fee;
                            $payment_expense->accoun_id = $pay->checkbox;
                            $payment_expense->account_reference_no = "";
                            $payment_expense->user_id= $user_id;
                            $payment_expense->added_by= $user;
                            $payment_expense_saved  =$payment_expense->save();

                        }

                    }
                }






            if($pay->checkbox == 0 && !empty($repair_detail->customer_id))
            {
                    // points system
                $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
                $points = 0;
                if(!empty($customer_data->points))
                {
                    $points=$customer_data->points;
                }
                $point_manager=Point::first();
                $sales_made=0;
                $sales_eq_points=0;
                $points_earned=0;
                $points_eq_amount=0;
                $point_percent =0;
                if(!empty($point_manager))
                {
                    $sales_made =$point_manager['pos_amount'];
                    $sales_eq_points =$point_manager['points_pos'];
                    $points_earned =$point_manager['points'];
                    $points_eq_amount =$point_manager['omr'];
                    $point_percent =$point_manager['point_percent'];
                }
                $sales_amount=$pay->input;
                $s1 = $sales_amount/$sales_made;
                $p1 = $s1*$sales_eq_points;
                $new_points = $points-$p1;
                $customer_data->points= $new_points;
                $customer_data->save();
                // history points
                $point_history = new PointHistory();
                $point_history->order_no= $reference_no;
                $point_history->order_id= $repair_detail->id;
                $point_history->customer_id=$repair_detail->customer_id;
                $point_history->account_id = $pay->checkbox;
                $point_history->amount = $pay->input;
                $point_history->points = $p1;
                $point_history->type = 2;
                $point_history->point_percent = $point_percent;
                $point_history->user_id= $user_id;
                $point_history->added_by= $user;
                $point_history->save();
                // sms for points
                // $params = [
                //     'order_no' => $order_no ,
                //     'sms_status' => 12,
                //     'points' => $p1
                // ];
                // $sms = get_sms($params);
                // sms_module($customer_data->customer_phone, $sms);
            }


            $total_paid_till = $total_paid_till + $pay->input;
        }

        // add point
        $point_percent =0;
        if($total_without_points > 0 && !empty($repair_detail->customer_id))
        {
            // points system
            $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
            $points = 0;
            if(!empty($customer_data->points))
            {
                $points=$customer_data->points;
            }

            $point_manager=Point::first();
            $sales_made=0;
            $sales_eq_points=0;
            $points_earned=0;
            $points_eq_amount=0;
            $point_percent =0;
            if(!empty($point_manager))
            {
                $sales_made =$point_manager['pos_amount'];
                $sales_eq_points =$point_manager['points_pos'];
                $points_earned =$point_manager['points'];
                $points_eq_amount =$point_manager['omr'];
                $point_percent =$point_manager['point_percent'];
            }

            $sales_amount = $total_profit / 100 * $point_percent;
            if($total_with_points > 0)
            {
                $sales_amount = $sales_amount - ($total_with_points / 100 * $point_percent) ;
            }

            // $sales_amount=$pay->input;

            $s1 = 0; // default value
            if ($sales_made > 0) {
                $s1 = $sales_amount / $sales_made;
            }

            $p1 = $s1*$sales_eq_points;
            $earn_points = $p1;
            $new_points = $points+$p1;
            $customer_data->points= $new_points;
            $customer_data->save();
            // history points

            $point_history = new PointHistory();
            $point_history->order_no= $reference_no;
            $point_history->order_id= $repair_detail->id;
            $point_history->customer_id=$repair_detail->customer_id;
            // $point_history->account_id = $pay->checkbox;
            $point_history->amount = $sales_amount;
            $point_history->points = $p1;
            $point_history->type = 1;
            $point_history->point_percent = $point_percent;
            $point_history->user_id= $user_id;
            $point_history->added_by= $user;
            $point_history->save();


        }


        $bill_data = Localmaintenancebill::where('reference_no', $reference_no)->first();
        $bill_data->remaining =0;
        $bill_data->save();

        // sms for payment
        if($repair_detail->warranty_day > 0 && !empty($repair_detail->warranty_day))
        {
            $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
            // $params = [
            //     'local_main_id' => $repair_detail->id ,
            //     'sms_status' => 7,
            //     'points' => $earn_points,
            // ];
            // $sms = get_sms($params);
            // sms_module($customer_data->customer_phone, $sms);
        }
        else
        {
            $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
            // $params = [
            //     'local_main_id' => $repair_detail->id ,
            //     'sms_status' => 6,
            //     'points' => $earn_points,
            // ];
            // $sms = get_sms($params);
            // sms_module($customer_data->customer_phone, $sms);
        }


    }

    //pending order

 public function add_pending_order(Request $request)
    {

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

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
        $pend_order->user_id= $user_id;
        $pend_order->added_by= $user;
        $pend_order->save();
        $pend_order_id = $pend_order->id;

        // pos order detail

        $final_discount = 0;
        $final_total = 0;
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

            // final discount
            $final_discount = $final_discount + $discount_amount;
            $final_total = $final_total + $item_total[$i];

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
            $pend_order_detail->user_id= $user_id;
            $pend_order_detail->added_by= $user;
            $pend_order_detail_saved= $pend_order_detail->save();


        }

        // update final dsicount
        $pend_order_data = PendingOrder::where ('id', $pend_order_id)->first();
        $pend_order_data->total_discount= $final_discount;
        $pend_order_data->total_amount= $final_total - $final_discount;
        $pend_order_data->save();

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
                        <td>'.trans('messages.cashier_lang', [], session('locale')).' <span>:  </span></td>

                        <td class="text"> ' . $order->added_by . '</td>
                    </tr>
                    <tr>
                        <td>'.trans('messages.customer_name_lang', [], session('locale')).'<span>:  </span></td>

                        <td class="text">' . $customer_name . '</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12 col-md-6 record mb-3">
                <table>
                    <tr>
                        <td>'.trans('messages.grand_total_pos_lang', [], session('locale')).' <span>:  </span></td>

                        <td class="text"> ' . $order->total_amount . ' <span></span></td>
                    </tr>
                    <tr>
                        <td>'.trans('messages.add_date_lang', [], session('locale')).' <span>:  </span></td>

                        <td class="text"> ' . $order->created_at->format('j M, Y (g:i a)') . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="btn-row d-flex align-items-center justify-content-between">
            <a href="javascript:void(0);" class="btn  btn-info btn-icon  flex-fill" id="btn_hold" data-order-id=" ' . $order->id . '">'.trans('messages.get_data_lang', [], session('locale')).'</a>
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

            $rowCount = 0;
            foreach ($all_details as $key => $detail) {

                $product_id = $detail->product_id;
                $product = Product::find($product_id);


                $rowCount++;
                $pro_image = 'asset("images/dummy_image/no_image.png")';
                if ($product->product_image && $product->product_image !== '') {
                    $pro_image = "asset('images/product_images/')". $product->product_image;
                }

                $warranty_type ="";
                if($product->warranty_type!=3)
                {
                    if ($product->warranty_type == 1) {
                        $warranty_type ='`<br><span class="badge badge-success">'.trans('messages.shop_lang', [], session('locale')).' : '.$product->warranty_days.' '. trans('messages.days_lang', [], session('locale')).'</span>';
                    } elseif ($product->warranty_type == 2) {
                        $warranty_type ='`<br><span class="badge badge-success">'.trans('messages.agent_lang', [], session('locale')).' : '.$product->warranty_days.' '. trans('messages.days_lang', [], session('locale')).'</span>';
                    }
                }

                $show_imei="";
                $qty_input = "";
                $imei_serial = "";
                if($detail->item_imei != "undefined" && $detail->item_imei !="")
                {
                     if($product->imei_serial_type == 2)
                    {
                        $imei_serial = trans('messages.serial_no_lang', [], session('locale'));
                    }
                    else
                    {
                        $imei_serial = trans('messages.imei_#_lang', [], session('locale'));
                    }
                }
                if ($detail->item_imei !== 'undefined' && $detail->item_imei !== "") {
                    $qty_input = '<div class="qty-item text-center"><input type="text" class="form-control text-center qty-input" readonly name="product_quantity" value="1"></div>';
                    $show_imei = '<br>'.$imei_serial.' : <span class="badge badge-warning">'.$detail->item_imei.'</span>';
                }
                else
                {
                    $qty_input = '<div class="qty-item text-center">
                                        <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i class="fas fa-minus-circle"></i></a>

                                        <input type="text" class="form-control text-center qty-input" readonly name="product_quantity" value="' . $detail->item_quantity . '">

                                        <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i class="fas fa-plus-circle"></i></a>
                                    </div>';
                }
                $final_name = "";
                if($product->product_name != "")
                {
                    $final_name = $product->product_name;
                }
                if($final_name == "")
                {
                    $final_name = $product->product_name_ar;
                }
                else if($final_name!= "" && $product->product_name_ar != "")
                {
                    $final_name = $final_name."<br>".$product->product_name_ar;
                }



                // <a  href="#" data-bs-toggle="modal" onclick="edit_product(${$product->product_barcode})" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>
                    $order_list = '
                    <tr class="list_'.$detail->item_barcode.'">
                        <th class="text-center">'.$rowCount.'</th>
                        <th>'.$final_name.'
                            <input type="hidden" name="stock_ids" value="'.$product->id.'" class="stock_ids product_id_'.$product->id.'">
                            <input type="hidden" name="product_tax" value="'.$detail->item_tax.'" class="tax tax_'.$detail->item_barcode.'">
                            <input type="hidden" value="'.$product->product_min_price.'" class="min_price min_price_'.$detail->item_barcode.'">
                            <input type="hidden" value="'.$product->product_name.'" class="product_name product_name_'.$detail->item_barcode.'">
                            <input type="hidden" name="product_barcode" value="'.$detail->item_barcode.'" class="barcode barcode_'.$detail->item_barcode.'">

                            <br>
                            <span class="badge badge-warning"> '.$detail->item_barcode.'</span>
                            '.$warranty_type.'
                            '.$show_imei.'
                            <input type="hidden" value="'.$detail->item_imei.'" class="imei imei_'.$detail->item_imei.'">
                        </th>
                        <th class="text-center">
                            <input type="text" readonly style="width:60px" value="'.$detail->item_price.'"class="price price_'.$detail->item_barcode.' text-center">
                        </th>
                        <th class="text-center">
                            <div style="padding:15px" class="product-list item_list d-flex align-items-center justify-content-between">

                                <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                                    '.$qty_input.'
                               </div>
                            </div>
                        </th>
                        <th class="text-center"><span class="total_price total_price_'.$detail->item_barcode.'"</span></th>
                        <th class="text-center">
                            <input type="text" style="width:60px" class="text-center offer_discount_percent" readonly  >
                            <br>
                            <input type="text" style="width:60px" class="text-center offer_discount_amount" readonly  >
                        </th>
                        <th class="text-center">
                            <input type="text" style="width:60px" name="product_discount" value="'.$detail->item_discount_price.'" class="isnumber text-center discount discount_'.$product->product_barcode.'"
                        </th>
                        <th class="text-center">
                            <span class="grand_price grand_price_'.$detail->item_barcode.'"</span>
                        </th>
                        <th class="text-center">
                            <a  href="#" data-bs-toggle="modal" onclick=edit_product("'.$detail->item_barcode.'") data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>

                            <a id="delete-item" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                        </th>
                    </tr>

            ';

                    $detail->delete();
            }

            if($pending_order){
            $pending_order->delete();
            }
            return response()->json(['order_list' => $order_list, 'customer_data'=>$customer_data,'customer_number' =>$customer_id]);

        }



        public function pos_bill($order_no)
        {

            $order = PosOrder::where('order_no', $order_no)->first();
            $payment = PosPayment::where('order_no', $order_no)->first();
            $payment_method= $payment->account_id;
            $account = Account::where('id', $payment_method )->first();
            // $account_name = $account ? $account->account_name : null;

            $detail = PosOrderDetail::where('order_no', $order_no)
                                    ->with('product')
                                    ->get();
            // point history
            $point_amount =0;
            $order_point = PointHistory::where('order_no', $order_no)
                                        ->where('type', 2)->first();
            if(!empty($order_point))
            {
                $point_amount = $order_point->amount;
            }
            $shop = Settingdata::first();
            $invo = Posinvodata::first();

            $payment = PosPayment::where('order_no', $order_no)
                            ->latest()
                            ->first();
            $account_id= $payment->account_id;
            $payment_data = PosPayment::where('order_no', $order_no)->get();

            $account_name = '';
            foreach ($payment_data as $key => $pay) {
                if($pay->account_id == 0)
                {
                    $account_name .= trans('messages.points_lang', [], session('locale')).', ';
                }
                else
                {
                    $acc = Account::where('id', $pay->account_id)->first();
                    if($acc)
                    {
                        $account_name .= $acc->account_name.', ';
                    }
                }
            }



            $user = User::where('id', $order->user_id)->first();

            return view('pos_pages.bill', compact('point_amount' , 'order','shop', 'payment', 'invo','detail', 'payment','user', 'account_name' ));
        }


        public function bills($order_no)
        {

            $order = PosOrder::where('order_no', $order_no)->first();

            $payment = PosPayment::where('order_no', $order_no)->first();
            $payment_method= $payment->account_id;
            $account = Account::where('id', $payment_method )->first();
            // $account_name = $account ? $account->account_name : null;

            $detail = PosOrderDetail::where('order_no', $order_no)
                                    ->with('product')
                                    ->get();
            // point history
            $point_amount =0;
            $order_point = PointHistory::where('order_no', $order_no)
                                        ->where('type', 2)->first();
            if(!empty($order_point))
            {
                $point_amount = $order_point->amount;
            }
            $shop = Settingdata::first();
            $invo = Posinvodata::first();
            $payment = PosPayment::where('order_no', $order_no)
                            ->latest()
                            ->first();
            $account_id= $payment->account_id;
            $payment_data = PosPayment::where('order_no', $order_no)->get();

            $account_name = '';
            foreach ($payment_data as $key => $pay) {
                if($pay->account_id == 0)
                {
                    $account_name .= trans('messages.points_lang', [], session('locale')).', ';
                }
                else
                {
                    $acc = Account::where('id', $pay->account_id)->first();
                    if($acc)
                    {
                        $account_name .= $acc->account_name.', ';
                    }
                }
            }

            return view('pos_pages.bill', compact('point_amount' , 'order','shop', 'payment', 'invo','detail', 'payment', 'account_name' ));
        }


        //university

        public function add_university(Request $request){

            $user_id = Auth::id();
            $data= User::where('id', $user_id)->first();
            $user= $data->username;

            $university = new University();
            $university->university_id = genUuid() . time();
            $university->university_name = $request['university_name'];
            $university->university_address = $request['university_address'];
            $university->added_by = $user;
            $university->user_id = $user_id;
            $university->save();
            return response()->json(['university_id' => $university->id]);

        }

        //workplace

        public function add_workplace(Request $request){

            $user_id = Auth::id();
            $data= User::where('id', $user_id)->first();
            $user= $data->username;

            $workplace = new Workplace();
            $workplace->workplace_id = genUuid() . time();
            $workplace->ministry_id = $request['ministry_id'];
            $workplace->workplace_name = $request['workplace_name'];
            $workplace->workplace_address = $request['workplace_address'];
            $workplace->added_by = $user;
            $workplace->user_id = $user_id;
            $workplace->save();
            return response()->json(['workplace_id' => $workplace->id]);

        }

        //ministry

        public function add_ministry(Request $request){

            $user_id = Auth::id();
            $data= User::where('id', $user_id)->first();
            $user= $data->username;

            $ministry = new Ministry();
            $ministry->ministry_id = genUuid() . time();
            $ministry->ministry_name = $request['ministry_name'];
            $ministry->added_by = $user;
            $ministry->user_id = $user_id;
            $ministry->save();
            return response()->json(['ministry_id' => $ministry->id]);

        }


        // get profit
        public function make_profit()
        {
            $orders = PosOrder::get();

            foreach ($orders as $key => $value) {
                // profit
                $total_profit = PosOrderDetail::where('order_no', $value->order_no)->sum('item_profit');
                $order_data = PosOrder::where('order_no', $value->order_no)->first();
                $order_data->total_profit = $total_profit;
                $order_data->save();
                // Now $total_profit contains the sum of 'item_profit' for the current order_no
            }

        }


}
