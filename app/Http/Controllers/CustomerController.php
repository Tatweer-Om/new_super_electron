<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Ministry;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Workplace;
use App\Models\University;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\PosOrderDetail;
use App\Models\Qoutation;
use App\Models\Qoutdata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    public function index()


    {

        $user = Auth::user();


        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);

        $workplaces = Workplace::all();
        $universities = University::all();
        $ministries = Ministry::all();
        $nationality = Nationality::all();
        $address = Address::all();

        if ($permit_array && in_array('9', $permit_array)) {


            return view('customer_module.customer', compact('workplaces', 'universities','permit_array', 'ministries','nationality','address'));

        } else {

            return redirect()->route('home');
        }



    }

    public function show_customer()
    {
        $sno=0;

        $view_customer= Customer::all();
        if(count($view_customer)>0)
        {
            foreach($view_customer as $value)
            {

                $customer_name='<a href="' . url('customer_profile/' . $value->id) . '">' . e($value->customer_name) . '</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_customer_modal"
                        type="button" onclick=edit("'.$value->customer_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->customer_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>
                      ';
                $add_data=get_date_only($value->created_at);

                if ($value->customer_type == 1) {
                    $customer_type = "Student";
                } elseif ($value->customer_type == 2) {
                    $customer_type = "Teacher";
                } elseif ($value->customer_type == 3) {
                    $customer_type = "Employee";
                } else {
                    $customer_type = "General";
                }

                $sno++;
                $json[]= array(
                            $sno,

                            $customer_name,
                            $value->customer_phone,
                            $value->customer_email,
                            $value->national_id,
                            $value->customer_detail,
                            $customer_type,
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

    public function add_customer(Request $request){
 
        $customer = new Customer();
        $customer_img_name="";
        if ($request->file('customer_image')) {
            $folderPath = public_path('images/customer_images');

            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $customer_img_name = time() . '.' . $request->file('customer_image')->extension();
            $request->file('customer_image')->move(public_path('images/customer_images'), $customer_img_name);
        }

        $nationalId = $request->input('national_id');
        $existingCustomer = Customer::where('national_id', $nationalId)->first();

        if ($existingCustomer) {
            return response()->json(['customer_id' => '', 'status' => 2]);
            exit();
        }


        $customer->customer_id = genUuid() . time();
        $customer->customer_name = $request['customer_name'];
        $customer->customer_phone = $request['customer_phone'];
        $customer->customer_email = $request['customer_email'];
        $customer->customer_number = $request['customer_number'];
        $customer->dob = $request['dob'];
        $customer->gender = $request['gender'];
        $customer->nationality_id = $request['nationality_id'];
        $customer->address = $request['address_id'];
        $customer->national_id = $request['national_id'];
        $customer->customer_detail = $request['customer_detail'];
        $customer->student_id = $request['student_id'];
        $customer->student_university = $request['student_university'];
        $customer->teacher_university = $request['teacher_university'];
        $customer->employee_id = $request['employee_id'];
        $customer->employee_workplace = $request['employee_workplace'];
        $customer->ministry_id = $request['ministry_id'];
        $customer->customer_type = $request['customer_type'];
        $customer->customer_image = $customer_img_name;
        $customer->added_by = 'admin';
        $customer->user_id = '1';
        $customer->save();
        // customer add sms
        $params = [
            'customer_id' => $customer->id,
            'sms_status' => 1
        ];
        $sms = get_sms($params); 
        sms_module($request['customer_phone'], $sms);

        // 
        return response()->json(['customer_id' => $customer->id , 'status' => 1]);

    }

    public function edit_customer(Request $request){
        $customer = new Customer();
        $customer_id = $request->input('id');

        // Use the Eloquent where method to retrieve the customer by column name
        $customer_data = Customer::where('customer_id', $customer_id)->first();

        if (!$customer_data) {
            return response()->json(['error' => trans('messages.customer_not_found', [], session('locale'))], 404);
        }

        // get workplace and minstry
        $workplace_datas = Workplace::where('ministry_id', $customer_data->ministry_id)->get();

        $workplace_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
        ';
        foreach ($workplace_datas as $key => $workplace) {
            $selected = "";
            if($workplace->id == $customer_data->employee_workplace);
            {
                $selected = "selected ='true'";
            }
            $workplace_data.='<option '.$selected.' value="'.$workplace->id.'" >'.$workplace->workplace_name.'</option>';
        }

        $ministry_datas = Ministry::all();

        $ministry_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
        ';
        foreach ($ministry_datas as $key => $ministry) {
            $selected = "";
            if($ministry->id == $customer_data->ministry_id);
            {
                $selected = "selected ='true'";
            }
            $ministry_data.='<option '.$selected.' value="'.$ministry->id.'" >'.$ministry->ministry_name.'</option>';
        }

        // Add more attributes as needed
        $data = [
            'customer_id' => $customer_data->customer_id,
            'customer_name' =>   $customer_data->customer_name,
            'customer_phone' =>  $customer_data->customer_phone,
            'customer_email' =>  $customer_data->customer_email,
            'customer_number' => $customer_data->customer_number,
            'national_id'    =>  $customer_data->national_id,
            'customer_detail' => $customer_data->customer_detail,
            'customer_type'  =>  $customer_data->customer_type,
            'student_id'  =>  $customer_data->student_id,
            'student_university'=> $customer_data->student_university,
            'teacher_university'=> $customer_data->teacher_university,
            'employee_id'=>$customer_data->employee_id,
            'ministry_id'=> $ministry_data,
            'employee_workplace'=> $workplace_data,
            'customer_image' => $customer_data->customer_image,
            'dob' => $customer_data->dob,
            'gender' => $customer_data->gender,
            'nationality_id' => $customer_data->nationality_id,
            'address' => $customer_data->address,

            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_customer(Request $request){
        $customer_id = $request->input('customer_id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        if (!$customer) {
            return response()->json(['error' => trans('messages.customer_not_found', [], session('locale'))], 404);
        }

        $nationalId = $request->input('national_id');
        $customer_id = $request->input('customer_id');

        // Check if the national ID already exists in the database
        $existingCustomer = Customer::where('national_id', $nationalId)
        ->where('customer_id', '!=', $customer_id)->first();

        if ($existingCustomer) {
            // If the national ID already exists, return an error message
            return response()->json(['customer_id' => $customer_id, 'status' => 2]);
            exit();
        }

        if ($request->hasFile('customer_image')) {
            $folderPath = public_path('images/customer_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $customer_img_name = time() . '.' . $request->file('customer_image')->extension();
            $request->file('customer_image')->move(public_path('images/customer_images'), $customer_img_name);
            $customer->customer_image = $customer_img_name;
        }

        $customer->customer_name = $request->input('customer_name');
        $customer->customer_phone = $request['customer_phone'];
        $customer->customer_email = $request['customer_email'];
        $customer->customer_number = $request['customer_number'];
        $customer->dob = $request['dob'];
        $customer->gender = $request['gender'];
        $customer->nationality_id = $request['nationality_id'];
        $customer->address = $request['address_id'];
        $customer->national_id = $request['national_id'];
        $customer->student_id = $request['student_id'];
        $customer->student_university = $request['student_university'];
        $customer->teacher_university = $request['teacher_university'];
        $customer->employee_id = $request['employee_id'];
        $customer->employee_workplace = $request['employee_workplace'];
        $customer->ministry_id = $request['ministry_id'];
        $customer->customer_type = $request['customer_type'];
        $customer->customer_detail = $request['customer_detail'];
        $customer->updated_by = 'admin';
        $customer->save();
        return response()->json(['customer_id' => '', 'status' => 1]);
    }

    public function delete_customer(Request $request){
        $customer_id = $request->input('id');
        $customer = Customer::where('customer_id', $customer_id)->first();
        if (!$customer) {
            return response()->json(['error' => trans('messages.customer_not_found', [], session('locale'))], 404);
        }
        $customer->delete();
        return response()->json([
            'success' => trans('messages.customer_deleted_lang', [], session('locale'))
        ]);


    }

    public function get_workplaces(Request $request){
        $ministry_id = $request->input('ministry_id');
        $workplace_datas = Workplace::where('ministry_id', $ministry_id)->get();

        $workplace_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
        ';
        foreach ($workplace_datas as $key => $workplace) {
            $workplace_data.='<option value="'.$workplace->id.'" >'.$workplace->workplace_name.'</option>';
        }
        return response()->json(['workplace_data' =>  $workplace_data]);
    }

    // add address
    public function add_address(Request $request){
        $address = new Address();

        $address->area_name = $request['address_name'];
        $address->added_by = 'admin';
        $address->save();

        // address
        $address_datas = Address::all();

        $address_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
        ';
        foreach ($address_datas as $key => $add) {
            $selected = "";
            if($add->id == $address->id);
            {
                $selected = "selected ='true'";
            }
            $address_data.='<option '.$selected.' value="'.$add->id.'" >'.$add->area_name.'</option>';
        }
        return response()->json(['address_data' => $address_data , 'status' => 1]);

    }

    public function customer_profile($customer_id){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $customer= Customer::where('id', $customer_id)->first();
        $ministry = Ministry::where('id', $customer->ministry_id)->first();
        $ministry_name = $ministry ? $ministry->ministry_name : 'none';
        $country = Nationality::where('id', $customer->nationality_id)->first();
        $country_name = $country ? $country->nationality_name : 'none';
        $university = University::where('id', $customer->student_university)->first();
        $university_name = $university ? $university->university_name : 'none';
        $universiti = University::where('id', $customer->teacher_university)->first();
        $universiti_teacher = $university ? $university->university_name : 'none';
        $workplace = University::where('id', $customer->employee_workplace)->first();
        $workplace_name = $workplace ? $workplace->workplace_name : 'none';
        $address = Address::where('id', $customer->address)->first();
        $address_name = $address ? $address->area_name : 'none';
        $orders = PosOrder::where('customer_id', $customer_id)->get();
        $order_detail= PosOrderDetail::where('customer_id', $customer_id)->get();
        $qouts = Qoutation::where('customer_id', $customer_id)->get();

        $warranties = Warranty::where('customer_id', $customer_id)->get();

            $warrantyDetails = [];
            foreach ($warranties as $warrant) {

                $product = Product::find($warrant->product_id);

                $created_at= PosOrder::where('order_no', $warrant->order_no)->first();


                $warrantyDetails[] = [
                    'product_name' => $product ? $product->product_name : 'N/A',
                    'warranty' => $warrant,
                    'created_at' => $created_at ? $created_at->created_at : null,
                ];
            }

        if ($permit_array && in_array('9', $permit_array)) {


            return view ('customer_module.customer_profile', compact('permit_array', 'customer','ministry_name'
        ,'country_name','address_name', 'qouts', 'university_name', 'address_name', 'warrantyDetails', 'universiti_teacher', 'orders', 'order_detail'));

        } else {

            return redirect()->route('home');
        }

    }





}
