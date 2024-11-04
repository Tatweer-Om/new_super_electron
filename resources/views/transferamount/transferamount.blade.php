@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.transferamount_lang', [], session('locale')) }}</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4> {{ trans('messages.transferamount_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_transferamount_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_transferamount_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.transferamount_lang', [], session('locale')) }}</a>
                    </div>
                </div>
                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_transferamount" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.transaction_id_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.account_from_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.account_to_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.transfer_date_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.amount_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.notes_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.created_by_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.created_at_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5"></th>
                                        <th id="total-opening-balance">0</th>
                                        <th colspan="4"></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- /product list -->
            </div>
        </div>
    </div>
    {{-- transferamount add modal --}}
    <div class="modal fade" id="add_transferamount_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_transferamount') }}" class="add_transferamount" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="transferamount_id" name="transferamount_id">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.transaction_id_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control transaction_no" readonly value="{{ $transaction_no }}" name="transaction_no">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_from_lang', [], session('locale')) }}</label>
                                        <select class="form-control acc_from" name="acc_from">
                                            <option value="">{{trans('messages.choose_lang', [], session('locale'))}}</option>

                                            @foreach ($view_account as $acc) {
                                                <option value="{{$acc->id}}">{{$acc->account_name}}</option>';
                                            }
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_to_lang', [], session('locale')) }}</label>
                                        <select class="form-control acc_to" name="acc_to">
                                            <option value="">{{trans('messages.choose_lang', [], session('locale'))}}</option>
                                            @foreach ($view_account as $acc) {
                                                <option value="{{$acc->id}}">{{$acc->account_name}}</option>';
                                            }
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.transfer_date_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control transfer_date datepick" value="<?php echo date('Y-m-d'); ?>" name="transfer_date">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.amount_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control amount isnumber" name="amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                        <textarea  class="form-control notes" rows="3" name="notes"></textarea>
                                    </div>
                                </div>
                            </div>
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

