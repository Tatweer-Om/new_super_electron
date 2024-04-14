<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\User;
use App\Models\Ministry;
use App\Models\Workplace;
use App\Models\University;
use App\Models\Nationality;
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

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_draw_modal"
                        type="button" onclick=edit("'.$value->draw_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->draw_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
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
        $draw->draw_detail = $request['draw_detail'];
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

        $data = [
            'draw_id' => $draw_data->draw_id,
            'draw_name' => $draw_data->draw_name,
            'draw_date' => $draw_data->draw_date,
            'draw_starts' => $draw_data->draw_starts,
            'draw_ends' => $draw_data->draw_ends,
            'draw_detail' => $draw_data->draw_detail,
            'nationality_id'=>$draw_data->nationality_id,
            'university_id'=>$draw_data->university_id,
            'ministry_id'=>$draw_data->ministry_id,
            'workplace_id'=>$draw_data->workplace_id,
            'male'=>$draw_data->male,
            'female'=>$draw_data->female,
            'draw_type_employee'=>$draw_data->draw_type_employee,
            'draw_type_student'=>$draw_data->draw_type_student,
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
        $draw->draw_detail = $request->input('draw_detail');

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

}
