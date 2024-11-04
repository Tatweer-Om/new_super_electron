<!DOCTYPE html>
<?php
$locale = session('locale');
if ($locale == 'ar') {
    $dir = "dir='rtl'";
} else {
    $dir = "dir='ltr'";
}
?>
<html lang="en" <?php echo $dir; ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Repairing Page</title>

    <!-- Bootstrap CSS -->

    {{-- <link rel="stylesheet" href="{{ asset('css/rtl/bootstrap.rtl.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <?php if($locale=="ar"){ ?>
    <link rel="stylesheet" href="{{ asset('css/rtl/bootstrap.rtl.min.css') }}">
    <?php } else {?>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <?php }?>

    {{-- datapicker --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">

    <!-- Animation CSS -->
    <?php if($locale=="ar"){ ?>
    <link rel="stylesheet" href="{{ asset('css/rtl/animate.css') }}">
    <?php } else {?>
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <?php }?>
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    {{-- bootsrap 5 css --}}
    <link rel="stylesheet" href=" {{ asset('css/pos_page/dataTables.bootstrap5.min.css') }}">


    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/css/all.min.css') }}">

    {{-- datarange css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/pos_page/daterangepicker.css') }}"> --}}

    {{-- carousel css --}}
    <link rel="stylesheet" href="{{ asset('plugins/owlcarousel/owl.carousel.min.css') }}">

    {{-- theme default css --}}
    <link rel="stylesheet" href="{{ asset('css/pos_page/owl.theme.default.min.css') }}">

    {{-- toastr css --}}
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    {{-- toastr css --}}

    <?php if($locale=="ar"){ ?>
    <link rel="stylesheet" href="{{ asset('css/pos_page_rtl/style.css') }}">
    <?php } else {?>
    <link rel="stylesheet" href="{{ asset('css/pos_page/style.css') }}">
    <?php }?>

    {{-- custom css --}}
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">

</head>

<body>
    <div id="global-loader" >
        <div id="preloader-img">
            <img src="{{asset('images/system_images/logo.png')}}" alt="Logo">
        </div>
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="index.html" class="logo logo-normal">
                    <img src="assets/img/logo.png" alt>
                </a>
                <a href="index.html" class="logo logo-white">
                    <img src="assets/img/logo-white.png" alt>
                </a>
                <a href="index.html" class="logo-small">
                    <img src="assets/img/logo-small.png" alt>
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn d-none" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item nav-searchinputs">

                </li>

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>


                <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                        role="button">
                        <i data-feather="globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if($locale=="ar"){ ?>
                        <a href="{{ route('switch_language', ['locale' => 'en']) }}"
                            class="dropdown-item{{ app()->getLocale() === 'en' ? ' active' : '' }}">
                            <img src="{{ asset('img/flags/us.png') }}" alt="" height="16"> English
                        </a>
                        <a href="{{ route('switch_language', ['locale' => 'ar']) }}"
                            class="dropdown-item{{ app()->getLocale() === 'ar' ? ' active' : '' }}">
                            <img src="{{ asset('img/flags/om.png') }}" alt="" height="16"> العربية
                        </a>
                        <?php } else {?>
                        <a href="{{ route('switch_language', ['locale' => 'ar']) }}"
                            class="dropdown-item{{ app()->getLocale() === 'ar' ? ' active' : '' }}">
                            <img src="{{ asset('img/flags/om.png') }}" alt="" height="16"> العربية


                        </a>
                        <a href="{{ route('switch_language', ['locale' => 'en']) }}"
                            class="dropdown-item{{ app()->getLocale() === 'en' ? ' active' : '' }}">
                            <img src="{{ asset('img/flags/us.png') }}" alt="" height="16"> English
                        </a>
                        <?php }?>
                    </div>

                </li>
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info">
                            <span class="user-letter">
                                <img src="{{ asset('img/profiles/avator1.jpg')}}" alt="" class="img-fluid">
                            </span>
                            <span class="user-detail">
                                <span class="user-name">{{ auth()->user()->username ?? '' }}</span>
                                <span class="user-role">مدير النظام</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="{{ asset('img/profiles/avator1.jpg')}}" alt="">
                                <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ auth()->user()->username ?? '' }}</h6>
                                    <h5>مدير النظام</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <!-- <a class="dropdown-item" href="profile.html"> <i class="me-2"  data-feather="user"></i> My Profile</a> -->
                            <a class="dropdown-item" href="#"><i class="me-2" data-feather="settings"></i>الإعدادات</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html"><img src="{{ asset('img/icons/log-out.svg')}}" class="me-2" alt="img">خروج</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="general-settings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>

    <div class="page-wrapper" style="margin: 0 0 0 0;">
        <input type="hidden" class="reference_no" value="{{ $repair_detail->reference_no }}">
        <div class="content">
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center welcome-text">
                <h3 class="d-flex align-items-center"> {{ $customer_data->customer_name }} ({{ $customer_data->customer_phone }})
                {{-- <h6><span class='badges bg-lightgreen badges_table'>{{ trans('messages.purchase_date_lang', [], session('locale')) }} : {{ get_date_only($order_data->created_at)}}</span> --}}
                    {{-- <span class='badges bg-lightgreen badges_table'>{{ trans('messages.receiving_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->receive_date) }}</span> --}}
                    <span class='badges bg-lightgreen badges_table'>{{ trans('messages.deliver_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->deliver_date)}}</span></h3>

                {{-- </h6> --}}
            </div>
           <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <select class="repairing_type form-control" {{ $repair_detail->repairing_type == 1 ? 'disabled' : '' }} id="repairing_type" name="repairing_type">
                            <option {{ $repair_detail->repairing_type == 1 ? 'selected' : '' }} value="1">{{ trans('messages.repair_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->repairing_type == 2 ? 'selected' : '' }} value="2">{{ trans('messages.inspection_lang', [], session('locale')) }}</option>

                        </select>
                    </div>
                </div>
            </div>



            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <select class="change_status form-control" id="change_status" name="status">
                            <option {{ $repair_detail->status == 1 ? 'selected' : '' }} value="1">{{ trans('messages.receive_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 4 ? 'selected' : '' }} value="4">{{ trans('messages.ready_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 5 ? 'selected' : '' }} value="5">{{ trans('messages.deleivered_lang', [], session('locale')) }}</option>
                        </select>
                     </div>
                </div>
             </div>
        </div>
        <div class="welcome d-lg-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <label>{{ trans('messages.technicians_lang', [], session('locale')) }}</label>
                        <select class="searchable_select select2 technician_id" name="technician_id" multiple>
                            @foreach ($view_technicians as $tech)
                                @php

                                    $selected = in_array($tech->id, $all_technicians) ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $tech->id }}" {{ $selected }}>{{ $tech->technician_name }}</option>
                            @endforeach
                        </select>

                     </div>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="col-lg-4 col-sm-6 col-12">
                        <label> {{ trans('messages.deliver_date_lang', [], session('locale')) }}</label>
                        <input type="date"  class="form-control deliver_date datepick" id="deliver_date" value="{{  $repair_detail->deliver_date ?? ''}}" name="deliver_date">

                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="col-lg-4 col-sm-6 col-12">
                        <label> {{ trans('messages.warranty_day_lang', [], session('locale')) }}</label>
                        <input type="text"  class="form-control warranty_day"  value="<?php echo $repair_detail->warranty_day; ?>" name="warranty_day">

                </div>
            </div>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-submit me-2" id="change_deliver_date">{{ trans('messages.submit_lang', [], session('locale')) }}</button>

            </div>

        </div>
        <div class="row sales-cards">
            <div class="col-xl-3 col-sm-12 col-12">
                <div class="card d-flex align-items-center justify-content-between default-cover mb-4">
                    <div>
                        <h6>
                            @php if ($repair_detail->repairing_type == 1) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.repair_lang', [], session('locale')) . "</span>";
                            } else if ($repair_detail->repairing_type == 2) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection', [], session('locale')) . "</span>";
                            }
                            @endphp
                            <br>
                            {{ $title.' ('.$repair_detail->product_model.')' }}
                        </h6>
                        @php
                            if ($imei != "") {
                        @endphp
                            <h3><span>{{ $imei }}</span></h3>
                        @php
                            }
                        @endphp
                        @php
                            if ($repair_detail->repairing_type == 2)
                            {
                                echo trans('messages.cost_lang', [], session('locale')). ' : '. $repair_detail->inspection_cost;
                            }
                        @endphp
                     </div>
                 </div>
            </div>
            <div class="col-xl-3 col-sm-12 col-12">
                <div style="height:156.52px!important;overflow-y: auto;padding:10px!important " class="card d-flex align-items-center justify-content-between default-cover mb-4">
                    <div>
                        <h6 style="white-space: preline">{{ trans('messages.notes_lang', [], session('locale')) }} : <br>{{ $repair_detail->notes }}</h6>
                    </div>
                 </div>
            </div>
            @php if($repair_detail->repairing_type==1){ @endphp
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-primary mb-4">
                        <i class="fas fa-wifi fa-3x"></i>
                        <h3 class="counters" data-count="{{$pro_sum }}" id="total_product">{{$pro_sum }}</h3>
                        <p>{{ trans('messages.total_product_lang', [], session('locale')) }}</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card color-info bg-secondary mb-4">
                        <i class="fas fa-tools fa-3x"></i>
                        <h3 class="counters" data-count="{{$serv_sum }}" id="total_service">{{$serv_sum }}</h3>
                        <p>{{ trans('messages.total_service_lang', [], session('locale')) }}</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
                    </div>
                </div>
            @php } @endphp
        </div>


        {{-- add pro and service for reparing --}}
        @php if($repair_detail->repairing_type==1){ @endphp
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.services_lang', [], session('locale')) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <select class="searchable_select select2 service_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                        @foreach ($view_service as $srv)
                                            <option value="{{$srv->id}}">{{$srv->service_name}}</option>;
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                <div class="add-icon">
                                    <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                    data-bs-target="#add_service_modal">
                                        <i class="plus_i_class fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.service_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>
                                <tbody id="service_tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.products_lang', [], session('locale')) }}</h4>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <select class="searchable_select select2 product_id">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                    @foreach ($view_product as $pro)
                                        @php
                                            $title = !empty($pro->product_name) ? $pro->product_name : $pro->product_name_ar;
                                        @endphp
                                        <option value="{{ $pro->id }}">{{ $title.'-'.$pro->barcode }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>
                                <tbody id="product_tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php }  @endphp
        <div class="row" id="issuetype_div">
            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.issuetype_lang', [], session('locale')) }}</h4>
                    </div>
                    <div class="card-body">
                        @php if($repair_detail->repairing_type==2){ @endphp
                            <div class="row">
                                <div class="col-lg-12 col-sm-10 col-10">
                                    <select class="searchable_select select2 issuetype_id">
                                        <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                            @foreach ($view_issuetype as $iss)
                                                <option value="{{$iss->id}}">{{$iss->issuetype_name}}</option>;
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        @php } @endphp
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.issuetype_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                    </tr>
                                </thead>
                                <tbody id="issuetype_tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         {{-- total s --}}
         <div class="btn-row d-sm-flex align-items-center justify-content-between">
            <table class="table" style="width:20%!important">
                <thead>
                    <tr>
                        <th class="td_font">{{ trans('messages.total_lang', [], session('locale')) }} </th>
                        <th class="td_font "><input class="form-control total_subtotal" readonly ></th>
                    </tr>
                    <tr style="display: none">
                        <th class="td_font">{{ trans('messages.cost_lang', [], session('locale')) }} </th>
                        <th class="td_font "><input class="form-control total_inspectioncost" readonly ></th>
                    </tr>
                    <tr>
                        <th class="td_font"> {{ trans('messages.discount_lang', [], session('locale')) }} </th>
                        <th class="td_font "><input class="form-control totaldiscount" ></th>
                    </tr>
                    <tr>
                        <th class="td_font"> {{ trans('messages.grand_total_lang', [], session('locale')) }}</th>
                        <th class="td_font "><input class="form-control total_grandtotal" readonly ></th>
                    </tr>
                </thead>
            </table>

        </div>
        {{--  --}}

        @php
        if (!$status_history_record=="") {
        @endphp

    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ trans('messages.status_history_lang', [], session('locale')) }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless recent-transactions">
                            <thead>
                                <tr>
                                    <th>{{ trans('messages.status_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.add_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.added_by_lang', [], session('locale')) }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php echo $status_history_record; @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        }
    @endphp
    @php
    if (!$repairing_history_record=="") {
    @endphp
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ trans('messages.repairing_history_lang', [], session('locale')) }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless recent-transactions">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.receiving_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.deliver_date_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php echo $repairing_history_record; @endphp
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        }
    @endphp





        </div>
        </div>
        <div class="customizer-links">
        <ul class="sticky-sidebar">
        <li class="sidebar-icons">
        <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Theme">
        <i data-feather="settings" class="feather-five"></i>
        </a>
        </li>
        </ul>
        </div>
        </div>

{{-- service add modal --}}
<div class="modal fade" id="add_service_modal" tabindex="-1" aria-labelledby="create"  aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ trans('messages.create_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('add_service') }}" class="add_service" method="POST" enctype="multipart/form-data">
                 @csrf

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="new_service_id" name="service_id">
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_name_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control service_name" name="service_name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_cost_lang', [], session('locale')) }}</label>
                                    <input type="text" class="form-control service_cost cost" name="service_cost">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>{{ trans('messages.service_detail_lang', [], session('locale')) }}</label>
                                    <textarea  class="form-control service_detail" rows="3" name="service_detail"></textarea>
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

{{-- <script src="{{ asset('js/pos_page/jquery-3.7.1.min.js')}}" type="7a3fc97ac244f422b7ec338a-text/javascript"></script> --}}
   <script src="{{  asset('js/jquery-3.6.0.min.js')}}"></script>
   <!-- jQuery UI library -->
   <script src="{{  asset('js/jquery-ui.min.js')}}"></script>    <!-- Feather Icon JS -->
   <script src="{{ asset('js/pos_page/feather.min.js') }}"></script>

   <!-- Slimscroll JS -->
   <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

   <!-- Datatable JS -->
   <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('js/pos_page/dataTables.bootstrap5.min.js') }}"></script>


   <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
   <script src="{{ asset('plugins/toastr/toastr.js') }}"></script>

   <!-- Bootstrap Core JS -->
   <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

   <!-- Chart JS -->
   <script src="{{ asset('js/apexcharts.min.js') }}"></script>
   <script src="{{ asset('js/chart-data.js') }}"></script>

   <!-- Datetimepicker JS -->
   <script src="{{  asset('js/moment.min.js')}}"></script>
   <script src="{{  asset('js/bootstrap-datetimepicker.min.js')}}"></script>

   {{-- caousel js --}}
   <script src="{{ asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>


   <!-- Select2 JS -->
   <script src="{{ asset('js/select2.min.js') }}"></script>
   <script src="{{ asset('plugins/select2/js/custom-select.js') }}"></script>

   <!-- Sweetalert 2 -->
   <script src="{{ asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
   <script src="{{ asset('plugins/sweetalert/sweetalerts.min.js') }}"></script>

   {{-- theme script --}}
   <script src="{{ asset('js/pos_page/theme-script.js') }}"></script>

   {{-- script js --}}
   <script src="{{ asset('js/pos_page/script.js') }}"></script>

   {{-- rocket loader --}}
   <script src="{{ asset('js/pos_page/rocket-loader.min.js') }}" data-cf-settings="7a3fc97ac244f422b7ec338a-|49" defer>
   </script>

   {{-- custom js --}}
   @include('custom_js.custom_js')
   {{-- Include the JavaScript file for pos --}}

   {{-- js --}}

   @include('custom_js.add_local_maintenance_js')


</body>

</html>
