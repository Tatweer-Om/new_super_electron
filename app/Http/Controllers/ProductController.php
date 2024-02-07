<?php

namespace App\Http\Controllers;

use App\Models\Product;

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
                $modal.='<a class="me-3 confirm-text text-primary" target="_blank" href="'.url('product_view').'/'.$value->id.'"><i class="fas fa-eye"></i>
                    </a>'; 

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
}
