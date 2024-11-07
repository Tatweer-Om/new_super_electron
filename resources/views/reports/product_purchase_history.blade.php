@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.product_purchase_history_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.product_purchase_history_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('product_purchase_history') }}" method="POST">
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
                            <label>{{ trans('messages.choose_product_lang', [], session('locale')) }}</label>
                            <select class="searchable_select form-control select2 product_id" name="product_id">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                @foreach ($products as $product)
                                @php
                                $selected = "";
                                if ($product->product_id == $product_id) {
                                    $selected = "selected='true'";
                                }
                            @endphp
                                    <option {!! $selected !!}  value="{{ $product->product_id }}" > {{ $product->product_name }}-{{ $product->barcode   }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <button type="submit" class="form btn btn-info mt-4" id="date_data">
                                <i class="ri-printer-line align-bottom me-1"></i> {{ trans('messages.submit', [], session('locale')) }}
                            </button>
                        </div>

                    </div>
                </form><br><br>
                    <div class=" table-responsive">
                        <table  id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th> {{ trans('messages.purchase_date_lang', [], session('locale')) }}</th>
                                    <th> {{ trans('messages.product_detail', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.quantity', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.purchase_detail', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.tax', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.supplier_detail', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php

                                $total_purchase = 0;
                                $total_quantity= 0;


                            @endphp


                                @foreach ($purchases as $purchase)
                                @php

                                    $total_purchase += $purchase->purchase_price ?? 0;
                                    $total_quantity += $purchase->quantity ?? 0;
                                @endphp
                                <tr>
                                    <td>{{ optional($purchase->purchase)->purchase_date ? \Carbon\Carbon::parse($purchase->purchase->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $purchase->product_name ?? '' }} <br>
                                        {{ trans('messages.barcode', [], session('locale')) }} : {{ $purchase->barcode ?? '' }}
                                 </td>
                                 <td>{{ $purchase->quantity }}</td>


                                    <td>  {{ trans('messages.unit_price_lang', [], session('locale')) }}: {{ $purchase->purchase_price ?? ''}}
<br>                                        {{ trans('messages.total_purchase_price_lang', [], session('locale')) }}: {{ $purchase->purchase_price * $purchase->quantity }}
                                    </td>
                                    <td>{{ $purchase->tax }}</td>


                                    @php
                                        $supplier_name= DB::table('suppliers')->where('id', $purchase->supplier_id)->value('supplier_name');
                                    @endphp
                                    <td> {{ trans('messages.invoice_no', [], session('locale')) }}: {{ $purchase->invoice_no }}
                                        <br>
                                        {{ trans('messages.supplier', [], session('locale')) }}: {{ $supplier_name ?? '' }}
                                    </td>
                                    <td>   <a class="me-3" href="{{ url('purchase_view/' . $purchase->purchase_id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a></td>


                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                                <td></td>

                                <td style="border-top"><strong>  {{ trans('messages.total_quatity', [], session('locale')) }}: {{ $total_quantity }}  </strong></td>
                                <td style="border-top"><strong>  {{ trans('messages.total_purchase', [], session('locale')) }}: {{ $total_purchase }}  </strong></td>

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
