@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.supplier_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.supplier_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('supplier_report') }}" method="POST">
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
                            <label>{{ trans('messages.choose_supplier_lang', [], session('locale')) }}</label>
                            <select class="searchable_select form-control select2 supplier_id" name="supplier_id">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                @foreach ($suppliers as $supp)

                                @php
                                $selected = "";
                                if($supplier_id == $supp->id)
                                {
                                    $selected = "selected='true'";
                                }
                            @endphp

                                    <option  {{ $selected }} value="{{ $supp->id }}" > {{ $supp->supplier_name }}</option>
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
                                    <th>{{ trans('messages.invoice_no_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.supplier_detail_lang', [], session('locale')) }}
                                    </th>

                                    <th>{{ trans('messages.invoice_price', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.total_price', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.shipping_charges', [], session('locale')) }}
                                    </th>

                                    <th>{{ trans('messages.total_shipping_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.shipping_percentage_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.tax_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.tax_status_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.payment_status_lang', [], session('locale')) }}
                                    </th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @php

                                $total_invoice=0;
                                $total_shipping_charges= 0;
                                $total_shipping_cost=0;
                                $total_price=0;
                                $total_tax= 0;
                                $bulk_tax= 0;

                                @endphp
                                @foreach ($purchasesall as $purchase)
                                    @php
                                        $total_invoice += $purchase['invoice_price'] ?? 0;
                                        $total_price += $purchase['total_price'] ?? 0;
                                        $total_shipping_charges +=  $purchase['shipping_cost'] ?? 0;
                                        $total_shipping_cost += $purchase['total_shipping'] ?? 0;
                                        $total_tax += $purchase['total_tax'] ?? 0;
                                       $bulk_tax += $purchase['bulk_tax'] ?? 0 ;


                                        $supplier_ids = DB::table('purchases')->where('supplier_id', $purchase['supplier_id'])->pluck('supplier_id')->toArray();
                                        $suppliers = DB::table('suppliers')->whereIn('id', $supplier_ids)->distinct()->get();
                                        $supplier_name = $suppliers->pluck('supplier_name')->implode(',');
                                    @endphp

                                    <tr>
                                        <td>{{ trans('messages.invoice_no_lang', [], session('locale')) }}: {{ $purchase['invoice_no'] }} <br>{{ trans('messages.invoice_date', [], session('locale')) }}: {{ $purchase['purchase_date'] }}</td>
                                        <td>{{ $supplier_name }}</td>
                                        <td>{{ $purchase['invoice_price'] }} </td>
                                        <td>{{ $purchase['total_price'] }} </td>
                                        <td>{{ $purchase['shipping_cost'] }}  </td>
                                        <td>{{ $purchase['total_shipping'] }} </td>
                                        <td>{{ $purchase['shipping_percentage'] }} %</td>
                                        <td>{{ $purchase['total_tax'] ?? ''}}  </td>
                                        <td>
                                            @if($purchase['available_tax_type'] == 2)
                                                <span style="font-weight: bold; color: red;">{{ trans('messages.refundable_lang', [], session('locale')) }}</span>
                                            @elseif($purchase['available_tax_type'] == 1)
                                                <span style="font-weight: bold; color: rgb(0, 98, 255);">{{ trans('messages.non_refundable_lang', [], session('locale')) }}</span>
                                            @endif
                                            <br>
                                            {{ trans('messages.bulk_tax_lang', [], session('locale')) }}: {{ $purchase['bulk_tax'] ?? 0 }}
                                        </td>

                                        <td>
                                            @if($purchase['remaining_amount'] > 0)
                                                <span class="badges bg-lightred">{{ trans('messages.unpaid_lang', [], session('locale')) }}</span>

                                            @elseif($purchase['remaining_amount'] == 0)
                                                <span class="badges bg-lightgreen">{{ trans('messages.paid_lang', [], session('locale')) }}</span>
                                            @endif
                                        </td>
                                       <td>
                                            <a class="me-3" href="{{ url('purchase_view/' . $purchase['id']) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <td></td>
                                <td></td>

                              <td style="border-top"> <strong> {{ trans('messages.total_invoice', [], session('locale')) }}: {{ $total_invoice }} </strong></td>
                              <td style="border-top"> <strong> {{ trans('messages.total', [], session('locale')) }}: {{ $total_price }} </strong></td>
                                <td style="border-top"> <strong> {{ trans('messages.total', [], session('locale')) }}: {{ $total_shipping_charges }} </strong></td>
                              <td style="border-top"> <strong> {{ trans('messages.total', [], session('locale')) }}: {{ $total_shipping_cost }} </strong></td>
                                <td></td>
                                <td style="border-top"> <strong> {{ trans('messages.total', [], session('locale')) }}: {{ $total_tax }} </strong></td>
                                <td style="border-top"> <strong> {{ trans('messages.total', [], session('locale')) }}: {{ $bulk_tax }} </strong></td>
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

