<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\User;
use App\Models\Account;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ministry;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Repairing;
use App\Models\Workplace;
use App\Models\Technician;
use App\Models\University;
use App\Models\Nationality;
use App\Models\Posinvodata;
use App\Models\Address;
use App\Models\Settingdata;
use Illuminate\Http\Request;
use App\Models\RepairProduct;
use App\Models\RepairService;
use App\Models\Inspectiondata;
use App\Models\PosOrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Product_qty_history;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\MaintenanceStatusHistory;

class RepairingController extends Controller
{
    public function index (){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);



        $ministries = Ministry::all();
        $nationality = Nationality::all();
        $address = Address::all();

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();
        $view_technicians = Technician::all();
        $orders = PosOrder::latest()->take(15)->get();
        $categories = Category::all();
        $count_products = Product::all()->count();

        // account
        $view_account = Account::where('account_type', 1)->get();

        if ($permit_array && in_array('12', $permit_array)) {

            return view ('maintenance.repairing', compact('view_technicians', 'ministries', 'nationality', 'address', 'permit_array',
             'categories', 'count_products',
            'active_cat', 'universities', 'workplaces' , 'view_account', 'orders'));
        } else {

            return redirect()->route('home');
        }

    }


    //customer details

    public function add_customer(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

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
        if(!empty($nationalId)){
            $existingCustomer = Customer::where('national_id', $nationalId)->first();

            if ($existingCustomer) {

                return response()->json(['customer_id' => '', 'status' => 2]);
            }
        }
        $existingCustomer = Customer::where('customer_phone', $request['customer_phone'])->first();
        if ($existingCustomer) {

            return response()->json(['customer_id' => '', 'status' => 3]);
            exit;
        }
        $existingCustomer = Customer::where('customer_number', $request['customer_number'])->first();
        if ($existingCustomer) {

            return response()->json(['customer_id' => '', 'status' => 3]);
            exit;
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
        $customer->added_by = $user;
        $customer->user_id = $user_id;
        $customer->save();
        // customer add sms
        $params = [
            'customer_id' => $customer->id,
            'sms_status' => 1
        ];
        $sms = get_sms($params);
        sms_module($request['customer_phone'], $sms);

        //
        $return_value =$request['customer_number'] . ': ' . $request['customer_name'] . ' (' . $request['customer_phone'] . ')';
        return response()->json(['customer_id' => $return_value, 'status' => 1]);


    }

    // customer autocomplte
    public function customer_auto(Request $request)
    {
        $term = $request->input('term');

        $customers = Customer::where('id', $term)
        ->orWhere('national_id', $term)
        ->orWhere('customer_name', 'like', "%{$term}%")
        ->orWhere('customer_phone', 'like', "%{$term}%")
        ->get(['id', 'national_id', 'customer_name', 'customer_phone','customer_number']);


        $response = [];
        foreach ($customers as $customer) {
            $label = $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')';
            if (!empty($customer->national_id)) {
                $label .= ' - ' . $customer->national_id;
            }

            $response[] = [
                'label' => $label,
                'value' => $customer->customer_number . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
                'phone' => $customer->customer_phone,
                'national_id' => $customer->national_id,
            ];
        }

        return response()->json($response);
    }

    //warranty_auto_complete
    public function warranty_auto(Request $request){


            $term = $request->input('term');

            try {

                $warranties = Warranty::where('order_no', 'like', "%{$term}%")
                    ->orWhere('item_imei', 'like', "%{$term}%")
                    ->orWhere('item_barcode', 'like', "%{$term}%")
                    ->limit(10)
                    ->get(['order_no', 'item_imei', 'item_barcode']);


                $response = $warranties->map(function ($warranty) {
                    $title = $warranty->item_barcode;
                    if(!empty($warranty->item_imei))
                    {
                        $title .= '-'.$warranty->item_imei;
                    }
                    return [
                        'label' => $warranty->order_no . '-' . $title,
                        'value' => $warranty->order_no . ' : ' . $title,
                    ];
                });

                return response()->json($response);
            } catch (\Exception $e) {

                Log::error('Error fetching warranty data: ' . $e->getMessage());

                // Return an error response
                return response()->json(['error' => 'An error occurred while fetching warranty data. Please try again later.'], 500);
            }

        }

    //repairing_products

    public function repairing_products(Request $request)
    {
        $search_type = $request->input('search_type');
        if($search_type==1)
        {
            $customer_id = $request->input('customer_id');
            $customer_data = Customer::where('customer_number', $customer_id)->first();
            $order_data = Warranty::where('customer_id', $customer_data->id)->get();
        }
        else
        {
            $order_no = $request->input('order_no');
            $imei = $request->input('imei');
            $barcode = $request->input('barcode');
            if(!empty($imei))
            {
                $order_data = Warranty::where('order_no', $order_no)
                ->where('item_imei', $imei)
                ->where('item_barcode', $barcode)->get();
            }
            else
            {
                $order_data = Warranty::where('order_no', $order_no)
                                    ->where('item_barcode', $barcode)->get();
            }

        }


        $response = [];

        if ($order_data->isNotEmpty()) {
            $product_data = [];
            $sno = 0;
            $status = 0;

            foreach ($order_data as $detail) {
                $product = Product::find($detail->product_id);
                $customer= Customer::find($detail->customer_id);
                $custmore_name= $customer->customer_name;

                if ($product) {

                    if ($product->warranty_days) {
                        // echo $detail->id;
                        $repairing_data = Repairing::where('warranty_id', $detail->id)
                                                    ->where('status', '<>', 5)
                                                        ->first();


                        if(empty($repairing_data))
                        {

                            $image = $product->stock_image ? asset('images/product_images/' . $product->stock_image) : asset('images/dummy_image/no_image.png');
                            $title = !empty($product->product_name_ar) ? $product->product_name_ar : $product->product_name;
                            // $imeis = Product_imei::where('barcode', $product->barcode)->distinct()->pluck('imei')->toArray();
                            $invoice_no = $detail->order_no;
                            $barcode = $detail->item_barcode;
                            $quantity = $detail->item_quantity;
                            $id_product= $product->id;
                            $item_price = $detail->purchase_price;
                            $imeis= $detail->item_imei;
                            $warranty_type = $detail->warranty_type;
                            if ($warranty_type == 1) {
                                $warranty_type = trans('messages.shop_lang', [], session('locale'));
                            } elseif ($warranty_type == 2) {
                                $warranty_type = trans('messages.agent_lang', [], session('locale'));
                            } else {
                                $warranty_type = trans('messages.none_lang', [], session('locale'));
                            }



                            $warranty_days = $product->warranty_days;
                            $warranty_end_date = Carbon::now()->addDays($warranty_days);
                            $remaining_warranty = Carbon::now()->diffInDays($warranty_end_date);
                            $status_badge = '';

                            $currentDate = new DateTime();
                            $currentDate->add(new DateInterval('P' . $warranty_days . 'D'));
                            $validity = $currentDate->format('Y-m-d');

                            if ($remaining_warranty > 0) {
                                $status_badge = '<span class="badges status-badge">' . $remaining_warranty . ' days</span>';
                            }
                            else{
                                $status_badge = '<span class="badges unstatus-badge">' . $remaining_warranty . ' days</span>';
                            }


                            $created_by = $detail->added_by;
                            $created_at = $detail->created_at;

                            $image2='<img src="' . $image . '" alt="' . $title . '" style="max-width: 60px; max-height: 70px;"> ';

                            $sno++;
                            $product_data[] = [

                                $title,
                                $imeis,
                                $barcode,
                                $item_price,
                                $created_at->format('d-m-Y'),
                                $warranty_type . ' : ' . $warranty_days .' '. trans('messages.days_lang', [], session('locale')),
                                $status_badge,
                                $invoice_no,
                                $validity,
                                $detail->id,
                                $detail->warranty_type,


                            ];
                        }
                    }

                }
            }


        }

        if(!empty($product_data))
        {
            $response['status'] = 1;
            $response['aaData'] = $product_data;
        }
        else
        {
            $response['status'] = 2;
            $response['message'] = 'No data found.';
            $response['aaData'] = [];
        }

        return response()->json($response);
    }







 // add repait maintenance

    public function add_repair_maintenance(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;


        $warranty_data = Warranty::where('id', $request['warranty_id'])->first();
        // refernce no
        $repairing_data = Repairing::orderBy('id', 'desc')
                    ->first();

        if($repairing_data)
        {

            $reference_no_old = ltrim($repairing_data->reference_no, '0');
        }
        else
        {
            $reference_no_old=0;
        }

        $reference_no = $reference_no_old+1;

        $reference_no = '0000000'.$reference_no;
        if(strlen($reference_no)!=8)
        {
           $len = (strlen($reference_no)-8);
           $reference_no = substr($reference_no,$len);
        }

        //get cutomer
        $customer = $request['customer_id'];
        $customer_id = $warranty_data->customer_id;
        if(!empty($customer))
        {
            $colonPosition = strpos($customer, ':');

            // Extract the substring from the start of the string up to the position of the colon
            if ($colonPosition !== false) {
                // Extract the substring from the start of the string up to the position of the colon
                $result = trim(substr($customer, 0, $colonPosition));

                if ($result) {
                    $customer_data = Customer::where('customer_number', $result)->first();
                    $customer_id = $customer_data->id;
                }
            }
        }

        $repairing = new Repairing();
        $repairing->reference_no = $reference_no;
        $repairing->customer_id = $customer_id;
        $repairing->invoice_no = $request['order_no'];
        $repairing->invoice_id = $warranty_data->order_id;
        $repairing->receive_date = $request['receive_date'];
        $repairing->deliver_date = $request['deliver_date'];
        $repairing->repairing_type = $request['repairing_type'];
        $repairing->warranty_id = $request['warranty_id'];
        $repairing->review_by = $request['technician_id'];
        $repairing->notes = $request['notes'];
        $repairing->added_by = $user;
        $repairing->user_id = $user_id;

        $repairing->save();
        $repairing_id = $repairing->id;
        // change status
        $status="";
        if($request['warranty_type']==1)
        {
            $repairing_data = Repairing::where('reference_no', $reference_no)
                    ->first();
            $repairing_data->status = 6;
            $repairing_data->save();
            $status =6;
        }
        else
        {
            $repairing_data = Repairing::where('reference_no', $reference_no)
                    ->first();
            $repairing_data->status = 1;
            $repairing_data->save();
            $status =1;
        }


        if($request['repairing_type'] == 2)
        {
            $repairing_data = Repairing::where('reference_no', $reference_no)
                    ->first();
            $repairing_data->status = 5;

            $repairing_data->save();
            $status =5;

        }

        // maintenance histoy status
        if(!empty($status))
        {
            $status_history = new MaintenanceStatusHistory();
            $status_history->order_no = $request['order_no'];
            $status_history->order_id = $warranty_data->order_id;
            $status_history->reference_no = $reference_no;
            $status_history->repair_id = $repairing_id;
            $status_history->warranty_id  = $request['warranty_id'];
            $status_history->customer_id  = $customer_id;
            $status_history->status = $status;
            $status_history->added_by = $user;
            $status_history->user_id = $user_id;
            $status_history->save();
        }


        return response()->json(['reference_no' => $reference_no]);

        if($request['repairing_type'] == 1)
        {
            // sms for payment
            $customer_data = Customer::where('id', $customer_id)->first();
            $params = [
                'repair_id' => $repairing_id ,
                'sms_status' => 8
            ];
            $sms = get_sms($params);
            sms_module($customer_data->customer_phone, $sms);
        }



    }

    // show maintenance
    public function repair_data(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('12', $permit_array)) {

            return view('maintenance.repair_data', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }

    }
    public function show_maintenance(Request $request)
    {
        $sno=0;
        $status = $request['status'];


        $query = Repairing::query();
         if (!empty($status)) {
            $query->where('status', $status);
        }
        $repairing = $query->orderBy('id')->get();


        if(count($repairing)>0)
        {
            foreach($repairing as $value)
            {

                 // status
                if ($value->status == "1") {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 6) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 2) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.send_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 3) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 4) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.ready_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 5) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.deleivered_status_lang', [], session('locale')) . "</span>";
                }

                // Qty type
                $repairing_type = "";
                if ($value->repairing_type == 1) {
                    $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_and_repair_lang', [], session('locale')) . "</span>";
                } else if ($value->repairing_type == 2) {
                    $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.replace_lang', [], session('locale')) . "</span>";
                }

                if($value->status != 5)
                {

                    $modal='<a class="me-3  text-primary" target="_blank" href="'.url('maintenance_profile').'/'.$value->id.'"><i class="fas fa-eye"></i></a>
                    <a class="me-3  text-primary" target="_blank" href="'.url('repair_invo').'/'.$value->reference_no.'"><i class="fas fa-print"></i></a>';
                }
                else
                {

                    $modal='<a class="me-3  text-primary" target="_blank" href="'.url('history_record').'/'.$value->id.'"><i class="fas fa-info"></i></a>
                    <a class="me-3  text-primary" target="_blank" href="'.url('repair_invo').'/'.$value->reference_no.'"><i class="fas fa-print"></i></a>';
                }




                // tim date
                $data_time=get_date_time($value->created_at);
                $sno++;
                $json[]= array(
                            $value->invoice_no,
                            $value->reference_no,
                            $value->receive_date,
                            $value->deliver_date,
                            $repairing_type,
                            $status,
                            $data_time,
                            $modal,
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

    // show maintenance profile
    public function maintenance_profile($id){
        $view_service= Service::all();
        $view_technicians= Technician::all();
        $view_product= Product::where('product_type', 2)->get();
        $repair_detail = Repairing::where('id', $id)->first();
        $all_technicians = explode(',', $repair_detail->technician_id);
        if($repair_detail->status == 5)
        {
            return redirect()->route('history_record', ['id' => $id]);
            exit;
        }
        $warranty_data = Warranty::where('id', $repair_detail->warranty_id)->first();
        $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
        $pro_data = Product::where('id', $warranty_data->product_id)->first();
        $order_data = PosOrder::where('order_no', $warranty_data->order_no)->first();
        $title = $pro_data->product_name;
        if(empty($title))
        {
            $title = $pro_data->product_name_ar;
        }
        // warranty type
        $warranty_type = $pro_data->warranty_type;
        $imei = "";
        if($warranty_data->item_imei!="undefined" && !empty($warranty_data->item_imei))
        {
            $imei = $warranty_data->item_imei;
        }
        // Qty type
        $repairing_type="";
        if ($repair_detail->repairing_type == 1) {
            $repairing_type = trans('messages.inspection_and_repair_lang', [], session('locale'));
        } else if ($repair_detail->type == 2) {
            $repairing_type = trans('messages.replace_lang', [], session('locale'));
        }

        // product sum
        $pro_sum = RepairProduct::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));
        // service sum
        $serv_sum = RepairService::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));


        $repairing_history = Repairing::whereHas('warranty', function($query) use ($warranty_data) {
                                $query->where('product_id', $warranty_data->product_id)
                                ->where('item_imei', $warranty_data->item_imei);
                            })
                            ->where('status', 5)
                            ->get();
        // dd($repairing_history); exit;
        $repairing_history_record = "";
        if(!empty($repairing_history))
        {
            foreach ($repairing_history as $key => $history) {
                // product sum
                $pro_sum_history = RepairProduct::where('repair_id', $history->id)
                ->sum(DB::raw('(cost)'));
                // service sum
                $serv_sum_history = RepairService::where('repair_id', $history->id)
                        ->sum(DB::raw('(cost)'));
                $total_cost_history = $serv_sum_history + $pro_sum_history;
                $repairing_history_record.= '<tr>
                    <td>'.$history->reference_no.'</td>
                    <td>'.get_date_only($history->receive_date).'</td>
                    <td>'.get_date_only($history->deliver_date).'</td>
                    <td>'.$total_cost_history.'</td>
                    <td><a class="me-3  text-primary"
                            href="'.url('history_record').'/'.$history->id.'">
                            <i class="fas fa-eye"></i>

                        </a>

                    </td>
                </tr>';
            }
        }


        // status history
        $status_history = MaintenanceStatusHistory::where('reference_no', $repair_detail->reference_no)
                                                ->get();
        $status_history_record = "";
        if(!empty($status_history))
        {
            foreach ($status_history as $key => $his) {
                 // status
                if ($his->status == "1") {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 6) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 2) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.send_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 3) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 4) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.ready_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 5) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.deleivered_status_lang', [], session('locale')) . "</span>";
                }
                $status_history_record.= '<tr>
                    <td>'.$status.'</td>
                    <td>'.$his->created_at.'</td>
                    <td>'.$his->added_by.'</td>

                </tr>';
            }
        }


        return view ('maintenance.maintenance_profile', compact('status_history_record', 'view_technicians', 'all_technicians', 'warranty_type', 'repairing_history_record', 'serv_sum', 'pro_sum', 'order_data', 'imei', 'title', 'pro_data', 'repairing_type', 'customer_data', 'view_service', 'repair_detail', 'view_product'));
    }


    // show history record
    public function history_record($id){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $view_service= Service::all();
        $view_technicians= Technician::all();
        $view_product= Product::where('product_type', 2)->get();
        $repair_detail = Repairing::where('id', $id)->first();
        $all_technicians = explode(',', $repair_detail->technician_id);
        $warranty_data = Warranty::where('id', $repair_detail->warranty_id)->first();
        $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
        $pro_data = Product::where('id', $warranty_data->product_id)->first();
        $order_data = PosOrder::where('order_no', $warranty_data->order_no)->first();

        $title = $pro_data->product_name;
        if(empty($title))
        {
            $title = $pro_data->product_name_ar;
        }
        // warranty type
        $warranty_type = $pro_data->warranty_type;
        $imei = "";
        if($warranty_data->item_imei!="undefined" && !empty($warranty_data->item_imei))
        {
            $imei = $warranty_data->item_imei;
        }
        // Qty type

        $repairing_type = $repair_detail->repairing_type ;

        // product sum
        $pro_sum = RepairProduct::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));
        // service sum
        $serv_sum = RepairService::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));

        $repairing_history = Repairing::whereHas('warranty', function($query) use ($warranty_data) {
                                $query->where('product_id', $warranty_data->product_id);
                            })
                            ->where('status', 5)
                            ->get();

        //get history
        $reference_no = $repair_detail->reference_no;
        $products_data = RepairProduct::where('reference_no', $reference_no)->get();
        $product_data = "";
        $total_product = 0;
        if(!empty($products_data))
        {
            foreach ($products_data as $key => $pro) {
                $pro_data = Product::where('id', $pro->product_id)->first();
                $title = $pro_data->product_name;
                if(empty($title))
                {
                    $title = $pro_data->product_name_ar;
                }
                $total_product+= $pro->cost;
                $product_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="productimgname">
                                            <a href="javascript:void(0);">'.$title.'</a>
                                        </div>
                                    </td>
                                    <td>'.$pro->cost.'</td>
                                 </tr>';
            }
        }
        else
        {
            $product_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                    </tr>';
        }

        $services_data = Repairservice::where('reference_no', $reference_no)->get();
        $service_data = "";
        $total_service = 0;
        if(!empty($services_data))
        {
            foreach ($services_data as $key => $serv) {
                $serv_data = service::where('id', $serv->service_id)->first();
                $title_serv = $serv_data->service_name;
                $total_service+= $serv->cost;
                $service_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="serviceimgname">
                                            <a href="javascript:void(0);">'.$title_serv.'</a>
                                        </div>
                                    </td>
                                    <td>'.$serv->cost.'</td>
                                 </tr>';
            }
        }
        else
        {
            $service_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                    </tr>';
        }

        // status history
        $status_history = MaintenanceStatusHistory::where('reference_no', $repair_detail->reference_no)
                                                ->get();
        $status_history_record = "";
        if(!empty($status_history))
        {
            foreach ($status_history as $key => $his) {
                 // status
                if ($his->status == "1") {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 2) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 6) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.send_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 3) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_agent_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 4) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.ready_status_lang', [], session('locale')) . "</span>";
                } else if ($his->status == 5) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.deleivered_status_lang', [], session('locale')) . "</span>";
                }
                $status_history_record.= '<tr>
                    <td>'.$status.'</td>
                    <td>'.$his->created_at.'</td>
                    <td>'.$his->added_by.'</td>

                </tr>';
            }
        }

        return view ('maintenance.history_record', compact('status_history_record', 'view_technicians','all_technicians', 'product_data', 'service_data', 'warranty_type', 'serv_sum', 'pro_sum', 'order_data', 'imei', 'title', 'pro_data', 'repairing_type', 'customer_data', 'view_service', 'repair_detail', 'view_product'));
    }

    // add service
    public function add_service(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $service = new Service();
        $service->service_id = genUuid() . time();
        $service->service_name = $request['service_name'];
        $service->service_cost = $request['service_cost'];
        $service->service_detail = $request['service_detail'];
        $service->added_by = $user;
        $service->user_id = $user_id;
        $service->save();
        $view_service= Service::all();
        $options="<option value=''>".trans('messages.choose_lang', [], session('locale'))."</option>";
        foreach ($view_service as $key => $value) {
            $selected="";
            if($value->id==$service->id)
            {
                $selected="selected='true'";
            }
            $options.='<option '.$selected.' value="'.$value->id.'">'.$value->service_name.'</option>';
        }
        return response()->json(['options' => $options]);

    }

    // add service
    public function add_maintenance_technician(Request $request){

        $reference_no = $request['reference_no'];
        $technician_id = implode(',' ,$request['technician_id']);
        $repair_data = Repairing::where('reference_no', $reference_no)->first();
        $repair_data->technician_id = $technician_id;
        $repair_data->save();
    }
    // get amintenane data
    public function get_maintenance_data(Request $request){

        $reference_no = $request['reference_no'];
        $products_data = RepairProduct::where('reference_no', $request['reference_no'])->get();
        $product_data = "";
        $total_product = 0;
        if(!empty($products_data))
        {
            foreach ($products_data as $key => $pro) {
                $pro_data = Product::where('id', $pro->product_id)->first();
                $title = $pro_data->product_name;
                if(empty($title))
                {
                    $title = $pro_data->product_name_ar;
                }
                $total_product+= $pro->cost;
                $product_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="productimgname">
                                            <a href="javascript:void(0);">'.$title.'</a>
                                        </div>
                                    </td>
                                    <td>'.$pro->cost.'</td>
                                    <td><a class="me-2 confirm-text p-2 mb-0" onclick=del_product("'.$pro->id.'") href="javascript:void(0);"><i class="fas fa-trash"></i></a></td>
                                </tr>';
            }
        }
        else
        {
            $product_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                 </tr>';
        }

        $services_data = Repairservice::where('reference_no', $request['reference_no'])->get();
        $service_data = "";
        $total_service = 0;
        if(!empty($services_data))
        {
            foreach ($services_data as $key => $serv) {
                $serv_data = service::where('id', $serv->service_id)->first();
                $title_serv = $serv_data->service_name;
                $total_service+= $serv->cost;
                $service_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="serviceimgname">
                                            <a href="javascript:void(0);">'.$title_serv.'</a>
                                        </div>
                                    </td>
                                    <td>'.$serv->cost.'</td>
                                    <td><a class="me-2 confirm-text p-2 mb-0" onclick=del_service("'.$serv->id.'") href="javascript:void(0);"><i class="fas fa-trash"></i></a></td>
                                </tr>';
            }
        }
        else
        {
            $service_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                 </tr>';
        }
        return response()->json(['product_data' => $product_data,'service_data' => $service_data,'total_service' => $total_service,'total_product' => $total_product]);

    }

    // add maintenance product
    public function add_maintenance_product(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $reference_no = $request['reference_no'];
        $product_id = $request['product_id'];
        $repair_data = Repairing::where('reference_no', $request['reference_no'])->first();
        $pro_data = Product::where('id', $product_id)->first();
        if($pro_data->quantity<=0)
        {
            return response()->json(['status' => 2]);
            exit;
        }

        $repair_product = new RepairProduct();
        $repair_product->order_no = $repair_data->invoice_no;
        $repair_product->order_id = $repair_data->invoice_id;
        $repair_product->reference_no = $reference_no;
        $repair_product->repair_id = $repair_data->id;
        $repair_product->warranty_id  = $repair_data->warranty_id ;
        $repair_product->customer_id  = $repair_data->customer_id ;
        $repair_product->product_id = $product_id;
        $repair_product->cost = $pro_data->total_purchase;
        $repair_product->added_by = $user;
        $repair_product->user_id = $user_id;
        $repair_product->save();

        // product qty history
        // $warranty = Warranty::where('id', $repair_data->warranty_id)->first();
        // $imei="";
        // if($warranty->item_imei!="undefined" && !empty($warranty->item_imei))
        // {
        //     $imei = $warranty->item_imei;
        // }
        $product_qty_history = new Product_qty_history();

        $product_qty_history->order_no =$repair_data->invoice_no;
        $product_qty_history->product_id =$product_id;
        $product_qty_history->barcode=$pro_data->barcode;
        // $product_qty_history->imei=$imei;
        $product_qty_history->source='warranty';
        $product_qty_history->type=2;
        $product_qty_history->previous_qty=$pro_data->quantity;
        $product_qty_history->given_qty=1;
        $product_qty_history->new_qty=$pro_data->quantity - 1;
        $product_qty_history->added_by = $user;
        $product_qty_history->user_id = $user_id;
        $product_qty_history->save();

        // update qty

        $pro_data->quantity=$pro_data->quantity - 1;
        $pro_data->save();

        return response()->json(['status' => 1]);
    }

    public function delete_maintenance_product(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $id = $request->input('id');
        $maintenance_product = RepairProduct::where('id', $id)->first();
        $pro_data = Product::where('id', $maintenance_product->product_id)->first();
        if (!$maintenance_product) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        $maintenance_product->delete();

        $product_qty_history = new Product_qty_history();

        $product_qty_history->order_no =$maintenance_product->order_no;
        $product_qty_history->product_id =$pro_data->id;
        $product_qty_history->barcode=$pro_data->barcode;
        // $product_qty_history->imei=$imei;
        $product_qty_history->source='warranty_return';
        $product_qty_history->type=1;
        $product_qty_history->previous_qty=$pro_data->quantity;
        $product_qty_history->given_qty=1;
        $product_qty_history->new_qty=$pro_data->quantity + 1;
        $product_qty_history->added_by = $user;
        $product_qty_history->user_id = $user_id;
        $product_qty_history->save();
        // update qty
        $pro_data->quantity=$pro_data->quantity + 1;
        $pro_data->save();

        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_deleted_lang', [], session('locale'))
        ]);
    }

    // add maintenance service
    public function add_maintenance_service(Request $request){
        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $reference_no = $request['reference_no'];
        $service_id = $request['service_id'];
        $repair_data = Repairing::where('reference_no', $request['reference_no'])->first();
        $serv_data = Service::where('id', $service_id)->first();

        $repair_service = new RepairService();
        $repair_service->order_no = $repair_data->invoice_no;
        $repair_service->order_id = $repair_data->invoice_id;
        $repair_service->reference_no = $reference_no;
        $repair_service->repair_id = $repair_data->id;
        $repair_service->warranty_id  = $repair_data->warranty_id ;
        $repair_service->customer_id  = $repair_data->customer_id ;
        $repair_service->service_id = $service_id;
        $repair_service->cost = $serv_data->service_cost;
        $repair_service->added_by = $user;
        $repair_service->user_id = $user_id;
        $repair_service->save();
    }

    public function delete_maintenance_service(Request $request){
        $id = $request->input('id');
        $maintenance_service = RepairService::where('id', $id)->first();
        if (!$maintenance_service) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        $maintenance_service->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_deleted_lang', [], session('locale'))
        ]);
    }

    // update_status
    public function change_maintenance_status(Request $request){
        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $status = $request->input('status');
        $reference_no = $request->input('reference_no');
        $repairing_data = Repairing::where('reference_no', $reference_no)->first();
        $repairing_data->status = $status;

        $repairing_data->save();

        $status_history = new MaintenanceStatusHistory();
        $status_history->order_no = $repairing_data->invoice_no;
        $status_history->order_id = $repairing_data->invoice_id;
        $status_history->reference_no = $reference_no;
        $status_history->repair_id = $repairing_data->id;
        $status_history->warranty_id  = $repairing_data->warranty_id ;
        $status_history->customer_id  = $repairing_data->customer_id ;
        $status_history->status = $status;
        $status_history->added_by = $user;
        $status_history->user_id = $user_id;
        $status_history->save();

        // sms for payment
        $customer_data = Customer::where('id', $repairing_data->customer_id)->first();
        $params = [
            'repair_id' => $repairing_data->id,
            'sms_status' => 9,
            'status' => $status
        ];
        $sms = get_sms($params);
        sms_module($customer_data->customer_phone, $sms);

    }

    // update_repair_type
    public function change_repair_type(Request $request){
        $type = $request->input('type');
        $reference_no = $request->input('reference_no');
        $repairing_data = Repairing::where('reference_no', $reference_no)->first();
        $repairing_data->repairing_type = $type;
        $repairing_data->status = 5;
        $repairing_data->save();
    }


    // update_deliver_date
    public function change_deliver_date(Request $request){
        $deliver_date = $request->input('deliver_date');
        $reference_no = $request->input('reference_no');
        $repairing_data = Repairing::where('reference_no', $reference_no)->first();
        $repairing_data->deliver_date = $deliver_date;
        $repairing_data->save();
    }

