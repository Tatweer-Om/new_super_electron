@extends('layouts.header')
@section('main')
    @push('title')
        <title>{{ trans('messages.customers_lang', [], session('locale')) }}</title>
    @endpush


    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Profile</h4>
                    <h6>Customer'sProfile</h6>
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
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>{{ $customer->customer_name }}</h2>
                                            @if (!empty($customer->customer_email))
                                                <h4>Email: {{ $customer->customer_email }}</h4>
                                            @endif
                                            @if (!empty($customer->customer_phone))
                                                <h4>Phone: {{ $customer->customer_phone }}</h4>
                                            @endif
                                            @if (!empty($customer->national_id))
                                                <h4>National ID: {{ $customer->national_id }} ({{ $country_name }})</h4>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>Customer Detail</h2>
                                            @if (!empty($customer->customer_number))
                                                <h4>Customer No: {{ $customer->customer_number }}</h4>
                                            @endif
                                            @switch($customer->customer_type)
                                                @case(1)
                                                    <h4>Customer Type: Student</h4>
                                                    @if (!empty($customer->student_id))
                                                        <h4>Student ID: {{ $customer->student_id }}</h4>
                                                    @endif
                                                @break

                                                @case(2)
                                                    <h4>Customer Type: Teacher</h4>
                                                    @if (!empty($customer->employee_id))
                                                        <h4>Employee ID: {{ $customer->employee_id }}</h4>
                                                    @endif
                                                @break

                                                @case(3)
                                                    <h4>Customer Type: Employee</h4>
                                                    @if (!empty($customer->employee_id))
                                                        <h4>Employee ID: {{ $customer->employee_id }}</h4>
                                                    @endif
                                                @break

                                                @case(4)
                                                    <h4>Customer Type: General</h4>
                                                @break
                                            @endswitch

                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2> Customer Details</h2>
                                            @if ($customer->customer_type == 1)
                                                <h4>Student University: {{ $university_name }}</h4>
                                                <h4>Student ID: {{ $customer->student_id }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 3)
                                                <h4>Customer Workplace: {{ $customer->employee_workplace }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 2)
                                                <h4>University: {{ universiti_teacher }}</h4>
                                            @endif
                                            @if ($customer->customer_type == 3)
                                                <h4>Ministry: {{ $ministry_name }}</h4>
                                            @endif


                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="profile-contentname">
                                            <h2>Personal Detail</h2>
                                            @if (!empty($customer->dob))
                                                <h4>Date of Birth: {{ $customer->dob }}</h4>
                                            @endif
                                            @if (!empty($address_name))
                                                <h4>Customer's Area: {{ $address_name }}</h4>
                                            @endif
                                            @if ($customer->gender == 1)
                                                <h4>Gender: Male</h4>
                                            @elseif ($customer->gender == 2)
                                                <h4>Gender: Female</h4>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class= "col-lg-12">

                                    <button class="btn btn-success" type="button"  data-bs-toggle="modal" data-bs-target="#create"> Qoutations</button>
                                    <button class="btn btn-danger"> Edit Customer</button>

                                </div>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="William">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="Castilo">
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">User Name</label>
                                    <input type="text" class="form-control" value="William Castilo">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">User Name</label>
                                    <input type="text" class="form-control" value="William Castilo">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="input-blocks">
                                    <label class="form-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" class="pass-input form-control">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div><br>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Orders Detail</h3>
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
                                    <h3>Warranty Proucts</h3>
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
                                                                            Item)</small><br>
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
                                                                        Validity:
                                                                        {{ $order->created_at->addDays($data['warranty']->warranty_days)->format('Y-m-d') }}
                                                                        <br>
                                                                        @php
                                                                            // Calculate the difference between the start and end date using DateInterval
                                                                            $start_date = $order->created_at;
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
                                                                        ({{ $months }} months and
                                                                        {{ $days }} days)
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    Order No. {{ $data['warranty']->order_no }} <br>
                                                                    Order Date: <span>
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
                                <a href="javascript:void(0);" class="btn btn-submit ">Submit</a>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
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
                    <h5 class="modal-title">Create</h5>
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
    @include('layouts.footer')
@endsection
