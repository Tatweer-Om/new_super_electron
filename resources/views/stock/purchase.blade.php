@extends('layouts.header')

@section('main')
@push('title')
<title> Purchases</title>
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
                        <h4>Purchases list</h4>
                        <h6>View/Search Purchases</h6>
                    </div>
                    <div class="page-btn">
                        {{-- <a href="{{ url }}" class="btn btn-added" data-bs-toggle="modal"
                        data-bs-target="#add_category_modal">
                            <i class="fa fa-plus me-2"></i> Purchases
                        </a> --}}
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_purchase" class="table  ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice #</th>
                                        <th>Status</th>
                                        <th>Supplier Name</th>
                                        <th>Purchase Date</th>
                                        <th>Shipping Cost</th>
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

