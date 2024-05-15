<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
{

public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('2', $permit_array)) {

            return view ('stock.store', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }

}

public function show_store()
    {
        $sno=0;

        $view_store= Store::all();
        if(count($view_store)>0)
        {
            foreach($view_store as $value)
            {

                $store_name='<a href="javascript:void(0);">'.$value->store_name.'</a>';
                $store_phone='<a href="javascript:void(0);">'.$value->store_phone.'</a>';
                $store_address='<a href="javascript:void(0);">'.$value->store_address.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_store_modal"
                        type="button" onclick=edit("'.$value->store_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->store_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $store_name,
                            $store_phone,
                            $store_address,
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

    public function add_store(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;

        $store = new Store();
        $store->store_id = genUuid() . time();
        $store->store_name = $request['store_name'];
        $store->store_phone = $request['store_phone'];
        $store->store_address = $request['store_address'];
        $store->added_by = $user;
        $store->user_id = $user_id;
        $store->save();
        return response()->json(['store_id' => $store->id]);

    }

    public function edit_store(Request $request){
        $store = new Store();
        $store_id = $request->input('id');
        // Use the Eloquent where method to retrieve the store by column name
        $store_data = Store::where('store_id', $store_id)->first();

        if (!$store_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'store_id' => $store_data->store_id,
            'store_name' => $store_data->store_name,
            'store_phone' => $store_data->store_phone,
            'store_address' => $store_data->store_address,
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_store(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;
        $store_id = $request->input('store_id');
        $store = Store::where('store_id', $store_id)->first();
        if (!$store) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }

        $store->store_name = $request->input('store_name');
        $store->store_phone = $request->input('store_phone');
        $store->store_address = $request->input('store_address');
        $store->updated_by = $user;
        $store->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_update_lang', [], session('locale'))
        ]);
    }

    public function delete_store(Request $request){
        $store_id = $request->input('id');
        $store = Store::where('store_id', $store_id)->first();
        if (!$store) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.store_not_found', [], session('locale'))], 404);
        }
        $store->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.store_deleted_lang', [], session('locale'))
        ]);
    }





}
