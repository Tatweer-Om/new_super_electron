<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use App\Models\User;
use App\Models\Brand;
use App\Models\Account;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\IssueType;
use App\Models\Repairing;
use App\Models\Workplace;
use App\Models\Technician;
use App\Models\University;
use Illuminate\Http\Request;
use App\Models\Localissuetype;
use App\Models\PosOrderDetail;
use Illuminate\Support\Carbon;
use App\Models\Localmaintenance;
use App\Models\Localrepairproduct;
use App\Models\Localrepairservice;
use Illuminate\Support\Facades\DB;
use App\Models\Product_qty_history;
use Illuminate\Support\Facades\Log;
use App\Models\Localmaintenancebill;
use App\Models\Ministry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\MaintenanceStatusHistory;
use App\Models\LocalMaintenanceStatusHistory;

class LocalmaintenanceController extends Controller
{
    public function index (){

        $active_cat= 'all';
        $workplaces = Workplace::all();
        $universities = University::all();
        $view_issuetype  = Issuetype::all();
        $view_technicians = Technician::all();
        $orders = PosOrder::latest()->take(15)->get();
        $view_category = Category::all();
        $view_brand = Brand::all();
        $view_customer = Customer::all();
        $count_products = Product::all()->count();
        $ministries = Ministry::all();
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        $view_account = Account::where('account_type', 1)->get();
        if ($permit_array && in_array('12', $permit_array)) {

            return view ('maintenance.local_maintenance', compact('ministries', 'view_issuetype', 'view_brand', 'view_customer', 'view_technicians', 'view_category',
            'count_products', 'active_cat', 'universities', 'workplaces', 'permit_array'));
        } else {

            return redirect()->route('home');
        }
        // account


    }


    //customer details

    public function add_maintenance_customer(Request $request){

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
        $customer->national_id = $request['national_id'];
        $customer->customer_number = $request['customer_number'];
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
        $customer->id;

        // customer
        $customer_datas = Customer::all();

        $customer_data='<option value="">'.trans('messages.choose_lang', [], session('locale')).'</option>
        ';
        foreach ($customer_datas as $key => $add) {
            $selected = "";
            if($add->id == $customer->id);
            {
                $selected = "selected ='true'";
            }
            $customer_data.='<option '.$selected.' value="'.$add->id.'" >'.$add->customer_name.'</option>';
        }
        $return_value =$customer_data;
        return response()->json(['customer_id' => $return_value, 'status' => 1]);


    }









 // add repait maintenance

    public function add_local_maintenance(Request $request){


        // refernce no
        $repairing_data = Localmaintenance::orderBy('id', 'desc')
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
        if(strlen($reference_no)!=4)
        {
           $len = (strlen($reference_no)-8);
           $reference_no = substr($reference_no,$len);
        }
        if($request['repairing_type']==3)
        {

            $warranty_data = Localmaintenance::where('reference_no', $request['warranty_reference_no'])
                                ->where('status', 5)->first();
            $remaining_days = get_days_from_date($warranty_data->deliver_date , date('Y-m-d'));
            if($remaining_days > $warranty_data->warranty_day)
            {
                return response()->json(['status' => 3]);
                exit;
            }
            else
            {
                if($warranty_data)
                {
                    $product_name = $warranty_data->product_name;
                    $category_id = $warranty_data->category_id;
                    $brand_id = $warranty_data->brand_id;
                    $imei_no = $warranty_data->imei_no;
                }
                else
                {
                    return response()->json(['status' => 2]);
                    exit;
                }
            }
            $repairing_type = 1;

        }
        else
        {
            $product_name = $request['product_name'];
            $category_id = $request['category_id'];
            $brand_id = $request['brand_id'];
            $imei_no = $request['imei_no'];
            $repairing_type = $request['repairing_type'];
        }


        //get cutomer
        $customer_id = $request['customer_id'];

        $local_main = new Localmaintenance();
        $local_main->reference_no = $reference_no;
        $local_main->customer_id = $customer_id;
        $local_main->receive_date = $request['receive_date'];
        $local_main->product_name = $product_name;
        $local_main->category_id = $category_id;
        $local_main->brand_id = $brand_id;
        $local_main->imei_no = $imei_no;
        $local_main->warranty_day = $request['warranty_day'];
        $local_main->repairing_type = $repairing_type;
        $local_main->warranty_reference_no = $request['warranty_reference_no'];
        $local_main->inspection_cost = $request['inspection_cost'];
        $local_main->review_by = $request['technician_id'];
        $local_main->notes = $request['notes'];
        $local_main->added_by = 'admin';
        $local_main->user_id = '1';

        $local_main->save();
        $local_main_id = $local_main->id;


        // maintenance histoy status
        $status_history = new LocalMaintenanceStatusHistory();
        $status_history->reference_no = $reference_no;
        $status_history->repair_id = $local_main_id;
        $status_history->customer_id  = $customer_id;
        $status_history->status = 1;
        $status_history->added_by = 'admin';
        $status_history->user_id = '1';
        $status_history->save();

        // customer add sms
        $customer_data = Customer::where('id', $customer_id)
                                ->first();
        $params = [
            'local_main_id' => $local_main_id ,
            'sms_status' => 4
        ];
        $sms = get_sms($params);
        sms_module($customer_data->customer_phone, $sms);
        //


        return response()->json(['status' => 1,'id'=>$local_main_id]);


    }

