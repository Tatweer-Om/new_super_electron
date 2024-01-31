<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Purchase_detail;
use App\Models\Supplier;
use App\Models\Purchase_imei;
use App\Models\Purchase_bill;
use App\Models\Product_imei;
use App\Models\Product_qty_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index (){


    }
    public function product (){

        $supplier= Supplier::all();
        $category= Category::all();
        $brands= Brand::all();
        $stores= Store::all();
        return view('stock.product', compact('supplier', 'brands', 'category','stores'));
    }
    public function get_selected_new_data()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $brands = Brand::all();
        $stores = Store::all();

        $sup_option = '<option value="">Choose...</option>';
        foreach ($supplier as $sup) {
            $sup_option .= '<option value="'.$sup->supplier_id.'">'.$sup->supplier_name.'</option>';
        }

        $cat_option = '<option value="">Choose...</option>';
        foreach ($category as $cat) {
            $cat_option .= '<option value="'.$cat->category_id.'">'.$cat->category_name.'</option>';
        }

        $bra_option = '<option value="">Choose...</option>';
        foreach ($brands as $bra) {
            $bra_option .= '<option value="'.$bra->brand_id.'">'.$bra->brand_name.'</option>';
        }

        $sto_option = '<option value="">Choose...</option>';
        foreach ($stores as $sto) {
            $sto_option .= '<option value="'.$sto->store_id.'">'.$sto->store_name.'</option>';
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

        $product = new Product();
        // $store->product_id = genUuid() . time();
        // purchase detail
        $invoice_no = $request['invoice_no'];
        $supplier_id = $request['supplier_id_stk'];
        $purchase_date = $request['purchase_date'];
        $shipping_cost = $request['shipping_cost'];
        $total_price = $request['total_price'];
        $total_tax = $request['total_tax'];
        $purchase_description = $request['purchase_description'];
        // stock detail
        $category_id = $request['category_id_stk'];
        $store_id = $request['store_id_stk'];
        $brand_id = $request['brand_id_stk'];
        $product_name = $request['product_name'];
        $product_name_ar = $request['product_name_ar'];
        $barcode = $request['barcode'];
        $purchase_price = $request['purchase_price'];
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
        $purchase->total_tax=$total_tax;
        $purchase->description=$purchase_description;
        $purchase->receipt_file=$purchase_receipt;
        $purchase->added_by = 'admin';
        $purchase->user_id = '1';
        $purchase->save();
        $purchase_id = $purchase->id;

        // add purchase detail and products
        $purchase_detail = new Purchase_detail();
        $product = new Product();
        


        $total_products=count($category_id);
        $single_product_shipping=0;
        if(!empty($shipping_cost))
        {
            $single_product_shipping=$shipping_cost/$total_products;
        }

        for ($i=0; $i <count($category_id) ; $i++) {
            
            $imeicheckValue = request()->has('imei_check'.$i) ? 1 : 0;

             // add products
             $product_ids=genUuid() . time().$i;
             $product_image="";
             if ($request->hasFile('stock_image_'.$i)) {
                 $folderPath = public_path('images/product_images');
 
                 // Check if the folder doesn't exist, then create it
                 if (!File::isDirectory($folderPath)) {
                     File::makeDirectory($folderPath, 0777, true, true);
                 }
                 $product_image = time() . '.' . $request->file('stock_image_'.$i)->extension();
                 $request->file('stock_image_'.$i)->move(public_path('images/product_images'), $product_image);
             }
             $wholeSaleValue = request()->has('whole_sale'.$i) ? 1 : 0;

             $product_type = $request['product_type_'.$i];
             $warranty_type = $request['warranty_type_'.$i];

             $product->product_id=$product_ids;
             $product->category_id=$category_id[$i];
             $product->store_id=$store_id[$i];
             $product->brand_id=$brand_id[$i];
             $product->supplier_id=$supplier_id;
             $product->product_name=$product_name[$i];
             $product->product_name_ar=$product_name[$i];
             $product->barcode=$barcode[$i];
             $product->purchase_price=$purchase_price[$i]+$single_product_shipping;
             $product->profit_percent=$profit_percent[$i];
             $product->sale_price=$sale_price[$i]+$single_product_shipping;
             $product->min_sale_price=$min_sale_price[$i];
             $product->tax=$tax[$i];
             $product->quantity=$quantity[$i];
             $product->notification_limit=$notification_limit[$i];
             $product->product_type=$product_type;
             $product->warranty_type=$warranty_type;
             $product->warranty_days=$warranty_days[$i];
             $product->whole_sale=$wholeSaleValue;
             $product->bulk_quantity=$bulk_quantity[$i];
             $product->bulk_price=$bulk_price[$i];
             $product->warranty_type=$warranty_type;
             $product->warranty_days=$warranty_days[$i];
             $product->check_imei=$imeicheckValue;
             $product->description=$description[$i];
             $product->stock_image=$product_image;
             $product->added_by = 'admin';
             $product->user_id = '1';
             $product->save();
             $product_id = $product->id;

            // add purchase detail
            $purchase_detail->purchase_id=$purchase_id;
            $purchase_detail->invoice_no=$invoice_no;
            $purchase_detail->product_id=$product_id;
            $purchase_detail->barcode=$barcode[$i];
            $purchase_detail->purchase_price=$purchase_price[$i];
            $purchase_detail->tax=$tax[$i];
            $purchase_detail->quantity=$quantity[$i];
            $purchase_detail->warranty_type=$warranty_type;
            $purchase_detail->warranty_days=$warranty_days[$i];
            $purchase_detail->check_imei=$imeicheckValue;
            $purchase_detail->added_by = 'admin';
            $purchase_detail->user_id = '1';
            $purchase_detail->save();


           


            // purchase and product imei
            $purchase_imei = new Purchase_imei();
            $product_imei = new Product_imei();
            $product_imeis=explode(',',$imei_no[$i]);
            if($imeicheckValue==1)
            {
                for ($z=0; $z <count($product_imeis) ; $z++) {
                    $purchase_imei->purchase_id=$purchase_id;
                    $purchase_imei->invoice_no=$invoice_no;
                    $purchase_imei->product_id=$product_id;
                    $purchase_imei->barcode=$barcode[$i];
                    $purchase_imei->imei=$product_imeis[$z];
                    $purchase_imei->added_by = 'admin';
                    $purchase_imei->user_id = '1';
                    $purchase_imei->save();
    
    
                    $product_imei->product_id=$product_id;
                    $product_imei->barcode=$barcode[$i];
                    $product_imei->imei=$product_imeis[$z];
                    $product_imei->added_by = 'admin';
                    $product_imei->user_id = '1';
                    $product_imei->save();

                    // product qty history
                    $product_qty_history = new Product_qty_history();

                    $product_qty_history->product_id =$product_id;
                    $product_qty_history->barcode=$barcode[$i];
                    $product_qty_history->imei=$product_imeis[$z];
                    $product_qty_history->source='purchase';
                    $product_qty_history->type=1;
                    $product_qty_history->previous_qty=0;
                    $product_qty_history->given_qty=1;
                    $product_qty_history->new_qty=1;
                    $product_qty_history->added_by = 'admin';
                    $product_qty_history->user_id = '1';
                    $product_qty_history->save();
                }
            }
            else
            {
                // product qty history
                $product_qty_history = new Product_qty_history();

                $product_qty_history->product_id =$product_id;
                $product_qty_history->barcode=$barcode[$i];
                $product_qty_history->source='purchase';
                $product_qty_history->type=1;
                $product_qty_history->previous_qty=0;
                $product_qty_history->given_qty=$quantity[$i];
                $product_qty_history->new_qty=$quantity[$i];
                $product_qty_history->added_by = 'admin';
                $product_qty_history->user_id = '1';
                $product_qty_history->save();
            }
            


            
        }

        // purchase bill
        $purchase_bill = new Purchase_bill();

        $purchase_bill->purchase_id=$purchase_id;
        $purchase_bill->invoice_no=$invoice_no;
        $purchase_bill->total_price=$total_price;
        $purchase_bill->total_tax=$total_tax;
        $purchase_bill->grand_total=$total_tax+$total_price+$shipping_cost;
        $purchase_bill->remaining_price=$total_tax+$total_price+$shipping_cost;
        $purchase_bill->added_by = 'admin';
        $purchase_bill->user_id = '1';
        $purchase_bill->save();



        // return response()->json(['product_id' => $product->product_id]);

    }
    // get invoice no
    public function search_invoice(Request $request)
    {
        $purchase = new Purchase();
        $invoice_no = $request['search'];
        $purchase_data = Purchase::where('invoice_no', $invoice_no)->first();

        if (!$purchase_data) {
            return response()->json(['error' => 'Invoice no not found','error_code' => 2], 200);
        }
        else
        {
            return response()->json(['error' => 'Invoice no already existed','error_code' => 1], 200);
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
        $product_imei = Product_imei::where('product_id', $product_data->product_id)->get();
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
            }
        }
        // 
        $data = [
            'category_id' => $product_data->category_id,
            'store_id' => $product_data->store_id,
            'brand_id' => $product_data->brand_id,
            'product_name' => $product_data->product_name,
            'product_name_ar' => $product_data->product_name_ar,
            'barcode' => $product_data->barcode,
            'purchase_price' => $product_data->purchase_price,
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
            'imei_no' => $product_data->all_imei,
        // Add more attributes as needed
        ];

        return response()->json($data);
    }
}
