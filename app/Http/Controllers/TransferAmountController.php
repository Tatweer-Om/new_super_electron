<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\User;
use App\Models\TransferAmount;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class TransferAmountController extends Controller
{
    public function index(){

        $user = Auth::user();
        $view_account = Account::all();
        // transaction #
        // order no
        $transfer_data = TransferAmount::orderBy('id', 'desc')
        ->first();

        if($transfer_data)
        {
            $transaction_no_old = ltrim($transfer_data->transaction_no, '0');
        }
        else
        {
            $transaction_no_old=0;
        }

        $transaction_no = $transaction_no_old+1;
        $transaction_no = '0000'.$transaction_no;
        if(strlen($transaction_no)!=4)
        {
            $len = (strlen($transaction_no)-4);
            $transaction_no = substr($transaction_no,$len);
        }
        // 
        $permit = User::find($user->id)->permit_type;


        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('10', $permit_array)) {

            return view('transferamount.transferamount', compact('permit_array','view_account','transaction_no'));
        } else {

            return redirect()->route('home');
        }
        



    }

    public function show_transferamount()
    {
        $sno=0;

        $view_transferamount= TransferAmount::all();
        if(count($view_transferamount)>0)
        {
            foreach($view_transferamount as $value)
            {

                $transaction_no='<a href="javascript:void(0);">'.$value->transaction_no.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_transferamount_modal"
                        type="button" onclick=edit("'.$value->transferamount_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->transferamount_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);
                $acc_from = getColumnValue('accounts','id',$value->acc_from,'account_name');
                $acc_to = getColumnValue('accounts','id',$value->acc_to,'account_name');
               
                $sno++;
                $json[]= array(
                            $sno,
                            $transaction_no,
                            $acc_from,
                            $acc_to,
                            $value->amount,
                            $value->transfer_date,
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

    public function add_transferamount(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;

        $transferamount = new TransferAmount();
 

        $transferamount->transferamount_id = genUuid() . time();
        $transferamount->transaction_no = $request['transaction_no'];
        $transferamount->acc_from = $request['acc_from'];
        $transferamount->acc_to = $request['acc_to'];
        $transferamount->transfer_date = $request['transfer_date'];
        $transferamount->amount = $request['amount']; 
        $transferamount->notes = $request['notes'];
        $transferamount->added_by = $user;
        $transferamount->user_id = $user_id;
        $transferamount->save();
        // transfer amount
           // Calculate the new balance
        $account_from = Account::find($request['acc_from']);
        if ($account_from) {
           $account_from_final = $account_from->opening_balance - $request['amount'];

           // Update the account's opening balance
           $account_from->opening_balance = $account_from_final;
           $account_from->save();
        }

        $account_to = Account::find($request['acc_to']);
        if ($account_to) {
           $account_to_final = $account_to->opening_balance + $request['amount'];

           // Update the account's opening balance
           $account_to->opening_balance = $account_to_final;
           $account_to->save();
        }
          
        // transaction #
        // order no
        $transfer_data = TransferAmount::orderBy('id', 'desc')
        ->first();

        if($transfer_data)
        {
            $transaction_no_old = ltrim($transfer_data->transaction_no, '0');
        }
        else
        {
            $transaction_no_old=0;
        }

        $transaction_no = $transaction_no_old+1;
        $transaction_no = '0000'.$transaction_no;
        if(strlen($transaction_no)!=4)
        {
            $len = (strlen($transaction_no)-4);
            $transaction_no = substr($transaction_no,$len);
        }
        // 
        return response()->json(['transferamount_id' => $transferamount->id,'transaction_no'=>$transaction_no]);

    }

    public function edit_transferamount(Request $request){
        
        $transferamount_id = $request->input('id');
        // Use the Eloquent where method to retrieve the transferamount by column name
        $transferamount_data = TransferAmount::where('transferamount_id', $transferamount_id)->first();

        if (!$transferamount_data) {
            return response()->json(['error' => trans('messages.data_not_found_lang', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'transferamount_id' => $transferamount_data->transferamount_id,
            'transaction_no' => $transferamount_data->transaction_no,
            'acc_from' => $transferamount_data->acc_from,
            'acc_to' => $transferamount_data->acc_to,
            'transfer_date' => $transferamount_data->transfer_date,
            'amount' => $transferamount_data->amount,
            'notes' => $transferamount_data->notes, 
            // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_transferamount(Request $request){
        $transferamount_id = $request->input('transferamount_id');
        $transferamount = TransferAmount::where('transferamount_id', $transferamount_id)->first();
        if (!$transferamount) {
            return response()->json(['error' => trans('messages.data_not_found_lang', [], session('locale'))], 404);
        }

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;
        
          // Calculate the old balance
        $account_from = Account::find($transferamount->acc_from);
        if ($account_from) {
           $account_from_final = $account_from->opening_balance + $transferamount->amount;

           // Update the account's opening balance
           $account_from->opening_balance = $account_from_final;
           $account_from->save();
        }

        $account_to = Account::find($transferamount->acc_to);
        if ($account_to) {
           $account_to_final = $account_to->opening_balance - $transferamount->amount;

           // Update the account's opening balance
           $account_to->opening_balance = $account_to_final;
           $account_to->save();
        }
          
          
        $transferamount->acc_from = $request['acc_from'];
        $transferamount->acc_to = $request['acc_to'];
        $transferamount->transfer_date = $request['transfer_date'];
        $transferamount->amount = $request['amount']; 
        $transferamount->notes = $request['notes'];
        $transferamount->updated_by = $user;
        $transferamount->save();

          // Calculate the new balance
        $account_from = Account::find($request['acc_from']);
        if ($account_from) {
           $account_from_final = $account_from->opening_balance - $request['amount'];

           // Update the account's opening balance
           $account_from->opening_balance = $account_from_final;
           $account_from->save();
        }

        $account_to = Account::find($request['acc_to']);
        if ($account_to) {
           $account_to_final = $account_to->opening_balance + $request['amount'];

           // Update the account's opening balance
           $account_to->opening_balance = $account_to_final;
           $account_to->save();
        }

        return response()->json(['success' => trans('messages.data_update_success_lang', [], session('locale'))]);
    }

    public function delete_transferamount(Request $request){
        $transferamount_id = $request->input('id');
        $transferamount = TransferAmount::where('transferamount_id', $transferamount_id)->first();
        if (!$transferamount) {
            return response()->json(['error' => trans('messages.data_not_found_lang', [], session('locale'))], 404);
        }
         // Calculate the old balance
         $account_from = Account::find($transferamount->acc_from);
         if ($account_from) {
            $account_from_final = $account_from->opening_balance + $transferamount->amount;
 
            // Update the account's opening balance
            $account_from->opening_balance = $account_from_final;
            $account_from->save();
         }
 
         $account_to = Account::find($transferamount->acc_to);
         if ($account_to) {
            $account_to_final = $account_to->opening_balance - $transferamount->amount;
 
            // Update the account's opening balance
            $account_to->opening_balance = $account_to_final;
            $account_to->save();
         }
        $transferamount->delete();
        return response()->json(['success' => trans('messages.delete_success_lang', [], session('locale'))]);
    }
}
