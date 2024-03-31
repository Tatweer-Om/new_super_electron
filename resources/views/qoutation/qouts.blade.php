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
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_quotation" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.Quotation_No._lang', [], session('locale')) }}</th>
                                        {{-- <th> {{ trans('messages.Qutation_date_lang', [], session('locale')) }}</th> --}}
                                        <th> {{ trans('messages.total_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.paid_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.remaining_amount_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.Customer_name_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.Customer_phone_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                    $sr =1;
                                @endphp
                                    @foreach ($qoutations as $qout )

                                    <tr>
                                        <td>{{ $sr++  }}</td>
                                        <td>Qout.No-00{{ $qout->id }}</td>

                                        <td>{{$qout->total_amount  }}</td>
                                        <td>{{$qout->paid_amount  }}</td>
                                        <td>{{ $qout->remaining_amount }}</td>
                                        @php
                                        $customer_name= DB::table('customers')->where('id', $qout->customer_id)->value('customer_name');
                                    @endphp
                                        <td>{{ $customer_name }}</td>
                                        @php
                                        $customer_phone= DB::table('customers')->where('id', $qout->customer_id)->value('customer_phone');
                                    @endphp
                                        <td>{{ $customer_phone }}</td>
                                        <td>{{$qout->added_by  }}</td>
                                        <td>{{ $qout->date}}</td>
                                        <td>
                                            <a class="me-3"
                        type="button" ><img src="{{  asset('img/icons/edit.svg')}}" alt="img">
                        </a>
                        <a class="me-3 confirm-text"><img src="{{ asset('img/icons/delete.svg')}}" alt="img">
                        </a>
                        <a class="me-3 confirm-text"><img src="{{ asset('img/icons/eye.svg')}}" alt="img">
                        </a>
                                        </td>
                                    </tr>

                                    @endforeach



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

