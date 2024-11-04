@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.damage_products_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.damage_prducts_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('damage_products') }}" method="POST">
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
                                    <th>{{ trans('messages.damage_qty_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.damage_reason_lang', [], session('locale')) }}</th>

                                    <th> {{ trans('messages.added_by_lang', [], session('locale')) }}</th>
 
                                    <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php

                                    $damage_quantity = 0;
                                @endphp


                                @foreach ($reports as $report)
                                @php
                                    $damage_quantity +=$report['damage_qty'] ?? 0;
                                @endphp


                                <tr>

                                    <td>
                                        {!! nl2br(e($report['product_name'])) !!}<br> {{ trans('messages.barcode_lang', [], session('locale')) }}: {{ $report['product_barcode'] }}
                                    </td>
                                    <td>
                                        {{ trans('messages.pre_quantity_lang', [], session('locale')) }}: {{ $report['pre_qty'] }} <br>
                                        {{ trans('messages.damage_qty_lang', [], session('locale')) }}: {{ $report['damage_qty'] }} <br>
                                        {{ trans('messages.new_quantity_lang', [], session('locale')) }}: {{ $report['new_qty'] }}
                                    </td>

 
                                    <td>
                                        {{ trans('messages.reason_lang', [], session('locale')) }}: {{ $report['reason'] }}
                                    </td>

 
                                    <td>
                                        {{ trans('messages.added_by_lang', [], session('locale')) }}: {{ $report['added_by'] }} <br> {{ $report['added_on'] }}
                                    </td> 

                                    <td>
                                        <a class="btn btn-primary" href="{{ url('product_view').'/'.$report['id'] }}">
                                            {{ trans('messages.view_detail', [], session('locale')) }}
                                        </a>


                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td></td>
                                <td style="border-top"><strong>  {{ trans('messages.total_damage_products', [], session('locale')) }}: {{ $damage_quantity ?? 0 }}  </strong></td>
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
