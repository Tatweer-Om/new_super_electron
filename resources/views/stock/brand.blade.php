@extends('layouts.header')

@section('main')
@push('title')
<title>Brands</title>
@endpush

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Brand list</h4>
                        <h6>View/Search Product Brand</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_brand_modal"><i class="fa fa-plus me-2"></i>Brand</a>
                    </div>
                </div>
                <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_brand" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.image_lang') }}</th>
                                        <th>{{ trans('messages.brand_name_lang') }}</th>
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
    {{-- brand add modal --}}
    <div class="modal fade" id="add_brand_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Create</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_brand') }}" class="add_brand" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="brand_id" name="brand_id">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>brand Name</label>
                                        <input type="text" class="form-control brand_name" name="brand_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="validationTooltip03">Upload Image</label>
                                        <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                             <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                <input type="file" class="image" onchange="return fileValidation('brand_img','img_tag')"   name="brand_image" id="brand_img"  >
                                            </span>
                                            {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                        </div>
                                        <img src="{{ asset('images/dummy_image/no_image.png') }}" class="img_tags" id="img_tag" width="300px" height="100px">
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

