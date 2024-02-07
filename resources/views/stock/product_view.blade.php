@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.product_view_lang', [], session('locale')) }}</title>
@endpush

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Details</h4>
                <h6>Full details of a product</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bar-code-view">
                            <img src="assets/img/barcode1.png" alt="barcode">
                            <a class="printimg">
                                <img src="assets/img/icons/printer.svg" alt="print">
                            </a>
                        </div>
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Product</h4>
                                    <h6>{{ $product_view->product_name }}</h6>
                                </li>
                                <li>
                                    <h4>Category</h4>
                                    <h6>{{ $product_view->category_id }}</h6>
                                </li>
                                <li>
                                    <h4>Brand</h4>
                                    <h6>{{ $product_view->brand_id }}</h6>
                                </li>
                                <li>
                                    <h4>Supplier</h4>
                                    <h6>{{ $product_view->supplier_id }}</h6>
                                </li>
                                <li>
                                    <h4>Quantity</h4>
                                    <h6>{{ $product_view->quantity }}</h6>
                                </li>
                                <li>
                                    <h4>Purchase Price</h4>
                                    <h6>{{ $product_view->purchase_price }}</h6>
                                </li>
                                <li>
                                    <h4>Profit(%)</h4>
                                    <h6>{{ $product_view->profit_percent}}</h6>
                                </li>
                                <li>
                                    <h4>Tax</h4>
                                    <h6>{{  $product_view->tax }}</h6>
                                </li>
                                <li>
                                    <h4>Sales Price</h4>
                                    <h6>{{ $product_view->sale_price }}</h6>
                                </li>

                                <li>
                                    <h4>Product Type</h4>
                                    <h6>{{ $product_view->product_type }}</h6>
                                </li>
                                <li>
                                    <h4>Warranty</h4>
                                    <h6>{{  $product_view->warranty_type}} : {{ $product_view->warranty_days }}</h6>
                                </li>
                                <li>
                                    <h4>Added By</h4>
                                    <h6>{{ $product_view->added_by }}</h6>
                                </li>
                                <li>
                                    <h4>Updated By</h4>
                                    <h6>{{ $product_view->updated_by}}</h6>
                                </li>

                                <li>
                                    <h4>Description</h4>
                                    <h6>{{ $product_view->description}}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="slider-product-details">
                            <div class="owl-carousel owl-theme product-slide">
                                <div>
                                    <img src="{{ asset('images/product_images/' . $product_view->stock_image) }}">
                                    <h4>{{$product_view->product_name   }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /add -->
    </div>
</div>
</div>
<!-- /Main Wrapper -->

@include('layouts.footer')
@endsection
