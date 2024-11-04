<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workplace;
use App\Models\Ministry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkplaceController extends Controller
{
    public function index (){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $ministry= Ministry::all();

        if ($permit_array && in_array('9', $permit_array)) {

            return view('customer_module.workplace', compact('ministry', 'permit_array'));
        } else {

            return redirect()->route('home');
        }


    }
    public function show_workplace()
    {
        $sno=0;

        $view_workplace= Workplace::all();
        if(count($view_workplace)>0)
        {
            foreach($view_workplace as $value)
            {

                // ministry_namne
                $ministry_name = getColumnValue('ministries','id',$value->ministry_id,'ministry_name');

                $workplace_name='<a href="javascript:void(0);">'.$value->workplace_name.'</a>';

                $workplace_address='<a href="javascript:void(0);">'.$value->workplace_address.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_workplace_modal"
                        type="button" onclick=edit("'.$value->workplace_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->workplace_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $ministry_name,
                            $workplace_name,
                            $workplace_address,
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

    public function edit_workplace(Request $request){
        $workplace = new Workplace();
        $workplace_id = $request->input('id');
        // Use the Eloquent where method to retrieve the workplace by column name
        $workplace_data = Workplace::where('workplace_id', $workplace_id)->first();

        if (!$workplace_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.workplace_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'ministry_id' => $workplace_data->ministry_id,
            'workplace_id' => $workplace_data->workplace_id,
            'workplace_name' => $workplace_data->workplace_name,
            'workplace_address' => $workplace_data->workplace_address,
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_workplace(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;
        $workplace_id = $request->input('workplace_id');
        $workplace = Workplace::where('workplace_id', $workplace_id)->first();
        if (!$workplace) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.workplace_not_found', [], session('locale'))], 404);
        }

        $workplace->ministry_id = $request->input('ministry_id');
        $workplace->workplace_name = $request->input('workplace_name');
        $workplace->workplace_address = $request->input('workplace_address');
        $workplace->updated_by = $user;
        $workplace->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.workplace_update_lang', [], session('locale'))
        ]);
    }

    public function delete_workplace(Request $request){
        $workplace_id = $request->input('id');
        $workplace = Workplace::where('workplace_id', $workplace_id)->first();
        if (!$workplace) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.workplace_not_found', [], session('locale'))], 404);
        }
        $workplace->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.workplace_deleted_lang', [], session('locale'))
        ]);
    }
}
