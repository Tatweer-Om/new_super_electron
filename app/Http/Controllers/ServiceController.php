<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        if ($permit_array && in_array('12', $permit_array)){

            return view ('maintenance.service', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }


    }

    public function show_service()
        {
            $sno=0;

            $view_service= Service::all();
            if(count($view_service)>0)
            {
                foreach($view_service as $value)
                {

                    $service_name='<a href="javascript:void(0);">'.$value->service_name.'</a>';
                    $service_cost='<a href="javascript:void(0);">'.$value->service_cost.'</a>';
                    $service_detail='<a href="javascript:void(0);">'.$value->service_detail.'</a>';

                    $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_service_modal"
                            type="button" onclick=edit("'.$value->service_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                            </a>
                            <a class="me-3 confirm-text"
                            onclick=del("'.$value->service_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                            </a>';
                    $add_data=get_date_only($value->created_at);

                    $sno++;
                    $json[]= array(
                                $sno,
                                $service_name,
                                $service_cost,
                                $service_detail,
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

        public function add_service(Request $request){

            $user_id = Auth::id();
            $data= User::find( $user_id)->first();
            $user= $data->username;

            $service = new Service();
            $service->service_id = genUuid() . time();
            $service->service_name = $request['service_name'];
            $service->service_cost = $request['service_cost'];
            $service->service_detail = $request['service_detail'];
            $service->added_by = $user;
            $service->user_id = $user_id;
            $service->save();
            return response()->json(['service_id' => $service->id]);

        }

        public function edit_service(Request $request){
            $service = new Service();
            $service_id = $request->input('id');
            // Use the Eloquent where method to retrieve the service by column name
            $service_data = Service::where('service_id', $service_id)->first();

            if (!$service_data) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.service_not_found', [], session('locale'))], 404);
            }
            // Add more attributes as needed
            $data = [
                'service_id' => $service_data->service_id,
                'service_name' => $service_data->service_name,
                'service_cost' => $service_data->service_cost,
                'service_detail' => $service_data->service_detail,
               // Add more attributes as needed
            ];

            return response()->json($data);
        }

        public function update_service(Request $request){

            $user_id = Auth::id();
            $data= User::find( $user_id)->first();
            $user= $data->username;
            $service_id = $request->input('service_id');
            $service = Service::where('service_id', $service_id)->first();
            if (!$service) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.service_not_found', [], session('locale'))], 404);
            }

            $service->service_name = $request->input('service_name');
            $service->service_cost = $request->input('service_cost');
            $service->service_detail = $request->input('service_detail');
            $service->updated_by = $user;
            $service->save();
            return response()->json([
                trans('messages.success_lang', [], session('locale')) => trans('messages.service_update_lang', [], session('locale'))
            ]);
        }

        public function delete_service(Request $request){
            $service_id = $request->input('id');
            $service = Service::where('service_id', $service_id)->first();
            if (!$service) {
                return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.service_not_found', [], session('locale'))], 404);
            }
            $service->delete();
            return response()->json([
                trans('messages.success_lang', [], session('locale')) => trans('messages.service_deleted_lang', [], session('locale'))
            ]);
        }


}
