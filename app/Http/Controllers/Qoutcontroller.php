<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Qoutation;
use App\Models\Workplace;
use App\Models\University;
use App\Models\Product_imei;
use App\Models\QouteProduct;
use App\Models\QouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class Qoutcontroller extends Controller
{
    public function index(){

        $customers = Customer::all();
        $products = Product::all();
        $services = Service::all();
        $user = auth()->user();
        $workplaces = Workplace::all();
        $universities = University::all();
        // $lastId = Qoutation::max('id');
        // if (!empty($lastId)) {
        //     $invoice_no = 'Invo-Tatweer-00' . $lastId + 1;
        // } else {
        //     $invoice_no = 'Invo-Tatweer-00' . 1;
        // }

        return view('qoutation.add_qout', compact('customers', 'products', 'services', 'universities', 'workplaces') );
    }

//     public function invoices()
//     {


//         $clients = Client::all();
//         $invoices = Invoice::with('client')->paginate(12);

//         $invoice = Invoice::with('invoice_payments')->get();


//         $invoice_total_payment = Invoice::sum('total_amount');

//         $total_invoices = Invoice::count();

//         $total_clients = Client::count();

//         $total_remaining_amounts = Invoice::sum('remaining_amount');

//         $total_paid_amounts = Invoice::sum('paid_amount') + Invoice_payment::sum('paid_amount');

//         $countInvoicesWithRemainingAmount = Invoice::where('remaining_amount', '>', 0)
//             ->count();





//         $countInvoicesWithpaidAmount = Invoice::where('paid_amount', '>', 0)
//             ->count();

//         $countInvoicesPaymentsWithpaidAmount = Invoice_payment::where('paid_amount', '>', 0)
//             ->count();


//         $totalCountpaid = $countInvoicesWithpaidAmount + $countInvoicesPaymentsWithpaidAmount;


//         $remaining_percent = $this->calculatePercentage($invoice_total_payment, $total_remaining_amounts);
//         $paid_percent = $this->calculatePercentage($invoice_total_payment, $total_paid_amounts);


//         $format_percent_paid = number_format($paid_percent, 2, '.', ',');
//         $format_percent_remaining = number_format($remaining_percent, 2, '.', ',');

//         $user = auth()->user();

//         return view('invoice-files.invoices', compact(

//             'clients',
//             'invoices',
//             'invoice',
//             'invoice_total_payment',
//             'total_invoices',
//             'total_remaining_amounts',
//             'total_paid_amounts',
//             'countInvoicesWithRemainingAmount',
//             'totalCountpaid',
//             'total_clients',
//             'format_percent_remaining',
//             'format_percent_paid',
//             'user'

//         ));
//     }

//     public function calculatePercentage($totalAmount, $partAmount)
// {
//     if ($totalAmount == 0) {
//         return 0;
//     }


//     return ($partAmount / $totalAmount) * 100;
// }




    public function add_invoice()
    {

        $customers = Customer::all();
        $products = Product::all();
        $services = Service::all();
        $user = auth()->user();
        // $lastId = Invoice::max('id');
        // if (!empty($lastId)) {
        //     $invoice_no = 'Invo-Tatweer-00' . $lastId + 1;
        // } else {
        //     $invoice_no = 'Invo-Tatweer-00' . 1;
        // }


        return view('invoice-files.add-invoice', compact('customers', 'products', 'services', 'invoice_no', 'user'));

    }





    // public function invoice_detail($id)
    // {

    //     $invoice = Qoutation::with(['client', 'products', 'services'])->find($id);

    //     $client = $invoice->client;
    //     $products = $invoice->products;
    //     $services = $invoice->services;
    //     $user = auth()->user();
    //     return view('invoice-files.invoice_detail', compact('invoice', 'client', 'products', 'services', 'user'));
    // }

    // public function add_invoice_post(Request $request)
    // {
    //     $request->validate([
    //         'invoice_no' => 'required|string',
    //         'date' => 'nullable',
    //         'client_name' => 'required',
    //     ]);


    //     $existingInvoice = Qoutation::where('invoice_no', $request->input('invoice_no'))->first();

    //     if ($existingInvoice) {
    //         return redirect()->route('add-invoice')->withError('Invoice with the same invoice number already exists.');
    //         exit();
    //     }
    //    $qout = new Qoutation();

    //    $qout->qout_no = $request->input('invoice_no');
    //    $qout->date = $request->input('date');
    //    $qout->customer_id = $request->input('customer_name');
    //    $qout->total_amount = $request->input('total_amount');
    //    $qout->paid_amount = $request->input('paid_amount');
    //    $qout->remaining_amount = $request->input('remaining_amount');
    //    $qout->save();

    //    $qout_id =$qout->id;



    //     $product_id = $request->input('product_name');

    //     if (!empty($product_id)) {

    //         for ($i = 0; $i < count($product_id); $i++) {

    //            $qout_product = new QouteProduct();
    //            $qout_product->qout_no = $request->input('qoute_no');

    //            $qout_product->qout_id =$qout_id;
    //            $qout_product->customer_id = $request->customer_name;
    //            $qout_product->product_id = $request->product_name[$i];
    //            $qout_product->product_detail = $request->product_detail[$i];
    //            $qout_product->product_amount = $request->product_amount[$i];
    //            $qout_product->warranty_days = $request->warranty_days[$i];
    //            $qout_product->warranty_type = $request->warranty_type[$i];
    //            $qout_product->quantity = $request->quantity[$i];

    //            $qout_product->save();
    //         }
    //     }

    //     $service_id = $request->input('service_name');


    //     if (!empty($service_id)) {

    //         for ($i = 0; $i < count($service_id); $i++) {
    //            $qout_service = new QouteService();
    //            $qout_service->qout_id =$qout_id;
    //            $qout_service->customer_id = $request->customer_name;
    //            $qout_service->service_id = $request->service_name[$i];
    //            $qout_service->service_detail = $request->service_detail[$i];
    //            $qout_service->service_amount = $request->service_amount[$i];
    //            $qout_service->warranty_days = $request->warranty_days[$i];
    //            $qout_service->warranty_type = $request->warranty_type[$i];
    //            $qout_service->quantity = $request->quantity[$i];

    //            $qout_service->save();
    //         }
    //     }


    //    $qout = Qoutation::latest()->first();
    //    $qout_id =$qout->id;

    //     return redirect()->route('invoice_detail', ['id' =>$qout_id])->withSuccess('Invoice Generated Successfully!!!');
    // }



//     public function invoice_remove($id)
//     {
//         $remove_invoice = Invoice::find($id);

//         if (!$remove_invoice) {
//             return redirect()->route('invoices')->withError('Invoice not found!');
//         }

//         $remove_invoice->delete();

//         return redirect()->route('invoices')->withSuccess('Invoice Deleted Successfully!');
//     }
//     public function payment_remove($id)
//     {
//         $remove_payment = Invoice_payment::find($id);

//         if (!$remove_payment) {
//             return redirect()->route('invoices')->withError('payment not found!');
//         }

//         $remove_payment->delete();

//         return redirect()->route('invoices')->withSuccess('payment Deleted Successfully!');
//     }


//     public function edit_invoice($id)
//     {




//         $clients = Client::all();
//         $products = Product::all();
//         $services = Service::all();
//        $qout = Invoice::where('id', $id)->first();



//         $invoice_service = Invoice_Service::where('invoice_id', $id)->get();
//         $invoice_product = Invoice_Product::where('invoice_id', $id)->get();

//         $user = auth()->user();






//         $lastId = Invoice::max('id');
//         if (!empty($lastId)) {
//             $invoice_no = 'Invo-Tatweer-00' . $lastId + 1;
//         } else {
//             $invoice_no = 'Invo-Tatweer-00' . 1;
//         }




//         return view('invoice-files.invoice_edit', compact('clients',
//         'products', 'services', 'invoice_no', 'invoice',
//         'invoice_product', 'invoice_service', 'user'));

//     }






//     public function edit_invoice_post(Request $request)
// {

//     $id = $request->input('invo_id');
//     $invoice_edit = Invoice::find($id);

//     // Check if the invoice exists
//     if (!$invoice_edit) {
//         return redirect()->route('invoices')->withSuccess('No invoice found');
//     }


//     $request->validate([
//         'invoice_no' => 'required|string',
//         'date' => 'nullable',
//         'client_name' => 'required',
//     ]);

//     $invoice_edit->invoice_no = $request->input('invoice_no');
//     $invoice_edit->date = $request->input('date');
//     $invoice_edit->client_id = $request->input('client_name');
//     $invoice_edit->company_name = $request->input('company_name');
//     $invoice_edit->total_amount = $request->input('total_amount');
//     $invoice_edit->paid_amount = $request->input('paid_amount');
//     $invoice_edit->remaining_amount = $request->input('remaining_amount');

//     $invoice_edit->save();


//     Invoice_Product::where('invoice_id', $id)->delete();
//     $product_id = $request->input('product_name');

//     if (!empty($product_id)) {

//         for ($i = 0; $i < count($product_id); $i++) {

//             $invoice_product = new Invoice_Product();
//             $invoice_product->invoice_no = $request->input('invoice_no');

//             $invoice_product->invoice_id = $id;
//             $invoice_product->client_id = $request->client_name;
//             $invoice_product->product_id = $request->product_name[$i];
//             $invoice_product->product_detail = $request->product_detail[$i];
//             $invoice_product->product_amount = $request->product_amount[$i];
//             $invoice_product->date_type = $request->renewl_date[$i];


//             if ($request->renewl_date[$i] == 1) {

//                 $invoice_product->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addYear();
//             } elseif ($request->renewl_date[$i] == 2) {

//                 $invoice_product->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(6);
//             } elseif ($request->renewl_date[$i] == 3) {

//                 $invoice_product->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(3);
//             } elseif ($request->renewl_date[$i] == 4) {

//                 $invoice_product->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(1);
//             } else {

//                 $invoice_product->renewl_date = null;
//             }

//             $invoice_product->save();
//         }
//     }

//     $service_id = $request->input('service_name');
//     Invoice_Service::where('invoice_id', $id)->delete();
//     if (!empty($service_id)) {

//         for ($i = 0; $i < count($service_id); $i++) {
//             $invoice_service = new Invoice_Service();
//             $invoice_service->invoice_no = $request->input('invoice_no');
//             $invoice_service->invoice_id = $id;
//             $invoice_service->client_id = $request->client_name;
//             $invoice_service->service_id = $request->service_name[$i];
//             $invoice_service->service_detail = $request->service_detail[$i];
//             $invoice_service->service_amount = $request->service_amount[$i];
//             $invoice_service->date_type = $request->serv_renewl_date1[$i];


//             if ($request->serv_renewl_date1[$i] == 1) {

//                 $invoice_service->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addYear();
//             } elseif ($request->serv_renewl_date1[$i] == 2) {

//                 $invoice_service->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(6);
//             } elseif ($request->serv_renewl_date1[$i] == 3) {

//                 $invoice_service->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(3);
//             } elseif ($request->serv_renewl_date1[$i] == 4) {

//                 $invoice_service->renewl_date = Carbon::parse($invoice_edit->delivery_date)->addMonths(1);
//             } else {

//                 $invoice_service->renewl_date = null;
//             }


//             $invoice_service->save();
//         }
//     }



//     // Redirect to the invoice detail page
//     return redirect()->route('invoice_detail', ['id' => $invoice_edit->id])->withSuccess('Invoice Updated Successfully!!!');
// }



//     public function get_invoice_payment(Request $request)
//     {
//         $invoice_id = $request->input('id');
//         $invoice = Invoice::find($invoice_id);

//         return response()->json(['invoice' => $invoice]);
//     }


//     public function get_invoice_payment_post(Request $request)
//     {


//         $invoice_payment = new Invoice_payment();

//         $invoice_payment->invoice_id = $request->input('invoice_id');
//         $invoice_payment->client_id = $request->input('client_id');
//         $invoice_payment->invoice_no = $request->input('invoice_no');
//         $invoice_payment->remaining_amount = $request->input('remaining_amount');
//         $invoice_payment->paid_amount = $request->input('paid_amount');
//         $invoice_payment->payment_date = $request->input('payment_date');


//         $invoice_payment->save();



//         $invoice_data= Invoice::findOrFail($invoice_payment->invoice_id);


//         $paidamount= $invoice_data->paid_amount + $request->input('paid_amount');

//         $remainingAmount = $invoice_data->remaining_amount - $request->input('paid_amount');
//         $invoice_data->update(['remaining_amount' => $remainingAmount, 'paid_amount'=> $paidamount]);




//         $invoice_payment = Invoice_payment::latest()->first();
//         $invoice_payment_id = $invoice_payment->id;


//         return redirect()->route('invoices', ['id' => $invoice_payment_id])->withSuccess('Invoice Updated Successfully!');
//     }





//     public function invoice_payment($id)
//     {


//         $invoice_payment = Invoice_payment::find($id);

//         $invoice_no = $invoice_payment->invoice_no;



//         $invoice = Invoice::where('invoice_no', $invoice_no)->first();



//         $user = auth()->user();


//         return view('invoice-files.invoice_payment', compact('invoice_payment', 'invoice', 'user'));
//     }





//product_auto

// public function product_autocomplete(Request $request) {
//     $term = $request->input('term');

//     $products = Product::where('barcode', 'like', '%' . $term . '%')
//                             ->orWhere('product_name', 'like', '%' . $term . '%')
//                             ->get()
//                             ->toArray();
//     $response = [];
//     if(!empty($products))
//     {
//         foreach ($products as $product) {
//             if($product['check_imei']==1)
//             {

//                 $products_imei = Product_imei::where('barcode', $product['barcode'])
//                                 ->get()
//                                 ->toArray();

//                 foreach ($products_imei as $imei) {

//                     $response[] = [
//                         'label' => $product['barcode'] . '+' . $imei['imei']. '+' .$product['product_name'] ,
//                         'value' => $product['product_name'] ,
//                         'imei' => $imei['imei'],
//                     ];
//                 }
//             }
//             else
//             {
//                 $response[] = [
//                     'label' => $product['product_name'].'+'.$product['barcode'],
//                     'value' => $product['barcode'] . '+' . $product['product_name'],
//                     'barcode' => $product['barcode'],
//                 ];

//             }
//         }
//     }
//     else
//     {
//         $products = Product_imei::where('imei', 'like', '%' . $term . '%')
//                             ->get()
//                             ->toArray();

//         foreach ($products as $product) {


//             $products_data = Product::where('barcode', $product['barcode'])->first();
//             $response[] = [
//                 'label' => $products_data['product_name'] . '+' . $products_data['barcode'] . '+' . $product['imei'],
//                 'value' => $products_data['barcode'] . '+' . $products_data['product_name'] . '+' . $product['imei'],
//                 'barcode' => $products_data['barcode'],
//             ];

//         }
//     }

//     return response()->json($response);
// }


public function product_autocomplete(Request $request) {
    $term = $request->input('term');

    $products = Product::where('barcode', 'like', '%' . $term . '%')
                            ->orWhere('product_name', 'like', '%' . $term . '%')
                            ->get()
                            ->toArray();
    $response = [];
    if(!empty($products)) {
        foreach ($products as $product) {

            if ($product['warranty_type'] == 1) {
                $warrantyText = 'Shop';
            } elseif ($product['warranty_type'] == 2) {
                $warrantyText = 'Agent';
            } elseif ($product['warranty_type'] == 3) {
                $warrantyText = 'None';
            } else {
                $warrantyText = 'Not Given';
            }

            $response[] = [
                'label' => $product['barcode'] . '+' . $product['product_name'],
                'value' => $product['barcode'] . '+' . $product['product_name'],
                'purchase_price' => $product['purchase_price'],
                'warranty' => $warrantyText . ': ' .$product['warranty_days'],
            ];
        }
    }

    return response()->json($response);
}


//service auto
public function service_autocomplete(Request $request) {
    $term = $request->input('term');
    $services = Service::where('service_name', 'like', '%' . $term . '%')->get();

    $response = [];
    foreach ($services as $service) {
        $response[] = [
            'label' => $service->service_name,
            'value' => $service->service_name,
            'service_cost' => $service->service_cost
        ];
    }

    return response()->json($response);
}



//customer auto
public function add_customer(Request $request){

    $customer = new Customer();
    $customer_img_name="";
    if ($request->file('customer_image')) {
        $folderPath = public_path('images/customer_images');
        if (!File::isDirectory($folderPath)) {
            File::makeDirectory($folderPath, 0777, true, true);
        }
        $customer_img_name = time() . '.' . $request->file('customer_image')->extension();
        $request->file('customer_image')->move(public_path('images/customer_images'), $customer_img_name);
    }

    $nationalId = $request->input('national_id');
    $existingCustomer = Customer::where('national_id', $nationalId)->first();

    if ($existingCustomer) {

        return response()->json(['customer_id' => '', 'status' => 2]);
    }

    $customer->customer_id = genUuid() . time();
    $customer->customer_name = $request['customer_name'];
    $customer->customer_phone = $request['customer_phone'];
    $customer->customer_email = $request['customer_email'];
    $customer->national_id = $request['national_id'];
    $customer->customer_detail = $request['customer_detail'];
    $customer->student_id = $request['student_id'];
    $customer->student_university = $request['student_university'];
    $customer->teacher_university = $request['teacher_university'];
    $customer->employee_id = $request['employee_id'];
    $customer->employee_workplace = $request['employee_workplace'];
    $customer->customer_type = $request['customer_type'];
    $customer->customer_image = $customer_img_name;
    $customer->added_by = 'admin';
    $customer->user_id = '1';
    $customer->save();
    return response()->json(['customer_id' => $customer->id, 'status' => 1]);


}

public function customer_auto(Request $request)
{
    $term = $request->input('term');

    $customers = Customer::where('id', $term)
    ->orWhere('national_id', $term)
    ->orWhere('customer_name', 'like', "%{$term}%")
    ->orWhere('customer_phone', 'like', "%{$term}%")
    ->get(['id', 'national_id', 'customer_name', 'customer_phone']);


    $response = [];
    foreach ($customers as $customer) {
        $label = $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')';
        if (!empty($customer->national_id)) {
            $label .= ' - ' . $customer->national_id;
        }

        $response[] = [
            'label' => $label,
            'value' => $customer->id . ': ' . $customer->customer_name . ' (' . $customer->customer_phone . ')',
            'phone' => $customer->customer_phone,
            'national_id' => $customer->national_id,
        ];
    }

    return response()->json($response);
}

}
