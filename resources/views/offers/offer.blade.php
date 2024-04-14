@extends('layouts.header')
@section('main')
    @push('title')
        <title>{{ trans('messages.offers_lang', [], session('locale')) }}</title>
    @endpush

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">

                    <h4>{{ trans('messages.offer_list_lang', [], session('locale')) }}</h4>
                    <h6> {{ trans('messages.search_offer_lang', [], session('locale')) }}</h6>
                </div>
                <div class="page-btn">
                    <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_offer_modal"><i
                            class="fa fa-plus me-2"></i>{{ trans('messages.add_offer_lang', [], session('locale')) }}</a>

                </div>
            </div>
            <!-- /product list -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="all_offer" class="table  ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.offer_name_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.offer_start_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.offer_end_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.offer_type_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.discount_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.offer_discount_type_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.created_at_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade" id="add_offer_modal" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" class="add_offer" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="row">
                                    <input type="hidden" class="offer_id" name="offer_id">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-6 col-12">
                                            <div class="row">
                                                <label
                                                    class="col-lg-6">{{ trans('messages.offer_type_lang', [], session('locale')) }}</label>
                                            </div>
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
                                                        <input class="form-check-input offer_type_student" type="checkbox"
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
                                                        <input class="form-check-input offer_type_employee" type="checkbox"
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
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-6 col-12">
                                            <div class="row product_radio_class">
                                                <label
                                                    class="col-lg-6">{{ trans('messages.gender_lang', [], session('locale')) }}</label>
                                                <div class="col-lg-12">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input male" type="checkbox"
                                                            name="male" id="gender_type_male" value="1">
                                                        <label class="form-check-label" for="gender_type_male">
                                                            {{ trans('messages.male_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input female" type="checkbox"
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
                                    </div>
                                    <div class="row ">
                                        <div class="col-lg-12 col-sm-6 col-12 ">
                                            <div class="row product_radio_class">
                                                <label
                                                    class="col-lg-6">{{ trans('messages.offer_category_lang', [], session('locale')) }}</label>
                                                <div class="col-lg-12">

                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input offer_apply_maint" type="checkbox"
                                                            name="offer_apply[]" id="offer_type_maint" value="2">
                                                        <label class="form-check-label" for="offer_type_maint">
                                                            {{ trans('messages.maintenance_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                    <div class=" form-check form-check-inline">
                                                        <input class="form-check-input offer_apply_product"
                                                            type="checkbox" name="offer_apply[]" id="offer_type_product"
                                                            value="3">
                                                        <label class="form-check-label" for="offer_type_product">
                                                            {{ trans('messages.offer_products_lang', [], session('locale')) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"><br>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.offer_name_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control offer_name" name="offer_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.offer_start_date_lang', [], session('locale')) }}</label>
                                                <input type="date" class="form-control offer_start" name="offer_start">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.offer_end_date_lang', [], session('locale')) }}</label>
                                                <input type="date" class="form-control offer_end" name="offer_end">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label id="tax_head" onclick="toggleTaxSign()">
                                                            {{ trans('messages.discount_lang', [], session('locale')) }}

                                                        </label>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input type="checkbox" id="box" onchange="toggleTaxSign()"
                                                            name="offer_discount_type">


                                                    </div>
                                                    <div class="col-lg-1">
                                                        <span id="tax_sign">%</span>
                                                    </div>

                                                    <input type="text" class="form-control offer_discount"
                                                        name="offer_discount">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <input type="radio" id="option1" name="option" value="1" checked>
                                            <label for="option1">Products</label>
                                        </div>
                                        <div class="col-lg-1" style="margin-right: 5px">
                                            <input type="radio" id="option3" name="option" value="3">
                                            <label for="option3">Categories</label>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type="radio" id="option2" name="option" value="2">
                                            <label for="option2">Brands</label>
                                        </div>


                                        <div class="col-lg-3 col-sm-10 col-10" id="brand_input" style="display: none;">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_brand_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 offer_brand" name="offer_brand[]"
                                                multiple>

                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"> {{ $brand->brand_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-10 col-10" id="category_input" style="display: none;">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_category_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 offer_category" id="my_select"
                                                name="offer_category[]" multiple>

                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"> {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-10 col-10" id="product_input" style="display: none;">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_product_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 offer_product" name="offer_product[]"
                                                multiple>

                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"> {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.offer_detail_lang', [], session('locale')) }}</label>
                                                <textarea class="form-control offer_detail" name="offer_detail" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-12">
                                <button type="submit"
                                    class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection
