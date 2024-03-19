<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Product_imei;
use App\Models\Qoutation;
use App\Models\Service;
use Illuminate\Http\Request;

class Qoutcontroller extends Controller
{
    public function index(){

        $customers = Customer::all();
        $products = Product::all();
        $services = Service::all();
        $user = auth()->user();
        // $lastId = Qoutation::max('id');
        // if (!empty($lastId)) {
        //     $invoice_no = 'Invo-Tatweer-00' . $lastId + 1;
        // } else {
        //     $invoice_no = 'Invo-Tatweer-00' . 1;
        // }

        return view('qoutation.add_qout', compact('customers', 'products', 'services') );
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





    public function invoice_detail($id)
    {

        $invoice = Qoutation::with(['client', 'products', 'services'])->find($id);

        $client = $invoice->client;
        $products = $invoice->products;
        $services = $invoice->services;
        $user = auth()->user();
        return view('invoice-files.invoice_detail', compact('invoice', 'client', 'products', 'services', 'user'));
    }

//     public function add_invoice_post(Request $request)
//     {
//         $request->validate([
//             'invoice_no' => 'required|string',
//             'date' => 'nullable',
//             'client_name' => 'required',
//         ]);


//         $existingInvoice = Invoice::where('invoice_no', $request->input('invoice_no'))->first();

//         if ($existingInvoice) {
//             return redirect()->route('add-invoice')->withError('Invoice with the same invoice number already exists.');
//             exit();
//         }
//         $invoice = new Invoice();

//         $invoice->invoice_no = $request->input('invoice_no');
//         $invoice->date = $request->input('date');
//         $invoice->delivery_date = $request->input('delivery_date');
//         $invoice->client_id = $request->input('client_name');
//         $invoice->company_name = $request->input('company_name');
//         $invoice->total_amount = $request->input('total_amount');
//         $invoice->paid_amount = $request->input('paid_amount');
//         $invoice->remaining_amount = $request->input('remaining_amount');

//         $invoice->save();

//         $invoice_id = $invoice->id;



//         $product_id = $request->input('product_name');

//         if (!empty($product_id)) {

//             for ($i = 0; $i < count($product_id); $i++) {

//                 $invoice_product = new Invoice_Product();
//                 $invoice_product->invoice_no = $request->input('invoice_no');

//                 $invoice_product->invoice_id = $invoice_id;
//                 $invoice_product->client_id = $request->client_name;
//                 $invoice_product->product_id = $request->product_name[$i];
//                 $invoice_product->product_detail = $request->product_detail[$i];
//                 $invoice_product->product_amount = $request->product_amount[$i];
//                 $invoice_product->date_type = $request->renewl_date[$i];


//                 if ($request->renewl_date[$i] == 1) {

//                     $invoice_product->renewl_date = Carbon::parse($invoice->delivery_date)->addYear();
//                 } elseif ($request->renewl_date[$i] == 2) {

//                     $invoice_product->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(6);
//                 } elseif ($request->renewl_date[$i] == 3) {

//                     $invoice_product->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(3);
//                 } elseif ($request->renewl_date[$i] == 4) {

//                     $invoice_product->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(1);
//                 } else {

//                     $invoice_product->renewl_date = $request->pro_other_renewal_date[$i];
//                 }

//                 $invoice_product->save();
//             }
//         }

//         $service_id = $request->input('service_name');


//         if (!empty($service_id)) {

//             for ($i = 0; $i < count($service_id); $i++) {
//                 $invoice_service = new Invoice_Service();
//                 $invoice_service->invoice_no = $request->input('invoice_no');
//                 $invoice_service->invoice_id = $invoice_id;
//                 $invoice_service->client_id = $request->client_name;
//                 $invoice_service->service_id = $request->service_name[$i];
//                 $invoice_service->service_detail = $request->service_detail[$i];
//                 $invoice_service->service_amount = $request->service_amount[$i];
//                 $invoice_service->date_type = $request->serv_renewl_date1[$i];


//                 if ($request->serv_renewl_date1[$i] == 1) {

//                     $invoice_service->renewl_date = Carbon::parse($invoice->delivery_date)->addYear();
//                 } elseif ($request->serv_renewl_date1[$i] == 2) {

//                     $invoice_service->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(6);
//                 } elseif ($request->serv_renewl_date1[$i] == 3) {

//                     $invoice_service->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(3);
//                 } elseif ($request->serv_renewl_date1[$i] == 4) {

//                     $invoice_service->renewl_date = Carbon::parse($invoice->delivery_date)->addMonths(1);
//                 } else {

//                     $invoice_service->renewl_date = $request->serv_other_renewal_date[$i];
//                 }


//                 $invoice_service->save();
//             }
//         }


//         $invoice = Invoice::latest()->first();
//         $invoice_id = $invoice->id;

//         return redirect()->route('invoice_detail', ['id' => $invoice_id])->withSuccess('Invoice Generated Successfully!!!');
//     }



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
//         $invoice = Invoice::where('id', $id)->first();



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

public function product_autocomplete(Request $request) {
    $term = $request->input('term');

    $products = Product::where('barcode', 'like', '%' . $term . '%')
                            ->orWhere('product_name', 'like', '%' . $term . '%')
                            ->get()
                            ->toArray();
    $response = [];
    if(!empty($products))
    {
        foreach ($products as $product) {
            if($product['check_imei']==1)
            {

                $products_imei = Product_imei::where('barcode', $product['barcode'])
                                ->get()
                                ->toArray();
                // $imeis = explode(',', $products_imei['imei']);


                foreach ($products_imei as $imei) {

                    $response[] = [
                        'label' => $product['barcode'] . '+' . $imei['imei']. '+' .$product['product_name'] ,
                        'value' => $product['barcode'] . '+' . $imei['imei']. '+' .$product['product_name'] ,
                        'imei' => $imei['imei'],
                    ];
                }
            }
            else
            {
                $response[] = [
                    'label' => $product['product_name'].'+'.$product['barcode'],
                    'value' => $product['barcode'] . '+' . $product['product_name'],
                    'barcode' => $product['barcode'],
                ];

            }
        }
    }
    else
    {
        $products = Product_imei::where('imei', 'like', '%' . $term . '%')
                            ->get()
                            ->toArray();

        foreach ($products as $product) {


            $products_data = Product::where('barcode', $product['barcode'])->first();
            $response[] = [
                'label' => $products_data['product_name'] . '+' . $products_data['barcode'] . '+' . $product['imei'],
                'value' => $products_data['barcode'] . '+' . $products_data['product_name'] . '+' . $product['imei'],
                'barcode' => $products_data['barcode'],
            ];



        }
    }

    return response()->json($response);
}
}
