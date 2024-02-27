<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function save_order(Request $request){

        $order= new Order();
        $order->product_quantity=$request->input('product_quantity');
        $order->product_barcode=$request->input('product_barcode');
        $order->product_total=$request->input('product_total');
        $order->product_discount=$request->input('product_discount');
        $order->product_tax=$request->input('product_tax');
        $order->sub_total=$request->input('sub_total');
        $order->total_discount=$request->input('total_discount');
        $order->total_tax=$request->input('total_tax');
        $order->grand_total=$request->input('grand_total');
        $order->payment_method=$request->input('payment_method');
        $order->payment_reference_no=$request->input('payment_reference_no');
        $order->added_by=$request->input('admin');
        $order->user_id=$request->input('1');
        $order->bulk_quantity=$request->input('bulk_quantity');
        $order->bulk_price=$request->input('bulk_price');
        $order->save();
        return response()->json(['success' => trans('messages.order_added_success_lang', [], session('locale'))]);
    }
}

