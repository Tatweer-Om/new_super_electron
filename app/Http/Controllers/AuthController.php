<?php

namespace App\Http\Controllers;


use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function loginform(){

        return view('user.login');
    }


    public function login(Request $request)
    {

        $username = $request->input('username');
        $password = $request->input('password');


        if (Auth::attempt(['username' => $username, 'password' => $password])) {

            return response()->json(['status' => 1]);
        }

        else {

            return response()->json(['status' => 2]);
        }
    }



    public function index(){

        $stores= Store::all();

        $user = Auth::user();


        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);

        return view ('user.add_user', compact('stores', 'permit_array'));

    }

    public function show_authuser()
    {



        $sno=0;

        $view_authuser= User::all();
        if(count($view_authuser)>0)
        {
            foreach($view_authuser as $value)
            {
                $img=asset('images/dummy_image/no_image.png');
                if(!empty($value->authuser_image))
                {
                    $img=asset('images/authuser_images/').'/'.$value->authuser_image;
                }
                $authuser_name='<a href="javascript:void(0);">'.$value->authuser_name.'</a>';
                $username='<a href="javascript:void(0);">'.$value->username.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_authuser_modal"
                        type="button" onclick=edit("'.$value->authuser_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->authuser_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            '<img class="table_image" src="'.$img.'" alt="'.$value->authuser_name.'">',
                            $authuser_name,
                            $username,
                            $value->authuser_phone,
                            $value->authuser_detail,
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

    public function add_authuser(Request $request){



        $authuser = new User();
        $authuser_img_name="";
        if ($request->hasFile('authuser_image')) {
            $folderPath = public_path('images/authuser_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $authuser_img_name = time() . '.' . $request->file('authuser_image')->extension();
            $request->file('authuser_image')->move(public_path('images/authuser_images'), $authuser_img_name);
        }
        $authuser->authuser_id = genUuid() . time();
        $authuser->authuser_name = $request['authuser_name'];
        $authuser->store_id = $request['store'];
        $authuser->username = $request['username'];
        $authuser->authuser_phone = $request['authuser_phone'];
        $authuser->permit_type = json_encode($request['permit_type']);
        $authuser->password = Hash::make($request['password']);
        $authuser->authuser_detail = $request['authuser_detail'];
        $authuser->authuser_image = $authuser_img_name;
        $authuser->added_by = 'admin';
        $authuser->user_id = '1';
        $authuser->save();
        return response()->json(['authuser_id' => $authuser->id]);

    }

    public function edit_authuser(Request $request){
        $authuser = new User();
        $authuser_id = $request->input('id');

        // Use the Eloquent where method to retrieve the authuser by column name
        $authuser_data = User::where('authuser_id', $authuser_id)->first();

        if (!$authuser_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.authuser_not_found', [], session('locale'))], 404);
        }
        $permit = json_decode($authuser_data->permit_type);
        $checkboxValues = [
            ['id' => 'stock', 'value' => 2, 'name' => 'messages.stock_lang'],
            ['id' => 'add_stock', 'value' => 3, 'name'=>'messages.add_stock_lang'],
            ['id' => 'dmg_quantity', 'value' => 4, 'name'=>'messages.stock_damage_quantity_lang'],
            ['id' => 'update_purchase', 'value' => 5, 'name'=>'messages.purchase_update_lang'],
            ['id' => 'delete_purchase', 'value' => 6, 'name'=>'messages.purchase_delete_lang'],
            ['id' => 'purchases', 'value' => 7, 'name'=>'messages.purchase_lang'],
            ['id' => 'purchase_payment', 'value' => 8, 'name'=>'messages.purchase_payment_lang'],
            ['id' => 'customer', 'value' => 9, 'name'=>'messages.customers_lang'],
            ['id' => 'accounting', 'value' => 10, 'name'=>'messages.sidebar_accounting'],
            ['id' => 'expense', 'value' => 11, 'name'=>'messages.expense_name_lang'],
            ['id' => 'maint', 'value' => 12, 'name'=>'messages.maintenance'],
            ['id' => 'warranty', 'value' => 13, 'name'=>'messages.warranty'],
            ['id' => 'setting', 'value' => 14, 'name'=>'messages.setting'],
            ['id' => 'offers', 'value' => 15, 'name'=>'messages.offers'],
            ['id' => 'services', 'value' => 16, 'name'=>'messages.services'],
            ['id' => 'sms', 'value' => 17, 'name'=>'messages.messages_panel'],
            ['id' => 'qout', 'value' => 18, 'name'=>'messages.quotation'],
            ['id' => 'delete', 'value' => 19, 'name'=>'messages.delete'],
            ['id' => 'add', 'value' => 20, 'name'=>'messages.add'],
            ['id' => 'update', 'value' => 21, 'name'=>'messages.update'],
            ['id' => 'view', 'value' => 22, 'name'=>'messages.view'],
            ['id' => 'pos', 'value' => 23, 'name'=>'messages.pos_lang'],
            ['id' => 'user', 'value' => 24, 'name'=>'messages.users_lang'],
        ];
        $checked_html = '<div class="form-check form-check-inline">
                            <input class="form-check-input permit_type" type="checkbox"
                                name="permit_type[]" id="permission_all" value="1"
                                >
                            <label class="form-check-label" for="permission_all">
                                '.trans('messages.all_lang', [], session('locale')).'
                            </label>
                        </div>';
        foreach ($checkboxValues as $key => $value) {
            $checked = "";
            if (in_array($value['value'], $permit))
            {
                $checked = "checked='true'";
            }
            $checked_html.='<div class="form-check form-check-inline">
                            <input '.$checked.' class="form-check-input permit_type" type="checkbox"
                                name="permit_type[]" id="'.$value['id'].'" value="'.$value['value'].'">
                            <label class="form-check-label" for="'.$value['id'].'">
                                '.trans($value['name'], [], session('locale')).'
                            </label>
                        </div>';
        }

        // Add more attributes as needed
        $data = [
            'authuser_id' => $authuser_data->authuser_id,
            'authuser_name' => $authuser_data->authuser_name,
            'username' => $authuser_data->username,
            'store_id'=>$authuser_data->store_id,
            'authuser_phone' => $authuser_data->authuser_phone,
            'permit_type' => $authuser_data->permit_type,
            'password' => $authuser_data->password,
            'authuser_detail' => $authuser_data->authuser_detail,
            'authuser_image' => $authuser_data->authuser_image,
            'checked_html' => $checked_html,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_authuser(Request $request){
        $authuser_id = $request->input('authuser_id');
        $authuser = User::where('authuser_id', $authuser_id)->first();
        if (!$authuser) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.authuser_not_found', [], session('locale'))], 404);
        }
        if ($request->hasFile('authuser_image')) {
            $folderPath = public_path('images/authuser_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $authuser_img_name = time() . '.' . $request->file('authuser_image')->extension();
            $request->file('authuser_image')->move(public_path('images/authuser_images'), $authuser_img_name);
            $authuser->authuser_image = $authuser_img_name;
        }
        $authuser->authuser_name = $request->input('authuser_name');
        $authuser->username = $request->input('username');
        $authuser->store_id = $request['store_id'];
        $authuser->authuser_phone = $request['authuser_phone'];
        $authuser->password = $request['password'];
        $authuser->permit_type = json_encode($request['permit_type']);
        $authuser->authuser_detail = $request['authuser_detail'];
        $authuser->updated_by = 'admin';
        $authuser->save();
        return response()->json([trans('messages.success_lang', [], session('locale')) => trans('messages.authuser_update_lang', [], session('locale'))]);
    }

    public function delete_authuser(Request $request){
        $authuser_id = $request->input('id');
        $authuser = User::where('authuser_id', $authuser_id)->first();
        if (!$authuser) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.authuser_not_found', [], session('locale'))], 404);
        }
        $authuser->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.authuser_deleted_lang', [], session('locale'))
        ]);

    }

}
