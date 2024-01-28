@extends('layouts.header')

@section('main')
@push('title')
<title> Categories</title>
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Category list</h4>
                        <h6>View/Search product Category</h6>
                    </div>
                    <div class="page-btn">
                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_category_modal">
                            <i class="fa fa-plus me-2"></i> Category
                        </a>
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_category" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('messages.image_lang') }}</th>
                                        <th>{{ trans('messages.category_name_lang',[],session('locale'))}}</th>
                                        <th>{{ trans('messages.created_by_lang',[],session('locale'))}}</th>
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
    {{-- category add modal --}}
    <div class="modal fade" id="add_category_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Create</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_category') }}" class="add_category" method="POST" enctype="multipart/form-data">
                     @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="category_id" name="category_id">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" class="form-control category_name" name="category_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="validationTooltip03">Upload Image</label>
                                        <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                             <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                <input type="file" class="image" onchange="return fileValidation('category_img','img_tag')"   name="category_image" id="category_img"  >
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

