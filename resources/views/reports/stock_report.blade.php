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

                                    <th>Product Name</th>
                                    <th>Product Barcode</th>
                                    <th>Purchase price</th>
                                    <th>Sale price</th>
                                    <th>Product Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $pro)
                                    <tr>
                                        <td>{{ $pro->product_name ?? '' }} <br> {{ $pro->product_name_ar ?? '' }}</td>
                                        <td>{{ $pro->barcode }}</td>

                                        <td>{{ $pro->purchase_price }}</td>
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
