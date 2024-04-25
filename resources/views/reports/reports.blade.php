@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.expense_report_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="row">

                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a> Daily Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a> Sales By users</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Sale by Caregories</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="align-justify"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Sales By Brands</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="aperture"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Most Sell Items</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="archive"></i>
                        </div>
                    </div>
                </div>

                //supplier

                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Supplier Item Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                v
                v
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                v
                v
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                v
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                v
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Track An Item</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="arrow-right-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Sales</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Supplier</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Expense</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="shuffle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Stocks</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="layers"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Accounting</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">

                            <a>Graphs</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="bar-chart"></i>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Button trigger modal -->



        </div>
    </div>

    </div>


    @include('layouts.report_footer')
@endsection
