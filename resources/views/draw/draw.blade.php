@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.draws_lang', [], session('locale')) }}</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">

                        <h4> {{ trans('messages.draw_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_draw_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_draw_modal"><i class="fa fa-plus me-2"></i>{{ trans('messages.draw_lang', [], session('locale')) }}</a>

                    </div>
                </div>

                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_draw" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.draw_name_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.draw_date_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.draw_starts_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.draw_ends_lang',[],session('locale')) }}</th>
                                        <th>{{ trans('messages.draw_detail_lang',[],session('locale')) }}</th>
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
    {{-- draw add modal --}}
    <div class="modal fade" id="add_draw_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_draw') }}" class="add_draw" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row product_radio_class">
                                <div class="col-lg-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_type" onclick="check_customer()" type="checkbox"
                                            name="offer_type" id="offer_type_general" value="4">
                                        <label class="form-check-label" for="offer_type_general">
                                            {{ trans('messages.genral_lang', [], session('locale')) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row product_radio_class"><br>
                                <div class="col-lg-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_type" type="checkbox"
                                            name="offer_type_student" id="offer_type_student" onclick="check_customer()" value="1">
                                        <label class="form-check-label" for="offer_type_student">
                                            {{ trans('messages.offer_student_lang', [], session('locale')) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3 student_detail display_none">
                                    <input type="checkbox" id="std_uni_check" > {{ trans('messages.select_all_lang', [], session('locale')) }}
                                    <select class="student_university" name="student_university[]" multiple>
                                         @foreach ($universities as $university )
                                        <option value="{{ $university->id }}"> {{ $university->university_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row product_radio_class"> <br>
                                <div class="col-lg-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_type" type="checkbox"
                                            name="offer_type_employee" id="offer_type_employee" onclick="check_customer()" value="3">
                                        <label class="form-check-label" for="offer_type_employee">
                                            {{ trans('messages.offer_employee_lang', [], session('locale')) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3 employee_detail display_none">
                                    <input type="checkbox" id="min_check" > {{ trans('messages.select_all_lang', [], session('locale')) }}
                                    <select class=" ministry_id" name="ministry_id[]" multiple>
                                         @foreach ($ministries as $ministry)
                                            <option value="{{ $ministry->id }}" > {{ $ministry->ministry_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 employee_detail display_none">
                                    <input type="checkbox" id="emp_check" > {{ trans('messages.select_all_lang', [], session('locale')) }}
                                    <select class=" employee_workplace" name="employee_workplace[]" multiple>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="row product_radio_class">
                                        <label
                                            class="col-lg-6">{{ trans('messages.gender_lang', [], session('locale')) }}</label>
                                        <div class="col-lg-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input gender_type" type="checkbox"
                                                    name="male" id="gender_type_male" value="1">
                                                <label class="form-check-label" for="gender_type_male">
                                                    {{ trans('messages.male_lang', [], session('locale')) }}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input gender_type" type="checkbox"
                                                    name="female" id="gender_type_female" value="2">
                                                <label class="form-check-label" for="gender_type_female">
                                                    {{ trans('messages.female_lang', [], session('locale')) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row product_radio_class">
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="col-lg-3">
                                        <label class="col-lg-6">{{ trans('messages.nationality_lang', [], session('locale')) }}</label>
                                        <input type="checkbox" id="national_check" > {{ trans('messages.select_all_lang', [], session('locale')) }}
                                        <select class=" nationality_id" name="nationality_id[]" multiple>
                                            <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                            @foreach ($nationality as $nat)
                                                <option value="{{ $nat->id }}" > {{ $nat->nationality_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="row">

                                <input type="hidden" class="draw_id" name="draw_id">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.draw_name_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control draw_name" name="draw_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.draw_date_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control draw_date datepick" name="draw_date">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.draw_starts_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control draw_starts datepick" name="draw_starts">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.draw_ends_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control draw_ends datepick" name="draw_ends">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.draw_detail_lang', [], session('locale')) }}</label>
                                        <textarea  class="form-control draw_detail" rows="3" name="draw_detail"></textarea>
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
    {{--  --}}
		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

