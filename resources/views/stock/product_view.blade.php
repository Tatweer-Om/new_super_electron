@extends('layouts.header')

@section('main')
@push('title')
<title> {{ trans('messages.product_view_lang', [], session('locale')) }}</title>
@endpush

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>{{ trans('messages.product_detail_lang', [], session('locale')) }}</h4>
                <h6>{{ trans('messages.grand_total_lang', [], session('locale')) }} </h6>
            </div>
        </div>
        <!-- /add -->
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="bar-code-view">
                            <div style="text-align:center; backgound:#000000" >
                                <svg class="barcode"
                                    jsbarcode-margin="0"
                                    jsbarcode-margintop="5"
                                    jsbarcode-marginright="15"
                                    jsbarcode-marginleft="1"
                                    jsbarcode-height="25"
                                    jsbarcode-width="1"
                                    jsbarcode-fontsize="14"
                                    jsbarcode-textalign="Center"
                                    jsbarcode-value="<?php echo $product_view->barcode; ?>"/>
                            </div>
                            <a class="printimg">
                                <button type="button" class="btn btn-warning">{{ trans('messages.print_lang', [], session('locale')) }}</button>
                            </a>
                        </div>
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>{{ trans('messages.product_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_view->product_name }}</h6>
                                </li>
                                <li>
                                    <h4> {{ trans('messages.store_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $store }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.category_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $category }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.brand_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $brand }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.supplier_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $supplier }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.quantity_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_view->quantity }}</h6>
                                </li>
                                <li>
                                    <h4> {{ trans('messages.purchase_price_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_view->total_purchase }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.profit_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_view->profit_percent}}%</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.tax_lang', [], session('locale')) }}</h4>
                                    <h6>{{  $product_view->tax }}</h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.sale_price_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_view->sale_price }}</h6>
                                </li>

                                <li>
                                    <h4>{{ trans('messages.product_type_lang', [], session('locale')) }}</h4>
                                    <h6>{{ $product_type }}</h6>
                                </li>
                                <li>
                                    <h4> {{ trans('messages.warranty_lang', [], session('locale')) }}</h4>
                                    <h6>{{  $warranty_type}}  </h6>
                                </li>
                                <li>
                                    <h4>{{ trans('messages.description_lang', [], session('locale')) }}</h4>
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
                                    <?php
                                        $pro_image=asset('images/dummy_image/no_image.png');
                                        if(!empty($product_view->stock_image))
                                        {
                                            $pro_image=asset('images/product_images/'.  $product_view->stock_image);
                                        }
                                    ?>
                                    <img src="{{ $pro_image }}">
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
