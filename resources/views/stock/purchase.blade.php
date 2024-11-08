@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.purchases_lang', [], session('locale')) }}</title>
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>{{ trans('messages.purchases_list_lang', [], session('locale')) }}</h4>
                        <h6>
                            {{ trans('messages.search_purchases_lang', [], session('locale')) }}
                        </h6>
                    </div>
                    <div class="page-btn">
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_purchase" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.invoice_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.status_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.supplier_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.purchase_date_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.subtotal_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.shipping_charges_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.total_tax_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.grand_total_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /product list -->
            </div>
        </div>
    </div>

    {{-- purchas_payment_modal modal --}}
    <div class="modal fade" id="purchase_payment_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.add_payment_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_purchase_payment') }}" class="add_purchase_payment" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="bill_id" name="bill_id">
                                <input type="hidden" class="purchase_id" name="purchase_id">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.grand_total_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control grand_total" readonly name="grand_total">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.remaining_price_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control remaining_price" readonly name="remaining_price">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.paid_amount_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control paid_amount isnumber" name="paid_amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.payment_method_lang', [], session('locale')) }}</label>
                                        <select class="form-control payment_method" name="payment_method">
                                            @foreach ($account as $acc) {
                                                <option value="{{$acc->id}}">{{$acc->account_name}}</option>';
                                            }
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.payment_date_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control payment_date datetimepicker" value="<?php echo date('Y-m-d'); ?>" name="payment_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                        <textarea  class="form-control notes" rows="3" name="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- purchas_product_modal modal --}}
    <div class="modal fade" id="purchase_product_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.purchase_product_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('approved_purchase') }}" class="approved_purchase" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <input type="hidden" class="approve_purchase_id" name="purchase_id">
                            <div class="row" id="purchase_products_div">
                                
                                 
                            </div>
                            
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>


		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

