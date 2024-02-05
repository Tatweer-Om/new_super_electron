@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.purcuase_detail_lang', [], session('locale')) }}</title>
    @endpush


    <div class="page-wrapper">
        <div class="content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <div class="page-title">
                            <h4> {{ trans('messages.purchase_detail_lang', [], session('locale')) }}</h4>

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
                                    <h6 class=" text-uppercase fw-semibold"> Company Detail</h6>
                                    <p class=" mb-1" id="zip-code"><span>Invoice No:</span> {{ $purchase->invoice_no }}</p>
                                    <p class=" mb-1" id="zip-code"><span>Added By:</span> admin</p>
                                    <p class=" mb-1" id="zip-code"><span>Purchase Date:</span> {{ $purchase->purchase_date }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <h6 class=" text-uppercase fw-semibold">Suuplier Detail</h6>
                                <p class=" mb-1" id="zip-code"><span>Supplier Name:</span> {{ $supplier_name }}</p>
                                <p class=" mb-1" id="zip-code"><span>Phone:</span> {{ $supplier_phone }}</p>
                                <p class=" mb-1" id="zip-code"><span>Email:</span> {{ $supplier_email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive card-body">
                                <h6 class=" text-uppercase fw-semibold">Products Detail</h6>
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <div class="row table-active">
                                            <th scope="col-lg-1">#</th>
                                            <th class="col-lg-2">Product Detail</th>
                                            <th class="col-lg-1">Unit Price(OMR) </th>
                                            <th class="col-lg-1">Qunatity</th>
                                            <th class="col-lg-3">IMEI</th>
                                            <th class="col-lg-2">Warranty</th>
                                            <th class="col-lg-1">Subtotal (OMR) </th>

                                            </div>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $purchase_detail_table; ?>
                                    </tbody>
                                </table>
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
                                            <th scope="col">Total Amount</th>
                                            <th scope="col">Payment Method</th>

                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>
                                                <p class="text-muted mb-0">{{ $invoice_detail->invoice_no }}
                                                </p>
                                            </td>
                                            {{-- <td>{{$purchase_payment->paid_amount }}</td> --}}
                                            <td>{{$invoice_detail-> remaining_price }}</td>
                                            <td>{{ $invoice_detail->total_price }}</td>
                                            {{-- <td>{{ $purchase_payment->payment_method }}</td> --}}
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
                                        <td class="text-end">{{ $invoice_detail->total_price }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estimated Tax</td>
                                        <td class="text-end">{{ $invoice_detail->total_tax}}</td>
                                    </tr>

                                    <tr>
                                        <td>Shipping Charge</td>
                                        <td class="text-end">{{ $shipping_cost }}</td>
                                    </tr>
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">Total Amount</th>
                                        <th class="text-end">{{ $invoice_detail->grand_total }}</th>
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
