@extends('layouts.report_header')

@section('main')
    @push('title')
        <title>{{ trans('messages.sales_by_category_report', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>{{ trans('messages.all_reports_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.sales_by_category_report', [], session('locale')) }}</h6>
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

                    <form class="form_data" action="{{ route('category_sale') }}" method="POST">
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
                            <label>{{ trans('messages.choose_sales_category_lang', [], session('locale')) }}</label>
                            <select class="searchable_select form-control select2 category_id" name="category_id">
                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                @foreach ($category as $cat)
                                    @php
                                        $selected = "";
                                        if($category_id == $cat->id)
                                        {
                                            $selected = "selected='true'";
                                        }
                                    @endphp
                                    <option {{ $selected }}  value="{{ $cat->id }}" > {{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <button type="submit" class="form btn btn-info mt-4" id="date_data">
                                <i class="ri-printer-line align-bottom me-1"></i> {{ trans('messages.submit', [], session('locale')) }}
                            </button>
                        </div>

                    </div>
                </form><br><br>
                    <div class=" table-responsive">
                        @php
    $total_sales = $category_sale->sum('total_sale');
    $total_all_profit = $category_sale->sum('total_profit');
@endphp
<table id="example" class="display nowrap">
    <thead>
        <tr>
            <th>{{ trans('messages.created_at_lang', [], session('locale')) }}</th>

            <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
            <th>{{ trans('messages.quantity', [], session('locale')) }}</th>
            <th>{{ trans('messages.total_sales', [], session('locale')) }}</th>
            <th>{{ trans('messages.total_profit', [], session('locale')) }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_sales = 0;
            $total_all_profit = 0;
        @endphp

        @foreach ($category_sale as $categoryId => $products)
            @php
                $category_name = DB::table('categories')->where('id', $categoryId)->value('category_name');
            @endphp
            <tr>
                @foreach ($products as $index => $product)
                    @if ($index > 0) <tr> @endif <!-- New row for each product under the same category -->
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d-m-Y (h:i a)') }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->total_sale }}</td>
                        <td>{{ $product->total_profit }}</td>
                    </tr>
                    @php
                        $total_sales += $product->total_sale ?? 0;
                        $total_all_profit += $product->total_profit ?? 0;
                    @endphp
                @endforeach
            @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td><strong>{{ trans('messages.total_sales', [], session('locale')) }}: {{ $total_sales }}</strong></td>
            <td><strong>{{ trans('messages.total_profit', [], session('locale')) }}: {{ $total_all_profit }}</strong></td>
        </tr>
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
