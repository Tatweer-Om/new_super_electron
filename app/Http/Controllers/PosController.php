<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index (){

        $active_cat= 'all';

        $categories = Category::all();
        $count_products = Product::all()->count();

        return view ('pos_pages.pos', compact('categories', 'count_products', 'active_cat'));
    }

    public function cat_products (Request $request){

        $cat_id = $request['cat_id'];

        if($cat_id=="all")
        {
            $cat_products = Product::all();
            $category_name= 'all';
        }
        else
        {

            $cat_products = Product::where('category_id', $cat_id)->get();
            $cat_name = Category::where('id', $cat_id)->first();
            $category_name = $cat_name->category_name;
        }


        $data = [
            'category_name' => $category_name,
            'products' => $cat_products,
        ];
        return response()->json($data);

    }

    public function order_list(Request $request){

        $product_barcode = $request->input('product_barcode');
        $product_quantity = $request->input('quantity');
        $product = Product::where('barcode', $product_barcode)->first();

        if (!$product) {
            return response()->json([
                'error'=> trans('messages.product_not_available_lang', [], session('locale')),
                'error_code' => 404
            ], 404);
        }

        elseif ($product->quantity<$product_quantity){

            return response()->json([
                'error'=> trans('messages.product_not_available_lang', [], session('locale')),
                'error_code' => 2
            ], 200);
        }

        else {
            $product_name = $product->product_name;
            $product_image = $product->stock_image;
            $product_barcode = $product->barcode;
            $product_price = $product->sale_price;
            $product_id = $product->id;

            return response()->json([
                'product_name' => $product_name,
                'product_barcode' => $product_barcode,
                'id' => $product_id,
                'product_image' => $product_image,
                'product_price' => $product_price
            ]);
        }


    }


}
