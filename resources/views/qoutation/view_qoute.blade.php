
@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.view_qout_lang', [], session('locale')) }}</title>
@endpush

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <a href="{{ url('invoices') }}">
                                    <h4 class="mb-sm-0">Invoices Details</h4>
                                </a>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ url('invoices') }}">Invoices</a></li>
                                        <li class="breadcrumb-item active">Invoice Detail</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row justify-content-center">
                        <div class="col-xxl-9">
                            <div class="card" id="demo">
                                   <div class="card-body">
                                    <div class="row p-4">
                                        <div class="col-lg-9">

                                            <div class="row g-4">
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Invoice No</p>
                                                    <h5 class="fs-16 mb-0" id="invoice-no">{{ $invoice->invoice_no }}</span></h5>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Invoice Date</p>
                                                    <h5 class="fs-16 mb-0">
                                                        <span id="invoice-date">{{ \Carbon\Carbon::parse($invoice->date)->format('j F, Y') }}</span>


                                                    </h5>
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Project Delivery Date</p>
                                                    <h5 class="fs-16 mb-0">
                                                        <span id="invoice-date">{{ \Carbon\Carbon::parse($invoice->delivery_date)->format('j F, Y') }}</span>


                                                    </h5>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mt-sm-0 mt-3">
                                                <div class="mb-4">
                                                    <img src="{{asset('images/tatweer_logo/logo.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="80" width="250">

                                                </div>
                                                <h6 class="text-muted text-uppercase fw-semibold">Tatweer For Software Solutions</h6>
                                                <h6><span class="text-muted fw-normal">Website:</span> <a href="https://tatweersoft.om/" class="link-primary" target="_blank" id="website">www.tatweersoft.om</a></h6>
                                                <h6><span class="text-muted fw-normal">Email:</span><span id="email">Info@tatweersoft.om</span></h6>

                                                <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span id="contact-no"> +96891937980</span></h6>
                                                <p class="text-muted mb-1" id="address-details">Mwaleh, Masqat, Oman</p>
                                                <p class="text-muted mb-1" id="zip-code"> Tatweersoft.om</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row p-4 border-top border-top-dashed">
                                        <div class="col-lg-9">
                                            <div class="row g-3">
                                                <div class="col-6">


                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Client's Details</h6>
                                                    <p class="fw-medium mb-2" id="billing-name">{{ $client->name }}</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">{{$client->company}}</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">{{$client->email}}</p>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">

                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Total Amount</h6>
                                            <h3 class="fw-bold mb-2 text-danger">OMR {{$invoice->total_amount  }}</h3>


                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-body p-4">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless text-center  align-middle mb-0">
                                                        <thead>
                                                            <tr class="table-active">
                                                                <th scope="col" style="text-align: left; width:30%;">Products and Services</th>

                                                                <th scope="col" style="width:20%;">Renewl Date</th>
                                                                <th scope="col" style="width:20%;">Amount</th>
                                                                <th scope="col" class="text-center" style="width:30%;">Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="products-list">
                                                            @if ($invoice->products->isNotEmpty())
                                                            @foreach ($invoice->products as $product)

                                                            <tr>

                                                                <td class="text-start">
                                                                    @php
                                                                        $product_name= DB::table('products')->where('id', $product->product_id)->value('product_name');
                                                                    @endphp
                                                                    <span class="fw-medium">{{ $product_name }}</span>

                                                                    <p class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $product->product_detail }}</p>
                                                                </td>


                                                                <td>{{ \Carbon\Carbon::parse($product->renewl_date)->format('j F, Y') }}
                                                                </td>



                                                                <td>{{ $product->product_amount }}</td>

                                                                    @php
                                                                        $product_detail= DB::table('products')->where('id', $product->product_id)->value('product_detail');
                                                                    @endphp

                                                                <td class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $product_detail }} </td>


                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                        <tbody id="products-list">
                                                            @if ($invoice->services->isNotEmpty())

                                                            @foreach ($invoice->services as $service)
                                                            <tr>

                                                                <td class="text-start">

                                                                    @php
                                                                        $service_name= DB::table('services')->where('id', $service->service_id)->value('service_name');
                                                                    @endphp
                                                                    <span class="fw-medium">{{ $service_name}}</span>

                                                                    <p class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $service->service_detail }}</p>
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($service->renewl_date)->format('j F, Y') }}
                                                                </td>
                                                                <td>{{ $service->service_amount }}</td>

                                                                @php
                                                                $service_detail= DB::table('services')->where('id', $service->service_id)->value('service_detail');
                                                                @endphp

                                                                <td class="text-muted mb-0 " style="white-space: pre-line; text-align: justify; width:50%;">{{  $service_detail}} </td>
                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table><!--end table-->
                                                </div>

                                                <div class="row border-top border-top-dashed mt-2 justify-content-between">
                                                    <div class="col-md-6 me-auto">
                                                        <table class="table table-borderless" style="width:300px">
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="col-md-6 ms-auto">
                                                        <table class="table table-borderless ms-auto" style="width:276px">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="fw-medium">Total Amount</td>
                                                                    <td class="text-end">OMR {{ $invoice->total_amount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">Paid Amount</td>
                                                                    <td class="text-end">OMR {{ $invoice->paid_amount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">Remaining Amount</td>
                                                                    <td class="text-end" >OMR {{ $invoice->remaining_amount }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>


                                                {{-- <div class="row border-top border-top-dashed mt-6">

                                                 <div class="col-md-6"><br><br>
                                                 <div id="signature-pad1"  >
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Client's Signature</h6>
                                                    <canvas id="signatureCanvas1" width="300" height="130" style="border: 1px dotted #b1abab;"></canvas>

                                                    <p class="text-muted mb-1">{{ $client->name }}</p>

                                                    <button id="clearSignature1" class="btn btn-warning " style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;"<i> Clear (X) </i></button>
                                                 </div>
                                                 </div>
                                                 <div class="col-md-6"><br><br>
                                                 <div id="signature-pad2" style="position: absolute; right: 0;" >
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Tatweer's Signature</h6>
                                                    <canvas id="signatureCanvas2" width="250" height="130" style="border: 1px dotted #b1abab;"></canvas>

                                                    <p class="text-muted mb-1"><a href="https://tatweersoft.om/" class="link-primary" target="_blank" id="website">www.tatweersoft.om</a></p>

                                                    <button id="clearSignature2" class="btn btn-warning " style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;"<i> Clear (X)</i></button>
                                                </div> --}}
                                            </div>
                                            </div>

                                            <div class="mt-3">
                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Tatweer's Signatures</h6>

                                            </div>

                                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                    <a href="javascript:window.print()" class="btn btn-success"><i class="ri-message-line align-bottom me-1"></i> Send Invoice</a>
                                                    <a href="javascript:window.print()" class="btn btn-info"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                                    <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                                </div>

                                                <div class="mt-4">
                                                    <div class="alert alert-info">
                                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                            <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or
                                                                credit card or direct payment online. If account is not paid within 7
                                                                days the credits details supplied as confirmation of work undertaken
                                                                will be charged the agreed quoted fee noted above.
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end card-body-->
                                        </div><!--end col-->
                                    </div>
                                   </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    @include('layouts.footer')
    @endsection


