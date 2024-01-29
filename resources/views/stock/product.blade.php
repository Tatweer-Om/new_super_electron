@extends('layouts.header')

@section('main')
@push('title')
<title> Purchase</title>
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
							<h4>Product Add</h4>
							<h6>Create new product</h6>
						</div>
					</div>
					<!-- /add -->
					<div class="card">
						<div class="card-body">
                            <div class="card-header">
                                <h5 class="card-title">Supplier & Invoice</h5>
                            </div>
                            <form method="POST" action="#" class="add_purchase_product" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Invoice #</label>
                                            <input type="text" class="form-control invoice_no" name="invoice_no">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <select class="searchable_select select2 supplier_id" name="supplier_id_stk">
                                                        <option value="">Choose...</option>
                                                            @foreach ($supplier as $sup) {
                                                                <option value="{{$sup->supplier_id}}">{{$sup->supplier_name}}</option>';
                                                            }
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
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Purchase Date</label>
                                            <input type="text"  class="form-control purchase_date datetimepicker" value="<?php echo date('Y-m-d'); ?>" name="purchase_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Shipping Cost</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" class="form-control shipping_cost isnumber" name="shipping_cost">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>	Invoice Receipt</label>
                                            <div class="image-upload">
                                                <input type="file" name="receipt_file">
                                                <div class="image-uploads">
                                                    <img src="{{  asset('img/icons/upload.svg')}}" alt="img">
                                                    <h4>Drag and drop a file to upload</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12 pb-5">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea class="form-control purchase_description" name="purchase_description" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="ribbon-wrapper card">
                                            <div class="card-body">
                                                <div class="ribbon ribbon-primary">Total Price</div>
                                                <h4><span id="total_price">0.000</span> OMR</h4>
                                                <input type="hidden" id="total_price_input" name="total_price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="ribbon-wrapper card">
                                            <div class="card-body">
                                                <div class="ribbon ribbon-primary">Total Tax</div>
                                                <h4><span id="total_tax">0.000</span> OMR</h4>
                                                <input type="hidden" id="total_tax_input" name="total_tax">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h5 class="card-title">Inventory Detail</h5>
                                </div>
                                <div class="stocks_class stock_no_1">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h1 class="pro_number">Stock 1</h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Stores</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        <select class="searchable_select select2 store_id_1" name="store_id_stk[]">
                                                            <option value="">Choose...</option>
                                                                @foreach ($stores as $store) {
                                                                    <option value="{{$store->store_id}}">{{$store->store_name}}</option>';
                                                                }
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                        <div class="add-icon">
                                                            <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                            data-bs-target="#add_store_modal" onclick="stock_number('1')">
                                                                <i class="plus_i_class fas fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Categories</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        <select class="searchable_select select2 category_id_1" name="category_id_stk[]">
                                                            <option value="">Choose...</option>
                                                                @foreach ($category as $cat) {
                                                                    <option value="{{$cat->category_id}}">{{$cat->category_name}}</option>';
                                                                }
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                        <div class="add-icon">
                                                            <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                            data-bs-target="#add_category_modal" onclick="stock_number('1')">
                                                                <i class="plus_i_class fas fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Brands</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        <select class="searchable_select select2 brand_id_1" name="brand_id_stk[]">
                                                            <option value="">Choose...</option>
                                                                @foreach ($brands as $brand) {
                                                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>';
                                                                }
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                        <div class="add-icon">
                                                            <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                            data-bs-target="#add_brand_modal" onclick="stock_number('1')">
                                                                <i class="plus_i_class fas fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Product Name (en)</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" class="form-control product_name_1" name="product_name[]">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Product Name (ar)</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" class="form-control product_name_ar_1" name="product_name[]">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Barcode Generator</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        <input type="text" class="form-control barcode_1" name="barcode[]">
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
                                </div>

                                    <div class="row">

                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <label class="form_group_input" style="margin-bottom: 10px">Purchase Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">OMR</span>
                                                <input type="text" class="form-control all_purchase_price purchase_price_1 isnumber" onkeyup="get_sale_price(1)" name="purchase_price[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12">
                                            <label class="form_group_input" style="margin-bottom: 10px">Profit</label>
                                            <div class="input-group">
                                                <span class="input-group-text">%</span>
                                                <input type="text" class="form-control profit_percent_1 isnumber" onkeyup="get_sale_price(1)" name="profit_percent[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <label class="form_group_input" style="margin-bottom: 10px">Sale Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">OMR</span>
                                                <input type="text" readonly class="form-control sale_price_1 isnumber" name="sale_price[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <label class="form_group_input" style="margin-bottom: 10px">Minnimum Sale Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">OMR</span>
                                                <input type="text" class="form-control min_sale_price_1 isnumber" name="min_sale_price[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12">
                                            <label class="form_group_input" style="margin-bottom: 10px">Tax</label>
                                            <div class="input-group">
                                                <span class="input-group-text">%</span>
                                                <input type="text" class="form-control all_tax tax_1 isnumber" name="tax[]">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" class="form-control quantity_1 isnumber1" name="quantity[]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Notification Limit</label>
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-10 col-10">
                                                        <input type="text" class="form-control notification_limit_1 isnumber1" name="notification_limit[]">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="row product_radio_class" >
                                                <label class="col-lg-4">Product Type : </label>
                                                <div class="col-lg-8">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="product_type[]" id="product_type_retail_1" value="1" checked>
                                                        <label class="form-check-label" for="product_type_retail_1">
                                                        Retail
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="product_type[]" id="product_type_spare_1" value="2">
                                                        <label class="form-check-label" for="product_type_spare_1">
                                                        Spare Parts
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12 pb-5">
                                            <div class="row product_radio_class" >
                                                <label class="col-lg-4">Warranty Type : </label>
                                                <div class="col-lg-8">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input warranty_type_1" type="radio" onclick="check_warranty(1)" name="warranty_type[]" id="warranty_type_none_1" value="3" checked>
                                                        <label class="form-check-label" for="warranty_type_none_1">
                                                        None
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input warranty_type_1" type="radio" onclick="check_warranty(1)" name="warranty_type[]" id="warranty_type_shop_1" value="1" >
                                                        <label class="form-check-label" for="warranty_type_shop_1">
                                                        Shop
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input warranty_type_1" type="radio" onclick="check_warranty(1)" name="warranty_type[]" id="warranty_type_agent_1" value="2">
                                                        <label class="form-check-label" for="warranty_type_agent_1">
                                                        Agent
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12 pb-5 warranty_days_div_1 display_none" >
                                            <label class="col-lg-6">Days</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control warranty_days_1" name="warranty_days[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12 pb-5">
                                            <div class="row product_radio_class">
                                                    <label class="checkboxs">Whole Sale
                                                        <input type="checkbox" onclick="check_whole_sale(1)" name="whole_sale1" value="1" id="whole_sale_1">
                                                        <span class="checkmarks" for="whole_sale_1"></span>
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 pb-5 bulk_stock_div_1 display_none">
                                            <label class="col-lg-6">Bulk Quantity</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control bulk_quantity_1" name="bulk_quantity[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 pb-5 bulk_stock_div_1 display_none">
                                            <label class="col-lg-6">Unit Price</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control bulk_price_1" name="bulk_price[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-1 col-sm-6 col-12 pb-5">
                                            <div class="row product_radio_class">
                                                    <label class="checkboxs">IMEI #
                                                        <input type="checkbox" value="1"  onclick="check_imei(1)" name="imei_check1" id="imei_check_1">
                                                        <span class="checkmarks" for="imei_check_1"></span>
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12 pb-5 imei_div_1 display_none">
                                            <label class="col-lg-6">IMEI</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input class="form-control imei_no_1 tags" name="imei_no[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12 pb-5">
                                            <label class="col-lg-6">Description</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <textarea class="form-control description_1" name="description[]" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="validationTooltip03">Upload Image</label>
                                                <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                    <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                        <input type="file" class="image" onchange="return fileValidation('stock_img_1','stock_img_tag_1')"   name="stock_image_1" id="stock_img_1"  >
                                                    </span>
                                                    {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                                </div>
                                                <img src="{{ asset('images/dummy_image/no_image.png') }}" id="stock_img_tag_1" width="200px" height="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="more_stk"></div>
                                <div class="row pt-5" >
                                    <div class="col-lg-12">
                                        <a  id="add_more_stk_btn" class="btn btn-cancel">Add Stock</a>
                                        <button type="submit" class="btn btn-submit me-2 submit_form">Submit</button>
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
                        <h5 class="modal-title" >Add Supplier</h5>
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
                                                <label>supplier Name</label>
                                                <input type="text" class="form-control supplier_name" name="supplier_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>supplier Phone</label>
                                                <input type="text" class="form-control supplier_phone phone" name="supplier_phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>supplier Email</label>
                                                <input type="text" class="form-control supplier_email" name="supplier_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label>supplier Detail</label>
                                                <textarea class="form-control supplier_detail" name="supplier_detail" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="validationTooltip03">Upload Image</label>
                                                <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                     <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                        <input type="file" class="image" onchange="return fileValidation('supplier_img','supplier_img_tag')"   name="supplier_image" id="supplier_img"  >
                                                    </span>
                                                    {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                                </div>
                                                <img src="{{ asset('images/dummy_image/no_image.png') }}" id="supplier_img_tag" width="300px" height="100px">
                                            </div>
                                        </div>
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
        {{-- brand --}}
        <div class="modal fade" id="add_brand_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" >Add Brand</h5>
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
                                            <label>brand Name</label>
                                            <input type="text" class="form-control brand_name" name="brand_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="validationTooltip03">Upload Image</label>
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
                                    <button type="submit" class="btn btn-submit me-2 submit_form">Submit</button>
                                    <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
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
                        <h5 class="modal-title" >Add Category</h5>
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
                                        <label>Category Name</label>
                                        <input type="text" class="form-control category_name" name="category_name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="validationTooltip03">Upload Image</label>
                                        <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                             <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                <input type="file" class="image" onchange="return fileValidation('category_img','category_img_tag')"   name="category_image" id="category_img"  >
                                            </span>
                                            {{-- <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> --}}
                                        </div>
                                        <img src="{{ asset('images/dummy_image/no_image.png') }}" id="category_img_tag" width="300px" height="100px">
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
    {{-- Brand Modal --}}
    <div class="modal fade" id="add_store_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Add Store</h5>
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


