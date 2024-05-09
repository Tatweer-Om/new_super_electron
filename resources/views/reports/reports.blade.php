@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.reports_page_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="row">

                <div class="col-lg-4 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3 clickable" data-href="{{ url('expense_report') }}" >
                        <div class="dash-counts">
                        {{ trans('messages.expense_report', [], session('locale')) }}
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file"></i>
                        </div>
                    </div>
                </div>



            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('sales_report') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.sale_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-minus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('brand_sale') }}" >
                    <div class="dash-counts">

                        <a> {{ trans('messages.sales_by_brand_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-plus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('category_sale') }}" >
                    <div class="dash-counts">

                        <a> {{ trans('messages.sales_by_category_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('most_sold') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.most_sold_items', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="archive"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('supplier_report') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.supplier_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="align-justify"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('stock_report') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.stock_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="database"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('local_repair') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.local_repairing_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="grid"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('warranty_repair') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.warranty_repairing_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="link-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('customer_point') }}" >
                    <div class="dash-counts">

                        <a>{{ trans('messages.customer_point', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('profit_expense') }}" >
                    <div class="dash-counts">

                        <a> {{ trans('messages.profit_expense_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="layers"></i>
                    </div>
                </div>
            </div>




        </div>





    </div>
    </div>

    </div>




    @include('layouts.report_footer')
@endsection
