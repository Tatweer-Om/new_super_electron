@extends('layouts.header')

@section('main')
@push('title')
<title>Stores</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product store list</h4>
                        <h6>View/Search product store</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_store_modal"><i class="fa fa-plus me-2"></i>Store</a>

                    </div>
                </div>


                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_store" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>{{ trans('messages.store_name_lang') }}</th>
                                        <th>{{ trans('messages.address_lang') }}</th>
                                        <th>{{ trans('messages.contact_lang') }}</th>
                                        <th>{{ trans('messages.created_by_lang') }}</th>
                                        <th>{{ trans('messages.created_at_lang') }}</th>
                                        <th>Action</th>
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
    {{-- store add modal --}}
    <div class="modal fade" id="add_store_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Create</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_store') }}" class="add_store" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="store_id" name="store_id">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>store Name</label>
                                        <input type="text" class="form-control store_name" name="store_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Store Phone</label>
                                        <input type="text" class="form-control store_phone phone" name="store_phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Store Address</label>
                                        <textarea  class="form-control store_address" rows="3" name="store_address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2 submit_form">Submit</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
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

