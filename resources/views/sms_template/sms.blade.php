@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.sms_panel_lang', [], session('locale')) }}</title>
    @endpush
            <div class="page-wrapper">
                <div class="content">
                    <div class="page-header">
                        <div class="page-title">
                            <h4> {{ trans('messages.sms_panel_lang', [], session('locale')) }}</h4>
                            <h6>{{ trans('messages.add_sms_lang', [], session('locale')) }}</h6>
                        </div>

                    </div>
                    <!-- /product list -->
                    <div class="card">
                        <div class="card-body">
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <form action="{{ url('add_status_sms') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-row">
                                            <label for="validationCustom04">{{ trans('messages.panel_available_msg_lang', [], session('locale')) }}:</label>
                                            <select class="form-control sms_status" name="status" id="sms_status">
                                                <option value="">{{ trans('messages.panel_choose_lang', [], session('locale')) }}</option>
                                                <option value="1">{{ trans('messages.panel_customer_add_lang', [], session('locale')) }}</option>
                                                <option value="2">{{ trans('messages.panel_checkout_lang', [], session('locale')) }}</option>
                                                <option value="3">{{ trans('messages.panel_checkout_warranty_lang', [], session('locale')) }}</option>
                                                <option value="12">{{ trans('messages.panel_point_payment_lang', [], session('locale')) }}</option>
                                                <option value="4">{{ trans('messages.panel_local_maintenance_receive_status_lang', [], session('locale')) }}</option>
                                                <option value="5">{{ trans('messages.panel_local_maintenance_ready_status_lang', [], session('locale')) }}</option>
                                                <option value="6">{{ trans('messages.panel_local_maintenance_after_paid_lang', [], session('locale')) }}</option>
                                                <option value="7">{{ trans('messages.panel_local_maintenance_after_paid_warranty_lang', [], session('locale')) }}</option>
                                                <option value="8">{{ trans('messages.panel_warranty_maintenance_receive_status_lang', [], session('locale')) }}</option>
                                                <option value="9">{{ trans('messages.panel_warranty_maintenance_all status_lang', [], session('locale')) }}</option>
                                                <option value="10">{{ trans('messages.panel_add_offer_lang', [], session('locale')) }}</option>
                                                <option value="11">{{ trans('messages.panel_add_luckydraw_lang', [], session('locale')) }}</option>
                                                <option value="13">{{ trans('messages.panel_pos_luckydraw_lang', [], session('locale')) }}</option>
                                            </select>
                                        </div>
                                        <br>
                                        <b>
                                            <div class="form-row">
                                                <p>{{ trans('messages.panel_variables_lang', [], session('locale')) }}</p>
                                            </div>

                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success customer_name">{{ trans('messages.customer_name_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success customer_number">{{ trans('messages.customer_number_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success total_point">{{ trans('messages.total_point_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success remaining_point">{{ trans('messages.remaining_point_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success invoice_link">{{ trans('messages.invoice_link_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success warranty_invoice_number">{{ trans('messages.warranty_invoice_number_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success warranty_detail">{{ trans('messages.warranty_detail_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success warranty_invoice_link">{{ trans('messages.warranty_invoice_link_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success transaction_no">{{ trans('messages.transaction_id_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success product_name">{{ trans('messages.product_name_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success receive_date">{{ trans('messages.receiving_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success delivery_date">{{ trans('messages.deliver_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success status">{{ trans('messages.status_lang', [], session('locale')) }}</p>
                                            </div>

                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success serial_no">{{ trans('messages.imei_serial_no_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success receipt_date">{{ trans('messages.receipt_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success notes">{{ trans('messages.notes_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success warranty_duration">{{ trans('messages.warranty_days_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success offer_name">{{ trans('messages.offer_name_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success start_date">{{ trans('messages.offer_start_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success end_date">{{ trans('messages.offer_end_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success luckydraw_name">{{ trans('messages.draw_name_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success luckydraw_date">{{ trans('messages.draw_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success luckydraw_coupons">{{ trans('messages.pos_luckydraw_coupons_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success draw_name">{{ trans('messages.pos_draw_name_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success draw_date">{{ trans('messages.pos_draw_date_lang', [], session('locale')) }}</p>
                                            </div>
                                            <div class="form-row">
                                                <p style="text-decoration: none;cursor: pointer;" class="text text-success gift">{{ trans('messages.pos_gift_lang', [], session('locale')) }}</p>
                                            </div>

                                            <!-- Other variable translations here -->
                                        </b>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <label for="validationCustom04">{{ trans('messages.panel_content_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control sms_area" id="sms" name="sms" placeholder="{{ trans('messages.sms_placeholder_lang', [], session('locale')) }}" rows="9" required=""></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <button class="btn btn-primary" type="submit">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                    <!-- /product list -->
                </div>
            </div>
            </div>
    <!-- Main Content -->
@include('layouts.footer')
@endsection
