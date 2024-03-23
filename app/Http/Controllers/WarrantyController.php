<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Warranty;
use App\Models\Product_imei;
use Illuminate\Http\Request;
use App\Models\PosOrderDetail;

class WarrantyController extends Controller
{
    public function index()
    {


        return view('warranty.warranty');


    }

    public function warranty_products(Request $request)
    {
        $order_id = $request->input('order_id');
        $order_data = PosOrderDetail::where('order_id', $order_id)->get();

        $response = [];

        if ($order_data->isNotEmpty()) {
            $product_data = [];
            $sno = 0;
            $status = 0;

            foreach ($order_data as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    if ($product->warranty_days) {
                        $title = !empty($product->product_name_ar) ? $product->product_name_ar : $product->product_name;
                        $product_id = $product->id;
                        $imeis= $detail->item_imei;
                        $invoice_no = $detail->order_id;
                        $barcode = $detail->item_barcode;
                        $price = $detail->item_price;
                        $quantity = $detail->item_quantity;
                        $total = $detail->item_total;
                        $warranty_type = $product->warranty_type;
                        if ($warranty_type == 1) {
                            $warranty_type = 'Shop';
                        } elseif ($warranty_type == 2) {
                            $warranty_type = 'Agent';
                        } else {
                            $warranty_type = 'None';
                        }

                        $customer_id1 = $detail->customer_id;
                        $warranty_days = $product->warranty_days;
                        $created_by = $detail->added_by;
                        $created_at = $detail->created_at;



                        $id = $detail->id;
                        $customer_id =  $customer_id1 ;
                        $id_product =  $product_id ;
                        $warratny_type_hidden =  $warranty_type;
                        $warranty_days_hidden =  $warranty_days;


                        $sno++;
                        $product_data[] = [
                            $sno,
                            $invoice_no,
                            $title,
                            $imeis,
                            $barcode,
                            'OMR ' . $price,
                            $quantity . ' item',
                            'OMR ' . $total,
                            $warranty_type . ' : ' . $warranty_days . ' days',
                            $created_by,
                            $created_at->format('d-m-Y'),
                            '<span class="hidden-data">' . $id . '</span>',
                            '<span class="hidden-data">' . $customer_id . '</span>',
                            '<span class="hidden-data">' . $id_product . '</span>',
                            '<span class="hidden-data">' . $warratny_type_hidden . '</span>',
                            '<span class="hidden-data">' . $warranty_days_hidden . '</span>',

                        ];
                    } else {
                        return response()->json(['status' => 1]);
                    }
                }
                $response['success'] = true;
                $response['aaData'] = $product_data;
            }
        } else {
            return response()->json(['status' => 1]);
            $response['success'] = false;
            $response['message'] = 'No data found.';
            $response['aaData'] = [];
        }

        return response()->json($response);
    }

    public function warranty_list(Request $request)
    {
        $customer_id = $request->input('customer_id');

        $product_ids = json_decode($request->input('product_id'));
        $item_barcodes = json_decode($request->input('barcode'));
        $quantities = json_decode($request->input('quantity'));
        $purchase_prices = json_decode($request->input('purchase_price'));
        $total_prices = json_decode($request->input('total_price'));
        $warranty_days_hidden = json_decode($request->input('warranty_days_hidden'));
        $warranty_type_hidden = json_decode($request->input('warranty_type_hidden'));
        $item_imei = json_decode($request->input('item_imei'));


        foreach ($product_ids as $index => $product_id) {
            $warranty_data = new Warranty();

            $warranty_data->product_id = $product_id;
            $warranty_data->customer_id=  $customer_id;
            $warranty_data->item_barcode = $item_barcodes[$index];
            $warranty_data->quantity = $quantities[$index];
            $warranty_data->purchase_price = $purchase_prices[$index];
            $warranty_data->total_price = $total_prices[$index];
            $warranty_data->item_imei = $item_imei[$index];
            $warranty_data->warranty_type = $warranty_type_hidden[$index];
            $warranty_data->warranty_days = $warranty_days_hidden[$index];
            $warranty_data->user_id = '1';
            $warranty_data->save();
        }

        return response()->json(['status' => 1]);
    }




//warranty_Card

    public function warranty_card(Request $request)
{
    $warranty_id = $request->input('warranty_id');
    $warranty_data = Warranty::where('id', $warranty_id)->get();

    $response = [];

    if ($warranty_data->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'No data found.', 'aaData' => []]);
    }

    $sno = 0;
    $data = [];

    foreach ($warranty_data as $warranty) {
        $sno++;

        $product_name = getColumnValue('products', 'id', $warranty->product_id, 'product_name');
        $customer_name = getColumnValue('customers', 'id', $warranty->customer_id, 'customer_name');

        $card_id = $warranty->id;
        $customer_id = $warranty->customer_id;
        $card_price = $warranty->purchase_price;
        $card_quantity = $warranty->quantity;
        $card_imei = $warranty->item_imei;
        $card_warranty_type = $warranty->warranty_type;
        $card_warranty_days = $warranty->warranty_days;
        $months_warranty = ceil($card_warranty_days / 30);
        $card_date = $warranty->created_at->format('Y-m-d');

        $currentDate = new DateTime();
        $currentDate->add(new DateInterval('P' . $card_warranty_days . 'D'));
        $validityDate = $currentDate->format('Y-m-d');

        $data[] = [

            'card_id' => $card_id,
            'product_name' => $product_name,
            'card_imei' => $card_imei,
            'customer_name' => $customer_name,
            'card_price' => $card_price,
            'card_quantity' => $card_quantity,
            'card_warranty_type' => $card_warranty_type,
            'months_warranty' => $months_warranty,
            'card_date' => $card_date,
            'validityDate' => $validityDate,
            'customer_id'=>$customer_id,

        ];
    }

    $response['success'] = true;
    $response['aaData'] = $data;

    return response()->json($response);
}

}
