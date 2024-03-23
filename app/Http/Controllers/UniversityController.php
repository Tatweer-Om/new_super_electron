<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index (){

        return view('customer_module.university');
    }
    public function show_university()
    {
        $sno=0;

        $view_university= University::all();
        if(count($view_university)>0)
        {
            foreach($view_university as $value)
            {

                $university_name='<a href="javascript:void(0);">'.$value->university_name.'</a>';

                $university_address='<a href="javascript:void(0);">'.$value->university_address.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_university_modal"
                        type="button" onclick=edit("'.$value->university_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->university_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $university_name,

                            $university_address,
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

    public function add_university(Request $request){

        $university = new University();
        $university->university_id = genUuid() . time();
        $university->university_name = $request['university_name'];
        $university->university_address = $request['university_address'];
        $university->added_by = 'admin';
        $university->user_id = '1';
        $university->save();
        return response()->json(['university_id' => $university->id]);

    }

    public function edit_university(Request $request){
        $university = new University();
        $university_id = $request->input('id');
        // Use the Eloquent where method to retrieve the university by column name
        $university_data = University::where('university_id', $university_id)->first();

        if (!$university_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.university_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'university_id' => $university_data->university_id,
            'university_name' => $university_data->university_name,
            'university_address' => $university_data->university_address,
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_university(Request $request){
        $university_id = $request->input('university_id');
        $university = University::where('university_id', $university_id)->first();
        if (!$university) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.university_not_found', [], session('locale'))], 404);
        }

        $university->university_name = $request->input('university_name');

        $university->university_address = $request->input('university_address');
        $university->updated_by = 'admin';
        $university->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.university_update_lang', [], session('locale'))
        ]);
    }

    public function delete_university(Request $request){
        $university_id = $request->input('id');
        $university = University::where('university_id', $university_id)->first();
        if (!$university) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.university_not_found', [], session('locale'))], 404);
        }
        $university->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.university_deleted_lang', [], session('locale'))
        ]);
    }





}
