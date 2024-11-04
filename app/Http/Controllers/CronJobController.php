<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CronJobController extends Controller
{
    public function index(){
        // Get today's date in the format stored in the database (e.g., 'Y-m-d')
        $today = now()->format('d-m');

        // Fetch customers whose birthday is today (ignoring the year)
        $customers = Customer::whereRaw('DATE_FORMAT(STR_TO_DATE(dob, "%d-%m-%Y"), "%d-%m") = ?', [$today])->get();

         
        foreach ($customers as $customer) {
            $params = [
                'customer_id' => $customer->id,
                'sms_status' => 14
            ];
            $sms = get_sms($params);
            sms_module($customer->customer_phone, $sms);
        }
    }
}
