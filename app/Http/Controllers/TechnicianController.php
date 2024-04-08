<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{

    public function index(){
        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('12', $permit_array)){

            return view ('maintenance.technician', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }


    }

    public function show_Technician()
        {
            $sno=0;

            $view_technician= Technician::all();
            if(count($view_technician)>0)
            {
                foreach($view_technician as $value)
                {

                    $technician_name='<a href="javascript:void(0);">'.$value->technician_name.'</a>';
                    $technician_phone='<a href="javascript:void(0);">'.$value->technician_phone.'</a>';
                    $technician_detail='<a href="javascript:void(0);">'.$value->technician_detail.'</a>';

                    $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_technician_modal"
                            type="button" onclick=edit("'.$value->technician_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                            </a>
                            <a class="me-3 confirm-text"
                            onclick=del("'.$value->technician_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                            </a>';
                    $add_data=get_date_only($value->created_at);

                    $sno++;
                    $json[]= array(
                                $sno,
                                $technician_name,
                                $technician_phone,
                                $technician_detail,
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

        public function add_technician(Request $request){

            $technician = new Technician();
            $technician->technician_id = genUuid() . time();
            $technician->technician_name = $request['technician_name'];
            $technician->technician_phone = $request['technician_phone'];
            $technician->technician_detail = $request['technician_detail'];
            $technician->added_by = 'admin';
            $technician->user_id = '1';
            $technician->save();
            return response()->json(['technician_id' => $technician->id]);

        }

        public function edit_technician(Request $request){
            $technician = new Technician();
            $technician_id = $request->input('id');
            // Use the Eloquent where method to retrieve the technician by column name
            $technician_data = Technician::where('technician_id', $technician_id)->first();

            if (!$technician_data) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.technician_not_found', [], session('locale'))], 404);
            }
            // Add more attributes as needed
            $data = [
                'technician_id' => $technician_data->technician_id,
                'technician_name' => $technician_data->technician_name,
                'technician_phone' => $technician_data->technician_phone,
                'technician_detail' => $technician_data->technician_detail,
               // Add more attributes as needed
            ];

            return response()->json($data);
        }

        public function update_technician(Request $request){
            $technician_id = $request->input('technician_id');
            $technician = Technician::where('technician_id', $technician_id)->first();
            if (!$technician) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.technician_not_found', [], session('locale'))], 404);
            }

            $technician->technician_name = $request->input('technician_name');
            $technician->technician_phone = $request->input('technician_phone');
            $technician->technician_detail = $request->input('technician_detail');
            $technician->updated_by = 'admin';
            $technician->save();
            return response()->json([
                trans('messages.success_lang', [], session('locale')) => trans('messages.technician_update_lang', [], session('locale'))
            ]);
        }

        public function delete_technician(Request $request){
            $technician_id = $request->input('id');
            $technician = Technician::where('technician_id', $technician_id)->first();
            if (!$technician) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.technician_not_found', [], session('locale'))], 404);
            }
            $technician->delete();
            return response()->json([
                trans('messages.success_lang', [], session('locale')) => trans('messages.technician_deleted_lang', [], session('locale'))
            ]);
        }
}
