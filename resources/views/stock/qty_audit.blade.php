@extends('layouts.header')

@section('main')
@push('title')
<title>  {{ trans('messages.quantity_audit_lang', [], session('locale')) }}</title>
@endpush

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>{{ trans('messages.quantity_audit_lang', [], session('locale')) }}</title></h4>
                        <h6> {{ trans('messages.product_quantity_lang', [], session('locale')) }}</title></h6>
                    </div>
                    <div class="page-btn">
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('qty_audit') }}" class="get_qty_audit" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label> {{ trans('messages.start_date_lang', [], session('locale')) }}</label>
                                        <input type="text"  class="form-control start_date datetimepicker" value="<?php echo $start_date; ?>" name="start_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label> {{ trans('messages.end_date_lang', [], session('locale')) }}</label>
                                        <input type="text"  class="form-control end_date datetimepicker" value="<?php echo $end_date; ?>" name="end_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label> {{ trans('messages.products_lang', [], session('locale')) }}</label>
                                        <select class="searchable_select select2 product_id" name="product_id">
                                            <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                            @foreach ($product as $pro)
                                                @if ($pro->id == $product_id)

                                                    <option value="{{ $pro->id }}" selected>{{ $pro->product_name }}-{{ $pro->barcode }}</option>
                                                @else
                                                    <option value="{{ $pro->id }}">{{ $pro->product_name }}-{{ $pro->barcode }}</option>

                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-submit me-2 submit_form report_btn">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="all_qty_audit" class="table">
                                <thead>
                                    <tr>
                                        <th> {{ trans('messages.Order#_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.title_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.barcode_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.imei_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.previous_quantity_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.given_quantity_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.new_quantity_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.source_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.reason_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                        <th class="d-none"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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

