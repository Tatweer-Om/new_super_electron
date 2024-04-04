@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.authusers_lang', [], session('locale')) }}</title>
@endpush

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">

                        <h4>{{ trans('messages.users_list_lang', [], session('locale')) }}</h4>
                        <h6> {{ trans('messages.search_user_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_authuser_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.add_user_btn_lang', [], session('locale')) }}</a>

                    </div>
                </div>
                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_authuser" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('messages.image_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.full_name_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.username_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.contact_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.authuser_detail_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.created_by_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.created_at_lang',[],session('locale'))}}</th>
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
    {{-- authuser add modal --}}
    <div class="modal fade" id="add_authuser_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_authuser') }}" class="add_authuser" method="POST" enctype="multipart/form-data">
                      @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 col-sm-12 col-12">
                                    <div class="row">
                                        <input type="hidden" class="authuser_id" name="authuser_id">
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.full_name_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control authuser_name" name="authuser_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.username_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control authuser_username" name="authuser_username">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.contact_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control authuser_phone phone" name="authuser_phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.password_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control authuser_password " name="authuser_password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-6 col-12">
                                            <div class="row product_radio_class">
                                                <label
                                                    class="col-lg-6">{{ trans('messages.permissions_lang', [], session('locale')) }}</label>
                                                <div class="col-lg-12" id="checked_html">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="permission_all" value="1"
                                                            >
                                                        <label class="form-check-label" for="permission_all">
                                                            {{ trans('messages.all_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="stock" value="2">
                                                        <label class="form-check-label" for="stock">
                                                            {{ trans('messages.stock_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="add_stock" value="3">
                                                        <label class="form-check-label" for="add_stock">
                                                            {{ trans('messages.add_stock_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="dmg_quantity" value="4"
                                                            >
                                                        <label class="form-check-label" for="dmg_quantity">
                                                            {{ trans('messages.stock_damage_quantity_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="update_purchase" value="5">
                                                        <label class="form-check-label" for="update_purchase">
                                                            {{ trans('messages.purchase_update_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="delete_purchase" value="6">
                                                        <label class="form-check-label" for="delete_purchase">
                                                            {{ trans('messages.purchase_delete_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="purchases" value="7"
                                                            >
                                                        <label class="form-check-label" for="purchases">
                                                            {{ trans('messages.purchase_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="purchase_payment" value="8"
                                                            >
                                                        <label class="form-check-label" for="purchase_payment">
                                                            {{ trans('messages.purchase_payment_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="customer" value="9">
                                                        <label class="form-check-label" for="customer">
                                                            {{ trans('messages.customers_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="accounting" value="10">
                                                        <label class="form-check-label" for="accounting">
                                                            {{ trans('messages.sidebar_accounting', [], session('locale')) }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="expense" value="11">
                                                        <label class="form-check-label" for="expense">
                                                            {{ trans('messages.expense_name_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="maint" value="12">
                                                        <label class="form-check-label" for="maint">
                                                            {{ trans('messages.maintenance', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="warranty" value="13">
                                                        <label class="form-check-label" for="warranty">
                                                            {{ trans('messages.warranty', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="setting" value="14">
                                                        <label class="form-check-label" for="setting">
                                                            {{ trans('messages.setting', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="offers" value="15">
                                                        <label class="form-check-label" for="offers">
                                                            {{ trans('messages.offers', [], session('locale')) }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="services" value="16">
                                                        <label class="form-check-label" for="services">
                                                            {{ trans('messages.services', [], session('locale')) }}
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="sms" value="17">
                                                        <label class="form-check-label" for="sms">
                                                            {{ trans('messages.messages_panel', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="qout" value="18">
                                                        <label class="form-check-label" for="qout">
                                                            {{ trans('messages.quotation', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="delete" value="19">
                                                        <label class="form-check-label" for="delete">
                                                            {{ trans('messages.delete', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="add" value="20">
                                                        <label class="form-check-label" for="add">
                                                            {{ trans('messages.add', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="update" value="21">
                                                        <label class="form-check-label" for="update">
                                                            {{ trans('messages.update', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permit_type" type="checkbox"
                                                            name="permit_type[]" id="view" value="22">
                                                        <label class="form-check-label" for="view">
                                                            {{ trans('messages.view', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.authuser_detail_lang', [], session('locale')) }}</label>
                                                <textarea class="form-control authuser_detail" name="authuser_detail" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="validationTooltip03">{{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                                <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                     <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                        <input type="file" class="image" onchange="return fileValidation('authuser_img','img_tag')"   name="authuser_image" id="authuser_img"  >
                                                    </span>
                                                    {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                                </div>
                                                <img src="{{ asset('images/dummy_image/no_image.png') }}" class="img_tags" id="img_tag" width="300px" height="100px">
                                            </div>
                                        </div>
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

