@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.customer_purchase', [], session('locale')) }}</title>
    @endpush
    <style>
        .ui-datepicker {
    z-index: 9999; /* Adjust the value as needed */
}
    </style>
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.customer_purchase', [], session('locale')) }}</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" id="csvButton" data-bs-placement="top" title="Excel"><img
                                src="{{ asset('img/icons/excel.svg') }}" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" id="printButton" data-bs-placement="top" title="Print"><i
                                data-feather="printer" class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
            </div>

            <div class="card">

                <div class="card-body">



                    <form class="form_data" action="{{ route('customer_purchase') }}" method="POST">

                        <div class="row">

                            @csrf


                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_customer_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_id" name="customer_id">
                                    <option selected value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($customers as $customer)
                                        @php
                                            $selected = '';
                                            if ($customer_id == $customer->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $customer->id }}">
                                            {{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 university_id" name="university_id">
                                    <option selected value="" >{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($universities as $uni)
                                        @php
                                            $selected = '';
                                            if ($university_id == $uni->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $uni->id }}">
                                            {{ $uni->university_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_nationality_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 nationality_id" name="nationality_id">
                                    <option selected value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($nationalities as $nationality)
                                        @php
                                            $selected = '';
                                            if ($nationality_id == $nationality->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $nationality->id }}">
                                            {{ $nationality->nationality_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_ministry_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 ministry_id" name="ministry_id">
                                    <option selected value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($ministries as $ministry)
                                        @php
                                            $selected = '';
                                            if ($ministry_id == $ministry->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $ministry->id }}">
                                            {{ $ministry->ministry_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label for="date-field">{{ trans('messages.date_from_lang', [], session('locale')) }}</label>
                                <input  class="datetimepicker form-control bg-light border-0 " value="{{ $sdata }}" id="date_from" data-time="true" name="date_from">
                                @error('date_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label for="date-field">{{ trans('messages.to_date_lang', [], session('locale')) }}</label>
                                <input  class="datetimepicker form-control bg-light border-0 " value="{{ $edata }}" id="to_date" data-time="true" name="to_date">
                                @error('to_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-lg-2">
                                <button type="submit" class="form btn btn-info mt-4" id="date_data">
                                    <i class="ri-printer-line align-bottom me-1"></i> Submit
                                </button>
                            </div>

                        </div>


                    </form><br><br>

                        <div class="col-lg-2 ">
                            <button class="form btn btn-success" id="date_data">
                                <p>{{ trans('messages.customers_count_lang', [], session('locale')) }}: {{ $filtered_customers_count }} <br>
                                    {{ trans('messages.customer_percentage_lang', [], session('locale')) }}: {{ $percent }} %</p>

                            </button>
                        </div>
                        <div class="col-lg-2">
                            <button class="form btn btn-primary mt-4" id="date_data">

                               <p>{{ trans('messages.purchase_percentage_lang', [], session('locale')) }}: {{ $total_purch }} {{ trans('messages.OMR_lang', [], session('locale')) }} <br>{{ trans('messages.purchase_percentage_lang', [], session('locale')) }}: {{ $percentage }} %</p>
                            </button>
                        </div><br><br>

                    <div class=" table-responsive">
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_orders', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_purchases', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $total_purchase= 0;

                                @endphp

                                    @foreach ($all_orders as $ord)

                                    @php
                                       $total_purchase +=  $ord['total_purchases'];

                                    @endphp

                                        <tr>
                                            <td>
                                                {{ trans('messages.customer_name_lang', [], session('locale')) }}: {{ $ord['customer_name'] ?? 'No Customer' }} <br>
                                                {{ trans('messages.nationality_lang', [], session('locale')) }}: {{ $ord['nationality_name'] ?? 'Null' }} <br>
                                                {{ trans('messages.customer_phone_lang', [], session('locale')) }}: {{ $ord['phone'] ?? '' }} <br>
                                                {{ trans('messages.customer_type_lang', [], session('locale')) }}: {{ $ord['type'] ?? '' }}
                                            </td>

                                            <td>{{ trans('messages.customer_number_lang', [], session('locale')) }}: {{ $ord['customer_number'] }}
                                            <br> {{ trans('messages.university_or_workplace_lang', [], session('locale')) }}: {{ $ord['university_name'] ?? '' }}
                                            {{ $ord['ministry_name'] ?? '' }} <br>{{ trans('messages.address_lang', [], session('locale')) }}: {{ $ord['address'] ?? '' }}</td>

                                            <td>{{ $ord['total_orders'] }}</td>
                                            <td>{{ $ord['total_purchases'] }}</td>


                                            <td>
                                                <a class="btn btn-success" href="{{ url('customer_profile/' . $ord['customer_id']) }}" type="button" >
                                                    {{ trans('messages.customer_profile_lang', [], session('locale')) }}
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach

                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ trans('messages.total_purchase_lang', [], session('locale')) }}: {{ $total_purchase }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                <td></td>
                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>



    @include('layouts.report_footer')
@endsection
