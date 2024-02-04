@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.brands_lang', [], session('locale')) }}</title>
    @endpush


    <div class="page-wrapper">
        <div class="content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <div class="page-title">
                            <h4> {{ trans('messages.product_brand_list_lang', [], session('locale')) }}</h4>
                            <h6>{{ trans('messages.search_product_brand_lang', [], session('locale')) }}</h6>
                        </div>

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
                            <div class="col-lg-8">
                                <div class="col-lg-6 col-6">
                                    <div>
                                        <img src="{{ asset('images/logo_shop/shop.png') }}" style="height: 100px">
                                    </div>
                                    <h6 class=" text-uppercase fw-semibold"> Company Detail</h6>
                                    <p class=" mb-1" id="zip-code"><span>Invoice No:</span> 90201</p>
                                    <p class=" mb-1" id="zip-code"><span>Added By:</span> 90201</p>
                                    <p class=" mb-1" id="zip-code"><span>Purchase Date:</span> date</p>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <div>
                                    <img src="{{ asset('images/logo_shop/shop.png') }}" style="height: 100px">
                                </div>
                                <h6 class=" text-uppercase fw-semibold">Suuplier Detail</h6>
                                <p class=" mb-1" id="zip-code"><span>Supplier Name:</span> 90201</p>
                                <p class=" mb-1" id="zip-code"><span>Phone:</span> 90201</p>
                                <p class=" mb-1" id="zip-code"><span>Email:</span> 90201</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-body p-4">
                                    <h6 class=" text-uppercase fw-semibold">Products Detail</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Product Details</th>
                                                    <th scope="col">Unit Price</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                <tr>
                                                <th scope="row" class="pt-4">01</th>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <img src="{{ asset('images/brand_images/1705920220.jpg') }}" alt="" style="height: 60px">
                                                            </div>
                                                            <div class="col-lg-6 pt-4">
                                                                <p>Sweatshirt for Men (Pink)</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>#</td>
                                                    <td>#</td>
                                                    <td >#</td>
                                                </tr>
                                            </tbody>
                                        </table><!--end table-->
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <h6 class=" text-uppercase fw-semibold">Payments Detail</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Invoice No</th>
                                                    <th scope="col">Paid Amount</th>
                                                    <th scope="col">Remaining Amout</th>
                                                    <th scope="col" >Payment Method</th>

                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                <tr>
                                                    <th scope="row">01</th>
                                                    <td >
                                                        <p class="text-muted mb-0">Graphic Print Men &amp; Women Sweatshirt
                                                        </p>
                                                    </td>
                                                    <td>$119.99</td>
                                                    <td>02</td>
                                                    <td >$239.98</td>
                                                </tr>
                                            </tbody>
                                        </table><!--end table-->
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                        style="width:250px">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end">$699.96</td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Tax (12.5%)</td>
                                                <td class="text-end">$44.99</td>
                                            </tr>

                                            <tr>
                                                <td>Shipping Charge</td>
                                                <td class="text-end">$65.00</td>
                                            </tr>
                                            <tr class="border-top border-top-dashed fs-15">
                                                <th scope="row">Total Amount</th>
                                                <th class="text-end">$755.96</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>

                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                            <span id="note">All accounts are to be paid within 7 days from receipt of
                                                invoice. To be paid by cheque or
                                                credit card or direct payment online. If account is not paid within 7
                                                days the credits details supplied as confirmation of work undertaken
                                                will be charged the agreed quoted fee noted above.
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <a href="javascript:window.print()" class="btn btn-info"><i
                                            class="ri-printer-line align-bottom me-1"></i> Print</a>
                                    <a href="javascript:window.print()" class="btn btn-success"><i
                                                class="ri-printer-line align-bottom me-1"></i> Pdf</a>
                                    <a href="javascript:void(0);" class="btn btn-primary"><i
                                            class="ri-download-2-line align-bottom me-1"></i> Download</a>
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

    @include('layouts.footer')
@endsection
