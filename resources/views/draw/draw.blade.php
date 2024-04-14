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

