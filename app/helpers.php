<?php
use Illuminate\Support\Facades\DB;
use App\Models\Purchase_imei;
use App\Models\Sms;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Repairing;
use App\Models\Draw;
use App\Models\DrawWinner;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Localmaintenance;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


// app/helpers.php
function genUuid() {
    return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
function get_date_only($timestamp)
{
    // Create a DateTime object from the timestamp
    $dateTime = new DateTime($timestamp);

    // Format the date as YYYY-MM-DD
    $dateOnly = $dateTime->format('Y-m-d');

    return $dateOnly;
}
function getColumnValue($table, $columnToSearch, $valueToSearch, $columnToRetrieve)
{
    $result = DB::table($table)
                ->where($columnToSearch, $valueToSearch)
                ->first();

    if ($result) {
        return $result->{$columnToRetrieve};
    }

    return 'n/a'; // or any default value you prefer
}
function get_date_time($timestamp)
{
    // Create a DateTime object from the timestamp
    $dateTime = new DateTime($timestamp);

    // Format the date as YYYY-MM-DD
    $formattedDateTime = $dateTime->format('Y-m-d h:i A');

    return $formattedDateTime;
}


function get_purchase_imei_comma_seperated($barcode)
{
    $imeis = purchase_imei::where('barcode', $barcode)->pluck('imei');
    $array = json_decode($imeis, true);
    $imeiString = implode(',', $array);
    return $imeiString;
}

function get_days_from_date($start_date , $end_date)
{
    $startDate = new DateTime($start_date);
    $endDate = new DateTime($end_date);

    $interval = $startDate->diff($endDate);
    $days = $interval->days;
    return $days;
}
// whatsapp api
function get_sms($params)
{
    // variable
    $customer_name = "";
    $customer_number = "";
    $total_point = "";
    $warranty_invoice_number = "";
    $warranty_detail = "";
    $warranty_invoice_link = "";
    $invoice_link = "";
    $transaction_no= "";
    $product_name= "";
    $receive_date= "";
    $delivery_date= "";
    $status="";
    $notes="";
    $receipt_date="";
    $serial_no="";
    $warranty_duration="";
    $remaining_point = "";
    $sms_text = Sms::where('sms_status', $params['sms_status'])->first();
    if($params['sms_status']==1)
    {
        $edit_customer = Customer::find($params['customer_id']);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
    }
    else if($params['sms_status']==2)
    {
        $order_data =  PosOrder::where('order_no', $params['order_no'])->first();
        $edit_customer = Customer::find($order_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $total_point = $params['points'];
        $invoice_link = route('bills', ['order_no' => $params['order_no']]);
    }
    else if($params['sms_status']==3)
    {
        $order_data =  PosOrder::where('order_no', $params['order_no'])->first();
        $edit_customer = Customer::find($order_data->customer_id);
        $warranty_data =  Warranty::where('order_no', $params['order_no'])->get();
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $total_point = $params['points'];
        $warranty_invoice_number = $params['order_no'];
        $warranty_detail="";
        foreach ($warranty_data as $key => $value) {
            $pro_data =  Product::where('id', $value->product_id)->first();
            $name = $pro_data->product_name;
            if(empty($name))
            {
                $name = $pro_data->product_name_ar;
            }
            $warranty_type = $value->warranty_type;
            if ($warranty_type == 1) {
                $warranty_type = trans('messages.shop_lang', [], session('locale'));
            } elseif ($warranty_type == 2) {
                $warranty_type = trans('messages.agent_lang', [], session('locale'));
            } else {
                $warranty_type = trans('messages.none_lang', [], session('locale'));
            }
            $warranty_detail.=$name."\n".$warranty_type." : ".$value->warranty_days." ".trans('messages.days_lang', [], session('locale'));

        }
        $invoice_link = route('bills', ['order_no' => $params['order_no']]);
        $warranty_invoice_link = route('warranty_bill', ['order_no' => $params['order_no']]);
        // $warranty_invoice_link = route('warranty.product', ['order_no' => $params['order_no']]);;
    }
    else if($params['sms_status']==4)
    {
        $local_data =  Localmaintenance::where('id', $params['local_main_id'])->first();
        $edit_customer = Customer::find($local_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $transaction_no = $local_data->reference_no;
        $product_name = $local_data->product_name;
        $receive_date = $local_data->receive_date;
        $delivery_date = $local_data->deliver_date;
    }
    else if($params['sms_status']==5)
    {
        $local_data =  Localmaintenance::where('id', $params['local_main_id'])->first();
        $edit_customer = Customer::find($local_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $transaction_no = $local_data->reference_no;
        $product_name = $local_data->product_name;
        $status = trans('messages.ready_status_lang', [], session('locale'));

    }
    else if($params['sms_status']==6)
    {
        $local_data =  Localmaintenance::where('id', $params['local_main_id'])->first();
        $edit_customer = Customer::find($local_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $total_point = "";
    }
    else if($params['sms_status']==7)
    {
        $local_data =  Localmaintenance::where('id', $params['local_main_id'])->first();
        $edit_customer = Customer::find($local_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $transaction_no = $local_data->reference_no;
        $product_name = $local_data->product_name;
        $warranty_duration = $local_data->warranty_day;
        $warranty_invoice_link = "";
        $total_point = "";
    }
    else if($params['sms_status']==8)
    {
        $repair_data =  Repairing::where('id', $params['repair_id'])->first();
        $warranty_data =  Warranty::where('id', $repair_data->warranty_id)->first();
        $pro_data =  Product::where('id', $warranty_data->product_id)->first();
        $name = $pro_data->product_name;
        if(empty($name))
        {
            $name = $pro_data->product_name_ar;
        }
        $edit_customer = Customer::find($repair_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $transaction_no = $repair_data->reference_no;
        $product_name = $name;
        $serial_no = $warranty_data->item_imei;
        $receipt_date = $repair_data->receive_date;
        $notes = $repair_data->notes;
    }
    else if($params['sms_status']==9)
    {
        $repair_data =  Repairing::where('id', $params['repair_id'])->first();
        $warranty_data =  Warranty::where('id', $repair_data->warranty_id)->first();
        $pro_data =  Product::where('id', $warranty_data->product_id)->first();
        $name = $pro_data->product_name;
        if(empty($name))
        {
            $name = $pro_data->product_name_ar;
        }
        $edit_customer = Customer::find($repair_data->customer_id);
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $transaction_no = $repair_data->reference_no;
        $product_name = $name;
        $serial_no = $warranty_data->item_imei;
        $notes = $repair_data->notes;
         // status
         if ($params['status'] == "1") {
            $status = trans('messages.receive_status_lang', [], session('locale'));
        } else if ($params['status'] == 6) {
            $status = trans('messages.inspection_status_lang', [], session('locale'));
        } else if ($params['status'] == 2) {
            $status = trans('messages.send_agent_status_lang', [], session('locale'));
        } else if ($params['status'] == 3) {
            $status = trans('messages.receive_agent_status_lang', [], session('locale'));
        } else if ($params['status'] == 4) {
            $status = trans('messages.ready_status_lang', [], session('locale'));
        } else if ($params['status'] == 5) {
            $status = trans('messages.deleivered_status_lang', [], session('locale'));
        }

    }
    else if($params['sms_status']==12)
    {
        $order_data =  PosOrder::where('order_no', $params['order_no'])->first();
        $edit_customer = Customer::find($order_data->customer_id);

        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $total_point = $params['points'];
        $remaining_point = $edit_customer->points;

     }


    $variables = [
        'customer_number' => $customer_number,
        'customer_name' => $customer_name,
        'total_point' => $total_point,
        'warranty_invoice_number' => $warranty_invoice_number,
        'invoice_link' => $invoice_link,
        'warranty_invoice_link' => $warranty_invoice_link,
        'warranty_detail' => $warranty_detail,
        'transaction_no' => $transaction_no,
        'product_name' => $product_name,
        'receive_date' => $receive_date,
        'delivery_date' => $delivery_date,
        'status' => $status,
        'serial_no' => $serial_no,
        'notes' => $notes,
        'receipt_date'=>$receipt_date,
        'warranty_duration'=>$warranty_duration,
        'remaining_point'=>$remaining_point
    ];

    $string = base64_decode($sms_text->sms);
    foreach ($variables as $key => $value) {
        $string = str_replace('{' . $key . '}', $value, $string);
    }
    return $string;
}
function sms_module($contact, $sms)
{
    if (!empty($contact)) {
        $url = "http://myapp3.com/whatsapp_admin_latest/Api_pos/send_request";

        $form_data = [
            'status' => 1,
            'sender_contact' => '968' . $contact,
            'customer_id' => 'notificationweb',
            'instance_id' => 'lsqevwf4',
            'sms' => base64_encode($sms),
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $form_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $result=json_decode($resp,true);
        // $return_status= $result['response'];

    }
}
// draw name
function get_draw_name($customer_id)
{
    // custoemr
    $customer = Customer::where('id', $customer_id)->first();

    $drawsWithoutWinner = Draw::leftJoin('draw_winners', 'draws.id', '=', 'draw_winners.draw_id')
                            ->whereNull('draw_winners.draw_id')
                            ->get();


    $draw_name = "";
    foreach ($drawsWithoutWinner as $key => $draw) {
        $draw_winner = DrawWinner::where('draw_id', $draw->id)->first();

        if(!empty($draw_winner))
        {
            $status = 2;
        }
        else
        {
            $start_date = $draw->draw_starts;
            $end_date = $draw->draw_ends;
            $all_sales = PosOrder::where('customer_id', $customer_id)
                ->whereNotNull('customer_id')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();

            foreach ($all_sales as $key => $value) {

                $customer = Customer::where('id', $value->customer_id)->first();
                if(!empty($customer))

                {
                    $first_step = 0;
                    if($customer->customer_type==1)
                    {
                        $university_ids = explode(',', $draw->university_id);
                        if($draw->draw_type_student==1)
                        {
                            if (in_array($customer->student_university, $university_ids)) {
                                $first_step++;
                            }
                        }
                    }
                    else if($customer->customer_type==3)
                    {

                        $ministry_ids = explode(',', $draw->ministry_id);
                        $workplace_ids = explode(',', $draw->workplace_id);
                        if($draw->draw_type_employee==1)
                        {

                            if (in_array($customer->ministry_id, $ministry_ids)) {
                                if (in_array($customer->employee_workplace, $workplace_ids)) {
                                    $first_step++;

                                }
                            }
                        }
                    }

                    else if($customer->customer_type==4)
                    {

                        $first_step++;
                    }
                    if($first_step>0)
                    {
                        if($customer->gender==1)
                        {
                            if($draw->male==1)
                            {
                                $first_step++;
                            }
                        }
                        else if($customer->gender==2)
                        {
                            if($draw->female==1)
                            {
                                $first_step++;
                            }
                        }
                    }
                    if($first_step>1)
                    {

                        $nationality_ids = explode(',', $draw->nationality_id);
                        if (in_array($customer->nationality_id, $nationality_ids)) {
                            $first_step++;
                        }
                    }

                    if($first_step>2)
                    {
                        $sum_paid_amount = PosOrder::where('customer_id', $value->customer_id)
                            ->whereDate('created_at', '>=', $draw->draw_starts)
                            ->whereDate('created_at', '<=', $draw->draw_ends)
                            ->sum('paid_amount'); // Get the sum of paid_amount column
                        $total_time = 0;

                        if($sum_paid_amount >= $draw->amount)
                        {

                            $total_time = $sum_paid_amount / $draw->amount;
                            $total_time_final = intval($total_time);
                            $draw_name = $draw->draw_name;
                            break;
                            // for ($i=0; $i < $total_time_final ; $i++) {
                            //     $customer_name = $customer->customer_name;
                            //     $customer_number = $customer->customer_number;
                            //     $formatted_customer = $customer_name . "(" . $customer_number . ")";
                            //     $lucky_customer[$i]['customer_name'] = $formatted_customer;
                            //     $lucky_customer[$i]['customer_id'] = $customer->id;
                            // }
                        }
                        else
                        {
                            continue;
                        }
                    }
                    else
                    {
                        continue;
                    }
                }
            }
        }
    }
    return $draw_name;

}


// offer name
function get_offer_name($customer_id)
{
    // custoemr
    $today = date('Y-m-d');
    $offer_datas = Offer::whereDate('offer_start_date', '<=', $today)
                ->whereDate('offer_end_date', '>=', $today)
                ->get();

    $offer_name = "";
    $offer_discount = "";
    $offer_id = "";
    $all_pros = "";
    $customer = Customer::where('id', $customer_id)->first();

    if(!empty($offer_datas))
    {
        foreach ($offer_datas as $key => $offer) {

            $first_step = 0;
            if($customer->customer_type==1)
            {
                $university_ids = explode(',', $offer->university_id);
                if($offer->offer_type_student==1)
                {
                    if (in_array($customer->student_university, $university_ids)) {
                        $first_step++;
                    }
                }

            }
            else if($customer->customer_type==3)
            {

                $ministry_ids = explode(',', $offer->ministry_id);
                $workplace_ids = explode(',', $offer->workplace_id);
                if($offer->offer_type_employee==1)
                {

                    if (in_array($customer->ministry_id, $ministry_ids)) {
                        if (in_array($customer->employee_workplace, $workplace_ids)) {
                            $first_step++;

                        }
                    }
                }
            }

            else if($customer->customer_type==4)
            {

                $first_step++;
            }
            if($first_step>0)
            {
                if($customer->gender==1)
                {
                    if($offer->male==1)
                    {
                        $first_step++;
                    }
                }
                else if($customer->gender==2)
                {
                    if($offer->female==1)
                    {
                        $first_step++;
                    }
                }
            }
            if($first_step>1)
            {

                $nationality_ids = explode(',', $offer->nationality_id);
                if (in_array($customer->nationality_id, $nationality_ids)) {
                    $first_step++;
                }
            }

            if($first_step>2)
            {
                $nationality_ids = explode(',', $offer->nationality_id);
                if (in_array($customer->nationality_id, $nationality_ids)) {
                    $first_step++;
                }
                $offer_name = $offer->offer_name;
                $offer_discount = $offer->offer_discount;
                $offer_id = $offer->id;
                if($offer->pro_type == 1)
                {
                    $all_pros  = $offer->offer_product_ids;
                }
                else if($offer->pro_type == 2)
                {
                    $all_products_ids = [];

                    $all_brands = explode(',', $offer->offer_brand_ids);

                    for($i = 0 ; $i < count($all_brands) ; $i++ )
                    {
                        // Retrieve all product IDs associated with the current brand ID
                        $products = Product::where('brand_id', $all_brands[$i])->pluck('id')->toArray();


                        // Merge the product IDs into the $all_products_ids array
                        $all_products_ids = array_merge($all_products_ids, $products);
                    }

                    // Remove duplicates from the array
                    $all_products_ids = array_unique($all_products_ids);

                    // Convert the array of product IDs to a comma-separated string
                    $all_pros = implode(',', $all_products_ids);

                    // Now $product_ids_string contains all unique product IDs associated with the brands in $all_brands

                }
                else if($offer->pro_type == 3)
                {
                    $all_products_ids = [];

                    $all_categories = explode(',', $offer->offer_category_ids);

                    foreach ($all_categories as $category_id) {
                        // Retrieve all product IDs associated with the current category ID
                        $products = Product::where('category_id', $category_id)->pluck('id')->toArray();

                        // Merge the product IDs into the $all_products_ids array
                        $all_products_ids = array_merge($all_products_ids, $products);
                    }

                    // Remove duplicates from the array
                    $all_products_ids = array_unique($all_products_ids);

                    // Convert the array of product IDs to a comma-separated string
                    $all_pros = implode(',', $all_products_ids);

                    // Now $product_ids_string contains all unique product IDs associated with the brands in $all_brands
                }
                break;
            }
        }


    }
    return array($offer_name , $all_pros , $offer_discount , $offer_id);

}
?>
