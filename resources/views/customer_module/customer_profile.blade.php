@extends('layouts.header')
@section('main')
    @push('title')
        <title>{{ trans('messages.customers_lang', [], session('locale')) }}</title>
    @endpush


    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ trans('messages.profile', [], session('locale')) }}</h4>
                    <h6>{{ trans('messages.customer_profile', [], session('locale')) }}</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div>
                        </div>
                        <div class="profile-top">
                            <div>
                                @if ($customer->customer_image)
                                    <div class="profile-contentimg">
                                        <img src="{{ asset('images/customer_images/' . $customer->customer_image) }}"
                                            alt="img" id="blah">
                                    </div>
                                @else
                                    <div class="profile-contentimg">
                                        <img src="{{ asset('images/dummy_image/no_image.png') }}" alt="img"
                                            id="blah">
                                    </div><br>
                                @endif

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>{{ $customer->customer_name }}</h2>
                                            @if (!empty($customer->customer_email))
                                                <h4>{{ trans('messages.email_lang', [], session('locale')) }}: {{ $customer->customer_email }}</h4>
                                            @endif
                                            @if (!empty($customer->customer_phone))
                                                <h4>{{ trans('messages.phone_lang', [], session('locale')) }}: {{ $customer->customer_phone }}</h4>
                                            @endif
                                            @if (!empty($customer->national_id))
                                                <h4>{{ trans('messages.national_id_lang', [], session('locale')) }}: {{ $customer->national_id }} ({{ $country_name }})</h4>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</h2>
                                            @if (!empty($customer->customer_number))
                                                <h4>Customer No: {{ $customer->customer_number }}</h4>
                                            @endif
                                            @switch($customer->customer_type)
                                                @case(1)
                                                    <h4>{{ trans('messages.customer_type_lang', [], session('locale')) }}: {{ trans('messages.student_lang', [], session('locale')) }}</h4>
                                                    @if (!empty($customer->student_id))
                                                        <h4>{{ trans('messages.student_id_lang', [], session('locale')) }}: {{ $customer->student_id }}</h4>
                                                    @endif
                                                @break

                                                @case(2)
                                                    <h4>{{ trans('messages.customer_type_lang', [], session('locale')) }}: {{ trans('messages.teacher_lang', [], session('locale')) }}</h4>
                                                    @if (!empty($customer->employee_id))
                                                        <h4>{{ trans('messages.employee_id_lang', [], session('locale')) }}: {{ $customer->employee_id }}</h4>
                                                    @endif
                                                @break

                                                @case(3)
                                                    <h4>{{ trans('messages.customer_type_lang', [], session('locale')) }}: {{ trans('messages.employee_lang', [], session('locale')) }}</h4>
                                                    @if (!empty($customer->employee_id))
                                                        <h4>Employee ID: {{ $customer->employee_id }}</h4>
                                                    @endif
                                                @break

                                                @case(4)
                                                    <h4>{{ trans('messages.customer_type_lang', [], session('locale')) }}: {{ trans('messages.general_lang', [], session('locale')) }}</h4>
                                                @break
                                            @endswitch

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2> {{ trans('messages.customer_detail_lang', [], session('locale')) }}</h2>
                                            @if ($customer->customer_type == 1)
                                                <h4>{{ trans('messages.student_university_lang', [], session('locale')) }}: {{ $university_name }}</h4>
                                                <h4>{{ trans('messages.student_id_lang', [], session('locale')) }}: {{ $customer->student_id }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 3)
                                                <h4>{{ trans('messages.customer_workpllace_lang', [], session('locale')) }}: {{ $customer->employee_workplace }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 2)
                                                <h4>{{ trans('messages.university_lang', [], session('locale')) }}: {{ universiti_teacher }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 3)
                                                <h4>{{ trans('messages.ministry_lang', [], session('locale')) }}: {{ $ministry_name }}</h4>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>{{ trans('messages.personal_detail_lang', [], session('locale')) }}</h2>
                                            @if (!empty($customer->dob))
                                                <h4>{{ trans('messages.dob_lang', [], session('locale')) }}: {{ $customer->dob }}</h4>
                                            @endif
                                            @if (!empty($address_name))
                                                <h4>{{ trans('messages.customer_area_lang', [], session('locale')) }}: {{ $address_name }}</h4>
                                            @endif
                                            @if ($customer->gender == 1)
                                                <h4>{{ trans('messages.gender_lang', [], session('locale')) }}: {{ trans('messages.male_lang', [], session('locale')) }}</h4>
                                            @elseif ($customer->gender == 2)
                                                <h4>{{ trans('messages.gender_lang', [], session('locale')) }}: {{ trans('messages.female_lang', [], session('locale')) }}</h4>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class= "col-lg-12">

                                    <button class="btn btn-success" type="button"  data-bs-toggle="modal" data-bs-target="#create"> {{ trans('messages.customer_quotations_lang', [], session('locale')) }}</button>


                                </div>
                            </div>
                        </div><br><br>
                        <div class="row">

                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>{{ trans('messages.order_detail_lang', [], session('locale')) }}</h3>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table" id="order_detail">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('messages.order_detail_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.amount_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.date_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.paylater_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                <td>{{ $order->order_no }}</td>
                                                                <td>{{ $order->total_amount }} omr</td>
                                                                <td>{{ $order->created_at->format('j-n-Y h:ia') }}</td>
                                                                <td>order->status </td>
                                                                <td>

                                                                    <a class="me-3"
                                                                        href="{{ url('pos_bill/' . $order->order_no) }}">
                                                                        <i class="fas fa-eye"></i>
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
                                <div class="col-lg-6">
                                    <h3>{{ trans('messages.warranty_products_lang', [], session('locale')) }}</h3>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table" id="warranty_detail">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('messages.product_detail_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.price_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.warranty_detail_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.order_detail_lang', [], session('locale')) }}
                                                            </th>
                                                            <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($warrantyDetails as $data)
                                                            <tr>
                                                                <td
                                                                    style="padding-bottom: 0px!important; text-align: center;">
                                                                    <span>
                                                                        {{ $data['product_name'] ?? 'N/A' }}<br>
                                                                        <small>({{ $data['warranty']->quantity ?? 'N/A' }}
                                                                            {{ trans('messages.item_lang', [], session('locale')) }})</small><br>
                                                                        <span>
                                                                            {{ $data['warranty']->item_imei ? $data['warranty']->item_imei : $data['warranty']->item_barcode ?? 'N/A' }}
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    style="padding-bottom: 0px!important; text-align: center;">
                                                                    <span>{{ $data['warranty']->total_price ?? 'N/A' }}</span>
                                                                </td>

                                                                <td
                                                                    style="padding-bottom: 0px!important; text-align: center;">
                                                                    <span>
                                                                        {{ $data['warranty']->warranty_type == 1 ? 'shop' : 'agent' }}:
                                                                        {{ $data['warranty']->warranty_days ?? 'N/A' }}days

                                                                    </span><br>

                                                                    <span>
                                                                        {{ trans('messages.validity_lang', [], session('locale')) }}:
                                                                        {{ $created_at->addDays($data['warranty']->warranty_days)->format('Y-m-d') }}
                                                                        <br>
                                                                        @php
                                                                            // Calculate the difference between the start and end date using DateInterval
                                                                            $start_date = $created_at;
                                                                            $end_date = clone $start_date;
                                                                            $end_date->addDays(
                                                                                $data['warranty']->warranty_days,
                                                                            );

                                                                            // Calculate the interval (difference) between the start and end date
                                                                            $interval = $start_date->diff($end_date);

                                                                            // Extract months and days from the interval
                                                                            $months = $interval->m + $interval->y * 12;
                                                                            $days = $interval->d;
                                                                        @endphp
                                                                        ({{ $months }}{{ trans('messages.month_and_lang', [], session('locale')) }}
                                                                        {{ $days }} {{ trans('messages.days_lang', [], session('locale')) }})
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    {{ trans('messages.oder_no_lang', [], session('locale')) }}. {{ $data['warranty']->order_no }} <br>
                                                                    {{ trans('messages.order_date_lang', [], session('locale')) }}: <span>
                                                                        {{ $data['created_at']->format('Y-m-d') ?? 'N/A' }}</span>

                                                                </td>
                                                                <td></td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="javascript:void(0);" class="btn btn-submit ">{{ trans('messages.submit_lang', [], session('locale')) }}</a>
                                <a href="javascript:void(0);" class="btn btn-cancel">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('messages.customer_quotations_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table" id="warranty_detail">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.Quotation', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.Total_amount', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.Paid_amount', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.Remaining_amount', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.action', [], session('locale')) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $qouts as $qout)
                                    <tr>
                                        <td>
                                        ID: {{$qout->id  }}
                                        Date: {{ $qout->created_at->format('Y-m-d')}}
                                        </td>
                                        <td> Total Amount : {{ $qout->total_amount }}</td>
                                        <td> Paid Amount : {{ $qout->paid_amount }}</td>
                                        <td> Remaining Amount : {{ $qout->remaining_amount }}</td>
                                        <td>  <a class="me-3"
                                            href="">
                                            <i class="fas fa-eye"></i>
                                        </a></td>

                                    </tr>
                                    @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


{{-- model  --}}

    @include('layouts.footer')
@endsection
