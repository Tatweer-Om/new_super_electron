<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Product_imei;
use Illuminate\Http\Request;
use App\Models\PosOrderDetail;
use App\Models\Warranty;

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
                        $imeis = Product_imei::where('barcode', $product->barcode)->distinct()->pluck('imei')->toArray();
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

                        $customer_id = $detail->customer_id;
                        $warranty_days = $product->warranty_days;

                        $created_by = $detail->added_by;
                        $created_at = $detail->created_at;



                        $id = '<td class="d-none"> ' . $detail->id . ' </td>';
                        $id_customer = '<td class="d-none"> ' . $customer_id . ' </td>';
                        $id_product = '<td class="d-none"> ' . $product_id . ' </td>';



                        $sno++;
                        $product_data[] = [
                            $sno,
                            $invoice_no,
                            $title,
                            implode(', ', $imeis),
                            $barcode,
                            'OMR ' . $price,
                            $quantity . ' item',
                            'OMR ' . $total,
                            $warranty_type . ' : ' . $warranty_days . ' days',
                            $created_by,
                            $created_at->format('d-m-Y'),
                            $id,
                            $id_customer,
                            $id_product,

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

        // Decode JSON inputs
        $product_ids = json_decode($request->input('product_id'));
        $item_barcodes = json_decode($request->input('barcode'));
        $quantities = json_decode($request->input('quantity'));
        $purchase_prices = json_decode($request->input('purchase_price'));
        $total_prices = json_decode($request->input('total_price'));
        $warranties = json_decode($request->input('warranty'));

        foreach ($product_ids as $index => $product_id) {
            $warranty_data = new Warranty();

            $warranty_data->product_id = $product_id;
            $warranty_data->item_barcode = $item_barcodes[$index];
            $warranty_data->quantity = $quantities[$index];
            $warranty_data->purchase_price = $purchase_prices[$index];
            $warranty_data->total_price = $total_prices[$index];
            $warranty_data->warranty = $warranties[$index];
            $warranty_data->user_id = 'admin';
            $warranty_data->save();
        }

        return response()->json(['status' => 1]);
    }

}
