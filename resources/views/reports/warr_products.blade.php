@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.warranty_prducts_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.warranty_prducts_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('warranty_products') }}" method="POST">
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

                                    <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.warranty', [], session('locale')) }}</th>

                                    <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($reports as $report)
                                <tr>

                                    <td>
                                        {!! nl2br(e($report['product_name'])) !!}<br> {{ trans('messages.barcode_lang', [], session('locale')) }}: {{ $report['product_barcode'] }}
                                    </td>

                                    <td>
                                        <span class="d-block">{{ $report['customer_name'] }}</span>
                                        <span class="d-block">{{ $report['customer_no'] }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ trans('messages.warrenty_type_lang', [], session('locale')) }}:
                                            @if($report['warranty_type'] == 1)
                                                {{ trans('messages.shop_lang') }}
                                            @elseif($report['warranty_type'] == 2)
                                                {{ trans('messages.agent_lang') }}
                                            @else
                                                {{ trans('messages.none') }}
                                            @endif
                                        </span>
                                        <span class="d-block">{{ trans('messages.warranty_days_lang', [], session('locale')) }}: {{ $report['warranty_days'] }}</span>

                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ url('product_view').'/'.$report['id'] }}">
                                            {{ trans('messages.view_detail', [], session('locale')) }}
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
