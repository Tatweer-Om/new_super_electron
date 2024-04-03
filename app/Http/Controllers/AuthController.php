<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{

    public function login(){

        return view('user.login');
    }


    public function index(){

        return view ('user.add_user');

    }

    public function show_authuser()
    {
        $sno=0;

        $view_authuser= AuthUser::all();
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



        $authuser = new authuser();
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
        $authuser->authuser_phone = $request['authuser_phone'];

        $authuser->authuser_detail = $request['authuser_detail'];
        $authuser->authuser_image = $authuser_img_name;
        $authuser->added_by = 'admin';
        $authuser->user_id = '1';
        $authuser->save();
        return response()->json(['authuser_id' => $authuser->id]);

    }

    public function edit_authuser(Request $request){
        $authuser = new authuser();
        $authuser_id = $request->input('id');

        // Use the Eloquent where method to retrieve the authuser by column name
        $authuser_data = AuthUser::where('authuser_id', $authuser_id)->first();

        if (!$authuser_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.authuser_not_found', [], session('locale'))], 404);
        }

        // Add more attributes as needed
        $data = [
            'authuser_id' => $authuser_data->authuser_id,
            'authuser_name' => $authuser_data->authuser_name,
            'authuser_phone' => $authuser_data->authuser_phone,

            'authuser_detail' => $authuser_data->authuser_detail,
            'authuser_image' => $authuser_data->authuser_image,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_authuser(Request $request){
        $authuser_id = $request->input('authuser_id');
        $authuser = AuthUser::where('authuser_id', $authuser_id)->first();
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
        $authuser->authuser_phone = $request['authuser_phone'];

        $authuser->authuser_detail = $request['authuser_detail'];
        $authuser->updated_by = 'admin';
        $authuser->save();
        return response()->json([trans('messages.success_lang', [], session('locale')) => trans('messages.authuser_update_lang', [], session('locale'))]);
    }

    public function delete_authuser(Request $request){
        $authuser_id = $request->input('id');
        $authuser = AuthUser::where('authuser_id', $authuser_id)->first();
        if (!$authuser) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.authuser_not_found', [], session('locale'))], 404);
        }
        $authuser->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.authuser_deleted_lang', [], session('locale'))
        ]);

    }

}
