@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.edit_purchase_lang', [], session('locale')) }}</title>
@endpush

			<div class="page-wrapper">
				<div class="content">
					<div class="page-header">
						<div class="page-title">
							<h4>{{ trans('messages.edit_purchase_lang', [], session('locale')) }}</h4>
							<h6> {{ trans('messages.create_new_product_lang', [], session('locale')) }}</h6>
						</div>
					</div>
					<!-- /add -->
					<div class="card">
						<div class="card-body">
                            <div class="card-header">
                                <h5 class="card-title">{{ trans('messages.supplier_&_invoice_lang', [], session('locale')) }}</h5>
                            </div>
                            <form method="POST" action="#" class="update_purchase" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="<?php echo count($purchase_detail); ?>" class="total_product">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.invoice_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control invoice_no" readonly value="{{ $purchase_order->invoice_no }}" name="invoice_no">
                                            <span class="invoice_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.supplier_lang', [], session('locale')) }}</label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <select class="searchable_select select2 supplier_id" name="supplier_id_stk">
                                                        <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                        @foreach ($supplier as $sup)
                                                            <option value="{{$sup->id}}" {{ $purchase_order->supplier_id == $sup->id ? 'selected' : '' }}>
                                                                {{$sup->supplier_name}}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                        data-bs-target="#add_supplier_modal">
                                                            <i class="plus_i_class fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> {{ trans('messages.purchase_date_lang', [], session('locale')) }}</label>
                                            <input type="text"  class="form-control purchase_date datetimepicker" value="{{ $purchase_order->purchase_date }}" name="purchase_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.shipping_cost_lang', [], session('locale')) }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ trans('messages.OMR_lang', [], session('locale')) }}</span>
                                            <input type="text" class="form-control shipping_cost isnumber" value="{{ $purchase_order->shipping_cost }}" name="shipping_cost">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.invoice_price_lang', [], session('locale')) }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ trans('messages.OMR_lang', [], session('locale')) }}</span>
                                            <input type="text" class="form-control invoice_price isnumber" value="{{ $purchase_order->invoice_price }}" name="invoice_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>	{{ trans('messages.Invoice_Reciept_lang', [], session('locale')) }}</label>
                                            <div class="image-upload">
                                                <input type="file" name="receipt_file">
                                                <div class="image-uploads">
                                                    <img src="{{  asset('img/icons/upload.svg')}}" alt="img">
                                                    <h4> {{ trans('messages.drag_file_lang', [], session('locale')) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(!empty($purchase_order->receipt_file)){ ?>
                                            <a href="{{ url('purchase_invoice').'/'.$purchase_order->id }}" class="btn btn-info"><i
                                                class="ri-printer-line align-bottom me-1"></i>  {{ trans('messages.purchase_detail_lang', [], session('locale')) }}</a>
                                        <?php }?>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12 pb-5">
                                        <div class="form-group">
                                            <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control purchase_description" name="purchase_description" rows="4">{{ $purchase_order->purchase_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="ribbon-wrapper card">
                                            <div class="card-body">
                                                <div class="ribbon ribbon-primary">{{  trans('messages.total_price_lang', [], session('locale'))  }}</div>
                                                <h4><span id="total_price">{{ $purchase_order->total_price - $sumTotalPurchase }}</span> {{ trans('messages.OMR_lang', [], session('locale')) }}</h4>
                                                <input type="hidden" id="total_price_input" value="{{ $purchase_order->total_price - $sumTotalPurchase }}" name="total_price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="ribbon-wrapper card">
                                            <div class="card-body">
                                                <div class="ribbon ribbon-primary">{{trans('messages.total_tax_lang', [], session('locale')) }}</div>
                                                <h4><span id="total_tax">{{ $purchase_order->total_tax - $sumTax }}</span> {{ trans('messages.OMR_lang', [], session('locale')) }}</h4>
                                                <input type="hidden" id="total_tax_input" value="{{ $purchase_order->total_tax - $sumTax }}" name="total_tax">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h5 class="card-title">{{ trans('messages.Inventory_Detail_lang', [], session('locale')) }}</h5>
                                </div>
                                <?php $s=1; ?>
                                @foreach ($purchase_detail as $detail)
                                    <div class="stocks_class stock_no_{{ $s }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h1 class="pro_number"> <?php echo trans('messages.stock_lang',[],session('locale')); ?> {{$s}}</h1>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="item_remove"><i class="fa fa-trash fa-3x"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.stores_lang', [], session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-10 col-sm-10 col-10">
                                                            <select class="searchable_select select2 store_id_{{ $s }}" name="store_id_stk[]">
                                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                                    @foreach ($stores as $store) {
                                                                        <option value="{{$store->id}}" {{ $detail->store_id == $store->id ? 'selected' : '' }}>{{$store->store_name}}</option>';
                                                                    }
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                            <div class="add-icon">
                                                                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                                data-bs-target="#add_store_modal" onclick="stock_number('<?php echo $s; ?>')">
                                                                    <i class="plus_i_class fas fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.categories_lang',[],session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-10 col-sm-10 col-10">
                                                            <select class="searchable_select select2 category_id_{{ $s }}" name="category_id_stk[]">
                                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                                    @foreach ($category as $cat) {
                                                                        <option value="{{$cat->id}}" {{ $detail->category_id == $cat->id ? 'selected' : '' }}>{{$cat->category_name}}</option>';
                                                                    }
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                            <div class="add-icon">
                                                                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                                data-bs-target="#add_category_modal" onclick="stock_number('<?php echo $s; ?>')">
                                                                    <i class="plus_i_class fas fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.brands_lang',[],session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-10 col-sm-10 col-10">
                                                            <select class="searchable_select select2 brand_id_{{ $s }}" name="brand_id_stk[]">
                                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                                    @foreach ($brands as $brand) {
                                                                        <option value="{{$brand->id}}" {{ $detail->brand_id == $brand->id ? 'selected' : '' }}>{{$brand->brand_name}}</option>';
                                                                    }
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                            <div class="add-icon">
                                                                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                                data-bs-target="#add_brand_modal" onclick="stock_number('<?php echo $s; ?>')">
                                                                    <i class="plus_i_class fas fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.Product_name(en)_lang',[],session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-10 col-10">
                                                            <input type="text" value="{{ $detail->product_name }}" class="form-control product_name_{{ $s }}" name="product_name[]">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.Product_name(ar)_lang',[],session('locale'))}}</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-10 col-10">
                                                            <input type="text" value="{{ $detail->product_name_ar }}" class="form-control product_name_ar_{{ $s }}" name="product_name_ar[]">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label> {{ trans('messages.barcode_generator_lang',[],session('locale')) }} </label>
                                                    <div class="row">
                                                        <div class="col-lg-10 col-sm-10 col-10">
                                                            <input type="text" value="{{ $detail->barcode }}" onkeyup="search_barcode('<?php echo $s; ?>')" onchange="search_barcode('<?php echo $s; ?>')" class="form-control barcodes barcode_{{ $s }}" name="barcode[]">
                                                            <span class="barcode_err_{{ $s }}"></span>
                                                        </div>
                                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                            <div class="add-icon">
                                                                <a onclick="get_rand_barcode(1)">
                                                                    <i class="plus_i_class fas fa-barcode"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.purchase_price_lang',[],session('locale')) }} </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ trans('messages.OMR_lang', [], session('locale')) }}</span>
                                                    <input type="text" value="{{ $detail->purchase_price }}" class="form-control all_purchase_price purchase_price_{{ $s }} isnumber" onkeyup="get_sale_price(1)" name="purchase_price[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px"> <?php echo trans('messages.total_purchase_price_lang',[],session('locale')) ; ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"> <?php echo trans('messages.OMR_lang', [], session('locale')) ; ?></span>
                                                    <input type="text" value="{{ $detail->total_purchase }}" class="form-control all_total_purchase_price total_purchase_price_{{ $s }} isnumber" readonly name="total_purchase_price[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.tax_lang', [], session('locale')) }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">%</span>
                                                    <input type="text" value="{{ $detail->tax }}" class="form-control all_tax tax_{{ $s }} isnumber" name="tax[]">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.profit_lang',[],session('locale')) }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">%</span>
                                                    <input type="text" value="{{ $detail->profit_percent }}" class="form-control profit_percent_{{ $s }} isnumber" onkeyup="get_sale_price(1)" name="profit_percent[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.sale_price_lang',[],session('locale')) }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ trans('messages.OMR_lang', [], session('locale')) }}</span>
                                                    <input type="text" value="{{ $detail->sale_price }}" class="form-control sale_price_{{ $s }} isnumber" onkeyup="get_profit_percent(1)" name="sale_price[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <label class="form_group_input" style="margin-bottom: 10px">{{ trans('messages.min_sale_price_lang',[],session('locale')) }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ trans('messages.OMR_lang', [], session('locale')) }}</span>
                                                    <input type="text" value="{{ $detail->min_sale_price }}" class="form-control min_sale_price_{{ $s }} isnumber" name="min_sale_price[]">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.quantity_lang', [], session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-10 col-10">
                                                            <input type="text" value="{{ $detail->quantity }}" class="form-control all_qty quantity_{{ $s }} isnumber1" {{ $detail->check_imei == 1 ? 'readonly' : '' }} name="quantity[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ trans('messages.notification_limit_lang', [], session('locale')) }}</label>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-sm-10 col-10">
                                                            <input type="text" value="{{ $detail->notification_limit }}" class="form-control notification_limit_{{ $s }} isnumber1" name="notification_limit[]">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-12 pb-1">
                                                <div class="row product_radio_class" >
                                                    <label class="col-lg-6">{{ trans('messages.warranty_lang', [], session('locale')) }}</label>
                                                    <div class="col-lg-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input warranty_type_{{ $s }}" type="radio" onclick="check_warranty(1)" name="warranty_type_{{ $s }}" id="warranty_type_none_{{ $s }}" value="3" {{ $detail->warranty_type == 3 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="warranty_type_none_{{ $s }}">
                                                                {{ trans('messages.none_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input warranty_type_{{ $s }}" type="radio" onclick="check_warranty(1)" name="warranty_type_{{ $s }}" id="warranty_type_shop_{{ $s }}" value="1" {{ $detail->warranty_type == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="warranty_type_shop_{{ $s }}">
                                                                {{ trans('messages.shop_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input warranty_type_{{ $s }}" type="radio" onclick="check_warranty(1)" name="warranty_type_{{ $s }}" id="warranty_type_agent_{{ $s }}" value="2" {{ $detail->warranty_type == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="warranty_type_agent_{{ $s }}">
                                                            {{ trans('messages.agent_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12 pb-1 warranty_days_div_{{ $s }} {{ $detail->warranty_type == 3 ? 'display_none' : '' }}" >
                                                <label class="col-lg-6">{{ trans('messages.days_lang', [], session('locale')) }}</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" class="form-control warranty_days_{{ $s }}" value="{{ $detail->warranty_days }}" name="warranty_days[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12 pb-1">
                                                <div class="row product_radio_class">
                                                        <label class="checkboxs">{{ trans('messages.whole_sale_lang', [], session('locale')) }}
                                                            <input type="checkbox" onclick="check_whole_sale(1)" name="whole_sale1" value="1" id="whole_sale_{{ $s }}" {{ $detail->whole_sale == 1 ? 'checked' : '' }}>
                                                            <span class="checkmarks" for="whole_sale_{{ $s }}"></span>
                                                        </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12 pb-1 bulk_stock_div_{{ $s }} {{ $detail->whole_sale == 1 ? '' : 'display_none' }}">
                                                <label class="col-lg-6">{{ trans('messages.bulk_quantity_lang', [], session('locale')) }}</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" value="{{ $detail->bulk_quantity }}" class="form-control bulk_quantity_{{ $s }}" name="bulk_quantity[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12 pb-1 bulk_stock_div_{{ $s }} {{ $detail->whole_sale == 1 ? '' : 'display_none' }}">
                                                <label class="col-lg-6">{{ trans('messages.unit_price_lang', [], session('locale')) }}</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" value="{{ $detail->bulk_price }}" class="form-control bulk_price_{{ $s }}" name="bulk_price[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12 pb-1">
                                                <div class="row product_radio_class" >
                                                    <label class="col-lg-6">{{ trans('messages.product_type_lang', [], session('locale')) }}</label>
                                                    <div class="col-lg-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="product_type_{{ $s }}" id="product_type_retail_{{ $s }}" value="1" {{ $detail->product_type == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="product_type_retail_{{ $s }}">
                                                                {{ trans('messages.retail_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="product_type_{{ $s }}" id="product_type_spare_{{ $s }}" value="2" {{ $detail->product_type == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="product_type_spare_{{ $s }}">
                                                            {{ trans('messages.spare_parts_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-1 col-sm-6 col-12 pb-5">
                                                <div class="row product_radio_class">
                                                        <label class="checkboxs">{{ trans('messages.imei_#_lang', [], session('locale')) }}
                                                            <input type="checkbox" value="1"  onclick="check_imei(1)" name="imei_check1" id="imei_check_{{ $s }}" {{ $detail->check_imei == 1 ? 'checked' : '' }}>
                                                            <span class="checkmarks" for="imei_check_{{ $s }}"></span>
                                                        </label>
                                                </div>
                                            </div>
                                            <?php $imeis = get_purchase_imei_comma_seperated($detail->barcode); ?>
                                            <div class="col-lg-3 col-sm-6 col-12 pb-5 imei_div_{{ $s }} {{ $detail->check_imei == 1 ? '' : 'display_none' }}">
                                                <label class="col-lg-6">{{ trans('messages.imei_lang', [], session('locale')) }}</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input class="form-control imei_no_{{ $s }} tags" value="{{ $imeis }}" onchange="get_imei_qty(1)" name="imei_no[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12 pb-5 imei_div_{{ $s }} {{ $detail->check_imei == 1 ? '' : 'display_none' }}">
                                                <div class="row product_radio_class" >
                                                    <div class="col-lg-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="imei_serial_type_{{ $s }}" id="imei_type_{{ $s }}" value="1" {{ $detail->imei_serial_type == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="imei_type_{{ $s }}">
                                                                {{ trans('messages.imei_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="imei_serial_type_{{ $s }}" id="serial_type_{{ $s }}" value="2" {{ $detail->imei_serial_type == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="serial_type_{{ $s }}">
                                                            {{ trans('messages.serial_no_lang', [], session('locale')) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12 pb-5">
                                                <label class="col-lg-6"> {{ trans('messages.description_lang', [], session('locale')) }}</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <textarea class="form-control description_{{ $s }}" name="description[]" rows="5">{{ $detail->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="validationTooltip03"> {{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                                    <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                        <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                            <input type="file" class="image" onchange="return fileValidation('stock_img_{{ $s }}','stock_img_tag_{{ $s }}')"   name="stock_image_{{ $s }}" id="stock_img_{{ $s }}"  >
                                                        </span>
                                                        {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                                    </div>
                                                    <?php
                                                    if(!empty($detail->stock_image)){ $img=asset('images/product_images').'/'.$detail->stock_image; }
                                                    else { $img=asset('images/dummy_image/no_image.png'); }
                                                    ?>
                                                    {{ $detail->stock_image == "" ? '' : '' }}
                                                    <img src="{{ $img }}" id="stock_img_tag_{{ $s }}" class="im img-thumbnail module_image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $s++; ?>
                                    @endforeach
                                    <div id="more_stk"></div>
                                    <div class="row pt-5" >
                                        <div class="col-lg-12">
                                            <a  id="add_more_stk_btn" class="btn btn-cancel"> {{ trans('messages.add_stock_lang', [], session('locale')) }}</a>
                                            <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
					<!-- /add -->
				</div>
			</div>
        </div>

        {{-- supplier add modal --}}
    <div class="modal fade" id="add_supplier_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ trans('messages.add_supplier_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('add_supplier') }}" class="add_supplier" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12 col-12">
                                <div class="row">
                                    <input type="hidden" class="supplier_id" name="supplier_id">
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.supplier_name_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control supplier_name" name="supplier_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label> {{ trans('messages.supplier_phone_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control supplier_phone phone" name="supplier_phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.supplier_email_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control supplier_email" name="supplier_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.supplier_detail_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control supplier_detail" name="supplier_detail" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="validationTooltip03">{{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                            <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                    <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                    <input type="file" class="image" onchange="return fileValidation('supplier_img','supplier_img_tag')"   name="supplier_image" id="supplier_img"  >
                                                </span>

                                            </div>
                                            <img src="{{ asset('images/dummy_image/no_image.png') }}" id="supplier_img_tag" width="300px" height="100px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2 submit_form"> {{ trans('messages.submit_lang', [], session('locale')) }}</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                        </div>
                    </div>
                </form>
          </div>
        </div>
    </div>
        {{-- brand --}}
        <div class="modal fade" id="add_brand_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >{{ trans('messages.add_brand_lang', [], session('locale')) }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ url('add_brand') }}" class="add_brand" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="brand_id" name="brand_id">
                                <input type="hidden" class="stock_number" name="stock_number">
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>{{ trans('messages.brand_name_lang', [], session('locale')) }}</label>
                                        <input type="text" class="form-control brand_name" name="brand_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="validationTooltip03">{{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                        <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                <input type="file" class="image" onchange="return fileValidation('brand_img','brand_img_tag')"   name="brand_image" id="brand_img"  >
                                            </span>
                                            {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                        </div>
                                        <img src="{{ asset('images/dummy_image/no_image.png') }}" id="brand_img_tag" width="300px" height="100px">
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
        {{-- category add modal --}}
    <div class="modal fade" id="add_category_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ trans('messages.add_category_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('add_category') }}" class="add_category" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="category_id" name="category_id">
                            <input type="hidden" class="stock_number" name="stock_number">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.category_name_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control category_name" name="category_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="validationTooltip03">{{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                    <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                            <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                            <input type="file" class="image" onchange="return fileValidation('category_img','category_img_tag')"   name="category_image" id="category_img"  >
                                        </span>

                                    </div>
                                    <img src="{{ asset('images/dummy_image/no_image.png') }}" id="category_img_tag" width="300px" height="100px">
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
    {{-- Brand Modal --}}
    <div class="modal fade" id="add_store_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ trans('messages.add_store_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('add_store') }}" class="add_store" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="store_id" name="store_id">
                            <input type="hidden" class="stock_number" name="stock_number">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.store_name_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control store_name" name="store_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.store_phone_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control store_phone phone" name="store_phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.store_address_lang', [], session('locale')) }}</label>
                                    <textarea  class="form-control store_address" rows="3" name="store_address"></textarea>
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

@include('layouts.footer')
@endsection


