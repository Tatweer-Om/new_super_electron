@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.stock_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.stock_report', [], session('locale')) }}</h6>
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


                    <div class=" table-responsive">
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.created_at_lang') }}</th>
                                    <th>{{ trans('messages.product_name_lang') }}</th>
                                    <th>{{ trans('messages.barcode_lang') }}</th>
                                    <th>{{ trans('messages.purchase_price') }}</th>
                                    <th>{{ trans('messages.sale_price_lang') }}</th>
                                    <th>{{ trans('messages.quantity_lang') }}</th>
                                    <th>{{ trans('messages.action_lang') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_purchase_price= 0;
                                    $total_sale_price = 0;
                                    $total_quantity = 0;
                                @endphp
                                @foreach ($product as $pro)

                                @php
                                    $total_purchase_price +=  $pro->total_purchase * $pro->quantity  ?? 0;
                                    $total_sale_price += $pro->sale_price * $pro->quantity  ?? 0;
                                    $total_quantity += $pro->quantity ?? 0;

                                @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($pro->created_at)->format('d-m-Y (h:i a)') }}</td>
                                        <td>{{ $pro->product_name ?? '' }} <br> {{ $pro->product_name_ar ?? '' }}</td>
                                        <td>{{ $pro->barcode }}</td>

                                        <td>{{ $pro->total_purchase }}</td>
                                        <td>{{ $pro->sale_price }}</td>
                                        <td>{{ $pro->quantity }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ url('product_view/' . $pro->id) }}">
                                                {{ trans('messages.view_detail', [], session('locale')) }}
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td style="border-top"> <strong> {{ trans('messages.total_purchase', [], session('locale')) }}: {{ $total_purchase_price }} </strong></td>
                                <td style="border-top"><strong>  {{ trans('messages.total_sales', [], session('locale')) }}: {{ $total_sale_price }}  </strong></td>
                                <td style="border-top"><strong>  {{ trans('messages.total_quantity', [], session('locale')) }}: {{ $total_quantity }}  </strong></td>
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
