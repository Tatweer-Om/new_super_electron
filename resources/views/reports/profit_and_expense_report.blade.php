@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.profit_expense_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.profit_expense_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('profit_expense') }}" method="POST">
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

                                    <th> {{ trans('messages.total_sales', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.pos_profit', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.services_profit', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.inspection_profit', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.spare_parts_profit', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.general_expense', [], session('locale')) }}</th>
                                    <th >{{ trans('messages.pos_payment_expense', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.maintenance_payment_expense', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.total_expense', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.total_profit', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $totalSales ?? '' }}</td>
                                    <td> {{ $orderProfit ?? 0 }} </td>
                                    <td> {{ $serviceCost ?? 0 }}   </td>
                                    <td>{{ $inspection_cost ?? 0}} </td>
                                    <td>{{ $repairCost ?? 0 }} </td>
                                    <td>{{ $generalExpense ?? 0}} </td>
                                    <td>{{ $posExpenseTotal ?? ''}}</td>
                                    <td>{{ $maintenanceExpenseTotal ?? 0 }} </td>
                                    <td>{{ $totalExpense ?? 0}} </td>
                                    <td>{{ $finalProfit ?? ''}}</td>
                                </tr>
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
