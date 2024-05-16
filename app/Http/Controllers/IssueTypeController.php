<?php



namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IssueType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IssueTypeController extends Controller
{
    public function index(){

        $user = Auth::user();
        $permit = User::find($user->id)->permit_type;
        $permit_array = json_decode($permit, true);

        if ($permit_array && in_array('12', $permit_array)) {

            return view ('maintenance.issuetype', compact('permit_array'));
        } else {

            return redirect()->route('home');
        }


    }

    public function show_issuetype()
    {
        $sno=0;

        $view_issuetype= IssueType::all();
        if(count($view_issuetype)>0)
        {
            foreach($view_issuetype as $value)
            {

                $issuetype_name='<a href="javascript:void(0);">'.$value->issuetype_name.'</a>';

                $modal='<a class="me-3" data-bs-toggle="modal" data-bs-target="#add_issuetype_modal"
                        type="button" onclick=edit("'.$value->issuetype_id.'")><img src="'.asset('img/icons/edit.svg').'" alt="img">
                        </a>
                        <a class="me-3 confirm-text"
                        onclick=del("'.$value->issuetype_id.'")><img src="'. asset('img/icons/delete.svg').'" alt="img">
                        </a>';
                $add_data=get_date_only($value->created_at);

                $sno++;
                $json[]= array(
                            $sno,
                            $issuetype_name,
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

    public function add_issuetype(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;

        $issuetype = new IssueType();
        $issuetype->issuetype_id = genUuid() . time();
        $issuetype->issuetype_name = $request['issuetype_name'];
        $issuetype->added_by = $user;
        $issuetype->user_id = $user_id;
        $issuetype->save();
        return response()->json(['issuetype_id' => $issuetype->id]);

    }

    public function edit_issuetype(Request $request){
        $issuetype = new IssueType();
        $issuetype_id = $request->input('id');
        // Use the Eloquent where method to retrieve the issuetype by column name
        $issuetype_data = IssueType::where('issuetype_id', $issuetype_id)->first();

        if (!$issuetype_data) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.issuetype_not_found', [], session('locale'))], 404);
        }
        // Add more attributes as needed
        $data = [
            'issuetype_id' => $issuetype_data->issuetype_id,
            'issuetype_name' => $issuetype_data->issuetype_name,
           // Add more attributes as needed
        ];

        return response()->json($data);
    }

    public function update_issuetype(Request $request){

        $user_id = Auth::id();
        $data= User::find( $user_id)->first();
        $user= $data->username;
        $issuetype_id = $request->input('issuetype_id');
        $issuetype = IssueType::where('issuetype_id', $issuetype_id)->first();
        if (!$issuetype) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.issuetype_not_found', [], session('locale'))], 404);
        }

        $issuetype->issuetype_name = $request->input('issuetype_name');
         $issuetype->updated_by = $user;
        $issuetype->save();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.issuetype_update_lang', [], session('locale'))
        ]);
    }

    public function delete_issuetype(Request $request){
        $issuetype_id = $request->input('id');
        $issuetype = IssueType::where('issuetype_id', $issuetype_id)->first();
        if (!$issuetype) {
            return response()->json([trans('messages.error_lang', [], session('locale')) => trans('messages.issuetype_not_found', [], session('locale'))], 404);
        }
        $issuetype->delete();
        return response()->json([
            trans('messages.success_lang', [], session('locale')) => trans('messages.issuetype_deleted_lang', [], session('locale'))
        ]);
    }




}
