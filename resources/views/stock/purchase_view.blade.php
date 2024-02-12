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
                                    <h6 class=" text-uppercase fw-semibold">  {{ trans('messages.company_detail_lang', [], session('locale')) }}</h6>
                                    <p class=" mb-1" id="zip-code"><span> {{ trans('messages.invoice_lang', [], session('locale')) }}</span> {{ $purchase_invoice->invoice_no }}</p>
                                    <p class=" mb-1" id="zip-code"><span> {{ trans('messages.created_by_lang', [], session('locale')) }}</span> admin</p>
                                    <p class=" mb-1" id="zip-code"><span>{{ trans('messages.purchase_date_lang', [], session('locale')) }}</span> {{ $purchase_invoice->purchase_date }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <h6 class=" text-uppercase fw-semibold"> {{ trans('messages.supplier_detail_lang', [], session('locale')) }}</h6>
                                <p class=" mb-1" id="zip-code"><span> {{ trans('messages.supplier_name_lang', [], session('locale')) }}</span> {{ $supplier_name }}</p>
                                <p class=" mb-1" id="zip-code"><span> {{ trans('messages.contact_lang', [], session('locale')) }}</span> {{ $supplier_phone }}</p>
                                <p class=" mb-1" id="zip-code"><span> {{ trans('messages.email_lang', [], session('locale')) }}</span> {{ $supplier_email }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive card-body">
                                <h6 class=" text-uppercase fw-semibold"> {{ trans('messages.product_detail_lang', [], session('locale')) }}</h6>
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <div class="row table-active">
                                            <th class="col-lg-1">#</th>
                                            <th class="col-lg-2"> {{ trans('messages.product_detail_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-1"> {{ trans('messages.unit_price_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-1">{{ trans('messages.tax_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-1"> {{ trans('messages.quantity_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-3">{{ trans('messages.imei_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-1"> {{ trans('messages.warranty_lang', [], session('locale')) }}</th>
                                            <th class="col-lg-1">{{ trans('messages.subtotal_lang', [], session('locale')) }}</th>
                                            </div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $purchase_detail_table; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if(!empty($purchase_payment_detail)){ ?>
                            <div class="card-body p-4">
                                <h6 class=" text-uppercase fw-semibold"> {{ trans('messages.purchase_detail_lang', [], session('locale')) }}</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col">{{ trans('messages.payment_date_lang', [], session('locale')) }}:</th>
                                                <th scope="col">{{ trans('messages.payment_method_lang', [], session('locale')) }}:</th>
                                                <th scope="col"> {{ trans('messages.total_price_lang', [], session('locale')) }}:</th>
                                                <th scope="col">{{ trans('messages.paid_amount_lang', [], session('locale')) }}:</th>
                                                <th scope="col">{{ trans('messages.remaining_amount_lang', [], session('locale')) }}:</th>

                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                            <?php echo $purchase_payment_detail; ?>
                                        </tbody>
                                    </table><!--end table-->
                                </div>
                            </div>
                        <?php }?>
                        <div class="mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                style="width:250px">
                                <tbody>
                                    <tr>
                                        <td>{{ trans('messages.subtotal_lang', [], session('locale')) }}:</td>
                                        <td class="text-end">{{ number_format($sub_total, 3) }}                                        </td>
                                    </tr>
                                    <tr>
                                        <td> {{ trans('messages.estimated_tax_lang', [], session('locale')) }}:</td>
                                        <td class="text-end">{{ $total_tax}}</td>
                                    </tr>
                                    <tr>
                                        <td> {{ trans('messages.shipping_charges_lang', [], session('locale')) }}:</td>
                                        <td class="text-end">{{ number_format($shipping_cost, 3) }}                                        </td>
                                    </tr>
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">{{ trans('messages.total_price_lang', [], session('locale')) }}:</th>
                                        <th class="text-end">{{ $grand_total }}</th>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('messages.total_paid_lang', [], session('locale')) }}:</td>
                                        <td class="text-end">{{ number_format($payment_paid,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td> {{ trans('messages.total_remaining_lang', [], session('locale')) }}:</td>
                                        <td class="text-end">{{ $payment_remaining }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        @if(!empty($purchase_invoice->description))
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <p class="mb-0">
                                        <span class="fw-semibold">{{ trans('messages.notes_lang', [], session('locale')) }}:</span>
                                        <span id="note">{{ $purchase_invoice->description }}</span>
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-info"><i class="ri-printer-line align-bottom me-1"></i>  {{ trans('messages.purchase_detail_lang', [], session('locale')) }}</a>
                            <?php if(!empty($purchase_invoice->receipt_file)){ ?>
                                <a href="{{ url('purchase_invoice').'/'.$purchase_invoice->id }}" class="btn btn-info"><i
                                    class="ri-printer-line align-bottom me-1"></i>  {{ trans('messages.purchase_detail_lang', [], session('locale')) }}</a>
                            <?php }?>
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
