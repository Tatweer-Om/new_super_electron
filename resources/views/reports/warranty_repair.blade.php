@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.warranty_repairing_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.warranty_repairing_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('warranty_repair') }}" method="POST">
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
                                    <th> {{ trans('messages.reference_no', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.warranty', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.recieve_delievr_date', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.repairing_status', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.services_products', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.expense_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php

                                $spare_part_amount= 0;
                                $total_services_cost= 0;
                                $total_expense= 0;

                                 @endphp

                                @foreach ($reports as $report)


                                @php

                                $spare_part_amount += (float)($report['product_prices'] ?? 0);
                                $total_services_cost += (float)($report['service_cost_total'] ?? 0);
                                $total_expense += (float)($report['expense'] ?? 0);

                            @endphp

                                <tr>
                                    <td>{{ trans('messages.ref_no', [], session('locale')) }}: {{ $report['ref_no'] }} <br>{{ trans('messages.order_no_lang', [], session('locale')) }}: {{ $report['invo_no'] }}</td>
                                    <td>
                                        {!! nl2br(e($report['product_name'])) !!}
                                    </td>

                                    <td>
                                        <span class="d-block">{{ $report['customer_name'] }}</span>
                                        <span class="d-block">{{ $report['customer_no'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.warrenty_type', [], session('locale')) }}: {{ $report['warranty_type'] }}</span>
                                        <span class="d-block">{{ trans('messages.warranty_days_lang', [], session('locale')) }}: {{ $report['warranty_days'] }}</span>
                                        <span class="d-block">{{ trans('messages.validity_lang', [], session('locale')) }}: {{ $report['validity'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.receive_date', [], session('locale')) }}: {{ $report['receive_date'] }}</span>
                                        <span class="d-block">{{ trans('messages.deliver_date', [], session('locale')) }}: {{ $report['deliver_date'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.repairing_type', [], session('locale')) }}: {{ $report['repairing'] }}</span>
                                        <span class="d-block">{{ trans('messages.status_lang', [], session('locale')) }}: {{ $report['status'] }}</span>
                                        <span class="d-block">{{ trans('messages.technician_lang', [], session('locale')) }}: {{ $report['technician'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.spare_parts_lang', [], session('locale')) }}: {{ $report['product_names'] }}</span>
                                        <span class="d-block">{{ trans('messages.services', [], session('locale')) }}: {{ $report['service_names'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.spare_part_cost', [], session('locale')) }}: {{ $report['product_prices'] }}</span>
                                        <span class="d-block">{{ trans('messages.services_cost', [], session('locale')) }}: {{ $report['service_cost_total'] }}</span>

                                        <span class="d-block">{{ trans('messages.expense_lang', [], session('locale')) }}: {{ $report['expense'] }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('maintenance_profile/'.$report['id']) }}">
                                            {{ trans('messages.view_detail', [], session('locale')) }}
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="border-top"><strong>{{ trans('messages.total_services_cost', [], session('locale')) }}:  {{ $total_services_cost}} </strong> <br>
                                        <strong>{{ trans('messages.spare_part_cost', [], session('locale')) }}:  {{ $spare_part_amount }} </strong> <br>
                                        <strong>{{ trans('messages.total_expense', [], session('locale')) }}:  {{ $total_expense }} </strong></td>
                                    <td></td>
                                    <td></td>
                                </tfoot>
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
