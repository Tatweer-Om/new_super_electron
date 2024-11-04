@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.income_report_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.income_report_lang', [], session('locale')) }}</h6>
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


                    <form class="form_data" action="{{ route('income_report') }}" method="POST">
                        <div class="row">

                            @csrf
                            <div class="col-lg-3 mt-1">
                                <label
                                    for="date-field">{{ trans('messages.date_from_lang', [], session('locale')) }}</label>
                                <input class="datetimepicker form-control bg-light border-0 " value="{{ $sdata }}"
                                    id="date_from" data-time="true" name="date_from">
                                @error('date_from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3 mt-1">
                                <label for="date-field">{{ trans('messages.to_date_lang', [], session('locale')) }}</label>
                                <input class="datetimepicker form-control bg-light border-0 " value="{{ $edata }}"
                                    id="to_date" data-time="true" name="to_date">
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

                    <div class="row">
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success">{{ trans('messages.total_income', [], session('locale')) }}: {{ $total_income }} </a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success">{{ trans('messages.total_discount', [], session('locale')) }}: {{ $overall_discount }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-success"> {{ trans('messages.total_visa', [], session('locale')) }}: {{ $total_visa }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-warning"> {{ trans('messages.total_bank', [], session('locale')) }}: {{ $total_bank }}</a>

                        </div>
                        <div class="col-lg-2">

                            <a href="" class="btn btn-warning"> {{ trans('messages.total_cash', [], session('locale')) }}: {{ $total_cash }}</a>

                        </div>

                    </div><br><br>
                    <div class=" table-responsive">
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>

                                    <th> {{ trans('messages.total_sales', [], session('locale')) }}</th>

                                    <th>{{ trans('messages.payment_detail_lang', [], session('locale')) }}</th>
                                    {{-- <th>{{ trans('messages.pos_profit', [], session('locale')) }}</th> --}}
                                    <th> {{ trans('messages.orders_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.maint_detail_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.maintenance_payment_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.view_detail_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ trans('messages.total_sales', [], session('locale')) }}:
                                        {{ $totalSales ?? '' }} <br>
                                        {{ trans('messages.total_discount_lang', [], session('locale')) }}:
                                        {{ $orderdiscount }}</td>




                                    <td>
                                        {{ trans('messages.visa_payment_lang', [], session('locale')) }}:
                                        {{ $visa }} <br>
                                        {{ trans('messages.bank_payment_lang', [], session('locale')) }}:
                                        {{ $bank }} <br>
                                        {{ trans('messages.cash_payment_lang', [], session('locale')) }}:
                                        {{ $cash }} <br>
                                        {{-- {{ trans('messages.points_lang', [], session('locale')) }}: {{ $total_points }} --}}
                                        {{ trans('messages.point_payment_lang', [], session('locale')) }}:
                                        {{ $points }}

                                    </td>

                                    {{-- <td> {{ $orderProfit ?? 0 }} </td> --}}

                                    <td>
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                            data-bs-target="#order">
                                            {{ trans('messages.orders_history_lang', [], session('locale')) }}</button>
                                    </td>



                                    <td>{{ trans('messages.maintenenace_payment_lang', [], session('locale')) }}:
                                        {{ $grand_total ?? 0 }} <br>

                                        {{ trans('messages.maintenenace_discount_lang', [], session('locale')) }}:
                                        {{ $total_discount ?? 0 }} </td>

                                    <td>
                                        {{ trans('messages.visa_payment_lang', [], session('locale')) }}:
                                        {{ $maint_visa }} <br>
                                        {{ trans('messages.bank_payment_lang', [], session('locale')) }}:
                                        {{ $maint_bank }} <br>
                                        {{ trans('messages.cash_payment_lang', [], session('locale')) }}:
                                        {{ $maint_cash }} <br>
                                        {{-- {{ trans('messages.points_lang', [], session('locale')) }}: {{ $total_points }} --}}
                                        {{ trans('messages.point_payment_lang', [], session('locale')) }}:
                                        {{ $maint_points }}

                                    </td>

                                    <td>

                                        <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                            data-bs-target="#maint">
                                            {{ trans('messages.maint_detail_lang', [], session('locale')) }}</button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="order" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('messages.order_history_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table" id="warranty_detail">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.order_no_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.discount_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.total_amount_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.points_payment_status', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posorder as $order)
                                <tr>
                                    <td>
                                        {{ $order->order_no ?? '' }} <br>
                                        {{ $order->created_at->format('Y-m-d h:i A') }}

                                    </td>
                                    <td> {{ $order->total_discount ?? '' }}</td>
                                    <td>{{ trans('messages.total_amount_lang', [], session('locale')) }}:
                                        {{ $order->total_amount }} <br>
                                        {{ trans('messages.profit_lang', [], session('locale')) }}:
                                        {{ $order->total_profit }} <br>

                                        @php
                                            $paymentMethods = [
                                                0 => trans('messages.points_lang', [], session('locale')),
                                                1 => trans('messages.visa_lang', [], session('locale')),
                                                2 => trans('messages.bank_lang', [], session('locale')),
                                                3 => trans('messages.cash_lang', [], session('locale')),
                                            ];

                                            $accountIds = explode(',', $order->account_id);
                                            $accountNames = array_map(function($id) use ($paymentMethods) {
                                                return $paymentMethods[$id] ?? $id;
                                            }, $accountIds);

                                            $accountNamesString = implode(', ', $accountNames);
                                        @endphp
                                        {{ trans('messages.payment_method_lang', [], session('locale')) }}: {{ $accountNamesString }}


                                        </td>





                                    @php
                                        // Fetch point history for the current order
                                        $point = DB::table('point_histories')
                                            ->where('order_id', $order->order_id)
                                            ->first();
                                        if ($point) {
                                            $points = $point->points;
                                            $amount = $point->amount;
                                            $type = $point->type == 1 ? 'Points Used' : 'Points Gained';
                                        } else {
                                            $points = '';
                                            $amount = '';
                                            $type = '';
                                        }
                                    @endphp

                                    <td>
                                        {{ trans('messages.points_lang', [], session('locale')) }}: {{ $points }}
                                        <br>
                                        {{ trans('messages.points_amount_lang', [], session('locale')) }}:
                                        {{ $amount }} <br>
                                        {{ trans('messages.points__type_lang', [], session('locale')) }}:
                                        {{ $type }}
                                    </td>

                                    <td>
                                        <a class="me-3" href="{{ url('pos_bill/' . $order->order_no) }}">
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

    <div class="modal fade" id="maint" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('messages.order_history_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table" id="warranty_detail">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.general_details_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.product_detail_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.maint_detail_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.payment_detail_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.payment_date_lang', [], session('locale')) }}
                                </th>

                                <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $rep)
                                <tr>
                                    <td>
                                        {{ trans('messages.reference_no', [], session('locale')) }}: {{ $rep->reference_no ?? '' }} <br>
                                        {{ trans('messages.recieve_date_lang', [], session('locale')) }}: {{ $rep->receive_date  }}<br>
                                        {{ trans('messages.deliver_date_lang', [], session('locale')) }}: {{ $rep->deliver_date  ?? '' }}<br>


                                    </td>

                                    <td>
                                        {{ trans('messages.product_lang', [], session('locale')) }}: {{ $rep->product_name  ?? '' }}<br>
                                        {{ trans('messages.product_model_lang', [], session('locale')) }}: {{ $rep->product_model  ?? '' }}<br>
                                        {{ trans('messages.added_by_lang', [], session('locale')) }}: {{ $rep->added_by  ?? '' }}<br>
                                        {{ $rep->created_at ? $rep->created_at->format('d-m-Y h:i a') : '' }}


                                    </td>
                                    <td>

                                        @php
                                        $technicianIds = explode(',', $rep->technician_id);

                                      // Fetch the technician names
                                      $technicians = DB::table('technicians')
                                          ->whereIn('id', $technicianIds)
                                          ->pluck('technician_name')
                                          ->toArray();

                                            if($rep->status==1){
                                            $status= 'Recieved';
                                            }
                                            elseif ($rep->status==4) {
                                                $status= 'Ready'; }
                                                else{
                                                    $status= 'Delievered';
                                                }

                                             if($rep->repairing_type==1){

                                                $repairing_type = 'Repair';


                                             }
                                             else{
                                                $repairing_type = 'Inspection';
                                             }


                                  @endphp
                                        {{ trans('messages.repairing_type_lang', [], session('locale')) }}: {{ $repairing_type   }}<br>


                                        {{ trans('messages.repairing_status_lang', [], session('locale')) }}: {{ $status   }}<br>


                                       {{ trans('messages.technicians_lang', [], session('locale')) }}: {{ implode(', ', $technicians) }}<br>
                                    </td>

                                    <td>
                                        {{ trans('messages.total_amount_lang', [], session('locale')) }}: {{ $rep->grand_total  + $rep->total_discount   }}<br>

                                            {{ trans('messages.discount_lang', [], session('locale')) }}: {{ $rep->total_discount }}<br>

                                        {{ trans('messages.paid_amount_lang', [], session('locale')) }}: {{ $rep->grand_total - ($rep->total_discount ?? 0) }} <br>
                                        @php
                                            if($rep->account_id ==1 ) {

                                                $account= 'visa';
                                            }
                                            elseif($rep->account_id ==2 ){
                                                $account= 'Bank';
                                            }
                                            elseif($rep->account_id ==3 ){
                                                $account= 'Cash';
                                            }
                                            else{
                                                $account= 'Points';
                                            }
                                        @endphp
                                        {{ trans('messages.payment_method_lang', [], session('locale')) }}: {{ $account }}



                                    </td>
                                   <td>{{ $rep->created_at->format('Y-m-d h:i A') }}</td>



                                    <td>
                                        <a class="me-3" href="{{ url('maint_bill/' . $rep->reference_no) }}">
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





    @include('layouts.report_footer')
@endsection
