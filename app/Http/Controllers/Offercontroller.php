<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Offercontroller extends Controller
{
    public function index()
    {
        $products= Product::all();
        $brands= Brand::all();
        $categories= Category::all();

        return view('offers.offer', compact('categories', 'brands', 'products'));
    }

    public function show_offer()
    {
        $sno=0;

        $view_offer= Offer::all();
        if(count($view_offer)>0)
        {
            foreach($view_offer as $value)
            {

                $offer_name='<a href="javascript:void(0);">'.$value->offer_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_offer_modal"
                        type="button" onclick=edit("'.$value->offer_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->offer_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                if ($value->offer_type == 1) {
                    $offer_type = "All Customers";
                } elseif ($value->offer_type == 2) {
                    $offer_type = "Student";
                } elseif ($value->offer_type == 3) {
                    $offer_type = "Teacher";
                } elseif ($value->offer_type == 4) {
                    $offer_type = "Employee";
                }elseif ($value->offer_type == 5) {
                    $offer_type = "Only Male";
                }elseif ($value->offer_type == 5) {
                    $offer_type = "Only Female";
                }

                else {
                    $offer_type = "";
                }

                $sno++;
                $json[]= array(
                            $sno,

                            $offer_name,
                            $value->offer_start_date,
                            $value->offer_end_date,
                            $offer_type,
                            // $value->offer_detail,
                            $value->offer_discount,
                            $value->offer_discount_type,
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

    public function add_offer(Request $request){

        $products = $request->input('offer_product', []);
        $brands = $request->input('offer_brand', []);
        $categories = $request->input('offer_category', []);
        $product_ids = implode(',', $products);
        $brand_ids = implode(',', $brands);
        $category_ids = implode(',', $categories);
        $offer_discount_type = $request->has('offer_discount_type') ? 'OMR' : 'Tax';

        $offer = new Offer();
        $offer->offer_id = genUuid() . time();
        $offer->offer_name = $request['offer_name'];
        $offer->offer_start_date = $request['offer_start'];
        $offer->offer_discount = $request['offer_discount'];
        $offer->offer_discount_type = $offer_discount_type;

        $offer->offer_end_date = $request['offer_end'];
        $offer->offer_detail = $request['offer_detail'];
        $offer->offer_type = implode(',', $request->input('offer_type', []));
        $offer->offer_apply = implode(',', $request->input('offer_apply', []));
        $offer->added_by = 'admin';
        $offer->user_id = '1';

        $offer->offer_product_ids= $product_ids;
        $offer->offer_category_ids= $brand_ids;
        $offer->offer_brand_ids= $category_ids;
        $offer->save();
        return response()->json(['offer_id' => $offer->id , 'status' => 1]);


    }

    public function edit_offer(Request $request){

        $offer = new offer();
        $offer_id = $request->input('id');


        $offer = Offer::where('offer_id', $offer_id)->first();

        if (!$offer) {
            return response()->json(['error' => trans('messages.offer_not_found', [], session('locale'))], 404);
        }

        // produt ids
        $view_product= Product::all();
        $product_id = explode(',' , $offer->offer_product_ids);
        $options_pro = ''; // Initialize an empty string to store option elements

        foreach ($view_product as $key => $value) {
            $selected = in_array($value->id, $product_id) ? 'selected' : ''; // Check if the product ID is in the array

            // Concatenate the option element to the $options string
            $options_pro .= '<option '.$selected.' value="'.$value->id.'">'.$value->product_name.'</option>';
        }

        $brand_id = explode(',' , $offer->offer_brand_ids);
        $view_brand= Brand::all();
        $options_bra = ''; // Initialize an empty string to store option elements

        foreach ($view_brand as $key => $bra) {
            $selected = in_array($bra->id, $brand_id) ? 'selected' : ''; // Check if the brand ID is in the array

            // Concatenate the option element to the $options string
            $options_bra .= '<option '.$selected.' value="'.$bra->id.'">'.$bra->brand_name.'</option>';
        }

        $category_id = explode(',' , $offer->offer_category_ids);
        $view_category= Category::all();
        $options_cat = ''; // Initialize an empty string to store option elements

        foreach ($view_category as $key => $cat) {
            $selected = in_array($cat->id, $category_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_cat .= '<option '.$selected.' value="'.$cat->id.'">'.$cat->category_name.'</option>';
        }
        // Add more attributes as needed
        $data = [

            'offer_id' => $offer->offer_id,
            'offer_name' => $offer->offer_name,
            'offer_start_date' => $offer->offer_start_date,
            'offer_discount' => $offer->offer_discount,
            'offer_discount_type' => $offer->offer_discount_type,
            'offer_end_date' => $offer->offer_end_date,
            'offer_detail' => $offer->offer_detail,
            'offer_discount_type' => $offer->offer_discount_type,
            'offer_type' => explode(',',$offer->offer_type),
            'offer_product' => $options_pro,
            'offer_brand' => $options_bra,
            'offer_category' => $options_cat,
            'added_by' => $offer->added_by,
            'user_id' => $offer->user_id,

        ];

        return response()->json($data);
    }

    public function update_offer(Request $request){
        $offer_id = $request->input('offer_id');
        $offer = Offer::where('offer_id', $offer_id)->first();
        if (!$offer) {
            return response()->json(['error' => trans('messages.offer_not_found', [], session('locale'))], 404);
        }

        $nationalId = $request->input('national_id');
        $offer_id = $request->input('offer_id');


        $existingoffer = Offer::where('national_id', $nationalId)
        ->where('offer_id', '!=', $offer_id)->first();

        if ($existingoffer) {

            return response()->json(['offer_id' => $offer_id, 'status' => 2]);
            exit();
        }




        $offer->offer_name = $request['offer_name'];
        $offer->offer_start_date = $request['offer_start'];
        $offer->offer_discount = $request['offer_discount'];
        $offer->offer_discount_type = $request['offer_discount_type'];
        $offer->offer_end_date = $request['offer_end'];
        $offer->offer_detail = $request['offer_detail'];
        $offer->offer_types = implode(',', $request->input('offer_type', []));
        $offer->added_by = 'admin';
        $offer->user_id = '1';
        $offer->save();
        $offer->brands()->attach($request->input('offer_brand'));
        $offer->categories()->attach($request->input('offer_category'));
        $offer->products()->attach($request->input('offer_product'));
        return response()->json(['offer_id' => '', 'status' => 1]);
    }

    public function delete_offer(Request $request){
        $offer_id = $request->input('id');
        $offer = Offer::where('offer_id', $offer_id)->first();
        if (!$offer) {
            return response()->json(['error' => trans('messages.offer_not_found', [], session('locale'))], 404);
        }
        $offer->delete();
        return response()->json([
            'success' => trans('messages.offer_deleted_lang', [], session('locale'))
        ]);


    }
}
