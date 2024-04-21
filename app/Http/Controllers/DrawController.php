<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\User;
use App\Models\Ministry;
use App\Models\Workplace;
use App\Models\University;
use App\Models\PosOrder;
use App\Models\Nationality;
use App\Models\DrawWinner;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrawController extends Controller
{
    public function index(){

        $workplaces = Workplace::all();
        $universities = University::all();
        $ministries = Ministry::all();
        $nationality = Nationality::all();

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('25', $permit_array)) {

            return view ('draw.draw', compact('permit_array','workplaces','universities','nationality','ministries'));
        } else {

            return redirect()->route('home');
        }

    }

public function show_draw()
    {
        $sno=0;

        $view_draw= Draw::all();
        if(count($view_draw)>0)
        {
            foreach($view_draw as $value)
            {

                $draw_name='<a href="javascript:void(0);">'.$value->draw_name.'</a>';
                $draw_date='<a href="javascript:void(0);">'.$value->draw_date.'</a>';
                $draw_starts='<a href="javascript:void(0);">'.$value->draw_starts.'</a>';
                $draw_ends='<a href="javascript:void(0);">'.$value->draw_ends.'</a>';
                $draw_detail='<a href="javascript:void(0);">'.$value->draw_detail.'</a>';

                $modal='<a class="me-3 text-success" data-bs-toggle="modal" data-bs-target="#add_draw_modal"
                        type="button" onclick=edit("'.$value->draw_id.'")><i class="fas fa-edit"></i>
                        </a>
                        <a class="me-3 confirm-text text-danger"
                        onclick=del("'.$value->draw_id.'")><i class="fas fa-trash"></i>
                        </a>
                        <a class="me-3 confirm-text text-primary" href="'.url('draw_profile').'/'.$value->id.'"><i class="fas fa-dice"></i>
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $draw_name,
                            $draw_date,
                            $draw_starts,
                            $draw_ends,
                            $draw_detail,
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

    public function add_draw(Request $request){

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

        $draw = new draw();
        $draw->draw_id = genUuid() . time();
        $draw->draw_name = $request['draw_name'];
        $draw->draw_date = $request['draw_date'];
        $draw->draw_starts = $request['draw_starts'];
        $draw->draw_ends = $request['draw_ends'];
        $draw->amount = $request['amount'];
        $draw->draw_detail = $request['draw_detail'];
        $draw->draw_type_general = $request->has('draw_type') ? 1 : 0;
        $draw->nationality_id = $nationality_id;
        $draw->university_id = $student_university;
        $draw->ministry_id = $ministry_id;
        $draw->workplace_id = $employee_workplace;
        $draw->male = $request->has('male') ? 1 : 0;
        $draw->female = $request->has('female') ? 1 : 0;
        $draw->draw_type_employee = $request->has('draw_type_employee') ? 1 : 0;
        $draw->draw_type_student = $request->has('draw_type_student') ? 1 : 0;
        $draw->added_by = 'admin';
        $draw->user_id = '1';
        $draw->save();
        return response()->json(['draw_id' => $draw->id]);

    }

    public function edit_draw(Request $request){
        $draw = new draw();
        $draw_id = $request->input('id');

        $draw_data = Draw::where('draw_id', $draw_id)->first();


        if (!$draw_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.draw_not_found', [], session('locale'))], 404);
        }

        $nationality_id = explode(',' , $draw_data->nationality_id);
        $view_nationality= Nationality::all();
        $options_nat = ''; // Initialize an empty string to store option elements

        foreach ($view_nationality as $key => $nat) {
            $selected = in_array($nat->id, $nationality_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_nat .= '<option '.$selected.' value="'.$nat->id.'">'.$nat->nationality_name.'</option>';
        }

        // university_id
        $university_id = explode(',' , $draw_data->university_id);
        $view_university= University::all();
        $options_uni = ''; // Initialize an empty string to store option elements

        foreach ($view_university as $key => $uni) {
            $selected = in_array($uni->id, $university_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_uni .= '<option '.$selected.' value="'.$uni->id.'">'.$uni->university_name.'</option>';
        }

        // ministry_id
        $ministry_id = explode(',' , $draw_data->ministry_id);
        $view_ministry= Ministry::all();
        $options_min = ''; // Initialize an empty string to store option elements

        foreach ($view_ministry as $key => $min) {
            $selected = in_array($min->id, $ministry_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_min .= '<option '.$selected.' value="'.$min->id.'">'.$min->ministry_name.'</option>';
        }

        // workplace_id
        $workplace_id = explode(',' , $draw_data->workplace_id);
        $view_workplace= Workplace::all();
        $options_work = ''; // Initialize an empty string to store option elements

        foreach ($view_workplace as $key => $work) {
            $selected = in_array($work->id, $workplace_id) ? 'selected' : ''; // Check if the category ID is in the array

            // Concatenate the option element to the $options string
            $options_work .= '<option '.$selected.' value="'.$work->id.'">'.$work->workplace_name.'</option>';
        }

        $data = [
            'draw_id' => $draw_data->draw_id,
            'draw_name' => $draw_data->draw_name,
            'draw_date' => $draw_data->draw_date,
            'draw_starts' => $draw_data->draw_starts,
            'draw_ends' => $draw_data->draw_ends,
            'amount' => $draw_data->amount,
            'draw_detail' => $draw_data->draw_detail,
            'options_work' => $options_work,
            'options_min' => $options_min,
            'options_uni' => $options_uni,
            'options_nat' => $options_nat,
            'male' => $draw_data->male,
            'female' => $draw_data->female,
            'draw_type_general' => $draw_data->draw_type_general,
            'draw_type_student' => $draw_data->draw_type_student,
            'draw_type_employee' => $draw_data->draw_type_employee,
        ];

        return response()->json($data);
    }

    public function update_draw(Request $request){
        $draw_id = $request->input('draw_id');
        $draw = Draw::where('draw_id', $draw_id)->first();
        if (!$draw) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.draw_not_found', [], session('locale'))], 404);
        }
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

        $draw->draw_name = $request->input('draw_name');
        $draw->draw_date = $request->input('draw_date');
        $draw->draw_starts = $request->input('draw_starts');
        $draw->draw_ends = $request->input('draw_ends');
        $draw->amount = $request['amount'];
        $draw->draw_detail = $request->input('draw_detail');
        $draw->nationality_id = $nationality_id;
        $draw->university_id = $student_university;
        $draw->ministry_id = $ministry_id;
        $draw->workplace_id = $employee_workplace;
        $draw->draw_type_general = $request->has('draw_type_general') ? 1 : 0;
        $draw->male = $request->has('male') ? 1 : 0;
        $draw->female = $request->has('female') ? 1 : 0;
        $draw->draw_type_employee = $request->has('draw_type_employee') ? 1 : 0;
        $draw->draw_type_student = $request->has('draw_type_student') ? 1 : 0;

        $draw->updated_by = 'admin';
        $draw->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.draw_update_lang', [], session('locale'))
        ]);
    }

    public function delete_draw(Request $request){
        $draw_id = $request->input('id');
        $draw = Draw::where('draw_id', $draw_id)->first();
        if (!$draw) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.draw_not_found', [], session('locale'))], 404);
        }
        $draw->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.draw_deleted_lang', [], session('locale'))
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

    // draw profile
    public function draw_profile($id){

        $draw = Draw::where('id', $id)->first();
        $draw_winner = DrawWinner::where('draw_id', $id)->first();
        $draw_customer ="";
        if($draw->draw_type_employee==4)
        {
            $draw_customer.='<span class="badges bg-lightgreen">'.trans('messages.genral_lang', [], session('locale')).'</span>'; 
        }
        if($draw->draw_type_employee==1)
        {
            $draw_customer.='<span class="badges bg-lightgreen">'.trans('messages.offer_student_lang', [], session('locale')).'</span>'; 
        }
        if($draw->draw_type_employee==3)
        {
            $draw_customer.='<span class="badges bg-lightgreen">'.trans('messages.offer_employee_lang', [], session('locale')).'</span>'; 
        }
        $lucky_customer = [];
        
        if(!empty($draw_winner))
        {
            $status = 2;
        }
        else
        {

         
            $start_date = $draw->draw_starts;
            $end_date = $draw->draw_ends; 
            $all_sales = PosOrder::select('customer_id')
                ->whereNotNull('customer_id')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->groupBy('customer_id')
                ->get();

            
             
            foreach ($all_sales as $key => $value) {
                echo $value->customer_id; exit;
                $customer = Customer::where('id', $value->customer_id)->first();
                 
                $first_step = 0;
                if($customer->customer_type==1)
                {
                    $university_ids = explode(',', $draw->university_id);
                    if($draw->draw_type_student==1)
                    {
                        if (in_array($customer->student_university, $university_ids)) {
                            $first_step++;
                        } 
                    }
                }
                else if($customer->customer_type==3)
                {
                    
                    $ministry_ids = explode(',', $draw->ministry_id);
                    $workplace_ids = explode(',', $draw->workplace_id);
                    if($draw->draw_type_employee==1)
                    {
                    
                        if (in_array($customer->ministry_id, $ministry_ids)) {
                            if (in_array($customer->employee_workplace, $workplace_ids)) {
                                $first_step++;
                                
                            }
                        } 
                    }
                }
                else if($customer->customer_type==4)
                {
                    $first_step++;
                }
                if($first_step>0)
                { 
                    if($customer->gender==1)
                    {
                        if($draw->male==1)
                        {
                            $first_step++;
                        }
                    }
                    else if($customer->gender==2)
                    {
                        if($draw->female==1)
                        {
                            $first_step++;
                        }
                    }
                }
              
                if($first_step>1)
                {
                    
                    $nationality_ids = explode(',', $draw->nationality_id);
                    if (in_array($customer->nationality_id, $nationality_ids)) {
                        $first_step++;
                    }
                }

                if($first_step>2)
                {
                    $sum_paid_amount = PosOrder::where('customer_id', $value->customer_id)
                        ->whereDate('created_at', '>=', $draw->draw_starts)
                        ->whereDate('created_at', '<=', $draw->draw_ends)
                        ->sum('paid_amount'); // Get the sum of paid_amount column
                    $total_time = 0;
                    
                    if($sum_paid_amount >= $draw->amount)
                    {
                        
                        $total_time = $sum_paid_amount / $draw->amount;
                        $total_time_final = intval($total_time);
                        for ($i=0; $i < $total_time_final ; $i++) { 
                            $customer_name = $customer->customer_name;
                            $customer_number = $customer->customer_number;
                            $formatted_customer = $customer_name . "(" . $customer_number . ")";
                            $lucky_customer[$i]['customer_name'] = $formatted_customer;
                            $lucky_customer[$i]['customer_id'] = $customer->id;
                        }
                    }
                    else
                    {
                        continue;
                    }
                }
                else
                {
                    continue;
                }
            }
            $status = 1;
        }

        
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('25', $permit_array)) {

            return view ('draw.draw_profile', compact('permit_array','draw_customer','draw_winner','status','draw','lucky_customer'));
        } else {

            return redirect()->route('home');
        }

    }

    // add winner history
    public function add_winner_history(Request $request){

        $drawwinner = Draw::where('id', $request['id'])->first();
        $drawwinner = new DrawWinner(); 
        $drawwinner->draw_id = $request['draw_id'];
        $drawwinner->customer_id = $request['id']; 
        $drawwinner->added_by = 'admin';
        $drawwinner->user_id = '1';
        $drawwinner->save(); 

    }

}
