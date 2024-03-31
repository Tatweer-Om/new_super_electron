@extends('layouts.header')

@section('main')
    @push('title')
        <title>{{ trans('messages.sms_panel_lang', [], session('locale')) }}</title>
    @endpush
            <div class="page-wrapper">
                <div class="content">
                    <div class="page-header">
                        <div class="page-title">
                            <h4> {{ trans('messages.Sms_panel_lang', [], session('locale')) }}</h4>
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
                                                <option value="2">{{ trans('messages.panel_header_lang', [], session('locale')) }}</option>
                                                <option value="3">{{ trans('messages.panel_footer_lang', [], session('locale')) }}</option>
                                                <option value="5">{{ trans('messages.panel_body_lang', [], session('locale')) }}</option>
                                                <option value="4">{{ trans('messages.panel_paylater_lang', [], session('locale')) }}</option>
                                                <option value="6">{{ trans('messages.panel_paylater_payment_lang', [], session('locale')) }}</option>
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
