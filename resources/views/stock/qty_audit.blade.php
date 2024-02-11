@extends('layouts.header')

@section('main')
@push('title')
<title> products</title>
@endpush
 
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Quantity Audit</h4>
                        <h6>Product quantity in and out</h6>
                    </div>
                    <div class="page-btn">
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="all_qty_audit" class="table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Title</th>
                                        <th>Barcode</th>   
                                        <th>Imei</th>   
                                        <th>Previous Quantity</th>
                                        <th>Given Quantity</th>
                                        <th>New Quantity</th>
                                        <th>Source</th>
                                        <th>Reason</th>
                                        <th>Added By</th>
                                        <th>Add Date</th> 
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

