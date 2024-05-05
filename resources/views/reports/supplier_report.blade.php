@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.sales_report_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.sales_report_lang', [], session('locale')) }}</h6>
                    </div>
                </div>




                <ul class="table-top-head">


                    <li>
                        <a data-bs-toggle="tooltip" id="csvButton" data-bs-placement="top" title="Excel"><img
                                src="{{ asset('img/icons/excel.svg') }}" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" id="printButton" data-bs-placement="top" title="Print"><i data-feather="printer"
                                class="feather-rotate-ccw"></i></a>
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

                    <div class="row">
                        <div class="col-md-1">
                            <button class="btn btn-success" onclick="get_order_detail_report('0')">
                              weekly report
                            </button>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-info" onclick="get_order_detail_report('2')">
                              monthly report
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-warning" onclick="get_order_detail_report('3')">
                             Annual report
                            </button>
                        </div>
                      </div><br><br>

                    <form class="form_data" action="{{ route('sales_report') }}" method="POST">
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
                            <label>{{ trans('messages.choose_sales_category_lang', [], session('locale')) }}</label>
                            <select class="searchable_select form-control select2 payment_method" name="payment_method">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                @foreach ($accounts as $account)
                                <option value="all"> all</option>
                                    <option  value="{{ $account->id }}" > {{ $account->account_name }}</option>
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
                        <table  id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>

                                    <th>Order Detail</th>
                                    <th>Customer Detail</th>
                                    <th>Payment Detail</th>
                                    <th>Payment Method</th>
                                    <th>Total Profit</th>
                                    <th>Total Tax</th>
                                    <th>Total Discount</th>
                                    <th>Order Expense</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amount= 0;
                                @endphp
                                @foreach ($orders as $order )
                                @php
                                    $total_amount+= $order->paid_amount;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);">{{ $order->order_no ?? '' }}</a> <br>
                                       Order Date: {{ $order->created_at->format('d-m-Y') }}
                                    </td>
                                    <td> {{ $order->customer->customer_name ?? '' }} <br>
                                      Customer ID:  {{ $order->customer->customer_number ?? '' }} </td>
                                    <td>Total Amount: {{ $order->total_amount ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }} <br>
                                    Paid Amount: {{ $order->paid_amount ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }} <br>
                                    Cash Back: {{ $order->cash_back ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }} </td>
                                    @php
                                    $account_name= DB::table('accounts')->where('id', $order->paymentExpense->account_id ?? '')->value('account_name');
                                    @endphp
                                    <td>{{ $account_name ?? ''}}</td>
                                    <td> {{ $order->total_profit ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                    <td> {{ $order->total_tax ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                    <td>{{ $order->total_discount + isset($order->offer_discount) ? $order->offer_discount : 0 }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                    <td>{{ $order->paymentExpense->account_tax_fee ?? 0}} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                    <td>{{ $order->added_by ?? ''}}</td>

                                    <td>
                                        <a class="me-3 " href="{{ url('pos_bill').'/'.$order->order_no }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a class="me-3 " href="{{ url('a5_print').'/'.$order->order_no }}">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                        <a class="me-3 confirm-text delete" href="{{ url('delete_order').'/'.$order->order_no }}">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>

                              <td style="border-top">  {{ trans('messages.total_sales', [], session('locale')) }} :{{ $total_amount }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
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

