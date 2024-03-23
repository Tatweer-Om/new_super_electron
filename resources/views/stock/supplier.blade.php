@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.suppliers_lang', [], session('locale')) }}</title>
@endpush

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">

                        <h4>{{ trans('messages.product_supplier_list_lang', [], session('locale')) }}</h4>
                        <h6> {{ trans('messages.search_product_supplier_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_supplier_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.add_brand_btn_lang', [], session('locale')) }}</a>

                    </div>
                </div>
                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_supplier" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('messages.image_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.supplier_name_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.supplier_phone_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.supplier_email_lang',[],session('locale'))}}</th>
                                        <th>{{trans('messages.supplier_address_lang',[],session('locale'))}}</th>
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
    {{-- supplier add modal --}}
    <div class="modal fade" id="add_supplier_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_supplier') }}" class="add_supplier" method="POST" enctype="multipart/form-data">
                      @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8 col-sm-12 col-12">
                                    <div class="row">
                                        <input type="hidden" class="supplier_id" name="supplier_id">
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.supplier_name_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control supplier_name" name="supplier_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.supplier_phone_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control supplier_phone phone" name="supplier_phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.supplier_email_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control supplier_email" name="supplier_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.supplier_detail_lang', [], session('locale')) }}</label>
                                                <textarea class="form-control supplier_detail" name="supplier_detail" rows="5"></textarea>
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
                                                        <input type="file" class="image" onchange="return fileValidation('supplier_img','img_tag')"   name="supplier_image" id="supplier_img"  >
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

