@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.expense_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.expense_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('expense_report') }}" method="POST">
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
                            <label>{{ trans('messages.choose_expense_category_lang', [], session('locale')) }}</label>
                            <select class="searchable_select form-control select2 expense_cat" name="expense_cat">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                @foreach ($expense_cat as $cat)
                                    @php
                                        $selected = "";
                                        if($cat_id == $cat->id)
                                        {
                                            $selected = "selected='true'";
                                        }
                                    @endphp
                                    <option {{  $selected }} value="{{ $cat->id }}" > {{ $cat->expense_category_name }}</option>
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

                                    <th>Expense Name</th>
                                    <th>Expense Category</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Expense Date</th>
                                    <th>Created By</th>
                                    <th>Expense Detaill</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_expense= 0;
                                @endphp
                                @foreach ($expenses as $expense )
                                @php
                                    $total_expense+= $expense->amount;
                                @endphp
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);">{{ $expense->expense_name ?? '' }}</a>
                                    </td>
                                    <td> {{ $expense->category->expense_category_name ?? '' }}</td>
                                    <td>{{ $expense->amount ?? '' }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                    <td> {{ $expense->payment->account_name ?? '' }}</td>
                                    <td>{{ $expense->expense_date ?? ''}}</td>
                                    <td>{{ $expense->added_by ?? ''}}</td>
                                    <td>{{ $expense->notes ?? '' }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>

                              <td style="border-top">  {{ trans('messages.total_expense', [], session('locale')) }} :{{ $total_expense }} {{ trans('messages.OMR_lang', [], session('locale')) }}</td>
                                <td></td>
                                <td></td>
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
