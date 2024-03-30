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
    <link rel="stylesheet" href="{{ asset('css/pos_page_rtl/bootstrap.rtl.min.css') }}">
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
    <link rel="stylesheet" href="{{ asset('css/pos_page/daterangepicker.css') }}">

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


    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
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
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#" class="dropdown">
                            <div class="searchinputs dropdown-toggle" id="dropdownMenuClickable"
                                data-bs-toggle="dropdown" data-bs-auto-close="false">
                                <input type="text" placeholder="Search">
                                <div class="search-addon">
                                    <span><i data-feather="x-circle" class="feather-14"></i></span>
                                </div>
                            </div>
                            <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                <div class="search-info">
                                    <h6><span><i data-feather="search" class="feather-16"></i></span>Recent Searches
                                    </h6>
                                    <ul class="search-tags">
                                        <li><a href="javascript:void(0);">Products</a></li>
                                        <li><a href="javascript:void(0);">Sales</a></li>
                                        <li><a href="javascript:void(0);">Applications</a></li>
                                    </ul>
                                </div>
                                <div class="search-info">
                                    <h6><span><i data-feather="help-circle" class="feather-16"></i></span>Help</h6>
                                    <p>How to Change Product Volume from 0 to 200 on Inventory management</p>
                                    <p>Change Product Name</p>
                                </div>
                                <div class="search-info">
                                    <h6><span><i data-feather="user" class="feather-16"></i></span>Customers</h6>
                                    <ul class="customers">
                                        <li><a href="javascript:void(0);">Aron Varu<img
                                                    src="assets/img/profiles/avator1.jpg" alt class="img-fluid"></a>
                                        </li>
                                        <li><a href="javascript:void(0);">Jonita<img
                                                    src="assets/img/profiles/avator1.jpg" alt class="img-fluid"></a>
                                        </li>
                                        <li><a href="javascript:void(0);">Aaron<img
                                                    src="assets/img/profiles/avator1.jpg" alt class="img-fluid"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </form>
                    </div>
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
                                <img src="assets/img/profiles/avator1.jpg" alt class="img-fluid">
                            </span>
                            <span class="user-detail">
                                <span class="user-name">John Smilga</span>
                                <span class="user-role">Super Admin</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt>
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>John Smilga</h6>
                                    <h5>Super Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i>
                                My Profile</a>
                            <a class="dropdown-item" href="general-settings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html"><img
                                    src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
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

        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">
                <div class="row align-items-start pos-wrapper">
                    <div class="col-md-12 col-lg-8">

                        <div class="page-wrapper">
                            <div class="content">
                                <div class="page-header">
                                    <div class="add-item d-flex">
                                        <div class="page-title">
                                            <h4>Product List</h4>
                                            <h6>Choose Products from the table</h6>
                                        </div>
                                    </div>

                                    <div class="page-btn">
                                        <a href="add-product.html" class="btn btn-added"><i
                                                data-feather="plus-circle" class="me-2"></i>Warranty Products</a>
                                    </div>
                                    <div class="page-btn import">
                                        <a href="#" class="btn btn-added color" data-bs-toggle="modal"
                                            data-bs-target="#view-notes"><i data-feather="download"
                                                class="me-2"></i>Non Warranty Products</a>
                                    </div>
                                </div>
                                <div class="card table-list-card">
                                    <div class="card-body">
                                        <div class="card mb-0" id="filter_inputs">
                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-lg-2 col-sm-6 col-12">
                                                                <div class="input-blocks">
                                                                    <i data-feather="box" class="info-img"></i>
                                                                    <select class="select">
                                                                        <option>Choose Product</option>
                                                                        <option>
                                                                            Lenovo 3rd Generation</option>
                                                                        <option>Nike Jordan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive product-list">
                                            <table class="table datanew">
                                                <thead>
                                                    <tr>
                                                        <th>Products</th>
                                                        <th>Imei/Sr.No</th>
                                                        <th>Barcode</th>
                                                        <th>Purchase Price</th>
                                                        <th>Purchase Date</th>
                                                        <th>Warranty</th>
                                                        <th>Rem Warranty</th>
                                                        <th>Invoice No.</th>

                                                    </tr>
                                                </thead>
                                                <tbody class= "repairing_data">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 ps-0">
                        <aside class="product-order-list">
                            <div class="head d-flex align-items-center justify-content-between w-100">
                                <div class>

                                    <h5>Maintenance Agreement</h>

                                </div>
                            </div>
                            <div class="customer-info block-section">
                                <div class="input-block d-flex align-items-center">
                                    <input type="text" id="warranty_no" class="warranty_no form-control"
                                        placeholder="{{ trans('messages.enter_imei_or_warranty_card_no_lang', [], session('locale')) }}">
                                    <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"><i
                                            data-feather="code" class="feather-16"></i></a>

                                </div>
                                <div class="input-block d-flex align-items-center">
                                    <input type="text" class="add_customer form-control customer_input" name="customer_id"
                                        placeholder="{{ trans('messages.enter_custoemr_pos_lang', [], session('locale')) }}">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon"
                                        data-bs-toggle="modal" data-bs-target="#add_customer_modal"><i
                                            data-feather="user-plus" class="feather-16"></i></a>
                                </div>
                            </div>
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">
                                        Product Details<span class="count"></span></h6>
                                    <a href="javascript:void(0);" class="d-flex align-items-center text-danger"
                                        id="clear_list" ><span class="me-1"><i data-feather="x"
                                                class="feather-16"></i></span>Delete</a>
                                </div>
                                <div class="product-wrap">

                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header justify-content-between">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table text-nowrap table-striped table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Barcode</th>
                                                                        <th scope="col">IMEI</th>
                                                                        <th scope="col">Product</th>
                                                                        <th scope="col">Warranty</th>
                                                                        <th scope="col">Validity</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="repairing_product">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                </div><br>
                                <div class="btn-row d-sm-flex align-items-center justify-content-between">

                                    <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"  onclick="send_to_repair()"><span class="me-1 d-flex align-items-center"><i
                                                data-feather="book" class="feather-16"></i></span>{{ trans('messages.send_to_maintenance_lang', [], session('locale')) }}</a>
                                </div>
                            </div>
                    </div>


                    </aside>
                </div>
            </div>

        </div>
    </div>
    </div>

    </div>


    {{-- customer modal --}}
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
                                </div>
                                <div class="row pb-3">
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_number_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_number" name="customer_number">
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


    <div class="modal fade modal-default" id="repair_modal" aria-labelledby="repair_agree_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">Maintenance Agreement</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('add_repair_maintenance') }}" class="add_repair_maintenance" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="row pb-3">
                                    <input type="hidden" class="repair_order_no" name="order_no">
                                    <input type="hidden" class="repair_warranty_id" name="warranty_id">
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.repair_type_lang', [], session('locale')) }}</label>
                                            <select class="repairing_type form-control" name="repairing_type">
                                                <option value="1">{{ trans('messages.inspection_and_repair_lang', [], session('locale')) }}</option> 
                                                <option value="2">{{ trans('messages.replace_lang', [], session('locale')) }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> {{ trans('messages.receiving_date_lang', [], session('locale')) }}</label>
                                            <input type="text"  class="form-control receive_date datetimepicker" value="<?php echo date('Y-m-d'); ?>" name="receive_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label> {{ trans('messages.deliver_date_lang', [], session('locale')) }}</label>
                                            <input type="text"  class="form-control deliver_date datetimepicker" value="<?php echo date('Y-m-d'); ?>" name="deliver_date">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.review_by_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 technician_id" name="technician_id">
                                                     @foreach ($view_technicians as $tech) {
                                                        <option value="{{$tech->id}}">{{$tech->technician_name}}</option>';
                                                    }
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.notes_lang', [], session('locale')) }}</label>
                                            <textarea class="form-control notes" name="notes" rows="5"></textarea>
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

    {{-- <script src="{{ asset('js/pos_page/jquery-3.7.1.min.js')}}" type="7a3fc97ac244f422b7ec338a-text/javascript"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- jQuery UI library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Feather Icon JS -->
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

    @include('custom_js.add_repairing_js')


</body>

</html>
