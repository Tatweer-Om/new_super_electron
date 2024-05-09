@extends('layouts.report_header')
@section('main')
    @push('title')
        <title>{{ trans('messages.most_sold_items', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.most_sold_items', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('most_sold') }}" method="POST">
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
                            <select class="searchable_select form-control select2 store_id" name="store_id">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>

                                @foreach ($stores as $store)
                                @php
                                $selected = "";
                                if($store_id == $store->id)
                                {
                                    $selected = "selected='true'";
                                }
                            @endphp
                                    <option {{  $selected }}  value="{{ $store->id }}" > {{ $store->store_name }}</option>
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
                                    <th> {{ trans('messages.product_detail_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.quantity_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.sale_price_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.total_discount', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.total_tax_lang', [], session('locale')) }}</th>
                                    <th >{{ trans('messages.product_profit', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.added_by_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php

                                $total_points_amount = 0;
                                $total_all_profit= 0;

                            @endphp

                            @foreach ($most_selling_products as $product )
                                @php
                                    // $total_amount += $order->paid_amount;
                                    // $total_all_discount += $order->total_discount + isset($order->offer_discount) ? $order->offer_discount : 0;
                                    $producti = DB::table('products')->where('id', $product->product_id)->first();
                                    $product_name= $producti->product_name;

                                @endphp
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);">{{ $product_name ?? '' }}</a> <br>
                                        {{ $product->item_barcode ?? '' }}
                                    </td>
                                    <td> {{ $product->total_quantity_sold ?? '' }}
                                    </td>
                                    <td> {{ $product->total_sales ?? '' }}</td>

                                    <td > {{ $product->total_discount ?? '' }} </td>
                                    <td>

                                        {{ $product->total_tax ?? ''}}
                                    </td>
                                    <td> {{ $product->total_profit ?? 0 }} </td>
                                    <td> {{ $product->added_by }} </td>
                                    <td>
                                        <a class="me-3 " href="{{ url('product_view').'/'.$product->product_id }}">
                                            <i class="fas fa-eye"></i>
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
                                <td></td>
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
