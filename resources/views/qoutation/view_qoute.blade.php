
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
                            <h6><a href="{{ route('qouts') }}">{{ trans('messages.Quotations_list_lang', [], session('locale')) }}</a></h6>
                            <div class="card" id="demo">
                                   <div class="card-body ">
                                    <div class="row p-4">
                                        <div class="col-lg-9">

                                            <div class="row g-4">
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14"> {{ trans('messages.qout_no_lang', [], session('locale')) }}</p>
                                                    <h5 class="fs-16 mb-0" id="invoice-no">{{ trans('messages.Qout_.No_-00_lang', [], session('locale')) }}{{ $qout_id }}</span></h5>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4 col-4">
                                                    <p class="text-muted mb-1 text-uppercase fw-medium fs-14"> {{ trans('messages.quot_date_lang', [], session('locale')) }}</p>
                                                    <h5 class="fs-16 mb-0">
                                                        <span id="invoice-date">{{ \Carbon\Carbon::parse( $qout_date)->format('j F, Y') }}</span>

                                                    </h5>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mt-sm-0 mt-3">
                                                <div >
                                                    <img src="{{ asset('images/setting_images/' . $shop->invo_logo) }}" class="card-logo card-logo-dark" alt="logo dark" height="80" width="250">

                                                </div>
                                                <h6 class="text-muted text-uppercase fw-semibold">{{ $shop->system_name ?? '' }}</h6>
                                                <h6><span class="text-muted fw-normal">{{ trans('messages.ig_lang', [], session('locale')) }}:</span> <a href="https://tatweersoft.om/" class="link-primary" target="_blank" id="website">{{ $invo->instagram }}</a></h6>
                                                <h6><span class="text-muted fw-normal">{{ trans('messages.email_lang', [], session('locale')) }}:</span><span id="email">{{ $invo->email ?? '' }}</span></h6>

                                                <h6 class="mb-0"><span class="text-muted fw-normal">{{ trans('messages.phone_lang', [], session('locale')) }}: </span><span id="contact-no"> {{ $invo->phone ?? '' }}</span></h6>
                                                <p class="text-muted mb-1" id="address-details">{{ trans('messages.address_lang', [], session('locale')) }}: {{ $invo->address ?? '' }}</p>
                                                <p class="text-muted mb-1" id="zip-code">{{ trans('messages.zip_code_lang', [], session('locale')) }}: {{ $shop->zip_code ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row p-4 border-top border-top-dashed">
                                        <div class="col-lg-9">
                                            <div class="row g-3">
                                                <div class="col-6">


                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">{{ trans('messages.customer_detail_lang', [], session('locale')) }}</h6>
                                                    <p class="fw-medium mb-2" id="billing-name"> {{ trans('messages.customer_name_lang', [], session('locale')) }}: {{ $customer_name }}</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1">{{ trans('messages.phone_lang', [], session('locale')) }}: {{$customer_phone}}</p>
                                                    <p class="text-muted mb-1" id="billing-address-line-1"> {{ trans('messages.customer_no_lang', [], session('locale')) }}:{{$customer_no}}</p>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-3">

                                            <h6 class="text-muted text-uppercase fw-semibold mb-3"> {{ trans('messages.total_amount_lang', [], session('locale')) }}</h6>
                                            <h3 class="fw-bold mb-2 text-danger">{{ trans('messages.OMR_lang', [], session('locale')) }} {{$total_amount  }}</h3>


                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="row">
                                            <div class="card-body p-4">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless text-center  align-middle mb-0">
                                                        <thead>
                                                            <tr class="table-active">
                                                                <th scope="col" style="text-align: left; width:30%;">{{ trans('messages.products_and_services_lang', [], session('locale')) }}</th>
                                                                <th scope="col" style="width:20%;"><P> {{ trans('messages.unit_price_lang', [], session('locale')) }}</P></th>
                                                                <th scope="col" style="width:20%;"><P> {{ trans('messages.quantity_lang', [], session('locale')) }}</P></th>
                                                                <th scope="col" style="width:20%;"> {{ trans('messages.total_amount_lang', [], session('locale')) }}</th>
                                                                <th scope="col" class="text-center" style="width:30%;">{{ trans('messages.description_lang', [], session('locale')) }}</th>
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
                                                            <p> {{ trans('messages.no_products_available_lang', [], session('locale')) }}</p>
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

                                                <div class="row  justify-content-between">
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
                                                                    <td class="fw-medium">{{ trans('messages.sub_total_lang', [], session('locale')) }}</td>
                                                                    <td class="text-end">{{ trans('messages.OMR_lang', [], session('locale')) }} {{ $sub_total }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">{{ trans('messages.shipping_cost_lang', [], session('locale')) }}</td>
                                                                    <td class="text-end">{{ trans('messages.OMR_lang', [], session('locale')) }} {{ $shipping }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="fw-medium"> {{ trans('messages.grand_total_lang', [], session('locale')) }}</td>
                                                                    <td class="text-end">{{ trans('messages.OMR_lang', [], session('locale')) }} {{ $total_amount}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">{{ trans('messages.paid_amount_lang', [], session('locale')) }}</td>
                                                                    <td class="text-end">{{ trans('messages.OMR_lang', [], session('locale')) }} {{ $paid_amount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-medium">{{ trans('messages.remaining_amount_lang', [], session('locale')) }}</td>
                                                                    <td class="text-end" >{{ trans('messages.OMR_lang', [], session('locale')) }} {{ $remaining_amount }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                            <div class="mt-3">
                                                <h6 class="text-muted text-uppercase fw-semibold mb-3">{{ trans('messages.company_signatures_lang', [], session('locale')) }}</h6>

                                            </div>

                                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                    <a href="#" class="btn btn-success"><i class="ri-message-line align-bottom me-1"></i> {{ trans('messages.send_invoice_lang', [], session('locale')) }}</a>
                                                    <a href="javascript:window.print()" class="btn btn-info"><i class="ri-printer-line align-bottom me-1"></i> {{ trans('messages.print_lang', [], session('locale')) }}</a>

                                                </div>

                                                <div class="mt-4">
                                                    <div class="alert alert-info">
                                                        <p class="mb-0"><span class="fw-semibold">{{ trans('messages.notes_lang', [], session('locale')) }}:</span>
                                                            <span id="note">
                                                                {{ $detail->qout_detail ?? '' }}
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
     <center>
            <div id="barcode"></div>
        </center>
    <!-- END layout-wrapper -->
    @include('layouts.footer')
    @endsection


