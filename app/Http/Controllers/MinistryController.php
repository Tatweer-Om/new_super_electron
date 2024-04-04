<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function index(){

        return view ('customer_module.ministry');
    }

    public function show_ministry()
    {
        $sno=0;

        $view_ministry= Ministry::all();
        if(count($view_ministry)>0)
        {
            foreach($view_ministry as $value)
            {

                $ministry_name='<a href="javascript:void(0);">'.$value->ministry_name.'</a>';
  
                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_ministry_modal"
                        type="button" onclick=edit("'.$value->ministry_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->ministry_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $ministry_name, 
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

    public function add_ministry(Request $request){

        $ministry = new Ministry();
        $ministry->ministry_id = genUuid() . time();
        $ministry->ministry_name = $request['ministry_name']; 
        $ministry->added_by = 'admin';
        $ministry->user_id = '1';
        $ministry->save();
        return response()->json(['ministry_id' => $ministry->id]);

    }

    public function edit_ministry(Request $request){
        $ministry = new Ministry();
        $ministry_id = $request->input('id');
        // Use the Eloquent where method to retrieve the ministry by column name
        $ministry_data = Ministry::where('ministry_id', $ministry_id)->first();

        if (!$ministry_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.ministry_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'ministry_id' => $ministry_data->ministry_id,
            'ministry_name' => $ministry_data->ministry_name, 
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_ministry(Request $request){
        $ministry_id = $request->input('ministry_id');
        $ministry = Ministry::where('ministry_id', $ministry_id)->first();
        if (!$ministry) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.ministry_not_found', [], session('locale'))], 404);
        }

        $ministry->ministry_name = $request->input('ministry_name');
         $ministry->updated_by = 'admin';
        $ministry->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.ministry_update_lang', [], session('locale'))
        ]);
    }

    public function delete_ministry(Request $request){
        $ministry_id = $request->input('id');
        $ministry = Ministry::where('ministry_id', $ministry_id)->first();
        if (!$ministry) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.ministry_not_found', [], session('locale'))], 404);
        }
        $ministry->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.ministry_deleted_lang', [], session('locale'))
        ]);
    }




}
