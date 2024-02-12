@extends('layouts.header')

@section('main')
@push('title')
<title> products</title>
@endpush
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Purchase Invoice</h4>
                        <h6>Check your Invoice Bill</h6>
                    </div>
                    <div class="page-btn">
                    </div>
                </div>
               <!-- /product list -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <iframe src="{{ asset('images/purchase_images')."/".$purchase_data->receipt_file }}" style="width:100%;height:1000px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /product list -->
            </div>
        </div>
    </div>

    { 

 


		<!-- /Main Wrapper -->
    @include('layouts.footer')
    @endsection

