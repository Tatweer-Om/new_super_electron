@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.Quotations_list_lang', [], session('locale')) }}</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4> {{ trans('messages.Quotations_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_Quotations_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                    </div>
                    <div class="page-btn">
                        <a href="{{ url('qoutation') }}" class="btn btn-added" ><i class="fa fa-plus me-2"></i>{{ trans('messages.add_qout_lang', [], session('locale')) }}</a>

                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_quotation" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.qout_no_lang', [], session('locale')) }}</th>
                                        {{-- <th> {{ trans('messages.Qutation_date_lang', [], session('locale')) }}</th> --}}
                                        <th> {{ trans('messages.total_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.paid_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.remaining_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.customer_name_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.customer_phone_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>

                                <tbody>




                                </tbody
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /product list -->
            </div>
        </div>
    </div>


		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

