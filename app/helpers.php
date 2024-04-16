<?php
use Illuminate\Support\Facades\DB;
use App\Models\Purchase_imei;
use App\Models\Sms;
use App\Models\PosOrder;
use App\Models\Warranty;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Repairing;
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
    $transaction_no= "";
    $product_name= "";
    $receive_date= "";
    $delivery_date= "";
    $status="";
    $notes="";
    $receipt_date="";
    $serial_no="";
    $warranty_duration="";
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
        $total_point = "";
    }
    else if($params['sms_status']==3)
    {
        $order_data =  PosOrder::where('order_no', $params['order_no'])->first();
        $edit_customer = Customer::find($order_data->customer_id);
        $warranty_data =  Warranty::where('order_no', $params['order_no'])->get();
        $customer_name = $edit_customer->customer_name;
        $customer_number = $edit_customer->customer_number;
        $total_point = "";
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
        $warranty_invoice_link = "";
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


    $variables = [
        'customer_number' => $customer_number,
        'customer_name' => $customer_name, 
        'total_point' => $total_point, 
        'warranty_invoice_number' => $warranty_invoice_number, 
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
        'warranty_duration'=>$warranty_duration
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
        $return_status= $result['response'];
         
    }
}
?>