    // show maintenance

    public function show_local_maintenance(Request $request)
    {
        $sno=0;
        $status = $request['status'];


        $query = Localmaintenance::query();
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
                } else if ($value->status == 4) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.ready_status_lang', [], session('locale')) . "</span>";
                } else if ($value->status == 5) {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.deleivered_status_lang', [], session('locale')) . "</span>";
                }

                // Qty type
                $repairing_type = "";
                if ($value->repairing_type == 1) {
                    $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.repair_lang', [], session('locale')) . "</span>";
                } else if ($value->repairing_type == 2) {
                    $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_lang', [], session('locale')) . "</span>";
                } else if ($value->repairing_type == 3) {
                    $repairing_type = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.warranty_lang', [], session('locale')) . "</span>";
                }


                if($value->status != 5)
                {
                    $modal='<a class="me-3  text-primary" target="_blank" href="'.url('local_maintenance_profile').'/'.$value->id.'"><i class="fas fa-eye"></i></a>';
                }
                else
                {
                    $modal='<a class="me-3  text-primary" target="_blank" href="'.url('history_local_record').'/'.$value->id.'"><i class="fas fa-info"></i></a>';
                }




                // tim date
                $data_time=get_date_time($value->created_at);
                $sno++;
                $json[]= array(
                            $value->reference_no,
                            $value->product_name,
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
        $view_issuetype= IssueType::all();
        $view_technicians= Technician::all();
        $view_product= Product::where('product_type', 2)->get();
        $repair_detail = Localmaintenance::where('id', $id)->first();

        $all_technicians = explode(',', $repair_detail->technician_id);

        if($repair_detail->status == 5)
        {
            return redirect()->route('history_local_record', ['id' => $id]);
            exit;
        }
        $customer_data = Customer::where('id', $repair_detail->customer_id)->first();
        $title = $repair_detail->product_name;

        // warranty type
         $imei = $repair_detail->imei_no;

        // Qty type
        $repairing_type="";
        if ($repair_detail->repairing_type == 1) {
            $repairing_type = trans('messages.repair_lang', [], session('locale'));
        } else if ($repair_detail->repairing_type == 2) {
            $repairing_type = trans('messages.inspection_)lang', [], session('locale'));
        }

        // product sum
        $pro_sum = Localrepairproduct::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));
        // service sum
        $serv_sum = Localrepairservice::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));


        $repairing_history = Localmaintenance::where('reference_no', $repair_detail->warranty_reference_no)
                            ->where('status', 5)
                            ->get();
        // dd($repairing_history); exit;
        $repairing_history_record = "";
        if(!empty($repairing_history))
        {
            foreach ($repairing_history as $key => $history) {
                // product sum
                $pro_sum_history = Localrepairproduct::where('repair_id', $history->id)
                ->sum(DB::raw('(cost)'));
                // service sum
                $serv_sum_history = Localrepairservice::where('repair_id', $history->id)
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
        $status_history = LocalMaintenanceStatusHistory::where('reference_no', $repair_detail->reference_no)
                                                ->get();
        $status_history_record = "";
        if(!empty($status_history))
        {
            foreach ($status_history as $key => $his) {
                 // status
                if ($his->status == "1") {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_status_lang', [], session('locale')) . "</span>";
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


        return view ('maintenance.local_maintenance_profile', compact('view_issuetype', 'status_history_record', 'view_technicians', 'all_technicians', 'repairing_history_record', 'serv_sum', 'pro_sum', 'imei', 'title', 'repairing_type', 'customer_data', 'view_service', 'repair_detail', 'view_product'));
    }


    // show history record
    public function history_local_record($id){
        $view_service= Service::all();
        $view_technicians= Technician::all();
        $view_issuetype= Issuetype::all();
        $view_product= Product::where('product_type', 2)->get();
        $repair_detail = Localmaintenance::where('id', $id)->first();
        $all_technicians = explode(',', $repair_detail->technician_id);
        $customer_data = Customer::where('id', $repair_detail->customer_id)->first();

        $title = $repair_detail->product_name;


        $imei = $repair_detail->imeo_no ;

        // Qty type

        $repairing_type = $repair_detail->repairing_type ;

        // product sum
        $pro_sum = Localrepairproduct::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));
        // service sum
        $serv_sum = Localrepairservice::where('repair_id', $id)
                                    ->sum(DB::raw('(cost)'));

        $repairing_history = Localmaintenance::where('reference_no', $repair_detail->warranty_reference_no)
        ->where('status', 5)->get();

        // dd($repairing_history); exit;
        $repairing_history_record = "";
        if(!empty($repairing_history))
        {
            foreach ($repairing_history as $key => $history) {
                // product sum
                $pro_sum_history = Localrepairproduct::where('repair_id', $history->id)
                ->sum(DB::raw('(cost)'));
                // service sum
                $serv_sum_history = Localrepairservice::where('repair_id', $history->id)
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

        //get history
        $reference_no = $repair_detail->reference_no;
        $products_data = Localrepairproduct::where('reference_no', $reference_no)->get();
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

        $services_data = Localrepairservice::where('reference_no', $reference_no)->get();
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


        $issuetypes_data = Localissuetype::where('reference_no', $reference_no)->get();
        $issuetype_data = "";
        $total_issuetype = 0;
        if(!empty($issuetypes_data))
        {
            foreach ($issuetypes_data as $key => $serv) {
                $iss_data = Issuetype::where('id', $serv->issuetype_id)->first();
                $title_iss = $iss_data->issuetype_name;
                $issuetype_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="issuetypeimgname">
                                            <a href="javascript:void(0);">'.$title_iss.'</a>
                                        </div>
                                    </td>
                                 </tr>';
            }
        }
        else
        {
            $issuetype_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                    </tr>';
        }

        // status history
        $status_history = LocalMaintenanceStatusHistory::where('reference_no', $repair_detail->reference_no)
                                                ->get();
        $status_history_record = "";
        if(!empty($status_history))
        {
            foreach ($status_history as $key => $his) {
                 // status
                if ($his->status == "1") {
                    $status = "<span class='badges bg-lightgreen badges_table'>" . trans('messages.receive_status_lang', [], session('locale')) . "</span>";
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

        return view ('maintenance.history_local_record', compact('view_issuetype', 'issuetype_data','repairing_history_record', 'status_history_record', 'view_technicians','all_technicians', 'product_data', 'service_data', 'serv_sum', 'pro_sum', 'imei', 'title', 'repairing_type', 'customer_data', 'view_service', 'repair_detail', 'view_product'));
    }

    // add service
    public function add_service(Request $request){

        $service = new Service();
        $service->service_id = genUuid() . time();
        $service->service_name = $request['service_name'];
        $service->service_cost = $request['service_cost'];
        $service->service_detail = $request['service_detail'];
        $service->added_by = 'admin';
        $service->user_id = '1';
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
        $repair_data = Localmaintenance::where('reference_no', $reference_no)->first();
        $repair_data->technician_id = $technician_id;
        $repair_data->save();
    }
    // get amintenane data
    public function get_maintenance_data(Request $request){

        $reference_no = $request['reference_no'];
        $products_data = Localrepairproduct::where('reference_no', $request['reference_no'])->get();
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

        $services_data = Localrepairservice::where('reference_no', $request['reference_no'])->get();
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

        $issuetypes_data = 	localissuetype::where('reference_no', $request['reference_no'])->get();
        $issuetype_data = "";
        $total_issuetype = 0;
        if(!empty($issuetypes_data))
        {
            foreach ($issuetypes_data as $key => $iss) {
                $iss_data = Issuetype::where('id', $iss->issuetype_id)->first();
                $title_iss = $iss_data->issuetype_name;

                $issuetype_data .='<tr class="odd">
                                    <td class="sorting_1">
                                        <div class="issuetypeimgname">
                                            <a href="javascript:void(0);">'.$title_iss.'</a>
                                        </div>
                                    </td>
                                    <td><a class="me-2 confirm-text p-2 mb-0" onclick=del_issuetype("'.$iss->id.'") href="javascript:void(0);"><i class="fas fa-trash"></i></a></td>
                                </tr>';
            }
        }
        else
        {
            $issuetype_data .='<tr class="odd">
                                    <td colspan="3">'.trans('messages.nothing_added_lang', [], session('locale')).'</td>
                                 </tr>';
        }
        return response()->json(['issuetype_data' => $issuetype_data,'product_data' => $product_data,'service_data' => $service_data,'total_service' => $total_service,'total_product' => $total_product]);

    }

    // add maintenance product
    public function add_maintenance_product(Request $request){
        $reference_no = $request['reference_no'];
        $product_id = $request['product_id'];
        $repair_data = Localmaintenance::where('reference_no', $request['reference_no'])->first();
        $pro_data = Product::where('id', $product_id)->first();
        if($pro_data->quantity<=0)
        {
            return response()->json(['status' => 2]);
            exit;
        }

        $repair_product = new Localrepairproduct();
        $repair_product->reference_no = $reference_no;
        $repair_product->repair_id = $repair_data->id;
        $repair_product->customer_id  = $repair_data->customer_id ;
        $repair_product->product_id = $product_id;
        $repair_product->cost = $pro_data->sale_price;
        $repair_product->added_by = 'admin';
        $repair_product->user_id = '1';
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
        $product_qty_history->added_by = 'admin';
        $product_qty_history->user_id = '1';
        $product_qty_history->save();

        // update qty

        $pro_data->quantity=$pro_data->quantity - 1;
        $pro_data->save();

        return response()->json(['status' => 1]);
    }

    public function delete_maintenance_product(Request $request){
        $id = $request->input('id');
        $maintenance_product = Localrepairproduct::where('id', $id)->first();
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
        $product_qty_history->added_by = 'admin';
        $product_qty_history->user_id = '1';
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
        $reference_no = $request['reference_no'];
        $service_id = $request['service_id'];
        $repair_data = Localmaintenance::where('reference_no', $request['reference_no'])->first();
        $serv_data = Service::where('id', $service_id)->first();

        $repair_service = new Localrepairservice();
        $repair_service->reference_no = $reference_no;
        $repair_service->repair_id = $repair_data->id;
        $repair_service->customer_id  = $repair_data->customer_id ;
        $repair_service->service_id = $service_id;
        $repair_service->cost = $serv_data->service_cost;
        $repair_service->added_by = 'admin';
        $repair_service->user_id = '1';
        $repair_service->save();
    }

    public function delete_maintenance_service(Request $request){
        $id = $request->input('id');
        $maintenance_service = Localrepairservice::where('id', $id)->first();
        if (!$maintenance_service) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        $maintenance_service->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_deleted_lang', [], session('locale'))
        ]);
    }


    // add maintenance issuetype
    public function add_maintenance_issuetype(Request $request){
        $reference_no = $request['reference_no'];
        $issuetype_id = $request['issuetype_id'];
        $repair_data = Localmaintenance::where('reference_no', $request['reference_no'])->first();
        $iss_data = Issuetype::where('id', $issuetype_id)->first();

        $repair_issuetype = new Localissuetype();
        $repair_issuetype->reference_no = $reference_no;
        $repair_issuetype->repair_id = $repair_data->id;
        $repair_issuetype->customer_id  = $repair_data->customer_id ;
        $repair_issuetype->issuetype_id = $issuetype_id;
        $repair_issuetype->added_by = 'admin';
        $repair_issuetype->user_id = '1';
        $repair_issuetype->save();
    }

    public function delete_maintenance_issuetype(Request $request){
        $id = $request->input('id');
        $maintenance_issuetype = Localissuetype::where('id', $id)->first();
        if (!$maintenance_issuetype) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        $maintenance_issuetype->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_deleted_lang', [], session('locale'))
        ]);
    }

    // update_status
    public function change_maintenance_status(Request $request){
        $status = $request->input('status');
        $reference_no = $request->input('reference_no');
        $repairing_data = Localmaintenance::where('reference_no', $reference_no)->first();
        $repairing_data->status = $status;

        $repairing_data->save();

        $status_history = new LocalMaintenanceStatusHistory();
        $status_history->reference_no = $reference_no;
        $status_history->repair_id = $repairing_data->id;
        $status_history->customer_id  = $repairing_data->customer_id ;
        $status_history->status = $status;
        $status_history->added_by = 'admin';
        $status_history->user_id = '1';
        $status_history->save();

        // make localmaintenancebill
        if($status == 5)
        {
            $sumproduct = Localrepairproduct::where('reference_no', $reference_no)
                                            ->sum(DB::raw('(cost)'));
            if($sumproduct<0 || empty($sumproduct))
            {
                $sumproduct=0;
            }
            $sumservice = Localrepairservice::where('reference_no', $reference_no)
                                            ->sum(DB::raw('(cost)'));
            if($sumservice<0 || empty($sumservice))
            {
                $sumservice=0;
            }
            $inspection_cost = $repairing_data->inspection_cost;
            if($inspection_cost<0 || empty($inspection_cost))
            {
                $inspection_cost=0;
            }
            $grand_total = $sumproduct + $sumservice +$inspection_cost;
            $local_main_bill = new Localmaintenancebill();
            $local_main_bill->reference_no = $reference_no;
            $local_main_bill->customer_id = $repairing_data->customer_id;
            $local_main_bill->warranty_reference_no = $repairing_data->warranty_reference_no;
            $local_main_bill->grand_total = $grand_total;
            $local_main_bill->remaining = $grand_total;
            $local_main_bill->added_by = 'admin';
            $local_main_bill->user_id = '1';
            $local_main_bill->save();
        }

        if($status==4)
        {
            // customer add sms
            $customer_data = Customer::where('id', $repairing_data->customer_id)
            ->first();
            $params = [
                'local_main_id' => $repairing_data->id,
                'status' => $status,
                'sms_status' => 5
            ];
            $sms = get_sms($params);
            sms_module($customer_data->customer_phone, $sms);
            //

        }

    }

    // update_repair_type
    public function change_repair_type(Request $request){
        $type = $request->input('type');
        $reference_no = $request->input('reference_no');
        $repairing_data = Localmaintenance::where('reference_no', $reference_no)->first();
        $repairing_data->repairing_type = $type;
        if($type==1)
        {
            $repairing_data->inspection_cost = NULL;
        }
        $repairing_data->save();
        // changer repair type

    }


    // update_deliver_date
    public function change_deliver_date(Request $request){
        $deliver_date = $request->input('deliver_date');
        $warranty_day = $request->input('warranty_day');
        $reference_no = $request->input('reference_no');
        $repairing_data = Localmaintenance::where('reference_no', $reference_no)->first();
        $repairing_data->deliver_date = $deliver_date;
        $repairing_data->warranty_day = $warranty_day;
        $repairing_data->save();
    }
}
