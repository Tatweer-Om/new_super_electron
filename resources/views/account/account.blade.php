@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.accounts_lang', [], session('locale')) }}</title>
@endpush

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4> {{ trans('messages.account_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_account_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_account_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.account_lang', [], session('locale')) }}</a>
                    </div>
                </div>
                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_account" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.account_name_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.account_branch_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.account_no_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.opening_balance_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.commission_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.account_type_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.notes_lang',[],session('locale')) }}</th>
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
    {{-- account add modal --}}
    <div class="modal fade" id="add_account_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_account') }}" class="add_account" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="account_id" name="account_id">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_name_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control account_name" name="account_name">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_branch_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control account_branch" name="account_branch">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_no_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control account_no" name="account_no">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.opening_balance_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control opening_balance isnumber" name="opening_balance">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.commission_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control commission isnumber" name="commission">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.account_type_lang', [], session('locale')) }}</label>
                                        <select class="form-control account_type" name="account_type">
                                            <option value="1">{{ trans('messages.normal_account_lang', [], session('locale')) }}</option>
                                            <option value="2">{{ trans('messages.saving_account_lang', [], session('locale')) }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <label class="checkboxs">{{ trans('messages.cash_lang', [], session('locale')) }}
                                        <input type="checkbox"   name="account_status" value="1" id="account_status" class="account_status">
                                        <span class="checkmarks" for="account_status"></span>
                                    </label>
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

