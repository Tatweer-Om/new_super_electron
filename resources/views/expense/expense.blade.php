@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.expense_lang', [], session('locale')) }}</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">

                        <h4> {{ trans('messages.expense_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_expense_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_expense_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.expense_lang', [], session('locale')) }}</a>

                    </div>
                </div>


                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_expense" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.expense_category_name_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.expense_name_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.amount_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.payment_method_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.expense_date_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.created_by_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.created_at_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
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
    {{-- expense add modal --}}
    <div class="modal fade" id="add_expense_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_expense') }}" class="add_expense" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="expense_id" name="expense_id">
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.expense_category_name_lang', [], session('locale')) }}</label>
                                        <select class="searchable_select select2 category_id" name="category_id">
                                            @foreach ($view_category as $cat) {
                                                <option value="{{$cat->id}}">{{$cat->expense_category_name}}</option>';
                                            }
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.expense_name_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control expense_name" name="expense_name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.amount_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control amount isnumber" name="amount">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.expense_date_lang', [], session('locale')) }}</label>
                                        <input type="" class="form-control expense_date datetimepicker" value="<?php echo date('Y-m-d'); ?>" name="expense_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.payment_method_lang', [], session('locale')) }}</label>
                                        <select class="searchable_select select2 payment_method" name="payment_method">
                                            @foreach ($view_account as $acc) {
                                                <option value="{{$acc->id}}">{{$acc->account_name}}</option>';
                                            }
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>	{{ trans('messages.expense_receipt_lang', [], session('locale')) }}</label>
                                        <div class="image-upload">
                                            <input type="file" name="expense_image">
                                            <div class="image-uploads">
                                                <img src="{{  asset('img/icons/upload.svg')}}" alt="img">
                                                <h4 style="font-size:10px"> {{ trans('messages.drag_file_lang', [], session('locale')) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                    <textarea class="notes form-control" name="notes" rows="5"></textarea>
                                </div>
                            </div><br>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>



                        </div>
                    </form>
          </div>
        </div>
    </div>

    @include('layouts.footer')
    @endsection

