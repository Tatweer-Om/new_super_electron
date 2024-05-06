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

                            <a> Expense Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="file"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a> Sales Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Supplier Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="align-justify"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Accounting Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="aperture"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">

                            <a>Stock Report</a>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="archive"></i>
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
