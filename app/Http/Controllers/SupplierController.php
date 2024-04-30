<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Purchase_bill;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SupplierController extends Controller
{
    public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        if ($permit_array && in_array('2', $permit_array)) {

            return view ('stock.supplier', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }


    }

    public function show_supplier()
    {
        $sno=0;

        $view_supplier= Supplier::all();
        if(count($view_supplier)>0)
        {
            foreach($view_supplier as $value)
            {
                $img=asset('images/dummy_image/no_image.png');
                if(!empty($value->supplier_image))
                {
                    $img=asset('images/supplier_images/').'/'.$value->supplier_image;
                }
                $supplier_name='<a href="' . url('supplier_profile/' . $value->id) . '">'.$value->supplier_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_supplier_modal"
                        type="button" onclick=edit("'.$value->supplier_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->supplier_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            '<img class="table_image" src="'.$img.'" alt="'.$value->supplier_name.'">',
                            $supplier_name,
                            $value->supplier_phone,
                            $value->supplier_email,
                            $value->supplier_detail,
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

    public function add_supplier(Request $request){



        $supplier = new Supplier();
        $supplier_img_name="";
        if ($request->hasFile('supplier_image')) {
            $folderPath = public_path('images/supplier_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $supplier_img_name = time() . '.' . $request->file('supplier_image')->extension();
            $request->file('supplier_image')->move(public_path('images/supplier_images'), $supplier_img_name);
        }
        $supplier->supplier_id = genUuid() . time();
        $supplier->supplier_name = $request['supplier_name'];
        $supplier->supplier_phone = $request['supplier_phone'];
        $supplier->supplier_email = $request['supplier_email'];
        $supplier->supplier_detail = $request['supplier_detail'];
        $supplier->supplier_image = $supplier_img_name;
        $supplier->added_by = 'admin';
        $supplier->user_id = '1';
        $supplier->save();
        return response()->json(['supplier_id' => $supplier->id]);

    }

    public function edit_supplier(Request $request){
        $supplier = new Supplier();
        $supplier_id = $request->input('id');

        // Use the Eloquent where method to retrieve the supplier by column name
        $supplier_data = supplier::where('supplier_id', $supplier_id)->first();

        if (!$supplier_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.supplier_not_found', [], session('locale'))], 404);
        }

        // Add more attributes as needed
        $data = [
            'supplier_id' => $supplier_data->supplier_id,
            'supplier_name' => $supplier_data->supplier_name,
            'supplier_phone' => $supplier_data->supplier_phone,
            'supplier_email' => $supplier_data->supplier_email,
            'supplier_detail' => $supplier_data->supplier_detail,
            'supplier_image' => $supplier_data->supplier_image,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_supplier(Request $request){
        $supplier_id = $request->input('supplier_id');
        $supplier = supplier::where('supplier_id', $supplier_id)->first();
        if (!$supplier) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.supplier_not_found', [], session('locale'))], 404);
        }
        if ($request->hasFile('supplier_image')) {
            $folderPath = public_path('images/supplier_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $supplier_img_name = time() . '.' . $request->file('supplier_image')->extension();
            $request->file('supplier_image')->move(public_path('images/supplier_images'), $supplier_img_name);
            $supplier->supplier_image = $supplier_img_name;
        }
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->supplier_phone = $request['supplier_phone'];
        $supplier->supplier_email = $request['supplier_email'];
        $supplier->supplier_detail = $request['supplier_detail'];
        $supplier->updated_by = 'admin';
        $supplier->save();
        return response()->json([trans('messages.success_lang', [], session('locale')) => trans('messages.supplier_update_lang', [], session('locale'))]);
    }

    public function delete_supplier(Request $request){
        $supplier_id = $request->input('id');
        $supplier = supplier::where('supplier_id', $supplier_id)->first();
        if (!$supplier) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.supplier_not_found', [], session('locale'))], 404);
        }
        $supplier->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.supplier_deleted_lang', [], session('locale'))
        ]);

    }


    public function supplier_profile($supplier_id){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        $supplier = Supplier::find($supplier_id);
        $purchases = Purchase::where('supplier_id', $supplier_id)->get();

        foreach ($purchases as $purchase) {
            $purchase->purchase_bill = Purchase_bill::where('purchase_id', $purchase->id)->first();
            $purchase->remaining_amount = $purchase->purchase_bill ? $purchase->purchase_bill->remaining_price : 0;
            $purchase->grand_total = $purchase->purchase_bill ? $purchase->purchase_bill->grand_total : 0;
        }

        $purchasesall = $purchases->toArray();

        if ($permit_array && in_array('2', $permit_array)) {
            return view ('stock.supplier_profile', compact('permit_array', 'supplier', 'purchasesall'));
        } else {
            return redirect()->route('home');
        }
    }

}
