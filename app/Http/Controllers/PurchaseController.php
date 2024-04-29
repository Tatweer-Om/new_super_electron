<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Account;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\Product_imei;
use Illuminate\Http\Request;
use App\Models\Purchase_bill;
use App\Models\Purchase_imei;
use App\Models\Purchase_detail;
use App\Models\Purchase_payment;
use Illuminate\Support\Facades\DB;
use App\Models\Product_qty_history;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class PurchaseController extends Controller
{
    public function index(){
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $account = Account::where('account_type', 1)->get();

        if ($permit_array && in_array('2', $permit_array)) {

            return view('stock.purchase', compact('account', 'permit_array' ));
        } else {

            return redirect()->route('home');
        }


    }
    public function show_purchase()
    {
        $sno=0;

        $view_purchase= Purchase::all();
        if(count($view_purchase)>0)
        {
            foreach($view_purchase as $value)
            {
                // shipping charges

                $tax = 0;
                if($value->available_tax_type==1)
                {
                    if(!empty($value->total_tax))
                    {
                        $tax = $value->total_tax;
                    }
                }
                else if($value->available_tax_type==2 && $value->tax_status==1)
                {
                    if(!empty($total_tax))
                    {
                        $tax = $total_tax;
                    }
                }
                $sumTotalPurchase = Purchase_detail::where('purchase_id', $value->id)
                ->sum(DB::raw('(purchase_price * quantity)'));


                // check remaining
                $remaining = getColumnValue('purchase_bills','purchase_id',$value->id,'remaining_price');
                $grand_total = getColumnValue('purchase_bills','purchase_id',$value->id,'grand_total');

                $invoice_no='<a  href="'.url('purchase_detail').'/'.$value->id.'">'.$value->invoice_no.'</a>';

                $modal='<a class="me-3 confirm-text text-primary" target="_blank" href="'.url('purchase_view').'/'.$value->id.'"><i class="fas fa-eye"></i>
                </a>';
                if($value->status==1)
                {
                    $modal.='<a class="me-3 confirm-text text-success"
                    onclick=approved_products("'.$value->invoice_no.'")><i class="fas fa-check"></i>
                    </a>
                    <a class="me-3 confirm-text text-danger" onclick=del_purchase("'.$value->id.'")><i class="fas fa-trash"></i>
                    </a>
                    <a class="me-3 confirm-text text-primary" href="'.url('edit_purchase').'/'.$value->id.'"><i class="fas fa-edit"></i>
                    </a>
                    <a class="me-3 confirm-text text-danger" onclick=complete_purchase("'.$value->id.'")><i class="fas fa-check-double"></i>
                    </a>
                    ';

                    $status = "<span class='badges bg-lightred'>" . trans('messages.pending_lang', [], session('locale')) . "</span>";

                }
                else
                {
                    if($remaining>0)
                    {
                        $modal.='<a class="me-3 confirm-text text-success"
                        onclick=get_purchase_payment("'.$value->id.'")><i class="fas fa-money-check-alt"></i>
                        </a>';
                    }
                    $status="<span class='badges bg-lightgreen'>" . trans('messages.completed_lang', [], session('locale')) . "</span>";
                }




                $supplier_name = getColumnValue('suppliers','id',$value->supplier_id,'supplier_name');
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $invoice_no,
                            $status,
                            $supplier_name,
                            $value->purchase_date,
                            $sumTotalPurchase,
                            $value->total_shipping,
                            $value->total_tax,
                            $grand_total,
                            $value->added_by,
                            $add_data,
                            $modal
                        );
            }
            $response = array();
            $response['success'] = true;
            $response['aaData'] = $json;
            echo json_encode($response);
        }
        else
        {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }
    public function product (){

        $supplier= Supplier::all();
        $category= Category::all();
        $brands= Brand::all();
        $stores= Store::all();
        $active_tax = 0;

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $account = Account::where('account_type', 1)->get();

        if ($permit_array && in_array('2', $permit_array)) {

            return view('stock.product', compact('supplier', 'brands', 'category','stores','active_tax', 'permit_array'));
        } else {

            return redirect()->route('home');
        }

    }

    public function edit_purchase ($id){

        $purchase_order = Purchase::where('id', $id)->first();
        $active_tax = $purchase_order->tax_status;
        $purchase_detail = Purchase_detail::where('purchase_id', $id)->where('status', 1)->get();
        $purchase_detail_send = Purchase_detail::where('purchase_id', $id)->where('status', 2)->get();
        $supplier= Supplier::all();
        $category= Category::all();
        $brands= Brand::all();
        $stores= Store::all();
        $sumTotalPurchase = Purchase_detail::where('purchase_id', $id)
                                    ->where('status', 2)
                                    ->sum(DB::raw('(total_purchase * quantity)'));
        $sumPurchase = Purchase_detail::where('purchase_id', $id)
                                    ->where('status', 2)
                                    ->sum(DB::raw('(purchase_price * quantity)'));
        if($sumTotalPurchase<0 || empty($sumTotalPurchase))
        {
            $sumTotalPurchase=0;
        }
        $sumTax = 0;
        $sum_shipping= 0;
        foreach ($purchase_detail_send as $key => $value) {
            $new_tax_expense = 0;
            $before_shipping_purchase_price = 0;
            if($purchase_order->tax_type==1)
            {

                if($purchase_order->available_tax_type==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase_order->bulk_tax * 1000) / 1000 );
                    $sumTax += sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase_order->available_tax_type==2 && $purchase_order->tax_status==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase_order->bulk_tax * 1000) / 1000 );
                    $sumTax += sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase_order->available_tax_type==2 && $purchase_order->tax_status==2)
                {
                    $taxValue = $value->purchase_price / 100 * $value->tax;
                    $sumTax += $taxValue*$value->quantity;
                    $before_shipping_purchase_price = $value->purchase_price ;
                }
            }
            else
            {
                $sumTax+= 0;
                $before_shipping_purchase_price = $value->purchase_price ;
            }


            // calculate shipping percentage

            $shippping_percentage = $purchase_order->shipping_percentage;
            if($shippping_percentage<=0)
            {
                $shippping_percentage = 0;
            }
            if($value->purchase_price>0)
            {

                $shipping_final_before=
                sprintf("%.3f",floor($before_shipping_purchase_price * 1000) / 1000 ) * sprintf("%.3f",floor($shippping_percentage * 100) / 100 );
                //  three_digit_after_decimal(before_shipping_purchase_price)   * two_digit_after_decimal($shippping_percentage);
                $sum_shipping+=
                sprintf("%.3f",floor($shipping_final_before/100 * 1000) / 1000 ) * $value->quantity;


            }
            else
            {
               $sum_shipping+= 0;

            }
        }


        $purchase_order = Purchase::where('id', $id)->first();
        $status = $purchase_order->status;
        return view('stock.edit_purchase', compact('sum_shipping','sumTotalPurchase','sumTax','purchase_order','purchase_detail','supplier', 'brands', 'category','stores','active_tax','status'));
    }

    public function get_selected_new_data()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $brands = Brand::all();
        $stores = Store::all();

        $sup_option = '<option value="">' . trans('messages.choose_lang', [], session('locale')) . '</option>';
        foreach ($supplier as $sup) {
            $sup_option .= '<option value="'.$sup->id.'">'.$sup->supplier_name.'</option>';
        }

        $cat_option = '<option value="">' . trans('messages.choose_lang', [], session('locale')) . '</option>';
        foreach ($category as $cat) {
            $cat_option .= '<option value="'.$cat->id.'">'.$cat->category_name.'</option>';
        }

        $bra_option = '<option value="">' . trans('messages.choose_lang', [], session('locale')) . '</option>';
        foreach ($brands as $bra) {
            $bra_option .= '<option value="'.$bra->id.'">'.$bra->brand_name.'</option>';
        }

        $sto_option = '<option value="">' . trans('messages.choose_lang', [], session('locale')) . '</option>';
        foreach ($stores as $sto) {
            $sto_option .= '<option value="'.$sto->id.'">'.$sto->store_name.'</option>';
        }


        $data = [
            'suppliers' => $sup_option,
            'categories' => $cat_option,
            'brands' => $bra_option,
            'stores' => $sto_option,
        ];

        // Use json() method directly
        return response()->json($data)->header('Content-Type', 'application/json');
    }

    public function add_purchase_product(Request $request){
        $setting = Settings::where('id', 1)->first();
        if($setting->tax_active==1)
        {
            $tax_active = 1;
        }
        else
        {
            $tax_active = 2;
        }
        // purchase detail
        $invoice_no = $request['invoice_no'];
        $purchase_check = Purchase::where('invoice_no', $invoice_no)->first();
        if ($purchase_check)
        {
            return response()->json(['status' => 2]);
            exit;
        }

        $supplier_id = $request['supplier_id_stk'];
        $purchase_date = $request['purchase_date'];
        $shipping_cost = $request['shipping_cost'];
        $invoice_price = $request['invoice_price'];
        $shipping_percentage = $request['shipping_percentage'];
        $tax_type = $request['tax_type'];
        $available_tax_type = $request['available_tax_type'];
        $bulk_tax = $request['bulk_tax'];
        $tax_status = $tax_active;
        $total_price = $request['total_price'];
        $total_tax = $request['total_tax'];
        $total_shipping = $request['total_shipping'];
        $purchase_description = $request['purchase_description'];
        // stock detail
        $category_id = $request['category_id_stk'];
        $store_id = $request['store_id_stk'];
        $brand_id = $request['brand_id_stk'];
        $product_name = $request['product_name'];
        $product_name_ar = $request['product_name_ar'];
        $barcode = $request['barcode'];
        $purchase_price = $request['purchase_price'];
        $total_purchase = $request['total_purchase_price'];
        $profit_percent = $request['profit_percent'];
        $sale_price = $request['sale_price'];
        $min_sale_price = $request['min_sale_price'];
        $tax = $request['tax'];
        $quantity = $request['quantity'];
        $notification_limit = $request['notification_limit'];
        $warranty_days = $request['warranty_days'];
        $bulk_quantity = $request['bulk_quantity'];
        $bulk_price = $request['bulk_price'];
        $imei_no = $request['imei_no'];
        $description = $request['description'];

        // $duplicate_barcodes="";
        // for ($bar=0; $bar < count($barcode) ; $bar++) {
        //     $product = new Product();
        //     if (!Product::where('barcode', $barcode[$i])->exists())
        //     {
        //         $duplicate_barcodes.=$barcode[$i].', ';
        //     }
        // }
        // if(!empty($duplicate_barcodes))
        // {
        //     return response()->json(['status' => 2, 'duplicate_barcodes'=>$duplicate_barcodes]);
        //     exit;
        // }

        // add purchase
        $purchase = new Purchase();
        $purchase_receipt="";
        if ($request->hasFile('receipt_file')) {
            $folderPath = public_path('images/purchase_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $purchase_receipt = time() . '.' . $request->file('receipt_file')->extension();
            $request->file('receipt_file')->move(public_path('images/purchase_images'), $purchase_receipt);
        }
        $purchase->invoice_no=$invoice_no;
        $purchase->supplier_id=$supplier_id;
        $purchase->purchase_date=$purchase_date;
        $purchase->shipping_cost=$shipping_cost;
        $purchase->total_price=$total_price;
        $purchase->invoice_price=$invoice_price;
        $purchase->shipping_percentage=$shipping_percentage;
        $purchase->tax_type=$tax_type;
        $purchase->available_tax_type=$available_tax_type;
        $purchase->bulk_tax=$bulk_tax;
        $purchase->tax_status=$tax_status;
        $purchase->total_tax=$total_tax;
        $purchase->total_shipping=$total_shipping;
        $purchase->description=$purchase_description;
        $purchase->receipt_file=$purchase_receipt;
        $purchase->added_by = 'admin';
        $purchase->user_id = '1';
        $purchase->save();
        $purchase_id = $purchase->id;

        // add purchase detail and products


        $total_products=count($category_id);
        $single_product_shipping=0;
        if(!empty($shipping_cost))
        {
            $single_product_shipping=$shipping_cost/$total_products;
        }

        $checkbox=0;
        for ($i=0; $i <count($category_id) ; $i++) {
            $purchase_detail = new Purchase_detail();

            $checkbox++;

            // add products
            $product = new Product();
            $product_data = Product::where('barcode', $barcode[$i])->first();
            if($product_data !== null)
            {
                $product_ids=$product_data->product_id;
            }
            else
            {
                $product_ids=genUuid() . time().$checkbox;
            }

            $product_image="";
            if ($request->hasFile('stock_image_'.$checkbox)) {
                 $folderPath = public_path('images/product_images');

                 // Check if the folder doesn't exist, then create it
                 if (!File::isDirectory($folderPath)) {
                     File::makeDirectory($folderPath, 0777, true, true);
                 }
                 $product_image = time() . '.' . $request->file('stock_image_'.$checkbox)->extension();
                 $request->file('stock_image_'.$checkbox)->move(public_path('images/product_images'), $product_image);
            }

            $imei_check = request()->has('imei_check'.$checkbox) ? 1 : 0;
            $whole_sale = request()->has('whole_sale'.$checkbox) ? 1 : 0;
            $product_type = $request['product_type_'.$checkbox];
            $warranty_type = $request['warranty_type_'.$checkbox];
            $imei_serial_type = $request['imei_serial_type_'.$checkbox];
             // add purchase detail
            $purchase_detail->purchase_id=$purchase_id;
            $purchase_detail->invoice_no=$invoice_no;
            $purchase_detail->product_id=$product_ids;
            $purchase_detail->category_id=$category_id[$i];
            $purchase_detail->store_id=$store_id[$i];
            $purchase_detail->brand_id=$brand_id[$i];
            $purchase_detail->supplier_id=$supplier_id;
            $purchase_detail->barcode=$barcode[$i];
            $purchase_detail->purchase_price=$purchase_price[$i];
            $purchase_detail->total_purchase=$total_purchase[$i];
            $purchase_detail->tax=$tax[$i];
            $purchase_detail->product_name=$product_name[$i];
            $purchase_detail->product_name_ar=$product_name_ar[$i];
            $purchase_detail->profit_percent=$profit_percent[$i];
            $purchase_detail->sale_price=$sale_price[$i];
            $purchase_detail->min_sale_price=$min_sale_price[$i];
            $purchase_detail->quantity=$quantity[$i];
            $purchase_detail->notification_limit=$notification_limit[$i];
            $purchase_detail->product_type=$product_type;
            $purchase_detail->warranty_type=$warranty_type;
            $purchase_detail->imei_serial_type=$imei_serial_type;
            $purchase_detail->warranty_days=$warranty_days[$i];
            $purchase_detail->whole_sale=$whole_sale;
            $purchase_detail->bulk_quantity=$bulk_quantity[$i];
            $purchase_detail->bulk_price=$bulk_price[$i];
            $purchase_detail->check_imei=$imei_check;
            $purchase_detail->description=$description[$i];
            $purchase_detail->stock_image=$product_image;
            $purchase_detail->added_by = 'admin';
            $purchase_detail->user_id = '1';
            $purchase_detail->save();

            // purchase and product imei


            $product_imeis=explode(',',$imei_no[$i]);
            if($imei_check==1)
            {
                for ($z=0; $z <count($product_imeis) ; $z++) {
                    $purchase_imei = new Purchase_imei();
                    $purchase_imei->purchase_id=$purchase_id;
                    $purchase_imei->invoice_no=$invoice_no;
                    $purchase_imei->product_id=$product_ids;
                    $purchase_imei->barcode=$barcode[$i];
                    $purchase_imei->imei=$product_imeis[$z];
                    $purchase_imei->added_by = 'admin';
                    $purchase_imei->user_id = '1';
                    $purchase_imei->save();
                }
            }
        }

        // purchase bill
        $purchase_bill = new Purchase_bill();

        $purchase_bill->purchase_id=$purchase_id;
        $purchase_bill->invoice_no=$invoice_no;
        $purchase_bill->total_price=$total_price;
        $purchase_bill->total_tax=$total_tax;
        if($tax_type==2)
        {
            $purchase_bill->grand_total=$total_price;
            $purchase_bill->remaining_price=$total_price;
        }
        else
        {
            if($available_tax_type == 1)
            {
                $purchase_bill->grand_total=$total_price;
                $purchase_bill->remaining_price=$total_price;
            }
            else if($available_tax_type == 2 && $tax_active==1)
            {
                $purchase_bill->grand_total=$total_price;
                $purchase_bill->remaining_price=$total_price;
            }
            else if($available_tax_type == 2 && $tax_active==2)
            {
                $purchase_bill->grand_total=$total_tax+$total_price;
                $purchase_bill->remaining_price=$total_tax+$total_price;
            }
        }

        $purchase_bill->added_by = 'admin';
        $purchase_bill->user_id = '1';
        $purchase_bill->save();
        return response()->json(['status' => 1]);
    }


    // update purchase
    public function update_purchase(Request $request){
        $invoice_no = $request['invoice_no'];
        $purchase = Purchase::where('invoice_no', $invoice_no)->first();

        if($purchase->tax_status==1)
        {
            $tax_active = 1;
        }
        else
        {
            $tax_active = 2;
        }
        // purchase detail

        $supplier_id = $request['supplier_id_stk'];
        $purchase_date = $request['purchase_date'];
        $shipping_cost = $request['shipping_cost'];
        $invoice_price = $request['invoice_price'];
        $shipping_percentage = $request['shipping_percentage'];
        $tax_type = $purchase->tax_type;
        $available_tax_type = $purchase->available_tax_type;
        $bulk_tax = $request['bulk_tax'];
        $tax_status = $tax_active;
        $total_price = $request['total_price'];
        $total_tax = $request['total_tax'];
        $total_shipping = $request['total_shipping'];
        $purchase_description = $request['purchase_description'];
        // stock detail
        $category_id = $request['category_id_stk'];
        $store_id = $request['store_id_stk'];
        $brand_id = $request['brand_id_stk'];
        $product_name = $request['product_name'];
        $product_name_ar = $request['product_name_ar'];
        $barcode = $request['barcode'];
        $purchase_price = $request['purchase_price'];
        $total_purchase = $request['total_purchase_price'];
        $profit_percent = $request['profit_percent'];
        $sale_price = $request['sale_price'];
        $min_sale_price = $request['min_sale_price'];
        $tax = $request['tax'];
        $quantity = $request['quantity'];
        $notification_limit = $request['notification_limit'];
        $warranty_days = $request['warranty_days'];
        $bulk_quantity = $request['bulk_quantity'];
        $bulk_price = $request['bulk_price'];
        $imei_no = $request['imei_no'];
        $description = $request['description'];

        // $duplicate_barcodes="";
        // for ($bar=0; $bar < count($barcode) ; $bar++) {
        //     $product = new Product();
        //     if (!Product::where('barcode', $barcode[$i])->exists())
        //     {
        //         $duplicate_barcodes.=$barcode[$i].', ';
        //     }
        // }
        // if(!empty($duplicate_barcodes))
        // {
        //     return response()->json(['status' => 2, 'duplicate_barcodes'=>$duplicate_barcodes]);
        //     exit;
        // }

        // add purchase

        $purchase_receipt="";
        if ($request->hasFile('receipt_file')) {
            $folderPath = public_path('images/purchase_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $purchase_receipt = time() . '.' . $request->file('receipt_file')->extension();
            $request->file('receipt_file')->move(public_path('images/purchase_images'), $purchase_receipt);
            $purchase->receipt_file=$purchase_receipt;
        }


        $sumTotalPurchase = Purchase_detail::where('invoice_no', $invoice_no)
                                    ->where('status', 2)
                                    ->sum(DB::raw('(total_purchase * quantity)'));
        $sumPurchase = Purchase_detail::where('invoice_no', $invoice_no)
                                    ->where('status', 2)
                                    ->sum(DB::raw('(purchase_price * quantity)'));
        if($sumTotalPurchase<0 || empty($sumTotalPurchase))
        {
            $sumTotalPurchase=0;
        }

        $purchase_detail_send = Purchase_detail::where('invoice_no', $invoice_no)->where('status', 2)->get();
        $sumTax = 0;
        $sum_shipping= 0;
        foreach ($purchase_detail_send as $key => $value) {
            $new_tax_expense = 0;
            $before_shipping_purchase_price = 0;
            if($purchase->tax_type==1)
            {

                if($purchase->available_tax_type==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase->bulk_tax * 1000) / 1000 );
                    $sumTax += sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase->available_tax_type==2 && $purchase->tax_status==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase->bulk_tax * 1000) / 1000 );
                    $sumTax += sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase->available_tax_type==2 && $purchase->tax_status==2)
                {
                    $taxValue = $value->purchase_price / 100 * $value->tax;
                    $sumTax += $taxValue*$value->quantity;
                    $before_shipping_purchase_price = $value->purchase_price ;
                }
            }
            else
            {
                $sumTax+= 0;
                $before_shipping_purchase_price = $value->purchase_price ;
            }


            // calculate shipping percentage

            $shippping_percentage = $purchase->shipping_percentage;
            if($shippping_percentage<=0)
            {
                $shippping_percentage = 0;
            }
            if($value->purchase_price>0)
            {

                $shipping_final_before=
                sprintf("%.3f",floor($before_shipping_purchase_price * 1000) / 1000 ) * sprintf("%.3f",floor($shippping_percentage * 100) / 100 );
                //  three_digit_after_decimal(before_shipping_purchase_price)   * two_digit_after_decimal($shippping_percentage);
                $sum_shipping+=
                sprintf("%.3f",floor($shipping_final_before/100 * 1000) / 1000 ) * $value->quantity;


            }
            else
            {
               $sum_shipping+= 0;

            }
        }



        $new_total_price =  $total_price + $sumTotalPurchase;
        $new_total_tax =  $sumTax + $total_tax;
        $new_total_shipping =  $sum_shipping + $total_shipping;

        $purchase->invoice_no=$invoice_no;
        $purchase->supplier_id=$supplier_id;
        $purchase->purchase_date=$purchase_date;
        $purchase->shipping_cost=$shipping_cost;
        $purchase->total_price=$new_total_price;
        $purchase->invoice_price=$invoice_price;
        $purchase->shipping_percentage=$shipping_percentage;
        $purchase->total_tax=$new_total_tax;
        $purchase->total_shipping=$new_total_shipping;
        $purchase->description=$purchase_description;
        $purchase->updated_by = 'admin';
        $purchase->user_id = '1';
        $purchase->save();
        $purchase_id = $purchase->id;

        // add purchase detail and products

        $delete_purchase_detail = Purchase_detail::where('invoice_no', $invoice_no)
                                                    ->where('status', 1)
                                                    ->delete();

        $total_products=count($category_id);
        $single_product_shipping=0;
        if(!empty($shipping_cost))
        {
            $single_product_shipping=$shipping_cost/$total_products;
        }


        $checkbox=0;
        for ($i=0; $i <count($category_id) ; $i++) {
            $purchase_detail = new Purchase_detail();

            $checkbox++;
         // add products
            $product = new Product();
            $product_data = Product::where('barcode', $barcode[$i])->first();
            if($product_data !== null)
            {
                $product_ids=$product_data->product_id;
            }
            else
            {
                $product_ids=genUuid() . time().$checkbox;
            }


            if ($request->hasFile('stock_image_' . $checkbox)) {
                $folderPath = public_path('images/product_images');

                // Check if the folder doesn't exist, then create it
                if (!File::isDirectory($folderPath)) {
                    File::makeDirectory($folderPath, 0777, true, true);
                }

                // Generate a unique filename for the uploaded image
                $product_image = time() . '_' . $checkbox . '.' . $request->file('stock_image_' . $checkbox)->extension();

                // Move the uploaded file to the destination folder
                $request->file('stock_image_' . $checkbox)->move(public_path('images/product_images'), $product_image);

                // Assign the filename to the corresponding property in your model
                $purchase_detail->stock_image = $product_image;
            }


            $imei_check = request()->has('imei_check'.$checkbox) ? 1 : 0;
            $whole_sale = request()->has('whole_sale'.$checkbox) ? 1 : 0;
            $product_type = $request['product_type_'.$checkbox];
            $warranty_type = $request['warranty_type_'.$checkbox];
            $imei_serial_type = $request['imei_serial_type_'.$checkbox];
             // add purchase detail
            $purchase_detail->purchase_id=$purchase_id;
            $purchase_detail->invoice_no=$invoice_no;
            $purchase_detail->product_id=$product_ids;
            $purchase_detail->category_id=$category_id[$i];
            $purchase_detail->store_id=$store_id[$i];
            $purchase_detail->brand_id=$brand_id[$i];
            $purchase_detail->supplier_id=$supplier_id;
            $purchase_detail->barcode=$barcode[$i];
            $purchase_detail->purchase_price=$purchase_price[$i];
            $purchase_detail->total_purchase=$total_purchase[$i];
            $purchase_detail->tax=$tax[$i];
            $purchase_detail->product_name=$product_name[$i];
            $purchase_detail->product_name_ar=$product_name_ar[$i];
            $purchase_detail->profit_percent=$profit_percent[$i];
            $purchase_detail->sale_price=$sale_price[$i];
            $purchase_detail->min_sale_price=$min_sale_price[$i];
            $purchase_detail->quantity=$quantity[$i];
            $purchase_detail->notification_limit=$notification_limit[$i];
            $purchase_detail->product_type=$product_type;
            $purchase_detail->warranty_type=$warranty_type;
            $purchase_detail->imei_serial_type=$imei_serial_type;
            $purchase_detail->warranty_days=$warranty_days[$i];
            $purchase_detail->whole_sale=$whole_sale;
            $purchase_detail->bulk_quantity=$bulk_quantity[$i];
            $purchase_detail->bulk_price=$bulk_price[$i];
            $purchase_detail->check_imei=$imei_check;
            $purchase_detail->description=$description[$i];
            $purchase_detail->added_by = 'admin';
            $purchase_detail->user_id = '1';
            $purchase_detail->save();

            // purchase and product imei

            $delete_purchase_imei = Purchase_imei::where('invoice_no', $invoice_no)
                                                    ->where('barcode', $barcode[$i])
                                                    ->delete();
            $product_imeis=explode(',',$imei_no[$i]);
            if($imei_check==1)
            {
                for ($z=0; $z <count($product_imeis) ; $z++) {
                    $purchase_imei = new Purchase_imei();
                    $purchase_imei->purchase_id=$purchase_id;
                    $purchase_imei->invoice_no=$invoice_no;
                    $purchase_imei->product_id=$product_ids;
                    $purchase_imei->barcode=$barcode[$i];
                    $purchase_imei->imei=$product_imeis[$z];
                    $purchase_imei->added_by = 'admin';
                    $purchase_imei->user_id = '1';
                    $purchase_imei->save();
                }
            }
        }

        // purchase bill

        $purchase_bill = Purchase_bill::where('invoice_no', $invoice_no)->first();

        $purchase_bill->purchase_id=$purchase_id;
        $purchase_bill->invoice_no=$invoice_no;
        $purchase_bill->total_price=$new_total_price;
        $purchase_bill->total_tax=$new_total_tax;
        if($tax_type==2)
        {
            $purchase_bill->grand_total=$sumPurchase+$total_price;
            $purchase_bill->remaining_price=$sumPurchase+$total_price;
        }
        else
        {
            if($available_tax_type == 1)
            {
                $purchase_bill->grand_total=$sumTotalPurchase+$total_price;
                $purchase_bill->remaining_price=$sumTotalPurchase+$total_price;
            }
            else if($available_tax_type == 2 && $tax_active==1)
            {
                $purchase_bill->grand_total=$sumTotalPurchase+$total_price;
                $purchase_bill->remaining_price=$sumTotalPurchase+$total_price;
            }
            else if($available_tax_type == 2 && $tax_active==2)
            {
                $purchase_bill->grand_total=$sumTotalPurchase+$sumTax+$total_tax+$total_price;
                $purchase_bill->remaining_price=$sumTotalPurchase+$sumTax+$total_tax+$total_price;
            }
        }
        $purchase_bill->added_by = 'admin';
        $purchase_bill->user_id = '1';
        $purchase_bill->save();

    }

    // check imei avaibality
    public function check_imei_availability(Request $request){
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();
        if (!$product) {
            return response()->json(['status' => 2, 'check_imei' => ""]);
        }
        else
        {
            return response()->json(['status' => 1, 'check_imei' => $product->check_imei]);
        }
    }
    // get invoice no
    public function search_invoice(Request $request)
    {
        $purchase = new Purchase();
        $invoice_no = $request['search'];
        $purchase_data = Purchase::where('invoice_no', $invoice_no)->first();

        if (!$purchase_data) {
            return response()->json([
                'error'=> trans('messages.invoice_not_found_lang', [], session('locale')),
                'error_code' => 2
            ], 200);
        }

        else
        {
            return response()->json(['error' => trans('messages.invoice_not_found_lang', [], session('locale')),'error_code' => 1,'purchase_id' => $purchase_data->id], 200);
        }
    }
    // get barcode no
    public function search_barcode(Request $request)
    {
        $product = new Product();
        $barcode = $request['search'];
        // Search in Stock
        $search_items = Product::where('barcode', 'like', '%' . $barcode . '%')
            ->get();
        $returnArr=[];
        foreach ($search_items as $item) {
            $returnArr[] = $item->barcode . '+' . $item->product_name;
        }
        return response()->json($returnArr);
    }
    // get product data
    public function get_product_data(Request $request)
    {
        $product = new Product();
        $product_imei = new Product_imei();
        $result = $request['result'];
        $exploded_result=explode('+',$result);
        $barcode=$exploded_result[0];
        // Search in Stock
        $product_data = Product::where('barcode', $barcode)->first();
        // get imei
        $all_imei='';
        $product_imei = Product_imei::where('product_id', $product_data->id)->get();
        $j=1;
        if(count($product_imei)>0)
        {
            foreach($product_imei as $value)
            {
                if(count($product_imei)==$j)
                {
                    $all_imei.=$value->imei;
                }
                else
                {
                    $all_imei.=$value->imei.',';
                }
                $j++;
            }
        }
        //
        $data = [
            'category_id' => $product_data->id,
            'store_id' => $product_data->id,
            'brand_id' => $product_data->id,
            'product_name' => $product_data->product_name,
            'product_name_ar' => $product_data->product_name_ar,
            'barcode' => $product_data->barcode,
            'purchase_price' => $product_data->purchase_price,
            'total_purchase' => $product_data->total_purchase,
            'profit_percent' => $product_data->profit_percent,
            'sale_price' => $product_data->sale_price,
            'min_sale_price' => $product_data->min_sale_price,
            'tax' => $product_data->tax,
            'quantity' => $product_data->quantity,
            'notification_limit' => $product_data->notification_limit,
            'product_type' => $product_data->product_type,
            'warranty_type' => $product_data->warranty_type,
            'warranty_days' => $product_data->warranty_days,
            'whole_sale' => $product_data->whole_sale,
            'bulk_quantity' => $product_data->bulk_quantity,
            'bulk_price' => $product_data->bulk_price,
            'check_imei' => $product_data->check_imei,
            'description' => $product_data->description,
            'stock_image' => $product_data->stock_image,
            'imei_no' => $all_imei,
        // Add more attributes as needed
        ];

        return response()->json($data);
    }

    // purchase completed
    public function get_purchase_products(Request $request){

        $invoice_no = $request['id'];
        $all_unapproved_products = Purchase_detail::where('invoice_no', $invoice_no)
                                                ->where('status', 1)->get();

        $purchase_product_div='<div class="col-md-12 col-6">
                                    <label class="checkboxs">
                                        <input type="checkbox"  value="all" id="all_select">
                                        <span class="checkmarks" for="all_select"></span> '.trans('messages.select_all_lang',[],session('locale')).'
                                    </label>
                                </div>';
        if ($all_unapproved_products->isEmpty())
        {
            return response()->json(['msg' => 2]);
        }
        else
        {
            foreach ($all_unapproved_products as $key => $value) {
                $title = $value->product_name;
                if(empty($title))
                {
                    $title = $value->product_name_ar;
                }


                $purchase_product_div.='<div class="col-md-2 col-6">
                                        <label class="checkboxs">
                                            <input type="checkbox" class="all_products" name="all_products[]" value="'.$value->id.'" id="'.$value->id.'_pro">
                                            <span class="checkmarks" for="'.$value->id.'_pro"></span>'.$title.'
                                        </label>
                                    </div> ';
            }
            return response()->json(['msg' => 1,'purchase_product_div' => $purchase_product_div]);

        }

    }
    public function approved_purchase(Request $request){

        $invoice_no = $request['purchase_id'];
        $approve_pro = $request['all_products'];
        $purchase_detail = new Purchase_detail();
        $purchase = new Purchase();

        $purchase_data = Purchase::where('invoice_no', $invoice_no)->first();
        // add approved products
        // $total_products=count($all_approved_products);
        // $single_product_shipping=0;
        // if(!empty($purchase_data->shipping_cost))
        // {
        //     $single_product_shipping=$purchase_data->shipping_cost/$total_products;
        // }


        // add products
        for ($z=0; $z < count($approve_pro) ; $z++) {
            $value = Purchase_detail::where('id', $approve_pro[$z])->first();

            $product = new Product();

            $product_data = Product::where('barcode', $value->barcode)->first();

            if($product_data !== null)
            {

                // average sale and purchase price
                $final_qty = $product_data->quantity + $value->quantity;
                $total_purchase_qty = $product_data->total_purchase * $product_data->quantity + $value->quantity * $value->total_purchase;
                $average_purchase_price = $total_purchase_qty / $final_qty;


                $total_sale_price_qty = $product_data->sale_price * $product_data->quantity + $value->quantity * $value->sale_price;
                $average_sale_price = $total_sale_price_qty / $final_qty;

                // purchase and product imei
                $purchase_imei = new Purchase_imei();

                $purchase_imei = Purchase_imei::where('invoice_no', $invoice_no)->where('barcode', $value->barcode)->get();

                if(count($purchase_imei)>0)
                {

                    $all_in_one="";
                    $em=1;
                    foreach ($purchase_imei as $key => $imei) {
                        // take imeis in one variable
                        if($em==count($purchase_imei))
                        {
                            $all_in_one.=$imei->imei;
                        }
                        else
                        {
                            $all_in_one.=$imei->imei.', ';
                        }

                        // add imei
                        $product_imei = new Product_imei();

                        $product_imei->product_id=$product_data->id;
                        $product_imei->barcode=$imei->barcode;
                        $product_imei->imei=$imei->imei;
                        $product_imei->added_by = 'admin';
                        $product_imei->user_id = '1';
                        $product_imei->save();

                        // incerment in em
                        $em++;
                    }

                    // product qty history
                    $product_qty_history = new Product_qty_history();

                    $product_qty_history->order_no =$invoice_no;
                    $product_qty_history->product_id =$product_data->id;
                    $product_qty_history->barcode=$value->barcode;
                    $product_qty_history->imei=$all_in_one;
                    $product_qty_history->source='purchase';
                    $product_qty_history->type=1;
                    $product_qty_history->previous_qty=0;
                    $product_qty_history->given_qty=count($purchase_imei);
                    $product_qty_history->new_qty=count($purchase_imei);
                    $product_qty_history->added_by = 'admin';
                    $product_qty_history->user_id = '1';
                    $product_qty_history->save();
                }
                else
                {
                    // product qty history
                    $product_qty_history = new Product_qty_history();

                    $product_qty_history->order_no =$invoice_no;
                    $product_qty_history->product_id =$product_data->id;
                    $product_qty_history->barcode=$value->barcode;
                    $product_qty_history->source='purchase';
                    $product_qty_history->type=1;
                    $product_qty_history->previous_qty=$product_data->quantity;
                    $product_qty_history->given_qty=$value->quantity;
                    $product_qty_history->new_qty=$value->quantity+$product_data->quantity;
                    $product_qty_history->added_by = 'admin';
                    $product_qty_history->user_id = '1';
                    $product_qty_history->save();
                }

                // update_qty_product
                $product_data->quantity = $value->quantity+$product_data->quantity;
                $product_data->sale_price = $average_sale_price;
                $product_data->total_purchase = $average_purchase_price;
                $product_data->updated_by = 'admin';
                $product_data->save();


            }
            else
            {

                $product->product_id=$value->product_id;
                $product->category_id=$value->category_id;
                $product->store_id=$value->store_id;
                $product->brand_id=$value->brand_id;
                $product->supplier_id=$value->supplier_id;
                $product->product_name=$value->product_name;
                $product->product_name_ar=$value->product_name_ar;
                $product->barcode=$value->barcode;
                $product->purchase_price=$value->purchase_price;
                $product->total_purchase=$value->total_purchase;
                $product->profit_percent=$value->profit_percent;
                $product->sale_price=$value->sale_price;
                $product->min_sale_price=$value->min_sale_price;
                $product->tax=$value->tax;
                $product->quantity=$value->quantity;
                $product->notification_limit=$value->notification_limit;
                $product->product_type=$value->product_type;
                $product->warranty_type=$value->warranty_type;
                $product->warranty_days=$value->warranty_days;
                $product->whole_sale=$value->whole_sale;
                $product->bulk_quantity=$value->bulk_quantity;
                $product->bulk_price=$value->bulk_price;
                $product->check_imei=$value->check_imei;
                $product->imei_serial_type=$value->imei_serial_type;
                $product->description=$value->description;
                $product->stock_image=$value->stock_image;
                $product->added_by = 'admin';
                $product->user_id = '1';
                $product->save();
                $product_id = $product->id;

                // purchase and product imei
                $purchase_imei = new Purchase_imei();
                $purchase_imei = Purchase_imei::where('invoice_no', $invoice_no)->where('barcode', $value->barcode)->get();

                if(count($purchase_imei)>0)
                {

                    $all_in_one="";
                    $em=1;
                    foreach ($purchase_imei as $key => $imei) {
                        // take imeis in one variable
                        if($em==count($purchase_imei))
                        {
                            $all_in_one.=$imei->imei;
                        }
                        else
                        {
                            $all_in_one.=$imei->imei.', ';
                        }

                        // add imei
                        $product_imei = new Product_imei();

                        $product_imei->product_id=$product_id;
                        $product_imei->barcode=$imei->barcode;
                        $product_imei->imei=$imei->imei;
                        $product_imei->added_by = 'admin';
                        $product_imei->user_id = '1';
                        $product_imei->save();

                        // incerment in em
                        $em++;
                    }

                    // product qty history
                    $product_qty_history = new Product_qty_history();

                    $product_qty_history->order_no =$invoice_no;
                    $product_qty_history->product_id =$product_id;
                    $product_qty_history->barcode=$value->barcode;
                    $product_qty_history->imei=$all_in_one;
                    $product_qty_history->source='purchase';
                    $product_qty_history->type=1;
                    $product_qty_history->previous_qty=0;
                    $product_qty_history->given_qty=count($purchase_imei);
                    $product_qty_history->new_qty=count($purchase_imei);
                    $product_qty_history->added_by = 'admin';
                    $product_qty_history->user_id = '1';
                    $product_qty_history->save();
                }
                else
                {
                    // product qty history
                    $product_qty_history = new Product_qty_history();

                    $product_qty_history->order_no =$invoice_no;
                    $product_qty_history->product_id =$product_id;
                    $product_qty_history->barcode=$value->barcode;
                    $product_qty_history->source='purchase';
                    $product_qty_history->type=1;
                    $product_qty_history->previous_qty=0;
                    $product_qty_history->given_qty=$value->quantity;
                    $product_qty_history->new_qty=$value->quantity;
                    $product_qty_history->added_by = 'admin';
                    $product_qty_history->user_id = '1';
                    $product_qty_history->save();
                }

            }
            $value->status=2;
            $value->save();
        }


    }

    // delete purchase
    public function delete_purchase(Request $request){
        $purchase_id = $request->input('id');
        $purchase = purchase::where('id', $purchase_id)->first();
        if (!$purchase) {
            return response()->json([
                'error' => trans('messages.purchase_not_found_lang', [], session('locale'))
            ], 404);
        }

        $purchase->delete();

        return response()->json([
            'success'=> trans('messages.purchase_deleted_lang', [], session('locale'))
        ]);
    }

    // complete_purchase
    public function complete_purchase(Request $request){
        $purchase_id = $request->input('id');
        $purchase = purchase::where('id', $purchase_id)->first();
        $purchase_detail = Purchase_detail::where('purchase_id', $purchase_id)
        ->where('status', 1)
        ->get();
        $num_rows = $purchase_detail->count();


        if (!$purchase) {
            return response()->json([
                'error' => trans('messages.purchase_not_found_lang', [], session('locale'))
            ,'msg'=>404]);
            exit;
        }
        if ($num_rows>0) {
            return response()->json([
                'error' => trans('messages.purchase_pro_approval_validation_lang', [], session('locale'))
            ,'msg'=>401]);
            exit;
        }

        $purchase->status=2;
        $purchase->save();

        return response()->json([
            'success'=> trans('messages.complete_purchase_lang', [], session('locale'))
        ]);
    }

    // purchase detail
    public function purchase_view($invoice_no) {
        $purchase_view = Purchase_detail::where('purchase_id', $invoice_no)->get();
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);





        $purchase_invoice = Purchase::where('id', $invoice_no)->first();
        $shipping_cost = 0;
        if ($purchase_invoice) {
            $id = $purchase_invoice->id;
            $bill_data = Purchase_bill::where('purchase_id', $id)->first();
            $payment_remaining=$bill_data->remaining_price;
            $sub_total=$bill_data->total_price;
            $total_tax=$bill_data->total_tax;
            $grand_total=$bill_data->grand_total;
            $shipping_cost=$purchase_invoice->total_shipping;
            $payment_remaining=$bill_data->remaining_price;
            $shipping_percentage=$purchase_invoice->shipping_percentage;

        }


        $purchase_detail_table="";

        $sub_total_all = 0;

        $without_shipping_sub_total=0;

        $sno=1;
        foreach ($purchase_view as $value) {
            $pro_image=asset('images/dummy_image/no_image.png');
            if(!empty($value->stock_image))
            {
                $pro_image=asset('images/product_images/'.  $value->stock_image);
            }
            if($value->warranty_type==1)
            {
                $warranty_type=trans('messages.shop_lang', [], session('locale')).' : '.$value->warranty_days;
            }
            else if($value->warranty_type==2)
            {
                $warranty_type=trans('messages.agent_lang', [], session('locale')).' : '.$value->warranty_days;
            }
            else if($value->warranty_type==3)
            {
                $warranty_type=trans('messages.none_lang', [], session('locale'));
            }

            $sub_total=$value->purchase_price*$value->quantity;
            $sub_total_all += $sub_total;



            $item_total=$value->purchase_price*$value->quantity;
            $without_shipping_sub_total+=$value->purchase_price*$value->quantity;



            $all_imei="";
            if($value->check_imei==1)
            {
                $purchase_imei = Purchase_imei::where('barcode', $value->barcode)->get();
                foreach ($purchase_imei as $imei) {

                    $all_imei.=$imei->imei.",";
                }
            }
            $pro_title=$value->product_name;
            if(empty($pro_title))
            {
                $pro_title=$value->product_name_ar;
            }
            $tax=0;
            if(!empty($value->tax))
            {
                $tax=$value->tax;
            }
            $sumTax = 0;
            $new_tax_expense = 0;
            $before_shipping_purchase_price = 0;
            if($purchase_invoice->tax_type==1)
            {

                if($purchase_invoice->available_tax_type==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase_invoice->bulk_tax * 1000) / 1000 );
                    $sumTax = sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase_invoice->available_tax_type==2 && $purchase_invoice->tax_status==1)
                {
                    $new_tax_expense =  sprintf("%.3f",floor($value->purchase_price/100*$purchase_invoice->bulk_tax * 1000) / 1000 );
                    $sumTax = sprintf("%.3f",floor($new_tax_expense*$value->quantity * 1000) / 1000 );
                    $before_shipping_purchase_price = $value->purchase_price + $new_tax_expense;
                }
                else if($purchase_invoice->available_tax_type==2 && $purchase_invoice->tax_status==2)
                {
                    $taxValue = $value->purchase_price / 100 * $value->tax;
                    $sumTax = $taxValue*$value->quantity;
                    $before_shipping_purchase_price = $value->purchase_price ;
                }
            }
            else
            {
                $sumTax = 0;
                $before_shipping_purchase_price = $value->purchase_price ;
            }
            $purchase_detail_table.='<tr>
                                        <th >'.$sno.'</th>
                                        <td class="productimgname">
                                            <a class="product-img">
                                                <img src="'.$pro_image.'" >
                                            </a>
                                            <a href="javascript:void(0);">'.$pro_title.'</a>
                                        </td>
                                        <td> '.$value->purchase_price.'</td>
                                        <td> '.$value->quantity.'</td>
                                        <td> '.$sumTax.'</td>
                                        <td> '.$all_imei.'</td>
                                        <td>'.$warranty_type.'</td>
                                        <td>'.$item_total.'</td>

                                    </tr>';
            $sno++;
        }

        $tax = 0;
        if($purchase_invoice->available_tax_type==1)
        {
            if(!empty($total_tax))
            {
                $tax = $total_tax;
            }
        }
        else if($purchase_invoice->available_tax_type==2 && $purchase_invoice->tax_status==1)
        {
            if(!empty($total_tax))
            {
                $tax = $total_tax;
            }
        }


        // get supplier
        $supplier_name="";
        $supplier_phone="";
        $supplier_email="";
        if ($purchase_invoice)
        {
            // Access the associated supplier
            $supplier = $purchase_invoice->supplier;
            if ($supplier) {
                $supplier_name = $supplier->supplier_name;
                $supplier_phone = $supplier->supplier_phone;
                $supplier_email = $supplier->supplier_email;
            }
        }


        // get payment_deatail
        $payment_paid=0;
        $purchase_payment = Purchase_payment::where('purchase_id', $id)->get();
        $purchase_payment_detail="";
        if($purchase_payment){
            foreach ($purchase_payment as $key => $pay) {
                $payment_paid += $pay->paid_amount;
                $account = Account::where('id', $pay->payment_method)->first();
                $purchase_payment_detail.='<tr>
                                            <td>'.$pay->payment_date.'</td>
                                            <td>'.$account->account_name.'</td>
                                            <td>'.$pay->total_price.'</td>
                                            <td>'.$pay->paid_amount.'</td>
                                            <td>'.$pay->remaining_price.'</td>
                                        </tr>';
            }

        }

        if ($permit_array && in_array('2', $permit_array)) {

            return view('stock.purchase_view', compact('purchase_payment', 'purchase_detail_table',
         'supplier_name', 'supplier_phone', 'supplier_email', 'shipping_cost',
         'payment_paid','payment_remaining','purchase_payment_detail','purchase_invoice',
            'sub_total','total_tax','grand_total','without_shipping_sub_total','sub_total_all', 'permit_array'));
        } else {

            return redirect()->route('home');
        }




    }

    // get_purchase_payment
    public function get_purchase_payment(Request $request){
        $purchase_id = $request->input('id');
        $purchase_bill = Purchase_bill::where('purchase_id', $purchase_id)->first();
        return response()->json(['grand_total' => $purchase_bill->grand_total,'remaining_price' => $purchase_bill->remaining_price,'bill_id' => $purchase_bill->id]);
    }

    // add purchae payment
    public function add_purchase_payment (Request $request){
        // get invoice_no
        $invoice_no = getColumnValue('purchases','id',$request['purchase_id'],'invoice_no');

        // add purchase payment
        $purchase_payment = new Purchase_payment();
        $purchase_payment->purchase_id = $request['purchase_id'];
        $purchase_payment->invoice_no = $invoice_no;
        $purchase_payment->total_price = $request['grand_total'];
        $purchase_payment->paid_amount = $request['paid_amount'];
        $purchase_payment->remaining_price = $request['remaining_price']-$request['paid_amount'];
        $purchase_payment->payment_method = $request['payment_method'];
        $purchase_payment->payment_reference_no = $request['payment_reference_no'];
        $purchase_payment->payment_date = $request['payment_date'];
        $purchase_payment->notes = $request['notes'];
        $purchase_payment->added_by = 'admin';
        $purchase_payment->user_id = '1';
        $purchase_payment->save();


        // update remainin bill
        $purchase_bill = Purchase_bill::where('invoice_no', $invoice_no)->first();
        $purchase_bill->remaining_price = $purchase_bill['remaining_price']-$request['paid_amount'];
        $purchase_bill->save();

        // add account amount
        $account_data = Account::where('id', $request['payment_method'])->first();
        $account_data->opening_balance = $account_data['opening_balance']-$request['paid_amount'];
        $account_data->save();
    }

    //purchase invoice
    public function purchase_invoice($purchase_id) {
        $purchase_data = Purchase::where('id', $purchase_id)->first();
        return view('stock.purchase_invoice', compact('purchase_data'));
    }

    // get_purchase_payment
    public function check_tax_active(Request $request){

        $setting = Settings::where('id', 1)->first();
        if($setting->tax_active==1)
        {
            $tax_active = 1;
        }
        else
        {
            $tax_active = 2;
        }
        return response()->json(['status' => $tax_active]);
    }

}
