<?php

namespace App\Http\Controllers;

use App\Models\Maint;
use App\Models\Point;
use App\Models\Qoutdata;
use App\Models\Taxsetting;
use App\Models\Posinvodata;
use App\Models\Settingdata;
use Illuminate\Http\Request;
use App\Models\Inspectiondata;
use App\Models\Proposalsetting;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index(){
        $setting_data = Settingdata::first();
        return view('setting.setting', compact('setting_data'));
    }

    public function maint_setting(){

        $maint= Maint::first();

        return view('setting.maint_setting', compact('maint'));
    }
    public function proposal_setting(){
        $proposal= Proposalsetting::first();
        return view('setting.proposal_setting', compact('proposal'));
    }
    public function qout_setting(){
        $qout= Qoutdata::first();
        return view('setting.qout_setting', compact('qout'));
    }
    public function tax_setting(){
        $tax= Taxsetting::first();
        return view('setting.tax_setting', compact('tax'));
    }
    public function pos_qout_setting(){
        $pos= Posinvodata::first();
        return view('setting.pos_qout_setting', compact('pos'));
    }
    public function inspection_setting(){
        $inspect= Inspectiondata::first();
        return view('setting.inspection_setting', compact('inspect'));
    }
    public function points(){
        $point= Point::first();
        return view('setting.points', compact('point'));
    }


    public function company_data_post(Request $request){

            $system_name = $request->input('system_name');
            $company_phone = $request->input('company_phone');
            $company_email = $request->input('company_email');
            $company_address = $request->input('company_address');
            $country = $request->input('country');
            $state = $request->input('state');
            $city = $request->input('city');
            $postal_code = $request->input('postal_code');
            $zip_code = $request->input('zip_code');
            $cr_no = $request->input('cr_no');

       if ($request->hasFile('main_logo')) {
            $imageName = time() . '.' . $request->file('main_logo')->extension();
            $request->file('main_logo')->move(public_path('images/setting_images'), $imageName);
        }
        else{
            $imageName = 'default_main_logo.jpg';
        }

        if ($request->hasFile('invo_logo')) {
            $imageName = time() . '.' . $request->file('invo_logo')->extension();
            $request->file('invo_logo')->move(public_path('images/setting_images'), $imageName);
        }
        else{
            $imageName = 'default_main_logo.jpg';
        }



            $existingRecord = Settingdata::first();
            if(!empty($existingRecord)){


            $existingRecord->system_name = $system_name;
            $existingRecord->company_phone =  $company_phone;
            $existingRecord->company_email = $company_email;
            $existingRecord->company_address = $company_address;
            $existingRecord->country = $country;
            $existingRecord->state = $state;
            $existingRecord->city = $request->input('city');
            $existingRecord->postal_code = $city;
            $existingRecord->zip_code = $zip_code;
            $existingRecord->cr_no =  $cr_no;
            $existingRecord->main_logo = $imageName;
            $existingRecord->invo_logo = $imageName;
            $existingRecord->updated_by='admin';
            $existingRecord->user_id = '1';
            $existingRecord->save();
            return response()->json(['status' => 2, 'existingRecord' => $existingRecord]);
            }

            else{

            $companyProfile = new Settingdata();
            $companyProfile->system_name = $system_name;
            $companyProfile->company_phone =  $company_phone;
            $companyProfile->company_email = $company_email;
            $companyProfile->company_address = $company_address;
            $companyProfile->country = $country;
            $companyProfile->state = $state;
            $companyProfile->city = $request->input('city');
            $companyProfile->postal_code = $city;
            $companyProfile->zip_code = $zip_code;
            $companyProfile->cr_no =  $cr_no;
            $companyProfile->main_logo = $imageName;
            $companyProfile->invo_logo = $imageName;
            $companyProfile->added_by='admin';
            $companyProfile->user_id = '1';
            $companyProfile->save();
            return response()->json(['status' => 1]);

            }


        }


//inspection

        public function inspection_setting_post (Request $request){

            $inspection_detail=$request->input('inspect');

            $data = Inspectiondata::first();
            if(!empty($data)){

                $data->inspection_detail= $inspection_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            }

            else{

                $data= new Inspectiondata();
                $data->inspection_detail= $inspection_detail;
                $data->added_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);



            }


        }

//repairing

        public function maint_setting_post (Request $request){

            $maint_detail=$request->input('maint');


            $data = Maint::first();
            if(!empty($data)){

                $data->maint_detail= $maint_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            }

            else{

                $data= new Maint();
                $data->maint_detail= $maint_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);



            }


        }

        //proposal


        public function proposal_setting_post (Request $request){

            $proposal_detail=$request->input('proposal');



            $data = Proposalsetting::first();
            if(!empty($data)){

                $data->proposal_detail= $proposal_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            }

            else{

                $data= new Proposalsetting();
                $data->proposal_detail= $proposal_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);



            }


        }

        //qout
        public function qout_setting_post (Request $request){

            $qout_detail=$request->input('qout');
            $data = Qoutdata::first();
            if(!empty($data)){

                $data->qout_detail= $qout_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            }

            else{

                $data= new Qoutdata();
                $data->qout_detail= $qout_detail;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);



            }


        }



        public function pos_qout_setting_post (Request $request){

            $ig=$request->input('instagram');
            $email=$request->input('email');
            $contact=$request->input('contact');
            $address=$request->input('address');
            $footer=$request->input('footer');


            $data = Posinvodata::first();
            if(!empty($data)){

                $data->instagram= $ig;
                $data->contact= $contact;
                $data->email= $email;
                $data->address= $address;
                $data->footer= $footer;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            }

            else{

                $data= new Posinvodata();
                $data->instagram= $ig;
                $data->contact= $contact;
                $data->email= $email;
                $data->address= $address;
                $data->footer= $footer;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);



            }


        }


        //taxsetting

        public function tax_setting_post (Request $request){


            $taxType = $request->has('check') ? '1' : '2';


            $tax = $request->input('tax');

            $data = Taxsetting::first();
            if(!empty($data)){
                $data->tax_type= $taxType;
                $data->tax= $tax;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            } else {
                $data= new Taxsetting();
                $data->tax_type= $taxType;
                $data->tax= $tax;
                $data->added_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);
            }


        }

        public function points_post (Request $request){


          $points=  $request->input('points');
          $omr=  $request->input('omr');

            $data = Point::first();
            if(!empty($data)){
                $data->points= $points;
                $data->omr= $omr;
                $data->updated_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 2, 'data'=>$data]);
            } else {
                $data= new Point();
                $data->points= $points;
                $data->omr= $omr;
                $data->added_by='admin';
                $data->user_id = '1';
                $data->save();
                return response()->json(['status' => 1]);
            }


        }



}
