<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index(){

        $user = Auth::user();


        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);


        if ($permit_array && in_array('2', $permit_array)) {

            return view ('stock.brand', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }



    }

    public function show_brand()
    {
        $sno=0;

        $view_brand= Brand::all();
        if(count($view_brand)>0)
        {
            foreach($view_brand as $value)
            {
                $img=asset('images/dummy_image/no_image.png');
                if(!empty($value->brand_image))
                {
                    $img=asset('images/brand_images/').'/'.$value->brand_image;
                }
                $brand_name='<a href="javascript:void(0);">'.$value->brand_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_brand_modal"
                        type="button" onclick=edit("'.$value->brand_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->brand_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            '<img class="table_image" src="'.$img.'" alt="'.$value->brand_name.'">',
                            $brand_name,
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

    public function add_brand(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $brand = new Brand();
        $brand_img_name="";
        if ($request->hasFile('brand_image')) {
            $folderPath = public_path('images/brand_images');
            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $brand_img_name = time() . '.' . $request->file('brand_image')->extension();
            $request->file('brand_image')->move(public_path('images/brand_images'), $brand_img_name);
        }
        $brand->brand_id = genUuid() . time();
        $brand->brand_name = $request['brand_name'];
        $brand->brand_image = $brand_img_name;
        $brand->added_by = $user;
        $brand->user_id = $user_id;
        $brand->save();
        return response()->json(['brand_id' => $brand->id]);

    }

    public function edit_brand(Request $request){
        $brand = new Brand();
        $brand_id = $request->input('id');
        // Use the Eloquent where method to retrieve the brand by column name
        $brand_data = brand::where('brand_id', $brand_id)->first();

        if (!$brand_data) {
            return response()->json(['error' => trans('messages.brand_not_found_lang', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'brand_id' => $brand_data->brand_id,
            'brand_name' => $brand_data->brand_name,
            'brand_image' => $brand_data->brand_image,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_brand(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $brand_id = $request->input('brand_id');
        $brand = brand::where('brand_id', $brand_id)->first();
        if (!$brand) {
            return response()->json(['error' => trans('messages.brand_not_found_lang', [], session('locale'))], 404);
        }
        if ($request->hasFile('brand_image')) {
            $folderPath = public_path('images/brand_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $brand_img_name = time() . '.' . $request->file('brand_image')->extension();
            $request->file('brand_image')->move(public_path('images/brand_images'), $brand_img_name);
            $brand->brand_image = $brand_img_name;
        }


        $brand->brand_name = $request->input('brand_name');
        $brand->updated_by = $user;
        $brand->save();
        return response()->json(['success' => trans('messages.data_update_success_lang', [], session('locale'))]);
    }

    public function delete_brand(Request $request){
        $brand_id = $request->input('id');
        $brand = brand::where('brand_id', $brand_id)->first();
        if (!$brand) {
            return response()->json(['error' => 'brand not found'], 404);
        }
        $brand->delete();
        return response()->json(['success' => trans('messages.delete_success_lang', [], session('locale'))]);
    }
}
