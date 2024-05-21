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
                        <a style="font-weight: bold;"> {{ trans('messages.expense_report', [], session('locale')) }}</a>
                        </div>

                        <div class="dash-imgs">
                            <i data-feather="file"></i>
                        </div>
                    </div>
                </div>



            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('sales_report') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.sale_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-minus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('brand_sale') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.sales_by_brand_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-plus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('category_sale') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.sales_by_category_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('most_sold') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.most_sold_items', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="archive"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('supplier_report') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;" style="font-weight: bold;">{{ trans('messages.supplier_report', [], session('locale')) }}</a>

                    </div>
                    <div class="dash-imgs">
                        <i data-feather="align-justify"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('stock_report') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.stock_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="database"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('local_repair') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.local_repairing_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="grid"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('warranty_repair') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.warranty_repairing_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="link-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('warranty_products') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.warranty_prducts_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="link-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('customer_point') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;">{{ trans('messages.customer_point', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('profit_expense') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.profit_expense_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="layers"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('customer_purchase') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.customer_purchases_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="crosshair"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('customer_type') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.customer_type_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="cpu"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('customer_address') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.customer_geography_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="command"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 d-flex">
                <div class="dash-count das3 clickable" data-href="{{ url('damage_products') }}" >
                    <div class="dash-counts">

                        <a style="font-weight: bold;"> {{ trans('messages.damage_products_report', [], session('locale')) }}</a>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="columns"></i>
                    </div>
                </div>
            </div>




        </div>





    </div>
    </div>

    </div>




    @include('layouts.report_footer')
@endsection
