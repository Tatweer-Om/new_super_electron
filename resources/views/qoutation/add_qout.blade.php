@extends('layouts.header')

@section('main')
@push('title')
<title>{{ trans('messages.add_qout_lang', [], session('locale')) }}</title>
@endpush




    {{-- <div class="page-content"> --}}
        {{-- <div class="container-fluid"> --}}



    <div class="page-wrapper">
		<div class="content">


            <div class="row justify-content-center">
                <div class="col-xxl-9">
                    <div class="card">
                        <form action="#" method="POST">


                            @csrf
                            <div class="card-body border-bottom border-bottom-dashed p-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row g-3">


                                            <div class="col-lg-8 col-sm-6">
                                                <label for="invoiceNumberInput">Invoice Number </label>
                                                <input type="text" class="form-control bg-light border-0"
                                                {{-- id="invoiceNumberInput" value="{{ $invoice_no }}" placeholder="Invoice Number" --}}
                                                 aria-hidden="true" name="invoice_no" readonly >

                                            </div>

                                            <div class="col-lg-8 col-sm-6">
                                                <div>
                                                    <label for="date-field">Invoice Date</label>
                                                    <input type="text"
                                                        class="form-control bg-light border-0 flatpickr-input date_picker"
                                                        id="date-field" data-provider="flatpickr" data-time="true"
                                                        placeholder="Select Date-time" readonly name="date" >
                                                    @error('date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-6">
                                                <div>
                                                    <label for="date-field">Project Delivery Date</label>
                                                    <input type="text"
                                                        class="form-control bg-light border-0 date_picker"
                                                        id="date-field"  data-time="true" readonly
                                                        placeholder="Select Date-time" name="delivery_date" >

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4 ms-auto">
                                        <div class="profile-user mx-auto  mb-3">
                                            <input id="profile-img-file-input" type="file"
                                                class="profile-img-file-input" />
                                            <label for="profile-img-file-input" class="d-block" tabindex="0">
                                                <span
                                                    class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded"
                                                    style="height: 100px; width: 280px;">
                                                    <img src="{{ asset('images/tatweer_logo/logo.png') }}"
                                                        class="card-logo card-logo-dark user-profile-image img-fluid"
                                                        alt="logo dark">

                                                    <img src="{{ asset('images/logo-light.png') }}"
                                                        class="card-logo card-logo-light user-profile-image img-fluid"
                                                        alt="logo light">
                                                </span>
                                            </label>
                                        </div>
                                        <div style="display: none">
                                            <select id="services_select" type="text"
                                                class="form-control bg-light border-0 service-select"
                                                  placeholder="Service Name"
                                                name="service_name[]">
                                                <option value="" disabled selected>Select Service
                                                </option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" >
                                                        {{ $service->service_name }}</option>
                                                @endforeach
                                            </select>

                                             <select id="products_select" type="text" class="form-control bg-light border-0 product-select"  name="product_name[]">
                                                <option value="" disabled selected>Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                         <div class="d-flex justify-content-between align-items-center">
                                            <label for="companyAddress">Client's Details</label>
                                            <a href="#"

                                                class="btn btn-warning mb-3"
                                                style="font-size: 12px; padding: 4px 8px; font-weight: bold; color: black;"

                                                        <i>+Add Client</i>
                                            </a>
                                            </a>
                                        </div>

                                        <div class="mb-2">
                                             <select type="text" class="form-control bg-light border-0 data-live-search="true" "
                                                name="client_name" id="clientSelect">

                                                <option value="" disabled selected>Select Client</option>

                                                @foreach ($customers as $customer)
                                                    <option value="{{  $customer->id}}"> {{ $customer->name }}</option>
                                                @endforeach

                                            </select>


                                            @error('client_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0" readonly
                                                id="companyName" placeholder="Company's Name" name="company_name"  />

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
                                                    Products And Services Detail
                                                </th>
                                                <th scope="col">Unit Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total Price</th>
                                                <th scope="col">Warranty</th>
                                                <th scope="col">Details </th>
                                                <th scope="col">Remove</th>
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
                                                            name="total_price[]" />
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
                                                    <textarea class="form-control bg-light border-0" name="product_detail[]" id="productDetails-1" rows="2"
                                                        placeholder="Product Details"></textarea>
                                                </td>


                                                <td class="product-removal">
                                                    <a href="javascript:void(0)" class="btn btn-success" onclick="deleteRow"><i class="ri-delete-bin-3-line"></i></a>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="5">
                                                    <a href="javascript:new_link()" id="add-item"
                                                        onclick="addNewRow()"
                                                        class="btn btn-warning " style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;"<i> +Add Item </i>
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
                                                                class="form-control bg-light border-0 service_price"
                                                                id="service_price-1" placeholder="OMR 0.00"
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
                                                                id="total_service-1" placeholder="OMR 0.00"
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
                                                        <textarea class="form-control bg-light border-0" name="service_detail[]" id="productDetails-1" rows="2"
                                                            placeholder="Service Details"></textarea>
                                                    </td>

                                                    <td class="service-removal">
                                                        <a href="javascript:void(0)" class="btn btn-success"
                                                            onclick="deleteRow"><i class=" ri-delete-bin-3-line"></i> </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5">
                                                        <a href="javascript:void(0)" id="addService"
                                                            onclick="addNewServiceRow()"
                                                          class="btn btn-warning" style="font-size: 12px; padding: 5px 10px; font-weight: bold; color: black;" <i>+Add Item</i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </div>

                                        <tbody>



                                            <tr class="border-top border-top-dashed mt-2">
                                            <td colspan="5">

                                            </td>
                                                <td colspan="5" class="p-0">
                                                    <table
                                                        class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                        <tbody>



                                                            <tr>
                                                                <th scope="row">Sub Total </th>
                                                                <td style="width:150px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0"
                                                                        id="cart-subtotal" placeholder="OMR 0.00"
                                                                        name="total_amount" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Shipping Cost</th>
                                                                <td style="width:150px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0"
                                                                        id="shipping" placeholder="OMR 0.00"
                                                                        name="shipping_cost" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Tax % </th>
                                                                <td style="width:150px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0"
                                                                        id="tax" placeholder="OMR 0.00"
                                                                        name="tax" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Grand Total</th>
                                                                <td style="width:150px;">
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0"
                                                                        id="cart-subtotal" placeholder="OMR 0.00"
                                                                        name="tax" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"> Amount Paid</th>
                                                                <td style="width:150px;">
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0"
                                                                        id="grand_total" placeholder="OMR 0.00"
                                                                        name="grand_total" />
                                                                </td>
                                                            </tr>
                                                            <tr class="border-top border-top-dashed">
                                                                <th scope="row">Remaining Amount</th>
                                                                <td>
                                                                    <input type="text" readonly
                                                                        class="form-control bg-light border-0"
                                                                        id="cart-total" placeholder="OMR0.00"
                                                                        name="remaining_amount" />
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
                                    <button type="submit" class="btn btn-info"><i
                                            class="ri-printer-line align-bottom me-1"></i> Save</button>
                                    <a href="javascript:void(0);" class="btn btn-primary"><i
                                            class="ri-download-2-line align-bottom me-1"></i> Download Invoice</a>
                                    <a href="javascript:void(0);" class="btn btn-danger"><i
                                            class="ri-send-plane-fill align-bottom me-1"></i> Send Invoice</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->
            </div>

        </div>

    </div>


@include('layouts.footer')
@endsection
