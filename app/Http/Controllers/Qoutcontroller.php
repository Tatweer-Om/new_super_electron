<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Qoutation;
use App\Models\Workplace;
use App\Models\University;
use App\Models\Posinvodata;
use App\Models\Qoutdata;
use App\Models\QoutProduct;
use App\Models\QoutService;
use App\Models\Settingdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Qoutcontroller extends Controller
{
    public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        $shop = Settingdata::first();
        $invo = Posinvodata::first();

        $customers = Customer::all();
        $products = Product::all();
        $services = Service::all();
        $workplaces = Workplace::all();
        $universities = University::all();

        if ($permit_array && in_array('18', $permit_array)) {

            return view('qoutation.add_qout', compact('customers',
            'products', 'services',
             'universities', 'workplaces', 'permit_array', 'invo', 'shop') );
        } else {

            return redirect()->route('home');
        }


    }


    public function show_qout()
        {
            $sno=0;

            $view_qout= Qoutation::all();
            if(count($view_qout)>0)
            {
                foreach($view_qout as $value)
                {
                    $customer= Customer::find($value->customer_id)->first();
                    if(!$customer){
                        $customer= 'Null';
                    }

                    $qout_no = '<a href="javascript:void(0);">' . trans('messages.Qout_.No_-00_lang', [], session('locale')) . ' ' . $value->id . '</a>';
                    $total='<a href="javascript:void(0);">'.$value->total_amount.'</a>';
                    $paid='<a href="javascript:void(0);">'.$value->paid_amount.'</a>';
                    $remaining_amount='<a href="javascript:void(0);">'.$value->remaining_amount.'</a>';
                    $cust_name='<a href="javascript:void(0);">'.$customer->customer_name.'</a>';
                    $cust_phone='<a href="javascript:void(0);">'.$customer->customer_phone.'</a>';
                    $added='<a href="javascript:void(0);">'.$value->added_by.'</a>';
                    $date='<a href="javascript:void(0);">'.$value->date.'</a>';
                    $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_qout_modal"
                            type="button" onclick=edit("'.$value->id.'")> <i class="fas fa-edit"></i>
                            </a>
                            <a class="me-3 confirm-text"
                            onclick=del("'.$value->id.'")> <i class="fas fa-trash"></i>
                            </a>
                             <a class="me-3 confirm-text" href="' . url('view_qout', ['id' => $value->id]) . '">
                             <i class="fas fa-eye"></i></a>
                            ';
                    $add_data=get_date_only($value->created_at);

                    $sno++;
                    $json[]= array(
                                $sno,
                                $qout_no,
                                $total,
                                $paid,
                                $remaining_amount,
                                $cust_name,
                                $cust_phone,
                                $added,
                                $date,
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


    public function view_qout(Request $request, $id)
    {


        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        $qout = Qoutation::with(['products', 'services'])->find($id);

        $qout_date=$qout->date;
        $qout_id= $qout->id;
        $total_amount=$qout->total_amount;
        $sub_total=$qout->sub_total;
        $tax=$qout->tax;
        $shipping=$qout->shipping;
        $paid_amount=$qout->paid_amount;
        $remaining_amount=$qout->remaining_amount;


        $products = $qout->products ? $qout->products : [];
        $services = $qout->services ? $qout->services : [];


        $customer_id=$qout->customer_id;
        $customer = Customer::find($customer_id);
        $customer_name = $customer ? $customer->customer_name : null;
        $customer_phone = $customer ? $customer->customer_phone : null;
        $customer_no = $customer ? $customer->customer_number : null;
        $shop = Settingdata::first();
        $invo = Posinvodata::first();
        $detail = Qoutdata::first();

        if ($permit_array && in_array('18', $permit_array)) {

            return view('qoutation.view_qoute', compact(
                'customer_id',
                'detail',
                'customer_no',
                'shop',
                'invo',
                'customer_name',
                'products',
                'services',
                'customer_phone',
                'total_amount',
                'paid_amount',
                'remaining_amount',
                'sub_total',
                'shipping',
                'tax',
                'qout_date',
               'qout_id', 'permit_array'));
        } else {

            return redirect()->route('home');
        }
        return view('qoutation.view_qoute', compact(
         'customer_id',
         'customer_name',
         'products',
         'services',
         'customer_phone',
         'total_amount',
         'paid_amount',
         'remaining_amount',
         'sub_total',
         'shipping',
         'tax',
         'qout_date',
        'qout_id'));
    }


public function product_autocomplete(Request $request) {
    $term = $request->input('term');

    $products = Product::where('barcode', 'like', '%' . $term . '%')
                            ->orWhere('product_name', 'like', '%' . $term . '%')
                            ->get()
                            ->toArray();

     $quantity= 1;
    $response = [];
    if(!empty($products)) {
        foreach ($products as $product) {

            if ($product['warranty_type'] == 1) {
                $warrantyText = 'Shop';
            } elseif ($product['warranty_type'] == 2) {
                $warrantyText = 'Agent';
            } elseif ($product['warranty_type'] == 3) {
                $warrantyText = 'None';
            } else {
                $warrantyText = 'Not Given';
            }
            $product_name = $product['product_name'];
            if(empty($product_name))
            {
                $product_name = $product['product_name_ar'];
            } 
            $response[] = [
                'label' => $product['id'] . ': ' . $product_name. '+' . $product['barcode'],
                'value' => $product['id'] . ': ' . $product_name. '+' . $product['barcode'],
                'purchase_price' => $product['purchase_price'],
                'warranty' => $warrantyText . ': ' .$product['warranty_days'],
                'pro_quantity'=>$quantity,
            ];
        }
    }

    return response()->json($response);
}


//service auto
public function service_autocomplete(Request $request) {
    $term = $request->input('term');
    $services = Service::where('service_name', 'like', '%' . $term . '%')->get();
$quantity= 1;
    $response = [];
    foreach ($services as $service) {
        $response[] = [
            'label' => $service->id . ': ' . $service->service_name,
            'value' => $service->id . ': ' . $service->service_name,

            'service_cost' => $service->service_cost,
            'service_quantity'=>$quantity,

        ];
    }

    return response()->json($response);
}



//customer auto
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
    }

    $customer->customer_id = genUuid() . time();
    $customer->customer_name = $request['customer_name'];
    $customer->customer_phone = $request['customer_phone'];
    $customer->customer_email = $request['customer_email'];
    $customer->customer_number = $request['customer_number'];
    $customer->national_id = $request['national_id'];
    $customer->customer_detail = $request['customer_detail'];
    $customer->student_id = $request['student_id'];
    $customer->student_university = $request['student_university'];
    $customer->teacher_university = $request['teacher_university'];
    $customer->employee_id = $request['employee_id'];
    $customer->employee_workplace = $request['employee_workplace'];
    $customer->customer_type = $request['customer_type'];
    $customer->customer_image = $customer_img_name;
    $customer->added_by = 'admin';
    $customer->user_id = '1';
    $customer->save();
    return response()->json(['customer_id' => $customer->id, 'status' => 1]);


}

public function customer_auto(Request $request)
{
    $term = $request->input('term');

    $customers = Customer::where('id', $term)
    ->orWhere('national_id', $term)
    ->orWhere('customer_name', 'like', "%{$term}%")
    ->orWhere('customer_phone', 'like', "%{$term}%")
    ->get(['id', 'national_id', 'customer_name', 'customer_phone']);


    $response = [];
    foreach ($customers as $customer) {
        $label = $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')';
        if (!empty($customer->national_id)) {
            $label .= ' - ' . $customer->national_id;
        }

        $response[] = [
            'label' => $label,
            'value' => $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
            'phone' => $customer->customer_phone,
            'national_id' => $customer->national_id,
        ];
    }

    return response()->json($response);
}


//add_qout

public function add_qout(Request $request){


//product
        $products = json_decode($request->input('product'));
        $product_line_price= json_decode($request->input('product_line_price'));
        $total_price_product = json_decode($request->input('total_price_product'));
        $warranty_type = json_decode($request->input('warranty_type'));
        $warranty_days = json_decode($request->input('warranty_days'));
        $product_detail = json_decode($request->input('product_detail'));
        $item_quantity_product= json_decode($request->input('item_quantity_product'));
        //service
        $services = json_decode($request->input('service'));
        $service_line_price= json_decode($request->input('service_line_price'));
        $item_quantity_service = json_decode($request->input('item_quantity_service'));
        $total_price_service =json_decode( $request->input('total_price_service'));
        $service_warranty =json_decode( $request->input('service_warranty'));
        $service_detail = json_decode($request->input('service_detail'));

        //maths
        $sub_total= $request->input('sub_total');
        $shipping= $request->input('shipping');
        // $tax= $request->input('tax');
        // $tax_value= $request->input('tax_value');
        $grand_total= $request->input('grand_total');
        $paid_amount= $request->input('paid_amount');
        $remaining_amount= $request->input('remaining_amount');
        $customer_id= $request->input('customer_id');
        $date= $request->input('date');

// qoutation_data
        $qout = new Qoutation();

        $qout->customer_id=$customer_id;
        $qout->sub_total = $sub_total;
        $qout->total_amount = $grand_total;
        $qout->paid_amount = $paid_amount;
        $qout->remaining_amount = $remaining_amount;
        $qout->shipping = $shipping;
        // $qout->tax = $tax;
        $qout->date= $date;
        $qout->store_id= 3;
        $qout->user_id= 1;
        $qout->added_by= 'admin';
        $qout->save();



// qoute products

    for ($i=0; $i < count($products) ; $i++) {
        $qout_product= new QoutProduct();

        $qout_product->qoute_id = $qout->id;
        $qout_product->customer_id=$customer_id;
        $qout_product->product_id= $products[$i];
        $qout_product->product_price = $product_line_price[$i];
        $qout_product->product_quantity = $item_quantity_product[$i];
        $qout_product->total_price = $total_price_product[$i];
        $qout_product->product_detail = $product_detail[$i];
        $qout_product->warranty_type = $warranty_type[$i];
        $qout_product->warranty_days = $warranty_days[$i];
        $qout_product->user_id= 1;
        $qout_product->store_id= 3;
        $qout_product->added_by= 'admin';

        $qout_product->save();
    }
    for ($i=0; $i < count($services) ; $i++) {
        $qout_service= new QoutService();

        $qout_service->qoute_id = $qout->id;
        $qout_service->customer_id=$customer_id;
        $qout_service->service_id= $services[$i];
        $qout_service->service_price = $service_line_price[$i];
        $qout_service->service_quantity = $item_quantity_service[$i];
        $qout_service->total_price = $total_price_service[$i];
        $qout_service->service_detail = $service_detail[$i];
        $qout_service->service_warranty = $service_warranty[$i];
        $qout_service->user_id= 1;
        $qout_service->added_by= 'admin';
        $qout_service->store_id= 3;
        $qout_service->save();
    }

    return response()->json(['qout_id' => $qout->id]);
}

// public function edit(Request $request){
//     $qout_id = $request->input('id');
//     $qout = Qoutation::where('id', $qout_id)->first();
//     if (!$qout) {
//         return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.service_not_found', [], session('locale'))], 404);
//     }

//     $customer= Customer::find($qout->customer_id)->first();
//     $products= QoutProduct::where('qout_id', $qout->id)->get();
//     $services= QoutService::where('qout_id', $qout->id)->get();



//     $data = [
//         'service_id' => $qout->service_id,
//         'product_id' => $qout->product_id,
//         'date' => $qout->service_cost,
//         'customer_id' => $customer->id,
//         'customer_name' => $customer->customer_name,
//         'customer_phone' => $customer->customer_phone,
//         'customer_no' =>$customer->customer_number,


//        // Add more attributes as needed
//     ];

//     return response()->json($data);


// }

        public function qouts(){

        $qoutations = Qoutation::with('products', 'services')->get();
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('18', $permit_array)) {

            return view('qoutation.qouts', compact('qoutations', 'permit_array'));
        } else {

            return redirect()->route('home');
        }


        }

        public function delete_qout(Request $request){
            $service_id = $request->input('id');
            $service = Qoutation::where('id', $service_id)->first();
            if (!$service) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.service_not_found', [], session('locale'))], 404);
            }
            $service->delete();
            return response()->json([
                trans('messages.success_lang', [], session('locale')) => trans('messages.service_deleted_lang', [], session('locale'))
            ]);
        }



}