public function repair_invo($reference_no){

    $repairing= Repairing::where('reference_no', $reference_no)->first();
    $customer = Customer::where('id', $repairing->customer_id)->first();
    $warranty = Warranty::where('id', $repairing->warranty_id)->first();
    $product= Product::where('id', $warranty->product_id)->first();
    $shop = Settingdata::first();
    $invo = Posinvodata::first();
    $condition = Inspectiondata::first();


return view ('maintenance.repair_invo', compact('repairing','invo', 'customer', 'warranty', 'condition', 'product', 'shop'));
}



public function add_university(Request $request){

    $user_id = Auth::id();
    $data= User::where('id', $user_id)->first();
    $user= $data->username;

    $university = new University();
    $university->university_id = genUuid() . time();
    $university->university_name = $request['university_name'];
    $university->university_address = $request['university_address'];
    $university->added_by = $user;
    $university->user_id = $user_id;
    $university->save();
    return response()->json(['university_id' => $university->id]);

}

//workplace

public function add_workplace(Request $request){

    $user_id = Auth::id();
    $data= User::where('id', $user_id)->first();
    $user= $data->username;

    $workplace = new Workplace();
    $workplace->workplace_id = genUuid() . time();
    $workplace->ministry_id = $request['ministry_id'];
    $workplace->workplace_name = $request['workplace_name'];
    $workplace->workplace_address = $request['workplace_address'];
    $workplace->added_by = $user;
    $workplace->user_id = $user_id;
    $workplace->save();
    return response()->json(['workplace_id' => $workplace->id]);

}

//ministry

public function add_ministry(Request $request){

    $user_id = Auth::id();
    $data= User::where('id', $user_id)->first();
    $user= $data->username;

    $ministry = new Ministry();
    $ministry->ministry_id = genUuid() . time();
    $ministry->ministry_name = $request['ministry_name'];
    $ministry->added_by = $user;
    $ministry->user_id = $user_id;
    $ministry->save();
    return response()->json(['ministry_id' => $ministry->id]);

}


}


