@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.sale_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.restore_sale_report', [], session('locale')) }}</h6>
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
                              {{ trans('messages.weekly_report', [], session('locale')) }}
                            </button>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-info" onclick="get_order_detail_report('2')">
                             {{ trans('messages.monthly_report', [], session('locale')) }}
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-warning" onclick="get_order_detail_report('3')">
                              {{ trans('messages.annual_report', [], session('locale')) }}
                            </button>
                        </div>
                      </div><br><br>

                    <form class="form_data" action="{{ route('restore_sales_report') }}" method="POST">
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
                                    <th> {{ trans('messages.order_date_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.order_no', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.payment_detail_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.payment_method_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.profit_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.tax_all_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.discount_pos_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.added_by_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_amount = 0;
                                $total_points_amount = 0;
                                $total_all_profit= 0;
                                $total_all_discount= 0;
                                $total_all_tax= 0;
                                $total_visa_exp= 0;
                            @endphp

                            @foreach ($orders as $order )
                                @php
                                    $total_amount += $order->total_amount;
                                    $total_all_discount += $order->total_discount ?? 0;
                                    $total_all_tax += $order->total_tax ?? 0;
                                    $total_all_profit += $order->total_profit ?? 0;
                                    $total_visa_exp += $order->paymentExpense->account_tax_fee ?? 0;
                                    $all_methods = DB::table('pos_payments')->where('order_no', $order->order_no)->get();
                                    $account_name = "";
                                    $points_amount = 0;

                                    foreach ($all_methods as $key => $met) {
                                        if($met->account_id == 0) {
                                            $points_amount = $met->paid_amount;
                                            $account_name .=  'Points ,';
                                        } else {
                                            $account = DB::table('accounts')->where('id', $met->account_id)->first();
                                            if ($account) {
                                                $account_name .= $account->account_name . ',';
                                            }
                                        }
                                    }

                                    $customer = DB::table('customers')->find($order->customer_id);
                                    $customer_name = $customer ? $customer->customer_name : '';
                                    $customer_no = $customer ? $customer->customer_number : '';

                                    $total_points_amount += $points_amount;

                                    $user_data = DB::table('users')->find($order->user_id);
                                    $username = $user_data ? $user_data->username : '';
                                @endphp
                                <tr>
                                    <td>

                                        {{ $order->created_at->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $order->order_no ?? '' }}

                                    </td>
                                    <td>
                                        {{ $customer_name ?? '' }} <br>
                                        {{ trans('messages.customer_id_lang', [], session('locale')) }}: {{ $customer_no ?? '' }}
                                    </td>
                                    <td>{{ trans('messages.total_amount_lang', [], session('locale')) }}: {{ $order->total_amount ?? '' }}  <br>
                                        {{ trans('messages.paid_amount_lang', [], session('locale')) }}: {{ $order->paid_amount ?? '' }}  <br>
                                        {{ trans('messages.cash_back_pos_lang', [], session('locale')) }} : {{ $order->cash_back ?? '' }}  </td>
                                    {{-- <td > {{ $points_amount  }} </td> --}}
                                    <td>

                                        {{ $account_name }}
                                    </td>

                                    <td> {{ $order->total_profit ?? 0 }} </td>
                                    <td> {{ $order->total_tax ?? 0 }} </td>
                                    <td>{{ $order->total_discount ?? 0 }} </td>
                                    {{-- <td>{{ $order->paymentExpense->account_tax_fee ?? 0}} </td> --}}
                                    <td>{{ $username ?? ''}}</td>

                                    <td>
                                        <a class="me-3 " href="{{ url('pos_bill').'/'.$order->order_no }}">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a class="me-3 " href="{{ url('a5_print').'/'.$order->order_no }}">
                                            <i class="fas fa-receipt"></i>
                                        </a>


                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>

                              <td style="border-top"><strong>  {{ trans('messages.total_sales', [], session('locale')) }}: {{ $total_amount }}  </strong></td>
                              {{-- <td style="border-top"> <strong> {{ trans('messages.total_points_payment', [], session('locale')) }}: {{ $total_points_amount }} </strong></td> --}}
                                <td></td>
                                <td style="border-top"> <strong> {{ trans('messages.total_profit', [], session('locale')) }}: {{ $total_all_profit }} </strong></td>
                                <td style="border-top"><strong>  {{ trans('messages.total_tax', [], session('locale')) }}: {{ $total_all_tax }} </strong></td>
                                <td style="border-top"><strong>{{ trans('messages.total_discount', [], session('locale')) }}:  {{ $total_all_discount }} </strong></td>

                                {{-- <td style="border-top"><strong>{{ trans('messages.total_visa_exp', [], session('locale')) }}:  {{ $total_visa_exp }} </strong></td> --}}
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
