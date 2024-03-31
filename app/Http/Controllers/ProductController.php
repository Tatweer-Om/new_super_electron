<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_imei;
use App\Models\Product_qty_history;

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
                if(empty($title))
                {
                    $title=$value->product_name_ar;
                }
                $title='<a  href="'.url('product_detail').'/'.$value->id.'">'.$title.'</a>';

                $modal='';
                $modal.='<a class="me-3 confirm-text text-primary" target="_blank" href="'.url('product_view').'/'.$value->id.'"><i class="fas fa-eye"></i></a>';
                // qty button
                if($value->quantity>0)
                {
                    $modal.='<a class="me-3 confirm-text text-success" onclick=get_product_qty("'.$value->id.'")><i class="fab fa-stack-exchange"></i></a>';
                }

                // damage undo button
                $product_qty_history_count = Product_qty_history::where('product_id', $value->id)
                                                                ->where('source', 'damage')
                                                                ->where('status', 1)
                                                                ->count();
                if($product_qty_history_count>0)
                {
                    $modal.='<a class="me-3 confirm-text text-danger" onclick=undo_damage_product("'.$value->id.'")><i class="fas fa-undo"></i></a>';
                }
                //

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
        $category = getColumnValue('categories','id',$product_view->category_id,'category_name');
        $brand = getColumnValue('brands','id',$product_view->brand_id,'brand_name');
        $store = getColumnValue('stores','id',$product_view->store_id,'store_name');
        $supplier = getColumnValue('suppliers','id',$product_view->supplier_id,'supplier_name');

        // product type
        if($product_view->product_type==1)
        {
            $product_type=trans('messages.retail_lang', [], session('locale'));
        }
        else
        {
            $product_type=trans('messages.spare_parts_lang', [], session('locale'));
        }

        // warranty type
        if($product_view->warranty_type==1)
        {
            $warranty_type=trans('messages.shop_lang', [], session('locale'))." : ".$product_view->warranty_days." ".trans('messages.days_lang', [], session('locale'));
        }
        else if($product_view->warranty_type==2)
        {
            $warranty_type=trans('messadays_lang', [], session('locale'))." : ".$product_view->warranty_days." ".trans('messages.days_lang', [], session('locale'));
        }
        else if($product_view->warranty_type==3)
        {
            $warranty_type=trans('messages.none_lang', [], session('locale'));
        }
        return view ('stock.product_view', compact('product_view','category','brand','store','supplier'
                    ,'product_type','warranty_type'));

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
                <input type="hidden" name="stock_type" class="stock_type" value="2" ><div class="row">';
                $product_imei = Product_imei::where('barcode', $product->barcode)->get();
                $uniqueImeis = [];
                foreach ($product_imei as $key => $imei) {
                    if (!in_array($imei->imei, $uniqueImeis)) {

                        $qty_div.='<div class="col-md-2 col-6">
                                    <label class="checkboxs">
                                        <input type="checkbox" class="all_imeis" name="all_imeis[]" value="'.$imei->id.'" id="'.$imei->id.'_qty">
                                        <span class="checkmarks" for="'.$imei->id.'_qty"></span>'.$imei->imei.'
                                    </label>
                                </div> ';
                                $uniqueImeis[] = $imei->imei;
                    }
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
                <input type="hidden" name="stock_type" class="stock_type" value="1" ><div class="row">
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
    public function add_damage_qty (Request $request)
    {

        $reason = $request['reason'];
        $product_id = $request['product_id'];

        // get product data
        $product_data = Product::where ('id', $product_id)->first();

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
            $product_qty_history->notes=$reason;
            $product_qty_history->added_by = 'admin';
            $product_qty_history->user_id = '1';
            $product_qty_history->save();

            // update qty
            $product_data->quantity=$new_qty;
            $product_data->save();
        }
        else
        {
            $total_qty=0;
            $all_in_one="";
            $all_imeis = $request['all_imeis'];
            for ($i=0; $i < count($all_imeis) ; $i++) {

                $imei_data = Product_imei::where('id', $all_imeis[$i])->first();
                if($i==count($all_imeis)-1)
                {
                    $all_in_one.=$imei_data['imei'];
                }
                else
                {
                    $all_in_one.=$imei_data['imei'].', ';
                }

                // delete iemi
                if ($imei_data) {
                    $imei_data->delete();
                }
            }

            $current_qty = $product_data['quantity'];
            $damage_qty = count($all_imeis);
            $new_qty = $current_qty - $damage_qty;

            // product qty history
            $product_qty_history = new Product_qty_history();

            $product_qty_history->order_no ="";
            $product_qty_history->product_id =$product_id;
            $product_qty_history->barcode=$product_data->barcode;
            $product_qty_history->imei=$all_in_one;
            $product_qty_history->source='damage';
            $product_qty_history->type=2;
            $product_qty_history->previous_qty=$current_qty;
            $product_qty_history->given_qty=$damage_qty;
            $product_qty_history->new_qty=$new_qty;
            $product_qty_history->notes=$reason;
            $product_qty_history->added_by = 'admin';
            $product_qty_history->user_id = '1';
            $product_qty_history->save();

            // update qty

            $product_data->quantity=$new_qty;
            $product_data->save();
        }
    }
    //

    // get_product_qty
    public function undo_damage_product(Request $request){
        $id = $request->input('id');
        // product data
        $product_data = Product::where('id', $id)->first();

        $product_qty_history = Product_qty_history::where('product_id', $id)
                                         ->where('source', 'damage')
                                         ->where('status', 1)
                                         ->get();

        $qty_div="";
        if (count($product_qty_history)<0) {
            return response()->json(['qty_status' => 2, 'qty_div' => ""]);
        }
        else
        {
            $qty_div.='<div class="row">
                        <div class="col-lg-1 col-sm-6 col-12 pb-5">
                            <label class="checkboxs">
                                <input type="checkbox" class="all_damge_requests" id="all_damage_request">
                                <span class="checkmarks" for="all_damage_request"></span>
                            </label>
                        </div>

                        <div class="col-lg-5 col-sm-6 col-6">
                            <div class="form-group">
                                <label>'.trans('messages.imei_lang', [], session('locale')).'</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-6">
                            <div class="form-group">
                                <label>'.trans('messages.current_qty_lang', [], session('locale')).'</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-6">
                            <div class="form-group">
                                <label>'.trans('messages.damage_qty_lang', [], session('locale')).'</label>
                            </div>
                        </div>
                    </div>';
            foreach ($product_qty_history as $key => $qty_history) {
                $damage_imei="";
                if(!empty($qty_history->imei))
                {
                    $imeis=explode(',', $qty_history->imei);
                    for ($i=0; $i < count($imeis) ; $i++) {
                        $damage_imei.="<span class='badges bg-lightgreen'>".$imeis[$i]."</span> ";
                    }
                    $stk_type='<input type="hidden" name="stock_type" class="undo_stock_type" value="2" >';
                }
                else
                {
                    // product_name
                    $product_name = getColumnValue('products','id',$product_data->id,'product_name');
                    $product_name_ar = getColumnValue('products','id',$product_data->id,'product_name_ar');
                    $title=$product_name;
                    if(empty($title))
                    {
                        $title=$product_name_ar;
                    }
                    $damage_imei.="<span class='badges bg-lightgreen'>".$title."</span> ";
                    $stk_type='<input type="hidden" name="stock_type" class="undo_stock_type" value="1" >';
                }
                $qty_div.='<input type="hidden" class="product_id" name="product_id" value="'.$id.'" >
                            '.$stk_type.'
                            <div class="row">
                                <div class="col-md-1 col-6">
                                    <label class="checkboxs">
                                        <input type="checkbox" class="single_damage_qty" name="all_damge_requests[]" type="checkbox" value="'.$qty_history->id.'" id="'.$qty_history->id.'_qty">
                                        <span class="checkmarks" for="'.$qty_history->id.'_qty"></span>
                                    </label>
                                </div>
                                <div class="col-lg-5 col-sm-6 col-6">
                                    <div class="form-group">
                                        '.$damage_imei.'
                                     </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-6">
                                    <div class="form-group">
                                        <input class="form-control undo_current_qty" name="undo_current_qty" readonly value="'.$product_data->quantity.'">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-6">
                                    <div class="form-group">
                                        <input class="form-control undo_damage_qty" value="'.$qty_history->given_qty.'" readonly name="undo_damage_qty">
                                    </div>
                                </div>
                            </div>';
            }
            $qty_div.='<div class="row">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>'.trans('messages.reason_lang', [], session('locale')).'</label>
                                    <textarea  class="form-control undo_reason" rows="3" name="reason"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 submit_form">'.trans('messages.submit_lang', [], session('locale')).'</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">'.trans('messages.cancel_lang', [], session('locale')).'</a>
                        </div>';

            return response()->json(['qty_status' => 1, 'qty_div' => $qty_div]);
        }
    }
    //

    // add undo damage qty
    public function add_undo_damage_qty (Request $request)
    {

        $reason = $request['reason'];
        $all_damge_requests = $request['all_damge_requests'];

        // undo damage items
        for ($i=0; $i < count($all_damge_requests) ; $i++) {
            // get product qty data
            $product_qty_history = Product_qty_history::where('id', $all_damge_requests[$i])->first();
            // get product data
            $product_data = Product::where ('id', $product_qty_history->product_id)->first();

            if(empty($product_qty_history->imei))
            {
                $current_qty = $product_data->quantity;
                $damage_qty = $product_qty_history->given_qty;
                $new_qty = $current_qty + $damage_qty;
                // product qty history
                $product_qty_history_save = new Product_qty_history();

                $product_qty_history_save->order_no ="";
                $product_qty_history_save->product_id =$product_qty_history->product_id;
                $product_qty_history_save->barcode=$product_data->barcode;
                $product_qty_history_save->source='undo_damage';
                $product_qty_history_save->type=1;
                $product_qty_history_save->previous_qty=$current_qty;
                $product_qty_history_save->given_qty=$damage_qty;
                $product_qty_history_save->new_qty=$new_qty;
                $product_qty_history_save->notes=$reason;
                $product_qty_history_save->added_by = 'admin';
                $product_qty_history_save->user_id = '1';
                $product_qty_history_save->save();

                // update qty
                $product_data->quantity=$new_qty;
                $product_data->save();
            }
            else
            {
                $current_qty = $product_data->quantity;
                $damage_qty = $product_qty_history->given_qty;
                $new_qty = $current_qty + $damage_qty;
                // product qty history
                $product_qty_history_save = new Product_qty_history();

                $product_qty_history_save->order_no ="";
                $product_qty_history_save->product_id = $product_qty_history->product_id;
                $product_qty_history_save->barcode= $product_data->barcode;
                $product_qty_history_save->imei= $product_qty_history->imei;
                $product_qty_history_save->source= 'undo_damage';
                $product_qty_history_save->type= 1;
                $product_qty_history_save->previous_qty= $current_qty;
                $product_qty_history_save->given_qty= $damage_qty;
                $product_qty_history_save->new_qty= $new_qty;
                $product_qty_history_save->notes=$reason;
                $product_qty_history_save->added_by = 'admin';
                $product_qty_history_save->user_id = '1';
                $product_qty_history_save->save();

                // update qty
                $product_data->quantity=$new_qty;
                $product_data->save();

                // add imei
                $all_imeis = $product_qty_history->imei;
                $undo_imeis = explode(',' , $all_imeis);
                for ($i=0; $i < count($undo_imeis) ; $i++) {

                    // add imei
                    $product_imei = new Product_imei();

                    $product_imei->product_id=$product_qty_history->product_id;
                    $product_imei->barcode=$product_data->barcode;
                    $product_imei->imei=$undo_imeis[$i];
                    $product_imei->added_by = 'admin';
                    $product_imei->user_id = '1';
                    $product_imei->save();
                }

            }
            // update histoy table
            $product_qty_history->status=2;
            $product_qty_history->save();
        }
    }
    //

    // qty audit report
    public function qty_audit(Request $request)
    {
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $product_id = "";
        if($request['start_date'])
        {
            $start_date = $request['start_date'];
        }
        if($request['end_date'])
        {
            $end_date = $request['end_date'];
        }
        if($request['product_id'])
        {
            $product_id = $request['product_id'];
        }
        $product= product::all();
        return view('stock.qty_audit', compact('product', 'start_date' , 'end_date' , 'product_id'));
    }


    // show qty audit
    public function show_qty_audit(Request $request)
    {
        $sno=0;

        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $product_id = "";
        if($request['start_date'])
        {
            $start_date = $request['start_date'];
        }
        if($request['end_date'])
        {
            $end_date = $request['end_date'];
        }
        if($request['product_id'])
        {
            $product_id = $request['product_id'];
        }

        $query = Product_qty_history::whereDate('created_at', '>=', $start_date)
                                    ->whereDate('created_at', '<=', $end_date);
         if (!empty($product_id)) {
            $query->where('product_id', $product_id);
        }
        $product_qty_history = $query->orderBy('id')->get();


        if(count($product_qty_history)>0)
        {
            foreach($product_qty_history as $value)
            {
                // product_name
                $product_name = getColumnValue('products','id',$value->product_id,'product_name');
                $product_name_ar = getColumnValue('products','id',$value->product_id,'product_name_ar');
                $title=$product_name;
                if(empty($product_name_ar))
                {
                    $title=$product_name_ar;
                }
                $title='<a  href="'.url('product_detail').'/'.$value->id.'">'.$title.'</a>';
                // source
                if ($value->source == "purchase") {
                    $source = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.purchase_lang', [], session('locale')) . "</span>";
                } else if ($value->source == "damage") {
                    $source = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.damage_lang', [], session('locale')) . "</span>";
                } else if ($value->source == "undo_damage") {
                    $source = "<span class='badges bg-lightgreen'>" . trans('messages.revert_damage_lang', [], session('locale')) . "</span>";
                }

                // Qty type
                if ($value->type == 1) {
                    $stock_type = "<span class='text text-success'><b>" . trans('messages.in_lang', [], session('locale')) . "</b></span>";
                } else if ($value->type == 2) {
                    $stock_type = "<span class='text text-danger'><b>" . trans('messages.out_lang', [], session('locale')) . "</b></span>";
                }



                // tim date
                $data_time=get_date_time($value->created_at);
                $sno++;
                $json[]= array(
                            $value->order_no,
                            $title,
                            $value->barcode,
                            $value->imei,
                            $value->previous_qty,
                            $value->given_qty." ".$stock_type,
                            $value->new_qty,
                            $source,
                            $value->notes,
                            $value->added_by,
                            $data_time,
                            $value->id,
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

    // product barcode
    //product view
    public function product_barcode($id){

        $product_view = Product::where ('id', $id)->first();
        $category = getColumnValue('categories','id',$product_view->category_id,'category_name');
        $brand = getColumnValue('brands','id',$product_view->brand_id,'brand_name');
        $store = getColumnValue('stores','id',$product_view->store_id,'store_name');
        $supplier = getColumnValue('suppliers','id',$product_view->supplier_id,'supplier_name');
        $title = "";
        $barcode = "";
        if(!empty($product_view))
        {
            $title = $product_view->product_name;
            if(empty($title))
            {
                $title = $product_view->product_name_ar;
            }
            $barcode = $product_view->barcode;
        }
        return view ('stock.product_barcode', compact('barcode','title'));

    }

}
