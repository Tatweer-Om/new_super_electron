@extends('layouts.header')

@section('main')
@push('title')
<title> products</title>
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
                        <h4>products list</h4>
                        <h6>View/Search products</h6>
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
                                        <th>Title</th>
                                        <th>Barcode</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Store</th>
                                        <th>Quantity</th>
                                        <th>Sale Price</th>
                                        <th>Added By</th>
                                        <th>Add Date</th>
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

 


		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

