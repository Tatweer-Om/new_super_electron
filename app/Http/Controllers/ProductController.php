<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_imei;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        return view('stock.products');
    }
    public function show_product()
    {
        $sno=0;
        $view_product= product::all();
        if(count($view_product)>0)
        {
            foreach($view_product as $value)
            {
                // product_name
                $title=$value->product_name;
                if(!empty($value->product_name_ar))
                {
                    $title=$title=$value->product_name_ar;
                }
                $title='<a  href="'.url('product_detail').'/'.$value->id.'">'.$title.'</a>';

                $modal='';
                $modal.='<a class="me-3 confirm-text text-primary" target="_blank" href="'.url('product_view').'/'.$value->id.'"><i class="fas fa-eye"></i></a>'; 
                if($value->quantity>0)
                {
                    $modal.='<a class="me-3 confirm-text text-success" onclick=get_product_qty("'.$value->id.'")><i class="fab fa-stack-exchange"></i></a>';
                }
                // check remaining
                $category = getColumnValue('categories','id',$value->category_id,'category_name');
                $brand = getColumnValue('brands','id',$value->brand_id,'brand_name');
                $store = getColumnValue('stores','id',$value->store_id,'store_name');
                $supplier = getColumnValue('suppliers','id',$value->supplier_id,'supplier_name');
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $title,
                            $value->barcode,
                            $category,
                            $brand,
                            $store,
                            $value->quantity,
                            $value->sale_price,
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

    //product view
    public function product_view($id){
        
        $product_view = Product::where ('id', $id)->first();
        return view ('stock.product_view', compact('product_view'));

    } 

    // get_product_qty
    public function get_product_qty(Request $request){
        $id = $request->input('id');
        $product = Product::where('id', $id)->first();
        $qty_div="";
        if ($product->quantity<=0) {
            return response()->json(['qty_status' => 2, 'qty_div' => ""]);
        }
        else
        {
            if($product->check_imei==1)
            {
                $qty_div.='<input type="hidden" class="product_id" name="product_id" value="'.$id.'" >
                <input type="hidden" name="stock_type" value="2" ><div class="row">';
                $product_imei = Product_imei::where('barcode', $product->barcode)->get();
                foreach ($product_imei as $key => $imei) {
                    $qty_div.='<div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input all_imeis" name="all_imeis[]" type="checkbox" value="'.$imei->id.'" id="'.$imei->imei.'">
                                            <label class="form-check-label" for="'.$imei->imei.'">
                                                '.$imei->imei.'
                                            </label> 
                                        </div>
                                    </div>
                                </div>';
                }
                $qty_div.='</div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>'.trans('messages.reason_lang', [], session('locale')).'</label>
                                    <textarea  class="form-control reason" rows="3" name="reason"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 submit_form">'.trans('messages.submit_lang', [], session('locale')).'</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">'.trans('messages.cancel_lang', [], session('locale')).'</a>
                        </div>';
            }
            else
            {
                $qty_div.='<input type="hidden" class="product_id" name="product_id" value="'.$id.'" >
                <input type="hidden" name="stock_type" value="1" ><div class="row"> 
                            <div class="col-lg-3 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>'.trans('messages.current_qty_lang', [], session('locale')).'</label>
                                    <input class="form-control current_qty" name="current_qty" readonly value="'.$product->quantity.'">
                                </div> 
                            </div> 
                            <div class="col-lg-3 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>'.trans('messages.damage_qty_lang', [], session('locale')).'</label>
                                    <input class="form-control damage_qty" name="damage_qty"  value="">
                                </div> 
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>'.trans('messages.reason_lang', [], session('locale')).'</label>
                                    <textarea  class="form-control reason" rows="3" name="reason"></textarea>
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 submit_form">'.trans('messages.submit_lang', [], session('locale')).'</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">'.trans('messages.cancel_lang', [], session('locale')).'</a>
                        </div>';
            }
            return response()->json(['qty_status' => 1, 'qty_div' => $qty_div]);
        }
    }
    // 

    // add damage qty
    public function add_damage_qty (Request $request){

        $reason = $request['reason'];
        $product_id = $request['product_id'];

        // get product data
        $product_data = Product::where ('id', $id)->first();

        if($request['stock_type']==1)
        {
            $current_qty = $request['current_qty'];
            $damage_qty = $request['damage_qty'];
            $new_qty = $current_qty - $damage_qty;
            // product qty history
            $product_qty_history = new Product_qty_history();

            $product_qty_history->order_no ="";
            $product_qty_history->product_id =$product_id;
            $product_qty_history->barcode=$product_data->barcode;
            $product_qty_history->source='damage';
            $product_qty_history->type=2;
            $product_qty_history->previous_qty=$current_qty;
            $product_qty_history->given_qty=$damage_qty;
            $product_qty_history->new_qty=$new_qty;
            $product_qty_history->added_by = 'admin';
            $product_qty_history->user_id = '1';
            $product_qty_history->save();

            $product_data->quantity=$new_qty; 
            $product_data->save();

        }
        else
        {
            $all_imeis = $request['all_imeis'];
        }
    }
    // 
}
