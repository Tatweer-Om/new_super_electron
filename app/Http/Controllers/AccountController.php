<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    public function index(){

        $user = Auth::user();


        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('10', $permit_array)) {

            return view('account.account', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }



    }

    public function show_account()
    {
        $sno=0;

        $view_account= account::all();
        if(count($view_account)>0)
        {
            foreach($view_account as $value)
            {

                $account_name='<a href="javascript:void(0);">'.$value->account_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_account_modal"
                        type="button" onclick=edit("'.$value->account_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->account_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);
                if($value->account_type)
                {
                    $account_type='Normal Account';
                }
                else
                {
                    $account_type='Saving Account';
                }
                $sno++;
                $json[]= array(
                            $sno,
                            $account_name,
                            $value->account_branch,
                            $value->account_no,
                            $value->opening_balance,
                            $value->commission,
                            $account_type,
                            $value->notes,
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

    public function add_account(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;

        $account = new account();

        $account->account_id = genUuid() . time();
        $account->account_name = $request['account_name'];
        $account->account_branch = $request['account_branch'];
        $account->account_no = $request['account_no'];
        $account->opening_balance = $request['opening_balance'];
        $account->commission = $request['commission'];
        $account->account_type = $request['account_type'];
        $account->account_status = $request['account_status'];
        $account->notes = $request['notes'];
        $account->added_by = $user;
        $account->user_id = $user_id;
        $account->save();
        return response()->json(['account_id' => $account->id]);

    }

    public function edit_account(Request $request){
        $account = new account();
        $account_id = $request->input('id');
        // Use the Eloquent where method to retrieve the account by column name
        $account_data = account::where('account_id', $account_id)->first();

        if (!$account_data) {
            return response()->json(['error' => trans('messages.account_not_found_lang', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'account_id' => $account_data->account_id,
            'account_name' => $account_data->account_name,
            'account_branch' => $account_data->account_branch,
            'account_no' => $account_data->account_no,
            'opening_balance' => $account_data->opening_balance,
            'commission' => $account_data->commission,
            'account_type' => $account_data->account_type,
            'account_status' => $account_data->account_status,
            'notes' => $account_data->notes,
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_account(Request $request){
        $account_id = $request->input('account_id');
        $account = account::where('account_id', $account_id)->first();
        if (!$account) {
            return response()->json(['error' => trans('messages.account_not_found_lang', [], session('locale'))], 404);
        }

         $user_id = Auth::id();
         $data= User::find( $user_id)->first();
         $user= $data->username;

        $account->account_name = $request['account_name'];
        $account->account_branch = $request['account_branch'];
        $account->account_no = $request['account_no'];
        $account->opening_balance = $request['opening_balance'];
        $account->commission = $request['commission'];
        $account->account_type = $request['account_type'];
        $account->account_status = $request['account_status'];
        $account->notes = $request['notes'];
        $account->updated_by = $user;
        $account->save();
        return response()->json(['success' => trans('messages.data_update_success_lang', [], session('locale'))]);
    }

    public function delete_account(Request $request){
        $account_id = $request->input('id');
        $account = account::where('account_id', $account_id)->first();
        if (!$account) {
            return response()->json(['error' => trans('messages.account_not_found_lang', [], session('locale'))], 404);
        }
        $account->delete();
        return response()->json(['success' => trans('messages.delete_success_lang', [], session('locale'))]);
    }
}
