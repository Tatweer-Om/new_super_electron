@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.qout_lang', [], session('locale')) }}</title>
@endpush

    <div class="page-wrapper">
		<div class="content">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="card">
                        <form>
                            <div class="card-body border-bottom border-bottom-dashed p-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-sm-4">
                                                <div>
                                                    <label for="date-field">التاريخ</label>
                                                    <input type="date"
                                                        class="form-control bg-light border-0 datepick"
                                                        id="date-field" data-time="true"
                                                        placeholder="Select Date-time" name="date" >
                                                    @error('date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ms-auto">
                                        <div class="profile-user mx-auto  mb-3">

                                            <label for="profile-img-file-input" class="d-block" tabindex="0">
                                                <span
                                                    class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded"
                                                    style="height: 100px; width: 280px;">
                                                    <img src="{{ asset('images/system_images/logo.png') }}"
                                                        class="card-logo card-logo-dark user-profile-image img-fluid"
                                                        alt="logo dark">

                                                    <img src="{{ asset('images/logo-light.png') }}"
                                                        class="card-logo card-logo-light user-profile-image img-fluid"
                                                        alt="logo light">
                                                </span>
                                            </label>
                                        </div>

                                         <div class="d-flex justify-content-between align-items-center">
                                            <label for="companyAddress">بيانات العميل</label>

                                        </div>
                                        <div >
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control bg-light border-0 add_customer"
                                                    id="add_customer">
                                                </div>
                                                <div class="col-lg-2">
                                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon"
                                                    data-bs-toggle="modal" data-bs-target="#add_customer_modal"><i
                                                        data-feather="user-plus" class="feather-16"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="invoice-table table table-borderless table-nowrap mb-0">
                                        <thead class="align-middle">
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;"></th>
                                                <th scope="col">
                                                    المنتجات والخدمات
                                                </th>
                                                <th scope="col">سعر الوحدة</th>
                                                <th scope="col">الكمية</th>
                                                <th scope="col">إجمالي</th>
                                                <th scope="col">الضمان</th>
                                                <th scope="col">تفاصيل إضافية </th>
                                                <th scope="col">إزالة</th>
                                            </tr>
                                        </thead>
                                        <tbody id="newlink">
                                            <tr id="1" class="product">
                                                <td></td>
                                                <td class="text-start">
                                                    <div class="mb-2">
                                                        <input type="text"
                                                        class="form-control bg-light border-0 product_select"
                                                        id="product_select-1" placeholder="Select Product"
                                                        name="product_select[]" />
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 product-line-price"
                                                            id="productPrice-1" placeholder="OMR 0.00"
                                                            name="product_amount[]" />
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <input type="text"
                                                    class="form-control bg-light border-0 quantity"
                                                    id="quantity-1" placeholder=""
                                                    name="quantity[]" />
                                                </td>
                                                <td class="text-end">
                                                    <div>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 total_price"
                                                            id="total_price-1" placeholder="OMR 0.00"
                                                            name="total_price[]" readonly />
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 product_warranty"
                                                            id="product_warranty-1"
                                                            name="product_warranty[]" />
                                                    </div>
                                                </td>

                                                <td>
                                                    <textarea class="form-control bg-light border-0 product_detail" name="product_detail[]" id="productDetails-1" rows="2"
                                                        placeholder="Product Details"></textarea>
                                                </td>


                                                <td class="product-removal">
                                                    <a href="javascript:void(0)"  onclick="deleteRow"><i class="fas fa-trash fa-lg"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="10">
                                                    <a href="javascript:" id="add-item"
                                                        onclick="addNewRow()"
                                                        class="btn btn-warning " style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;" <i> +منتج جديد </i>
                                                </td>
                                            </tr>

                                        </tbody>

                                        <div id="serviceTable">
                                            <tbody id="serviceRows">

                                                <tr id="serviceRow-1" class="service">
                                                    <td></td>
                                                    <td class="text-start">
                                                        <div class="mb-2">
                                                            <input type="text"
                                                            class="form-control bg-light border-0 service_select"
                                                            id="service_select-1" placeholder="Select service"
                                                            name="service_select[]" />
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div>
                                                            <input type="text"
                                                                class="form-control bg-light border-0 service-line-price"
                                                                id="servicePrice-1" placeholder="OMR 0.00"
                                                                name="service_price[]" />
                                                        </div>
                                                    </td>

                                                    <td class="text-end">
                                                        <input type="text"
                                                        class="form-control bg-light border-0 service_quantity"
                                                        id="service_quantity-1" placeholder=""
                                                        name="service_quantity[]" />
                                                    </td>
                                                    <td class="text-end">
                                                        <div>
                                                            <input type="text"
                                                                class="form-control bg-light border-0 total_service"
                                                                id="total_service-1" placeholder="OMR 0.00" readonly
                                                                name="total_service[]" />
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div>
                                                            <input type="text"
                                                                class="form-control bg-light border-0 service_warranty"
                                                                id="service_warranty-1"
                                                                name="service_warranty[]" />
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <textarea class="form-control bg-light border-0 service_detail" name="service_detail[]" id="productDetails-1" rows="2"
                                                            placeholder="Service Details"></textarea>
                                                    </td>

                                                    <td class="service-removal">
                                                        <a href="javascript:void(0)"
                                                            onclick="deleteRow"><i class="fas fa-trash fa-lg"></i> </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5">
                                                        <a href="javascript:void(0)" id="addService"
                                                            onclick="addNewServiceRow()"
                                                          class="btn btn-warning" style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;" <i>+إضافة خدمة</i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </div>

                                        <tbody>

                                            <tr class="border-top border-top-dashed mt-2">
                                            <td colspan="6">
                                            </td>
                                                <td colspan="5" class="p-0">
                                                    <table
                                                        class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                        <tbody>

                                                            <tr>
                                                                <th class=" align-middle">المجموع الفرعي </th>
                                                                <td style="width:200px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0 sub_total"
                                                                        id="cart-subtotal" placeholder="OMR 0.00"
                                                                        name="total_amount" />
                                                                </td>
                                                            </tr>
                                                            <tr >
                                                                {{-- <th class=" align-middle">Shipping Cost (OMR) </th> --}}
                                                                <td style="width:200px;">
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0 shipping"
                                                                        id="shipping" placeholder="OMR 0.00"
                                                                        name="shipping_cost" style="display: none;"/>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                {{-- <th class=" align-middle">Grand Total (OMR) </th> --}}
                                                                <td style="width:200px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0 grand_total"
                                                                        id="grand_total" placeholder="OMR 0.00"
                                                                        name="grand_total" style="display: none;"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                {{-- <th class=" align-middle"> Amount Paid (OMR) </th> --}}
                                                                <td style="width:200px;">
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0 paid"
                                                                        id="paid" placeholder="OMR 0.00"
                                                                        name="paid" style="display: none;"/>
                                                                </td>
                                                            </tr>
                                                            <tr class="border-top border-top-dashed">
                                                                {{-- <th class=" align-middle">Remaining Amount (OMR) </th> --}}
                                                                <td style="width:200px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0 remaining_amount"
                                                                        id="remaining" placeholder="OMR 0.00"
                                                                        name="remaining_amount" style="display: none;"/>
                                                                </td>
                                                            </tr>


                                                        </tbody>


                                                    </table>
                                                </div>


                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                 <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <button type="submit" class="btn btn-info" id="add_qout">
                                        <i class="ri-printer-line align-bottom me-1"></i> Save
                                    </button>
                                    <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> View Invoice</a>

                                    {{-- <a href="javascript:void(0);" class="btn btn-danger"><i
                                            class="ri-send-plane-fill align-bottom me-1"></i> Send Invoice</a> --}}
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!--end col-->
            </div>

        </div>

    </div>
    <div class="modal fade modal-default" id="add_customer_modal" aria-labelledby="add_customer_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('add_customer') }}" class="add_customer_form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="row pb-3">
                                    <input type="hidden" class="customer_id" name="customer_id">
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_name_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_name"
                                                name="customer_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_phone_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_phone phone"
                                                name="customer_phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_email_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_email"
                                                name="customer_email">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.national_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control national_id"
                                                name="national_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> {{ trans('messages.customer_number_generator_lang',[],session('locale')) }} </label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <input type="text" onkeyup="search_barcode('1')" onchange="search_barcode('1')" class="form-control customer_number barcode_1" name="customer_number">
                                                    <span class="barcode_err_1"></span>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a onclick="get_rand_barcode(1)">
                                                            <i class="plus_i_class fas fa-user"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  pb-3">
                                    <div class="col-lg-12 col-sm-6 col-12 ">
                                        <div class="row product_radio_class">
                                            <label
                                                class="col-lg-6">{{ trans('messages.customer_type_lang', [], session('locale')) }}</label>
                                            <div class="col-lg-10">
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio"
                                                        onclick="check_customer()" name="customer_type"
                                                        id="customer_type_general" value="4" checked>
                                                    <label class="form-check-label" for="customer_type_none">
                                                        {{ trans('messages.genral_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio"
                                                        onclick="check_customer()" name="customer_type"
                                                        id="customer_type_student" value="1">
                                                    <label class="form-check-label" for="customer_type_student">
                                                        {{ trans('messages.customer_student_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio"
                                                        onclick="check_customer()" name="customer_type"
                                                        id="customer_type_teacher" value="2">
                                                    <label class="form-check-label" for="customer_type_teacher">
                                                        {{ trans('messages.customer_teacher_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio"
                                                        onclick="check_customer()" name="customer_type"
                                                        id="customer_type_employee" value="3">
                                                    <label class="form-check-label" for="customer_type_employee">
                                                        {{ trans('messages.customer_employee_lang', [], session('locale')) }}
                                                    </label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="student_detail display_none">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-10 col-10">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 student_university"
                                                name="student_university">
                                                <option value="">
                                                    {{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($universities as $university)
                                                    <option value="{{ $university->id }}">
                                                        {{ $university->university_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <label
                                                class="col-lg-6">{{ trans('messages.student_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control student_id" name="student_id">
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="validationTooltip03">
                                                    {{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                                <div class="fileinput fileinput-new input-group"
                                                    data-provides="fileinput">
                                                    <span class="input-group-addon fileupload btn btn-submit"
                                                        style="width: 100%">
                                                        <input type="file" class="image"
                                                            onchange="return fileValidation('customer_img','img_tag')"
                                                            name="customer_image" id="customer_img">
                                                    </span>
                                                </div>
                                                <img src="{{ asset('images/dummy_image/no_image.png') }}"
                                                    class="img_tags" id="img_tag" width="300px" height="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="teacher_detail display_none pb-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-10 col-10">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 teacher_university"
                                                name="teacher_university">
                                                <option value="">
                                                    {{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($universities as $university)
                                                    <option value="{{ $university->id }}">
                                                        {{ $university->university_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="employee_detail display_none pb-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-10 col-10">
                                            <label
                                                class="col-lg-6">{{ trans('messages.choose_workplace_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 employee_workplace"
                                                name="employee_workplace">
                                                <option value="">
                                                    {{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($workplaces as $workplace)
                                                    <option value="{{ $workplace->id }}">
                                                        {{ $workplace->workplace_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <label
                                                class="col-lg-6">{{ trans('messages.employee_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control employee_id"
                                                name="employee_id">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_detail_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control customer_detail" name="customer_detail" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit"
                                    class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    @endsection


