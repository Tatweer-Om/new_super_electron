<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Expense_Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{

    public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);
        $view_account= Account::all();
        $view_category= Expense_Category::all();
        return view ('expense.expense', compact('view_account', 'view_category', 'permit_array'));
    }

    public function show_expense()
    {
        $sno=0;

        $view_expense= Expense::all();
        if(count($view_expense)>0)
        {
            foreach($view_expense as $value)
            {

                $expense_name='<a href="javascript:void(0);">'.$value->expense_name.'</a>';
                // cat_name

                $cat_name = getColumnValue('expense_categories','id',$value->category_id,'expense_category_name');
                // payment_method
                $payment_method = getColumnValue('accounts','id',$value->payment_method,'account_name');

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_expense_modal"
                        type="button" onclick=edit("'.$value->expense_id.'")><i class="fas fa-edit"></i>
                        </a>
                        <a class="me-3 text-danger"
                        onclick=del("'.$value->expense_id.'")><i class="fas fa-trash"></i>
                        </a>
                        ';
                if(!empty($value->expense_image))
                {
                    $modal.='<a target="_blank" class="me-3 text-primary" href="'.url('download_expense_image').'/'.$value->expense_image.'"><i class="fas fa-download"></i>
                    </a>';
                }
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $cat_name,
                            $expense_name,
                            $value->amount,
                            $payment_method,
                            $value->expense_date,
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

    public function add_expense(Request $request){

        $expense = new Expense();
        $expense_image="";
        if ($request->hasFile('expense_image')) {
            $folderPath = public_path('images/expense_images');

            // Check if the folder doesn't exist, then create it
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $expense_image = time() . '.' . $request->file('expense_image')->extension();
            $request->file('expense_image')->move(public_path('images/expense_images'), $expense_image);
        }
        $expense->expense_id = genUuid() . time();
        $expense->category_id = $request['category_id'];
        $expense->expense_name = $request['expense_name'];
        $expense->payment_method = $request['payment_method'];
        $expense->amount = $request['amount'];
        $expense->expense_date = $request['expense_date'];
        $expense->notes = $request['notes'];
        $expense->expense_image = $expense_image;
        $expense->added_by = 'admin';
        $expense->user_id = '1';
        $expense->save();

        // minus from account
        $account_data = Account::where('id', $request['payment_method'])->first();
        $new_amount = $account_data->opening_balance - $request['amount'];
        $account_data->opening_balance = $new_amount;
        $account_data->updated_by = 'admin';
        $account_data->save();

        return response()->json(['expense_id' => $expense->id]);

    }

    public function edit_expense(Request $request){
        $expense = new Expense();
        $expense_id = $request->input('id');
        // Use the Eloquent where method to retrieve the expense by column name
        $expense_data = Expense::where('expense_id', $expense_id)->first();

        if (!$expense_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'expense_id' => $expense_data->expense_id,
            'expense_name' => $expense_data->expense_name,
            'category_id' => $expense_data->category_id,
            'amount' => $expense_data->amount,
            'payment_method' => $expense_data->payment_method,
            'expense_date' => $expense_data->expense_date,
            'category_image' => $expense_data->category_image,
            'notes' => $expense_data->notes,
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_expense(Request $request){
        $expense_id = $request->input('expense_id');
        $expense = Expense::where('expense_id', $expense_id)->first();
        if (!$expense) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_not_found', [], session('locale'))], 404);
        }

        // plus from account
        $account_data = Account::where('id', $expense->payment_method)->first();
        $new_amount = $account_data->opening_balance + $expense->amount;
        $account_data->opening_balance = $new_amount;
        $account_data->updated_by = 'admin';
        $account_data->save();

        if ($request->hasFile('expense_image')) {
            $folderPath = public_path('images/expense_images');
            if (!File::isDirectory($folderPath)) {
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $expense_image = time() . '.' . $request->file('expense_image')->extension();
            $request->file('expense_image')->move(public_path('images/expense_images'), $expense_image);
            $expense->expense_image = $expense_image;
        }
        $expense->category_id = $request['category_id'];
        $expense->expense_name = $request['expense_name'];
        $expense->payment_method = $request['payment_method'];
        $expense->amount = $request['amount'];
        $expense->expense_date = $request['expense_date'];
        $expense->notes = $request['notes'];
        $expense->updated_by = 'admin';
        $expense->save();

        // plus from account
        $account_data = Account::where('id', $request['payment_method'])->first();
        $new_amount = $account_data->opening_balance - $request['amount'];
        $account_data->opening_balance = $new_amount;
        $account_data->updated_by = 'admin';
        $account_data->save();


        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.expense_update_lang', [], session('locale'))
        ]);
    }

    public function delete_expense(Request $request){
        $expense_id = $request->input('id');
        $expense = Expense::where('expense_id', $expense_id)->first();
        if (!$expense) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_not_found', [], session('locale'))], 404);
        }
        $expense->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.expense_deleted_lang', [], session('locale'))
        ]);
    }

    // download
    public function download_expense_image($filename)
    {
        $filePath = public_path('images/expense_images/' . $filename);

        // Check if file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, $filename);
        }

        // File not found
        abort(404);
    }



}
