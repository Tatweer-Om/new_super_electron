@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.customer_purchase', [], session('locale')) }}</title>
    @endpush

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
                            <div class="col-lg-2 mt-1">
                                <label for="date-field">{{ trans('messages.date_from_lang', [], session('locale')) }}</label>
                                <input  class="datetimepicker form-control bg-light border-0 " value="{{ $sdata }}" id="date_from" data-time="true" name="date_from">
                                @error('date_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-2 mt-1">
                                <label for="date-field">{{ trans('messages.to_date_lang', [], session('locale')) }}</label>
                                <input  class="datetimepicker form-control bg-light border-0 " value="{{ $edata }}" id="to_date" data-time="true" name="to_date">
                                @error('to_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-2 mt-1">
                                <label>{{ trans('messages.choose_customer_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_id" name="customer_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}
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
                            <div class="col-lg-2 mt-1">
                                <label>{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 university_id" name="university_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($university as $uni)
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
                            <div class="col-lg-2 mt-1">
                                <label>{{ trans('messages.choose_workplace_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 workplace_id" name="workplace_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($workplaces as $workplace)
                                        @php
                                            $selected = '';
                                            if ($workplace_id == $workplace->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $workplace->id }}">
                                            {{ $workplace->workplace_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <button type="submit" class="form btn btn-info mt-4" id="date_data">
                                    <i class="ri-printer-line align-bottom me-1"></i> Submit
                                </button>
                            </div>

                        </div>
                    </form><br><br>
                    <div class=" table-responsive">
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.customer_name_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_number_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_orders', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_purchases', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($all_orders as $ord)

                                        <tr>
                                            <td>{{ $ord['customer_name'] }}</td>
                                            <td>{{ $ord['customer_number'] }}</td>
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
