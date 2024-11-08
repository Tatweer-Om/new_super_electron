<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(){

        $user = Auth::user();


        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('2', $permit_array)) {

            return view ('stock.category', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }



    }

    public function show_category()
    {
        $sno=0;

        $view_category= Category::all();
        if(count($view_category)>0)
        {
            foreach($view_category as $value)
            {
                $img=asset('images/dummy_image/no_image.png');
                if(!empty($value->category_image))
                {
                    $img=asset('images/category_images/').'/'.$value->category_image;
                }
                $category_name='<a href="javascript:void(0);">'.$value->category_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_category_modal"
                        type="button" onclick=edit("'.$value->category_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->category_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            '<img class="table_image" src="'.$img.'" alt="'.$value->category_name.'">',
                            $category_name,
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

    public function add_category(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $category = new Category();
        $cat_img_name="";
        if ($request->hasFile('category_image')) {
            $folderPath = public_path('images/category_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $cat_img_name = time() . '.' . $request->file('category_image')->extension();
            $request->file('category_image')->move(public_path('images/category_images'), $cat_img_name);
        }
        $category->category_id = genUuid() . time();
        $category->category_name = $request['category_name'];
        $category->category_image = $cat_img_name;
        $category->added_by = $user;
        $category->user_id = $user_id;
        $category->save();
        return response()->json(['category_id' => $category->id]);

    }

    public function edit_category(Request $request){
        $category = new Category();
        $category_id = $request->input('id');

        // Use the Eloquent where method to retrieve the category by column name
        $category_data = Category::where('category_id', $category_id)->first();

        if (!$category_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.category_not_found', [], session('locale'))], 404);
        }

        // Add more attributes as needed
        $data = [
            'category_id' => $category_data->category_id,
            'category_name' => $category_data->category_name,
            'category_image' => $category_data->category_image,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_category(Request $request){

        $user_id = Auth::id();
        $data= User::where('id', $user_id)->first();
        $user= $data->username;

        $category_id = $request->input('category_id');
        $category = Category::where('category_id', $category_id)->first();
        if (!$category) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.category_not_found', [], session('locale'))], 404);
        }
        if ($request->hasFile('category_image')) {
            $folderPath = public_path('images/category_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $cat_img_name = time() . '.' . $request->file('category_image')->extension();
            $request->file('category_image')->move(public_path('images/category_images'), $cat_img_name);
            $category->category_image = $cat_img_name;
        }
        $category->category_name = $request->input('category_name');
        $category->updated_by = $user;
        $category->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.category_update_lang', [], session('locale'))
        ]);
    }

    public function delete_category(Request $request){
        $category_id = $request->input('id');
        $category = Category::where('category_id', $category_id)->first();
        if (!$category) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.category_not_found', [], session('locale'))], 404);
        }
        $category->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.category_deleted_lang', [], session('locale'))
        ]);
    }
}
