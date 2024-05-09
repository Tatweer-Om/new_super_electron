@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.customer_point', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.customer_point', [], session('locale')) }}</h6>
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



                    <form class="form_data" action="{{ route('customer_point') }}" method="POST">
                        <div class="row">

                            @csrf

                            <div class="col-lg-3 mt-1">
                                <label>{{ trans('messages.choose_customer_lang', [], session('locale')) }}</label>
                                <select class="searchable_select form-control select2 customer_id" name="customer_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}
                                    </option>
                                    @foreach ($customers as $customer)
                                        @php
                                            $selected = '';
                                            if ($customer_id == $customer->id) {
                                                $selected = "selected='true'";
                                            }
                                        @endphp
                                        <option {{ $selected }} value="{{ $customer->id }}">
                                            {{ $customer->customer_name }}</option>
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
                        <table id="example" class="display nowrap" id="example">
                            <thead>
                                <tr>

                                    <th> {{ trans('messages.customer_name_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_number_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.customer_point', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_data as $cust)
                                    <tr>
                                        <td>{{ $cust->customer_name ?? '' }}</td>
                                        <td>{{ $cust->customer_number ?? '' }}</td>
                                        <td>{{ $cust->points ?? 0 }}</td>
                                        <td>
                                            <button class="btn btn-success" onclick="points_history({{ $cust->id }})" type="button" data-bs-toggle="modal"
                                                data-bs-target="#points">
                                                {{ trans('messages.points_history_lang', [], session('locale')) }}
                                            </button>
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
    <div class="modal fade" id="points" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('messages.points_history_lang', [], session('locale')) }} (<span id="customer_name"> </span>)</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table" id="warranty_detail">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.order_no_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.points_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.amount_lang', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.points_status', [], session('locale')) }}
                                </th>
                                <th>{{ trans('messages.action_lang', [], session('locale')) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id ="point_history_body">
                            {{-- @foreach ($points_history as $history)
                                <tr>
                                    <td>
                                        {{ $history->order_no ?? '' }} <br>
                                        {{ $history->created_at->format('Y-m-d') }}
                                    </td>
                                    <td> {{ $history->points ?? '' }}</td>
                                    <td>{{ $history->amount }}</td>
                                    @if ($history->type == 1)
                                        <td>Points Added</td>
                                    @elseif($history->type == 2)
                                        <td>Points Used</td>
                                    @endif


                                    <td>
                                        <a class="me-3" href="{{ url('pos_bill/' . $history->order_no) }}">
                                            <i class="fas fa-eye" data-bs-toggle="modal" data-bs-target="#points"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    @include('layouts.report_footer')
@endsection
