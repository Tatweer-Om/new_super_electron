@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.customer_type', [], session('locale')) }}</title>
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
                        <h6>{{ trans('messages.customer_type', [], session('locale')) }}</h6>
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



                    <form class="form_data" action="#" method="POST">

                        <div class="row">

                            @csrf


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


                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_customer_type_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_type" name="customer_type">
                                    <option selected value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_type == 'General Customer'){ echo 'selected';} @endphp  value="4">{{ trans('messages.general_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_type == 'Student'){ echo 'selected';} @endphp  value="1">{{ trans('messages.student_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_type == 'Employee'){ echo 'selected';} @endphp  value="3">{{ trans('messages.employee_lang', [], session('locale')) }}
                                    </option>

                                </select>
                            </div>

                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_gender_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_gender" name="customer_gender">
                                    <option  value="" >{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    <option  @php if($customer_gender == 'Male'){ echo 'selected';} @endphp  value="1" >{{ trans('messages.male_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_gender == 'Female'){ echo 'selected';} @endphp  value="2" >{{ trans('messages.female_lang', [], session('locale')) }}
                                    </option>

                                </select>
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_age_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_age" name="customer_age">
                                    <option selected value="" >{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 1){ echo 'selected';} @endphp  value="1" >{{ trans('messages.less_than_19_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 2){ echo 'selected';} @endphp  value="2" >{{ trans('messages.between_20_29_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 3){ echo 'selected';} @endphp value="3" >{{ trans('messages.between_30_39_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 4){ echo 'selected';} @endphp  value="4" >{{ trans('messages.between_40_49_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 5){ echo 'selected';} @endphp  value="5" >{{ trans('messages.between_50_59_lang', [], session('locale')) }}
                                    </option>
                                    <option @php if($customer_age == 6){ echo 'selected';} @endphp value="6" >{{ trans('messages.60_and_more_lang', [], session('locale')) }}
                                    </option>
                                </select>
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
                                <p>{{ trans('messages.customers_count_lang', [], session('locale')) }}: {{ $total_customers }} <br>
                                    {{ trans('messages.customer_percentage_lang', [], session('locale')) }}: {{ $percentage_of_customers }} %</p>

                            </button>
                        </div>
                         {{-- <div class="col-lg-2">
                            <button class="form btn btn-primary mt-4" id="date_data">

                               <p>{{ trans('messages.type_percentage_lang', [], session('locale')) }}: {{ $percentage_of_sales }} %</p>
                            </button>
                        </div><br><br> --}}
                    <div class=" table-responsive">
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.dob_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_orders', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_total_purchase', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_purch= 0;

                                @endphp
                                <!-- Iterate over the data returned from the customer_type function -->
                                @foreach ($data as $customer)

                                @php
                                $total_purch +=  $customer['total_purchases'];



                             @endphp
                                    <tr>
                                        <td>

                                              {{ $customer['customer_name'] ?? 'No Name' }} <br>

                                              {{ trans('messages.phone_lang', [], session('locale')) }}:{{ $customer['phone'] ?? '' }} <br>{{ trans('messages.customer_id_lang', [], session('locale')) }}: {{ $customer['customer_number'] }}

                                        </td>
                                        <td>{{ $customer['customer_type'] ?? '' }} <br> {{ $customer['customer_gender'] ?? '' }}</td>
                                        <td>{{ $customer['dob'] ?? ''}} <br> {{ $customer['age'] ?? ''}} {{ trans('messages.years_lang', [], session('locale')) }}</td>

                                        <td>{{ $customer['total_orders'] }}</td>
                                        <td>{{ $customer['total_purchases'] }}</td>
                                        <td>
                                            <!-- Action button, for example, linking to customer profile -->
                                            <a class="btn btn-success" href="{{ url('customer_profile/' . $customer['customer_id']) }}" type="button" >
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
                                <td></td>
                                <td>
                                    {{ trans('messages.total_purchase_lang', [], session('locale')) }}: {{ $total_purch }} {{ trans('messages.OMR_lang', [], session('locale')) }}
                                    <br>

                                    @if ($total_sales > 0)
                                      {{ trans('messages.purchase_percentage_lang', [], session('locale')) }}:   {{ number_format(($total_purch / $total_sales) * 100, 3) }}%
                                    @else
                                        0%
                                    @endif
                                </td>

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
