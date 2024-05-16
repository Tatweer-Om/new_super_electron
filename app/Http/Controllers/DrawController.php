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
use App\Models\DrawSingle;
use App\Models\Customer;
use App\Models\DrawCustomer;
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
                // <a class="me-3 text-success" data-bs-toggle="modal" data-bs-target="#add_draw_modal"
                // type="button" onclick=edit("'.$value->draw_id.'")><i class="fas fa-edit"></i>
                // </a>
                $modal='
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

        // Check if any draw has status 1
        $drawWithStatus1 = Draw::where('status', 1)->exists();

        // If any draw has status 1, return an error response
        if ($drawWithStatus1) {
            return response()->json(['error' => 2]);
            exit;
        }

        $draw = new draw();
        $draw->draw_id = genUuid() . time();
        $draw->draw_name = $request['draw_name'];
        $draw->draw_date = $request['draw_date'];
        $draw->draw_starts = $request['draw_starts'];
        $draw->draw_ends = $request['draw_ends'];
        $draw->amount = $request['amount'];
        $draw->draw_total = $request['draw_total'];
        $draw->draw_detail = $request['draw_detail'];
        $draw->added_by = 'admin';
        $draw->user_id = '1';
        $draw->save();
        $draw_id = $draw->id;
        // save the total draw
        $single_draw_date = $request['single_draw_date'];
        $gift = $request['gift'];
        for ($i=0; $i < count($single_draw_date) ; $i++) {
            $draw_single = new DrawSingle();
            $draw_single->draw_id = $draw_id;
            $draw_single->gift = $gift[$i];
            $draw_single->draw_date = $single_draw_date[$i];
            $draw_single->added_by = 'admin';
            $draw_single->user_id = '1';
            $draw_single->save();
        }


        return response()->json(['draw_id' => $draw->id , 'error' => 1]);

    }

    public function edit_draw(Request $request){
        $draw = new draw();
        $draw_id = $request->input('id');

        $draw_data = Draw::where('draw_id', $draw_id)->first();


        if (!$draw_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.draw_not_found', [], session('locale'))], 404);
        }


        // get total draw
        $draw_single = Drawsingle::where('draw_id', $draw_data->id)->get();
        $i = 1;
        $draw_total_div = "";
        foreach ($draw_single as $key => $value) {
             $draw_total_div .= '
                               <div class="col-md-6 col-sm-12 col-12">
                               <div class="form-group">
                               <label for="gift'.$i.'">'.trans('messages.gift_lang', [], session('locale')).' '.$i.'</label>
                               <input type="text" class="form-control gift" value="'.$value->gift.'" name="gift[]" id="gift1">
                               </div>
                               </div>
                               <div class="col-md-6 col-sm-12 col-12">
                               <div class="form-group">
                               <label for="draw_date'.$i.'">'.trans('messages.draw_date_lang', [], session('locale')).' '.$i.'</label>
                               <input type="text" class="form-control single_draw_date datepick" value="'.$value->draw_date.'" name="single_draw_date[]" id="draw_date'.$i.'">
                               </div>
                               </div>
                               </div>';
        }

        //
        $data = [
            'draw_id' => $draw_data->draw_id,
            'draw_name' => $draw_data->draw_name,
            'draw_date' => $draw_data->draw_date,
            'draw_starts' => $draw_data->draw_starts,
            'draw_ends' => $draw_data->draw_ends,
            'amount' => $draw_data->amount,
            'draw_total' => $draw_data->draw_total,
            'draw_detail' => $draw_data->draw_detail,
            'draw_total_div' => $draw_total_div,

        ];

        return response()->json($data);
    }

    public function update_draw(Request $request){
        $draw_id = $request->input('draw_id');
        $draw = Draw::where('draw_id', $draw_id)->first();
        if (!$draw) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.draw_not_found', [], session('locale'))], 404);
        }


        $draw->draw_name = $request->input('draw_name');
        $draw->draw_date = $request->input('draw_date');
        $draw->draw_starts = $request->input('draw_starts');
        $draw->draw_ends = $request->input('draw_ends');
        $draw->amount = $request['amount'];
        $draw->draw_total = $request['draw_total'];
        $draw->draw_detail = $request->input('draw_detail');
        $draw->updated_by = 'admin';
        $draw->save();


        // save the total draw
        DrawSingle::where('draw_id', $draw->id)->delete();
        $single_draw_date = $request['single_draw_date'];
        $gift = $request['gift'];
        for ($i=0; $i < count($single_draw_date) ; $i++) {
            $draw_single = new DrawSingle();
            $draw_single->draw_id = $draw->id;
            $draw_single->gift = $gift[$i];
            $draw_single->draw_date = $single_draw_date[$i];
            $draw_single->added_by = 'admin';
            $draw_single->user_id = '1';
            $draw_single->save();
        }


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
        for ($i=0; $i <count($ministry_id) ; $i++) {
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
        $lucky_customer = [];
        if($draw->status == 1)
        {
            $closestDraw = DrawSingle::where('draw_id', $id) // Specify the draw ID
                                   ->where('status', 1) // Filter by status
                                //    ->whereDate('draw_date', '>=', $todayDate) // Filter by draw date greater than or equal to today
                                   ->orderBy('id', 'asc') // Order by draw date ascending
                                   ->first(); // Get the first result
            if(!empty($closestDraw))
            {
                $draw_customer_data = DrawCustomer::where('draw_id', $id)
                                   ->where('draw_single_id', $closestDraw->id)
                                   ->inRandomOrder() // Retrieve records in random order
                                   ->get();
                $i =0;
                foreach ($draw_customer_data as $key => $value) {
                    $customer = Customer::where('id', $value->customer_id)->first();
                    $luckydraw_no = '0000000'.$value->luckydraw_no;
                    if(strlen($luckydraw_no)!=8)
                    {
                       $len = (strlen($luckydraw_no)-8);
                       $luckydraw_no = substr($luckydraw_no,$len);
                    }
                    $customer_number = $customer->customer_number; 
                    $formatted_customer = $customer_number. " (" . $luckydraw_no . ")";
                    $lucky_customer[$i]['customer_name'] = $formatted_customer;
                    $lucky_customer[$i]['customer_id'] = $customer->id;
                    $lucky_customer[$i]['single_draw_id'] = $closestDraw->id;
                    $lucky_customer[$i]['luckydraw_no'] = $value->luckydraw_no;
                    $i++;
                }
            }
        }

        $winner_data = DrawSingle::where('draw_id', $id) // Specify the draw ID
                                   ->where('status', 2) // Filter by status
                                //    ->whereDate('draw_date', '>=', $todayDate) // Filter by draw date greater than or equal to today
                                   ->orderBy('id', 'asc') // Order by draw date ascending
                                   ->get(); // Get the first result
            $all_winners = "";
            foreach($winner_data as $winner)
            {
                $customer = Customer::where('id', $winner->winner_id)->first();
                $luckydraw_no = '0000000'.$winner->luckydraw_no;
                if(strlen($luckydraw_no)!=8)
                {
                    $len = (strlen($luckydraw_no)-8);
                    $luckydraw_no = substr($luckydraw_no,$len);
                }
                $customer_name = $customer->customer_name;
                $customer_number = $customer->customer_number;
                $formatted_customer = $customer_number. " (" . $luckydraw_no . ")";

                $all_winners .='<div class="d-flex flex-column flex-1 align-content-center justify-content-center">
                    <h6 class="text-center">'.trans('messages.winner_lang', [], session('locale')).'</h6>
                    <div class="text-center"><h1>'.$formatted_customer.'</h1></div>
                    <div class="text-center"><h1>'.trans('messages.gift_lang', [], session('locale')).' : '.$winner->gift.'</h1></div>
                    <div class="text-center"><h1>'.get_date_only($winner->winning_time).'</h1></div>
                        <i class="fas fa-trophy fa-4x text-center" style="color:gold"></i>
                        <br><hr>
                    </div>
                 ';
            }


        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('25', $permit_array)) {

            return view ('draw.draw_profile', compact('permit_array','all_winners','draw','lucky_customer'));
        } else {

            return redirect()->route('home');
        }

    }

    // add winner history
    public function add_winner_history(Request $request){

        $drawwinner = DrawSingle::where('id', $request['single_draw_id'])->first();
        $drawwinner->luckydraw_no = $request['luckydraw_no'];
        $drawwinner->winner_id = $request['id'];
        $drawwinner->winning_time = date('Y-m-d H:i:s');
        $drawwinner->status = 2;
        $drawwinner->save();

        $draw_single_data = !DrawSingle::where('draw_id', $drawwinner->draw_id)
                                  ->where('status', 1)
                                  ->exists();
        if($draw_single_data)
        {
            $draw_data = Draw::where('id', $drawwinner->draw_id)->first();
            $draw_data->status = 2;
            $draw_data->save();
        }



    }

}
