<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\Account;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Workplace;
use App\Models\University;
use Illuminate\Http\Request;
use App\Models\PosOrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class RepairingController extends Controller
{
    public function index (){

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();
        $orders = PosOrder::latest()->take(15)->get();
        $categories = Category::all();
        $count_products = Product::all()->count();
        // account
        $view_account = Account::where('account_type', 1)->get();
        return view ('maintenance.repairing', compact('categories', 'count_products', 'active_cat', 'universities', 'workplaces' , 'view_account', 'orders'));
    }


    //customer details

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

  // customer autocomplte
  public function customer_auto(Request $request)
  {
      $term = $request->input('term');

      $customers = Customer::where('id', $term)
      ->orWhere('national_id', $term)
      ->orWhere('customer_name', 'like', "%{$term}%")
      ->orWhere('customer_phone', 'like', "%{$term}%")
      ->get(['id', 'national_id', 'customer_name', 'customer_phone']);


      $response = [];
      foreach ($customers as $customer) {
          $label = $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')';
          if (!empty($customer->national_id)) {
              $label .= ' - ' . $customer->national_id;
          }

          $response[] = [
              'label' => $label,
              'value' => $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
              'phone' => $customer->customer_phone,
              'national_id' => $customer->national_id,
          ];
      }

      return response()->json($response);
  }

  //warranty_auto_complete
  public function warranty_auto(Request $request){


        $term = $request->input('term');

        try {

            $warranties = Warranty::where('id', 'like', "%{$term}%")
                ->orWhere('item_imei', 'like', "%{$term}%")
                ->orWhere('item_barcode', 'like', "%{$term}%")
                ->limit(10)
                ->get(['id', 'item_imei']);


            $response = $warranties->map(function ($warranty) {
                return [
                    'label' => $warranty->id . ':' . $warranty->item_imei,
                    'value' => $warranty->id . ':' . $warranty->item_imei,
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {

            Log::error('Error fetching warranty data: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while fetching warranty data. Please try again later.'], 500);
        }

    }

//repairing_products

public function repairing_products(Request $request)
{
    $customer_id = $request->input('customer_id');
    $order_data = PosOrderDetail::where('customer_id', $customer_id)->get();

    $response = [];

    if ($order_data->isNotEmpty()) {
        $product_data = [];
        $sno = 0;
        $status = 0;

        foreach ($order_data as $detail) {
            $product = Product::find($detail->product_id);
            $customer= Customer::find($detail->customer_id);
            $custmore_name= $customer->customer_name;

            if ($product) {

                if ($product->warranty_days) {

                $image = $product->stock_image ? asset('images/product_images/' . $product->stock_image) : asset('images/dummy_image/no_image.png');
                $title = !empty($product->product_name_ar) ? $product->product_name_ar : $product->product_name;
                // $imeis = Product_imei::where('barcode', $product->barcode)->distinct()->pluck('imei')->toArray();
                $invoice_no = $detail->order_id;
                $barcode = $detail->item_barcode;
                $quantity = $detail->item_quantity;
                $id_product= $product->id;
                $item_price = $detail->item_price;
                $imeis= $detail->item_imei;
                $warranty_type = $product->warranty_type;
                if ($warranty_type == 1) {
                    $warranty_type = 'Shop';
                } elseif ($warranty_type == 2) {
                    $warranty_type = 'Agent';
                } else {
                    $warranty_type = 'None';
                }



                $warranty_days = $product->warranty_days;
                $warranty_end_date = Carbon::now()->addDays($warranty_days);
                $remaining_warranty = Carbon::now()->diffInDays($warranty_end_date);
                $status_badge = '';

                $currentDate = new DateTime();
                $currentDate->add(new DateInterval('P' . $warranty_days . 'D'));
                $validity = $currentDate->format('Y-m-d');

                if ($remaining_warranty > 0) {
                    $status_badge = '<span class="badges status-badge">' . $remaining_warranty . ' days</span>';
                }
                else{
                    $status_badge = '<span class="badges unstatus-badge">' . $remaining_warranty . ' days</span>';
                }


                $created_by = $detail->added_by;
                $created_at = $detail->created_at;

                $image2='<img src="' . $image . '" alt="' . $title . '" style="max-width: 60px; max-height: 70px;"> ';

                $sno++;
                $product_data[] = [

                    $title. $image2 ,
                    $imeis,
                    $barcode,
                   'OMR '. $item_price,
                    $created_at->format('d-m-Y'),
                    $warranty_type . ' : ' . $warranty_days . ' days',
                    $status_badge,
                    $invoice_no,
                    '<span class="hidden-data">' . $validity . '</span>',
                    '<span class="hidden-data">' . $id_product . '</span>',


                ];
            }
            else {
                return response()->json(['status' => 1]);
            }
        }
        }
        $response['success'] = true;
        $response['aaData'] = $product_data;

    }
     else {
        return response()->json(['status' => 1]);
        $response['success'] = false;
        $response['message'] = 'No data found.';
        $response['aaData'] = [];
    }

    return response()->json($response);
}




//warranty_card_auto

public function repair_data(){

return view('maintenance.repair_data');
}

public function product_status(){

    return view('maintenance.product_status');
    }

}



