<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pos_Order;
use Illuminate\Http\Request;
use App\Models\Pos_Order_Detail;

class OrderController extends Controller
{


    public function pos_order(Request $request)
    {

        $customerId = $request->input('customerId');


        $orderData = json_decode($request->input('orderData'));
        $product_barcode = $orderData->product_barcode;
        $product = Product::where('barcode', $product_barcode)->first();
        $store_id = null;
        if ($product) {
            $store_id = $product->store_id; }

        $pos_order = new Pos_Order();

        $pos_order->customer_id= $customerId;
        $pos_order->store_id= $store_id;
        $pos_order->item_count = $orderData->quantity;
        $pos_order->product_barcode = $orderData->product_barcode;
        $pos_order->total_amount = $orderData->grand_total;
        $pos_order->total_tax = $orderData->total_tax;
        $pos_order->total_discount = $orderData->grand_discount;
        $pos_order->cash_back = $orderData->cash_back;
        $pos_order->paid_amount = $orderData->cash_payment;

        $pos_order->discount_type= 1;
        $pos_order->return_status= 1;
        $pos_order->user_id= 1;
        $pos_order->discount_by= 'admin';
        $pos_order->notes= 'admin';
        $pos_order->added_by= 'admin';

        $pos_order->save();
        if ($pos_order->save()) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 2]);
        }


    }


}

