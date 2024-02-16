@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.customers_lang', [], session('locale')) }}</title>
@endpush

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">

                <h4>{{ trans('messages.customer_list_lang', [], session('locale')) }}</h4>
                <h6> {{ trans('messages.search_customer_lang', [], session('locale')) }}</h6>
            </div>
            <div class="page-btn">
                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                data-bs-target="#add_customer_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.add_brand_btn_lang', [], session('locale')) }}</a>

            </div>
        </div>
        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="all_customer" class="table  ">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>{{trans('messages.image_lang',[],session('locale'))}}</th> --}}
                                <th>{{trans('messages.customer_name_lang',[],session('locale'))}}</th>
                                <th>{{trans('messages.customer_phone_lang',[],session('locale'))}}</th>
                                <th>{{trans('messages.customer_email_lang',[],session('locale'))}}</th>
                                <th>{{trans('messages.customer_id_lang',[],session('locale'))}}</th>
                                <th>{{trans('messages.customer_address_lang',[],session('locale'))}}</th>
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
    {{-- customer add modal --}}
    <div class="modal fade" id="add_customer_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_customer') }}" class="add_customer" method="POST" enctype="multipart/form-data">
                      @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="row">
                                        <input type="hidden" class="customer_id" name="customer_id">
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.customer_name_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control customer_name" name="customer_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.customer_phone_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control customer_phone phone" name="customer_phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.customer_email_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control customer_email" name="customer_email">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.national_id_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control national_id" name="national_id">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-6 col-12 ">
                                            <div class="row product_radio_class" >
                                                <label class="col-lg-6">{{ trans('messages.customer_type_lang', [], session('locale')) }}</label>
                                                <div class="col-lg-10">
                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_student" value="1">
                                                        <label class="form-check-label" for="customer_type_student">
                                                            {{ trans('messages.customer_student_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_teacher" value="2" >
                                                        <label class="form-check-label" for="customer_type_teacher">
                                                            {{ trans('messages.customer_teacher_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_employee" value="3">
                                                        <label class="form-check-label" for="customer_type_employee">
                                                        {{ trans('messages.customer_employee_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_general" value="4" checked>
                                                        <label class="form-check-label" for="customer_type_none">
                                                        {{ trans('messages.genral_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="student_detail display_none">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-10 col-10">
                                                <label class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                                <select class="searchable_select select2 " name="student_university">
                                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                    @foreach ($universities as $university )
                                                    <option value="{{ $university->id }}"> {{ $university->university_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12" >
                                                <label class="col-lg-6">{{ trans('messages.student_id_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control " name="student_id">
                                            </div>
                                            <div class="col-lg-3 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="validationTooltip03"> {{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                                    <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                        <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                            <input type="file" class="image" onchange="return fileValidation('customer_img','img_tag')" name="customer_image" id="customer_img">
                                                        </span>
                                                    </div>
                                                    <img src="{{ asset('images/dummy_image/no_image.png') }}" class="img_tags" id="img_tag" width="300px" height="100px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="teacher_detail display_none pb-3">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-10 col-10">
                                                <label class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                                <select class="searchable_select select2 teacher_university" name="teacher_university">
                                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                    @foreach ($universities as $university)
                                                        <option value="{{ $university->id }}" > {{ $university->university_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="employee_detail display_none pb-3">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-10 col-10">
                                                <label class="col-lg-6">{{ trans('messages.choose_workplace_lang', [], session('locale')) }}</label>
                                                <select class="searchable_select select2 " name="employee_workplace">
                                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                    @foreach ($workplaces as $workplace)
                                                    <option value="{{ $workplace->id }}" > {{ $workplace->workplace_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12" >
                                                <label class="col-lg-6">{{ trans('messages.employee_id_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control " name="employee_id">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</label>
                                                <textarea class="form-control customer_detail" name="customer_detail" rows="5"></textarea>
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

