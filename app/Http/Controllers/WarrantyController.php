<?php

namespace App\Http\Controllers;

use App\Models\PosOrderDetail;
use App\Models\Product;
use App\Models\Product_imei;
use Illuminate\Http\Request;

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

                $warranty_days = $product->warranty_days;

                $created_by = $detail->added_by;
                $created_at = $detail->created_at;
            //     $checkbox = '<td>
            //     <label class="checkboxs">
            //         <input type="checkbox" class="select-checkbox">
            //         <span class="checkmarks"></span>
            //     </label>
            // </td>';


                $sno++;
                $product_data[] = [
                    $sno,
                    $invoice_no,
                    $title,
                    implode(', ', $imeis),
                    $barcode,
                    $price,
                    $quantity,
                    $total,
                    $warranty_days . ' days',
                    $warranty_type,
                    $created_by,
                    $created_at->format('d-m-Y'),
                    $detail->id,
                ];
            }
            else {
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


//warranty_list

public function warranty_list(Request $request){


}
}
