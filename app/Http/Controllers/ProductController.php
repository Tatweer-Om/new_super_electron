<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
}
