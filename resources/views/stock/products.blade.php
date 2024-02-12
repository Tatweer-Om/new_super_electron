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




		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

