<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense_Category;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{

    public function index(){

        return view ('expense.expense_category');
    }

    public function show_expense_category()
    {
        $sno=0;

        $view_expense_category= Expense_Category::all();
        if(count($view_expense_category)>0)
        {
            foreach($view_expense_category as $value)
            {

                $expense_category_name='<a href="javascript:void(0);">'.$value->expense_category_name.'</a>';
  
                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_expense_category_modal"
                        type="button" onclick=edit("'.$value->expense_category_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->expense_category_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $expense_category_name, 
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

    public function add_expense_category(Request $request){

        $expense_category = new Expense_Category();
        $expense_category->expense_category_id = genUuid() . time();
        $expense_category->expense_category_name = $request['expense_category_name']; 
        $expense_category->added_by = 'admin';
        $expense_category->user_id = '1';
        $expense_category->save();
        return response()->json(['expense_category_id' => $expense_category->id]);

    }

    public function edit_expense_category(Request $request){
        $expense_category = new Expense_Category();
        $expense_category_id = $request->input('id');
        // Use the Eloquent where method to retrieve the expense_category by column name
        $expense_category_data = Expense_Category::where('expense_category_id', $expense_category_id)->first();

        if (!$expense_category_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_category_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'expense_category_id' => $expense_category_data->expense_category_id,
            'expense_category_name' => $expense_category_data->expense_category_name, 
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_expense_category(Request $request){
        $expense_category_id = $request->input('expense_category_id');
        $expense_category = Expense_Category::where('expense_category_id', $expense_category_id)->first();
        if (!$expense_category) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_category_not_found', [], session('locale'))], 404);
        }

        $expense_category->expense_category_name = $request->input('expense_category_name');
         $expense_category->updated_by = 'admin';
        $expense_category->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.expense_category_update_lang', [], session('locale'))
        ]);
    }

    public function delete_expense_category(Request $request){
        $expense_category_id = $request->input('id');
        $expense_category = Expense_Category::where('expense_category_id', $expense_category_id)->first();
        if (!$expense_category) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.expense_category_not_found', [], session('locale'))], 404);
        }
        $expense_category->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.expense_category_deleted_lang', [], session('locale'))
        ]);
    }





}