
@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.view_qout_lang', [], session('locale')) }}</title>
@endpush

        <div class="main-content">

            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-xxl-8" style="margin: 100px" >
                            <div class="card" id="demo">
                                   <div class="card-body ">
                                    <div class="row p-4">
                                        <div class="col-lg-9">

                                            <div class="row g-4">
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Qoutation No</p>
                                                    <h5 class="fs-16 mb-0" id="invoice-no">Qout.No-00{{ $qout_id }}</span></h5>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Qoutation Date</p>
                                                    <h5 class="fs-16 mb-0">
                                                        <span id="invoice-date">{{ \Carbon\Carbon::parse( $qout_date)->format('j F, Y') }}</span>

                                                    </h5>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mt-sm-0 mt-3">
                                                <div class="mb-4">
                                                    <img src="{{asset('img/logo.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="80" width="250">

                                                </div>
                                                <h6 class="text-muted text-uppercase fw-semibold">Super Electron Enterprise</h6>
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
                                                    <p class="fw-medium mb-2" id="billing-name">{{ $customer_name }}</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">{{$customer_phone}}</p>


                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">

                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Total Amount</h6>
                                            <h3 class="fw-bold mb-2 text-danger">OMR {{$total_amount  }}</h3>


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
                                                                <th scope="col" style="width:20%;"><P>Unit Price</P></th>
                                                                <th scope="col" style="width:20%;"><P>Quantity</P></th>
                                                                <th scope="col" style="width:20%;">Total Price</th>
                                                                <th scope="col" class="text-center" style="width:30%;">Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="products-list">

                                                            @forelse ($products as $product)

                                                            <tr>

                                                                <td class="text-start">
                                                                    @php
                                                                        $product_name= DB::table('products')->where('id', $product->product_id)->value('product_name');
                                                                    @endphp
                                                                    <span class="fw-medium">{{ $product_name }}</span>

                                                                    <p class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $product->product_detail }}</p>
                                                                </td>

                                                                <td>{{ $product->product_price}}
                                                                </td>
                                                                <td>{{ $product->product_quantity}}
                                                                </td>



                                                                <td>{{ $product->total_price }}</td>


                                                                @php
                                                                $product_detail = DB::table('products')->where('id', $product->product_id)->value('description');

                                                                 @endphp


                                                                 <td class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $product_detail }} </td>


                                                            </tr>
                                                            @empty
                                                            <p>No products available</p>
                                                            @endforelse

                                                        </tbody>
                                                        <tbody id="services-list">


                                                            @foreach ($services as $service)
                                                            <tr>

                                                                <td class="text-start">
                                                                    @php
                                                                        $service_name = DB::table('services')->where('id', $service->service_id)->value('service_name');
                                                                    @endphp
                                                                    @if ($service_name)
                                                                        <span class="fw-medium">{{ $service_name }}</span>
                                                                        <p class="text-muted mb-0" style="white-space: pre-line; text-align: justify; width:100%;">{{ $service->service_detail }}</p>

                                                                    @endif
                                                                </td>
                                                                <td>{{$service->service_price }}
                                                                </td>
                                                                <td>{{ $service->service_quantity}}
                                                                </td>
                                                                <td>{{ $service->total_price }}</td>

                                                                @php
                                                                $service_detail = DB::table('services')->where('id', $service->service_id)->value('service_detail');

                                                            @endphp


                                                                <td class="text-muted mb-0 " style="white-space: pre-line; text-align: justify; width:50%;">{{  $service_detail}} </td>
                                                            </tr>
                                                            @endforeach

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
                                                                    <td class="fw-medium">Sub Total</td>
                                                                    <td class="text-end">OMR {{ $sub_total }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">Shipping Cost</td>
                                                                    <td class="text-end">OMR {{ $shipping }}</td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td class="fw-medium">Tax</td>
                                                                    <td class="text-end">OMR {{ $tax }}</td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td class="fw-medium">Grand Total</td>
                                                                    <td class="text-end">OMR {{ $total_amount}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">Paid Amount</td>
                                                                    <td class="text-end">OMR {{ $paid_amount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">Remaining Amount</td>
                                                                    <td class="text-end" >OMR {{ $remaining_amount }}</td>
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


