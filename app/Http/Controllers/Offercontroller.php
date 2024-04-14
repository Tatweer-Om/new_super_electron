<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Workplace;
use App\Models\University;
use App\Models\Ministry;
use App\Models\Nationality;
use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Offercontroller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        $products= Product::all();
        $brands= Brand::all();
        $categories= Category::all();
        $workplaces = Workplace::all();
        $universities = University::all();
        $ministries = Ministry::all();
        $nationality = Nationality::all();
        $address = Address::all();
        

        if ($permit_array && in_array('15', $permit_array)) {

            return view('offers.offer', compact('universities','workplaces','ministries','nationality','address','categories', 'brands', 'products','permit_array'));
        } else {

            return redirect()->route('home');
        }


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
                }elseif ($value->offer_type == 6) {
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

        $nationality_id = "";
        if(!empty($request['nationality_id']))
        {
            $nationality_id = implode(',',$request['nationality_id']);
        }
        $student_university = "";
        if(!empty($request['student_university']))
        {
            $student_university = implode(',',$request['student_university']);
        }
        $ministry_id = "";
        if(!empty($request['ministry_id']))
        {
            $ministry_id = implode(',',$request['ministry_id']);
        }
        $employee_workplace = "";
        if(!empty($request['employee_workplace']))
        {
            $employee_workplace = implode(',',$request['employee_workplace']);
        }

        $offer = new Offer();
        $offer->offer_id = genUuid() . time();
        $offer->offer_name = $request['offer_name'];
        $offer->offer_start_date = $request['offer_start'];
        $offer->offer_discount = $request['offer_discount'];
        $offer->nationality_id = $nationality_id;
        $offer->university_id = $student_university;
        $offer->ministry_id = $ministry_id;
        $offer->workplace_id = $employee_workplace;
        $offer->offer_type = $request->has('offer_type') ? 1 : 0;
        $offer->male = $request->has('male') ? 1 : 0;
        $offer->female = $request->has('female') ? 1 : 0;
        $offer->offer_type_employee = $request->has('offer_type_employee') ? 1 : 0;
        $offer->offer_type_student = $request->has('offer_type_student') ? 1 : 0;
        $offer->offer_discount_type = $offer_discount_type;

        $offer->offer_end_date = $request['offer_end'];
        $offer->offer_detail = $request['offer_detail'];
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


        // nationality_id
        $nationality_id = explode(',' , $offer->nationality_id);
        $view_nationality= Nationality::all();
        $options_nat = ''; // Initialize an empty string to store option elements

        foreach ($view_nationality as $key => $nat) {
            $selected = in_array($nat->id, $nationality_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_nat .= '<option '.$selected.' value="'.$nat->id.'">'.$nat->nationality_name.'</option>';
        }

        // university_id
        $university_id = explode(',' , $offer->university_id);
        $view_university= University::all();
        $options_uni = ''; // Initialize an empty string to store option elements

        foreach ($view_university as $key => $uni) {
            $selected = in_array($uni->id, $university_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_uni .= '<option '.$selected.' value="'.$uni->id.'">'.$uni->university_name.'</option>';
        }

        // ministry_id
        $ministry_id = explode(',' , $offer->ministry_id);
        $view_ministry= Ministry::all();
        $options_min = ''; // Initialize an empty string to store option elements

        foreach ($view_ministry as $key => $min) {
            $selected = in_array($min->id, $ministry_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_min .= '<option '.$selected.' value="'.$min->id.'">'.$min->ministry_name.'</option>';
        }

        // workplace_id
        $workplace_id = explode(',' , $offer->workplace_id);
        $view_workplace= Workplace::all();
        $options_work = ''; // Initialize an empty string to store option elements

        foreach ($view_workplace as $key => $work) {
            $selected = in_array($work->id, $workplace_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_work .= '<option '.$selected.' value="'.$work->id.'">'.$work->workplace_name.'</option>';
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
            'offer_apply' => explode(',',$offer->offer_apply),
            'offer_product' => $options_pro,
            'offer_brand' => $options_bra,
            'offer_category' => $options_cat,
            'options_work' => $options_work,
            'options_min' => $options_min,
            'options_uni' => $options_uni,
            'options_nat' => $options_nat,
            'male' => $offer->male,
            'female' => $offer->female,
            'offer_type_student' => $offer->offer_type_student,
            'offer_type_employee' => $offer->offer_type_employee,
            'offer_type' => $offer->offer_type,
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

        // $nationalId = $request->input('national_id');
        // $offer_id = $request->input('offer_id');


        // $existingoffer = Offer::where('national_id', $nationalId)
        // ->where('offer_id', '!=', $offer_id)->first();

        // if ($existingoffer) {

        //     return response()->json(['offer_id' => $offer_id, 'status' => 2]);
        //     exit();
        // }

        $nationality_id = "";
        if(!empty($request['nationality_id']))
        {
            $nationality_id = implode(',',$request['nationality_id']);
        }
        $student_university = "";
        if(!empty($request['student_university']))
        {
            $student_university = implode(',',$request['student_university']);
        }
        $ministry_id = "";
        if(!empty($request['ministry_id']))
        {
            $ministry_id = implode(',',$request['ministry_id']);
        }
        $employee_workplace = "";
        if(!empty($request['employee_workplace']))
        {
            $employee_workplace = implode(',',$request['employee_workplace']);
        }

        $offer_brand = "";
        if(!empty($request['offer_brand']))
        {
            $offer_brand = implode(',',$request['offer_brand']);
        }
        $offer_category = "";
        if(!empty($request['offer_category']))
        {
            $offer_category = implode(',',$request['offer_category']);
        }
        $offer_apply = "";
        if(!empty($request['offer_apply']))
        {
            $offer_apply = implode(',',$request['offer_apply']);
        }



        $offer->offer_name = $request['offer_name'];
        $offer->offer_start_date = $request['offer_start'];
        $offer->offer_discount = $request['offer_discount'];
        $offer->offer_discount_type = $request['offer_discount_type'];
        $offer->offer_end_date = $request['offer_end'];
        $offer->offer_detail = $request['offer_detail'];
        $offer->nationality_id = $nationality_id;
        $offer->university_id = $student_university;
        $offer->ministry_id = $ministry_id;
        $offer->workplace_id = $employee_workplace; 
        $offer->offer_product_ids = implode(',',$request->input('offer_product'));
        $offer->offer_brand_ids = $offer_brand;
        $offer->offer_category_ids = $offer_category;
        $offer->offer_apply = $offer_apply;
        $offer->offer_type = $request->has('offer_type') ? 1 : 0;
        $offer->male = $request->has('male') ? 1 : 0;
        $offer->female = $request->has('female') ? 1 : 0;
        $offer->offer_type_employee = $request->has('offer_type_employee') ? 1 : 0;
        $offer->offer_type_student = $request->has('offer_type_student') ? 1 : 0;
         $offer->added_by = 'admin';
        $offer->user_id = '1';
        $offer->save();
        // $offer->brands()->attach($request->input('offer_brand'));
        // $offer->categories()->attach($request->input('offer_category'));
        // $offer->products()->attach($request->input('offer_product'));
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

    public function get_workplaces(Request $request){
        $ministry_id = $request->input('ministry_id');
        $workplace_data='';
        for ($i=0; $i < count($ministry_id) ; $i++) { 
            $workplace_datas = Workplace::where('ministry_id', $ministry_id[$i])->get();

           
            foreach ($workplace_datas as $key => $workplace) {
                $workplace_data.='<option value="'.$workplace->id.'" >'.$workplace->workplace_name.'</option>';
            }
        }
       
        return response()->json(['workplace_data' =>  $workplace_data]);
    }
}
