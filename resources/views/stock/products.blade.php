@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.product_list_lang', [], session('locale')) }}</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4> {{ trans('messages.product_list_lang', [], session('locale')) }}</h4>
                        <h6>{{ trans('messages.search_products_lang', [], session('locale')) }}</h6>
                    </div>
                    <div class="page-btn">
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_product" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.title_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.barcode_generator_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.category_name_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.brand_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.store_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.quantity_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.sale_price_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.created_by_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                        <th> {{ trans('messages.action_lang', [], session('locale')) }}</th>
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

    {{-- damage_qty_modal --}}
    <div class="modal fade" id="damage_qty_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.damage_qty_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_damage_qty') }}" class="add_damage_qty" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body" id="damag_qty_div">


                        </div>
                    </form>
            </div>
        </div>
    </div>

    {{-- undo_damage_qty_modal --}}
    <div class="modal fade" id="undo_damage_qty_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.undo_damage_qty_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_undo_damage_qty') }}" class="add_undo_damage_qty" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body" id="undo_damag_qty_div">


                        </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_product_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" class="add_product" method="POST" enctype="multipart/form-data">
                      @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div >
                                    <div class="row">
                                        <input type="hidden" class="product_id" name="product_id">
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.product_name_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control product_name" name="product_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>{{ trans('messages.product_name_ar_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control product_name_ar " name="product_name_ar">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-10 col-10">
                                            <div class="form-group">
                                                <label class="col-lg-6">{{ trans('messages.brand_lang', [], session('locale')) }}</label>
                                                <select class="searchable_select select2 brand_id" name="brand_id">
                                                    @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-4 col-sm-10 col-10">
                                            <div class="form-group"> <!-- Wrap label and select box inside a div with class form-group -->
                                                <label>{{ trans('messages.category_lang', [], session('locale')) }}</label>
                                                <select class="searchable_select select2 category_id form-control" name="category_id">
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group"> <!-- Wrap label and input box inside a div with class form-group -->
                                                <label>{{ trans('messages.sale_price_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control sale_price" name="sale_price">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group"> <!-- Wrap label and input box inside a div with class form-group -->
                                                <label>{{ trans('messages.min_sale_price_lang', [], session('locale')) }}</label>
                                                <input type="text" class="form-control min_sale_price" name="min_sale_price">
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div>
                                    <label for="quick_sale">Quick Sale</label>
                                    <input type="checkbox" class="quick_sale" id="quick_sale">
                                </div>

                            </div><br><br>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                    </form>
          </div>
        </div>
    </div>

    {{-- replace_imei --}}
    <div class="modal fade" id="add_replace_pro_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.replace_product_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" class="add_replace_product_form" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="row">
                                    <input type="hidden" class="replace_product_id" name="product_id">
                                    <div class="col-lg-4 col-sm-10 col-10">
                                        <div class="form-group">
                                            <label class="col-lg-6">{{ trans('messages.order_no_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control order_no" readonly name="order_no">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.current_imei_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control current_imei" name="current_imei">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.new_imei_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control new_imei" name="new_imei">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control replace_notes" name="replace_notes" rows="5"></textarea>
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

		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

