<!DOCTYPE html>
<?php
	$locale = session('locale');
	if($locale=="ar")
	{
		$dir="dir='rtl'";
	}
	else
	{
		$dir="dir='ltr'";
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
    <title>POS Page</title>

    <!-- Bootstrap CSS -->

    {{-- <link rel="stylesheet" href="{{ asset('css/rtl/bootstrap.rtl.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    <?php if($locale=="ar"){ ?>
        <link rel="stylesheet" href="{{asset('css/pos_page_rtl/bootstrap.rtl.min.css')}}">
    <?php } else {?>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <?php }?>

    {{-- datapicker --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.css')}}">

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
	<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    {{-- toastr css --}}

    <?php if($locale=="ar"){ ?>
        <link rel="stylesheet" href="{{asset('css/pos_page_rtl/style.css')}}">
    <?php } else {?>
        <link rel="stylesheet" href="{{asset('css/pos_page/style.css')}}">
    <?php }?>

    {{-- custom css --}}
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">


    <!-- jQuery UI CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

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
                    <div class="btn-row d-sm-flex align-items-center">
                        <a href="{{  url('warranty')}}" target="_blank" class="btn btn-secondary mb-xs-3"><i class="fas fa-shield-alt"></i>
                            {{ trans('messages.warranty_lang', [], session('locale')) }}</a>
                        <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                                data-bs-target="#orders"><i class="fas fa-shopping-cart"></i> {{ trans('messages.view_orders_lang', [], session('locale')) }}</a>
                        <a href="javascript:void(0);" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#return_modal"><i class="fas fa-undo"></i> {{ trans('messages.reset_lang', [], session('locale')) }}</a>
                            <a href="javascript:void(0);" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#maintenancepayment_modal"><i class="fas fa-money-check-alt"></i> {{ trans('messages.maintenance_payment_lang', [], session('locale')) }}</a>
                    </div>
                </li>
                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>


                <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                        <i data-feather="globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if($locale=="ar"){ ?>
                            <a href="{{ route('switch_language', ['locale' => 'en']) }}" class="dropdown-item{{ app()->getLocale() === 'en' ? ' active' : '' }}">
                                <img src="{{ asset('img/flags/us.png') }}" alt="" height="16"> English
                            </a>
                            <a href="{{ route('switch_language', ['locale' => 'ar']) }}" class="dropdown-item{{ app()->getLocale() === 'ar' ? ' active' : '' }}">
                                <img src="{{ asset('img/flags/om.png') }}" alt="" height="16"> العربية
                            </a>
                        <?php } else {?>
                            <a href="{{ route('switch_language', ['locale' => 'ar']) }}" class="dropdown-item{{ app()->getLocale() === 'ar' ? ' active' : '' }}">
                                <img src="{{ asset('img/flags/om.png') }}" alt="" height="16"> العربية


                            </a>
                            <a href="{{ route('switch_language', ['locale' => 'en']) }}" class="dropdown-item{{ app()->getLocale() === 'en' ? ' active' : '' }}">
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
                                <span class="user-name">سلطان</span>
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
                                    <h6>سلطان</h6>
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

        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">
                <div class="row align-items-start pos-wrapper">
                    <div class="col-md-12 col-lg-6">
                        {{-- <div class="btn-row d-sm-flex align-items-center">
                            <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                                data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i
                                        data-feather="shopping-cart" class="feather-16"></i></span>{{ trans('messages.view_orders_lang', [], session('locale')) }}</a>
                            <a href="javascript:void(0);" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#return_modal"><span
                                    class="me-1 d-flex align-items-center "><i data-feather="rotate-cw"
                                        class="feather-16 "></i></span>{{ trans('messages.reset_lang', [], session('locale')) }}</a>

                        </div> --}}
                        <div class="pos-categories tabs_wrapper">
                            {{-- <h5>{{ trans('messages.item_catgory_pos_lang', [], session('locale')) }}</h5>
                            <p>{{ trans('messages.item_list_pos_lang', [], session('locale')) }}</p> --}}
                            <ul class="tabs owl-carousel pos-category">
                                <li id="all" class="{{ $active_cat === 'all' ? 'active' : '' }}" onclick="cat_products('all')">
                                    <a href="javascript:void(0);">
                                        <img src="{{  asset('images/dummy_image/no_image.png')}}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">{{ trans('messages.all_products_pos_lang', [], session('locale')) }}</a></h6>
                                    <span>{{$count_products}} Items</span>
                                </li>
                                @foreach ($categories as $category)
                                    @php
                                        $pro_image = asset('images/dummy_image/no_image.png');
                                        if (!empty($category->category_image)) {
                                            $pro_image = asset('images/category_images/' . $category->category_image);
                                        }
                                    @endphp
                                    <li id="cat_{{ $category->id }}" onclick="cat_products('{{ $category->id }}')">
                                        <a href="javascript:void(0);">
                                            <img src="{{ $pro_image }}" alt="{{ $category->category_name }}">
                                        </a>
                                        <h6>
                                            <a class="cat_products" data-category-id="{{ $category->id }}">{{ $category->category_name }}</a>
                                        </h6>
                                        <span>{{ $category->products->count() }} {{ trans('messages.items_pos_lang', [], session('locale')) }}</span>
                                    </li>
                                @endforeach


                            </ul>
                            <div class="pos-products">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-3">{{ trans('messages.products_pos_lang', [], session('locale')) }}</h5>
                                </div>
                                <div class="tabs_container">
                                    <div class="row" id="cat_products"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 ps-0">
                        <aside class="product-order-list">
                            {{-- <div class="head d-flex align-items-center justify-content-between w-100">
                                <div class>

                                    <h5>{{ trans('messages.order_list_lang', [], session('locale')) }}</h5>


                                </div>
                            </div> --}}
                            <div class="customer-info block-section">
                                <div class="input-block d-flex align-items-center">
                                        <input type="text" class="product_input form-control" placeholder="{{ trans('messages.enter_imei_barcode_lag', [], session('locale')) }}">
                                        <a href="#" class="btn btn-primary btn-icon"  data-bs-toggle="modal"
                                        id = "enter"><i data-feather="code" class="feather-16"></i></a>

                                </div>
                                <div class="input-block d-flex align-items-center">
                                    <input type="hidden" class="pos_customer_id form-control">
                                    <input type="text" class="add_customer form-control " id="customer_input_data" name="customer_id" placeholder="{{ trans('messages.enter_custoemr_pos_lang', [], session('locale')) }}">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#add_customer_modal"><i data-feather="user-plus" class="feather-16"></i></a>
                               </div>
                        </div>
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">{{ trans('messages.tqty_lang', [], session('locale')) }}<span
                                            class="count">0</span></h6>
                                    <a href="javascript:void(0);"
                                        class="d-flex align-items-center text-danger" id="clear_list"><span class="me-1"><i
                                        data-feather="x" class="feather-16"></i></span>{{ trans('messages.clear_all_lang', [], session('locale')) }}</a>
                                </div>
                                <div class="product-wrap">
                                    <div id="order_list"></div>
                                </div>
                            </div>


                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" id="hold" class="btn btn-info btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#hold-order"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="pause"
                                            class="feather-16"></i></span>{{ trans('messages.hold_btn_lang', [], session('locale')) }}</a>

                                {{-- data-bs-toggle="modal" data-bs-target="#payment-completed" --}}
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#payment_modal" class="btn btn-success btn-icon flex-fill"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                            class="feather-16" ></i></span>{{ trans('messages.payment_btn_lang', [], session('locale')) }}</a>
                            </div>
                        </aside>
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
                    <h5 class="modal-title">{{ trans('messages.add_customer_lang', [], session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('add_customer') }}" class="add_customer_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="row pb-3">
                                    <input type="hidden" class="customer_id" name="customer_id">
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_name_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_name" name="customer_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_phone_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_phone phone" name="customer_phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.customer_email_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control customer_email" name="customer_email">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>{{ trans('messages.national_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control national_id" name="national_id">
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
                                        <div class="row product_radio_class" >
                                            <label class="col-lg-6">{{ trans('messages.customer_type_lang', [], session('locale')) }}</label>
                                            <div class="col-lg-10">
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_general" value="4" checked>
                                                    <label class="form-check-label" for="customer_type_none">
                                                    {{ trans('messages.genral_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_student" value="1">
                                                    <label class="form-check-label" for="customer_type_student">
                                                        {{ trans('messages.customer_student_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_teacher" value="2" >
                                                    <label class="form-check-label" for="customer_type_teacher">
                                                        {{ trans('messages.customer_teacher_lang', [], session('locale')) }}
                                                    </label>
                                                </div>
                                                <div class=" form-check form-check-inline">
                                                    <input class="form-check-input customer_type" type="radio" onclick="check_customer()" name="customer_type" id="customer_type_employee" value="3">
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
                                            <label class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 student_university" name="student_university">
                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($universities as $university )
                                                <option value="{{ $university->id }}"> {{ $university->university_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12" >
                                            <label class="col-lg-6">{{ trans('messages.student_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control student_id" name="student_id">
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="validationTooltip03"> {{ trans('messages.upload_image_lang', [], session('locale')) }}</label>
                                                <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                    <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                        <input type="file" class="image" onchange="return fileValidation('customer_img','img_tag')" name="customer_image" id="customer_img">
                                                    </span>
                                                </div>
                                                <img src="{{ asset('images/dummy_image/no_image.png') }}" class="img_tags" id="img_tag" width="300px" height="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="teacher_detail display_none pb-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-10 col-10">
                                            <label class="col-lg-6">{{ trans('messages.choose_university_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 teacher_university" name="teacher_university">
                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($universities as $university)
                                                    <option value="{{ $university->id }}" > {{ $university->university_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="employee_detail display_none pb-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-10 col-10">
                                            <label class="col-lg-6">{{ trans('messages.choose_workplace_lang', [], session('locale')) }}</label>
                                            <select class="searchable_select select2 employee_workplace" name="employee_workplace">
                                                <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                                @foreach ($workplaces as $workplace)
                                                <option value="{{ $workplace->id }}" > {{ $workplace->workplace_name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12" >
                                            <label class="col-lg-6">{{ trans('messages.employee_id_lang', [], session('locale')) }}</label>
                                            <input type="text" class="form-control employee_id" name="employee_id">
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
                                <button type="submit" class="btn btn-submit me-2 submit_form">{{ trans('messages.submit_lang', [], session('locale')) }}</button>
                                <a class="btn btn-cancel" data-bs-dismiss="modal">{{ trans('messages.cancel_lang', [], session('locale')) }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}

    <div class="modal fade modal-default" id="payment-completed" aria-labelledby="payment-completed">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form action="pos.html">
                        <div class="icon-head">
                            <a href="javascript:void(0);">
                                <i data-feather="check-circle" class="feather-40"></i>
                            </a>
                        </div>
                        <h4>Payment Completed and order number is <span id="pos_order_no"></span></h4>
                        <p class="mb-0">Do you want to Print Receipt for the Completed Order</p>
                        <div class="modal-footer d-sm-flex justify-content-between">
                            <button type="button" class="btn btn-primary flex-fill" data-bs-dismiss="modal">Print Receipt<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
                            <button type="button" id="nextOrderButton" data-bs-dismiss="modal" class="btn btn-secondary flex-fill">Next Order<i class="feather-arrow-right-circle icon-me-5"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-default" id="print-receipt" aria-labelledby="print-receipt">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-end">
                    <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="icon-head text-center">
                        <a href="javascript:void(0);">
                            <img src="assets/img/logo.png" width="100" height="30" alt="Receipt Logo">
                        </a>
                    </div>
                    <div class="text-center info text-center">
                        <h6>Dreamguys Technologies Pvt Ltd.,</h6>
                        <p class="mb-0">Phone Number: +1 5656665656</p>
                        <p class="mb-0">Email: <a
                                href="/cdn-cgi/l/email-protection#56332e373b263a3316313b373f3a7835393b"><span
                                    class="__cf_email__"
                                data-cfemail="0f6a776e627f636a4f68626e6663216c6062">[email&#160;protected]</span></a>
                        </p>
                    </div>
                    <div class="tax-invoice">
                        <h6 class="text-center">Tax Invoice</h6>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="invoice-user-name"><span>Name: </span><span>John Doe</span></div>
                                <div class="invoice-user-name"><span>Invoice No: </span><span>CS132453</span></div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="invoice-user-name"><span>Customer Id: </span><span>#LL93784</span></div>
                                <div class="invoice-user-name"><span>Date: </span><span>01.07.2022</span></div>
                            </div>
                        </div>
                    </div>
                    <table class="table-borderless w-100 table-fit">
                        <thead>
                            <tr>
                                <th># Item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-end"></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table class="table-borderless w-100 table-fit">
                                        <tr>
                                            <td>Sub Total :</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        <tr>
                                            <td>Discount :</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        <tr>
                                            <td>Tax </td>
                                            <td class="text-end"></td>
                                        </tr
                                        <tr>
                                            <td>Total Bill :</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Remainign</td>
                                            <td class="text-end"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center invoice-bar">
                        <p>**VAT against this challan is payable through central registration. Thank you for your
                            business!</p>
                        <a href="javascript:void(0);">
                            <img src="assets/img/barcode/barcode-03.jpg" alt="Barcode">
                        </a>
                        <p>Sale 31</p>
                        <p>Thank You For Shopping With Us. Please Come Again</p>
                        <a href="javascript:void(0);" class="btn btn-primary">Print Receipt</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-default pos-modal" id="hold_order" aria-labelledby="create">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5>SELECT IMEI</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row" id="all_pro_imei"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-default pos-modal" id="edit-product" aria-labelledby="edit-product">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="edit_pro_name"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <input type="hidden" class="edit_barcode">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="input-blocks add-product">
                                <label>{{ trans('messages.price_pos_lang', [], session('locale')) }} <span>*</span></label>
                                <input type="text"  class="edit_price">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="input-blocks add-product">
                                <label>{{ trans('messages.tax_pos_lang', [], session('locale')) }} <span>*</span></label>
                                <input type="text"  class="edit_tax">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="input-blocks add-product">
                                <label>{{ trans('messages.discount_pos_lang', [], session('locale')) }} <span>*</span></label>
                                <input type="text" value="0"  class="edit_discount" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <div class="input-blocks add-product">
                                <label>{{ trans('messages.min_sale_price_pos_lang', [], session('locale')) }} <span>*</span></label>
                                <input type="text" class="edit_min_price" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" onclick="update_product()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade pos-modal" id="orders" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">Orders</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="tabs-sets">
                        <ul class="nav nav-tabs" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                    data-bs-target="#onhold" type="button" aria-controls="onhold"
                                    aria-selected="true" role="tab">Onhold</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="paid-tab" data-bs-toggle="tab"
                                    data-bs-target="#paid" type="button" aria-controls="paid"
                                    aria-selected="false" role="tab">Paid</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="onhold" role="tabpanel"
                                aria-labelledby="onhold-tab">

                                <div class="order-body" id= "hold_data">

                                </div>
                            </div>
                            <div class="tab-pane fade" id="paid" role="tabpanel">
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" id="orderNoSearch" class="form-control" placeholder="{{ trans('messages.order_no_lang',[],session('locale')) }}">
                                    </div>
                                </div> --}}
                                <div class="order-body">
                                    <div class="default-cover p-4 mb-4">
                                        
                                        @foreach ($orders as $order )
                                        <div class="order-details" data-order-no="{{ $order->order_no }}">
                                            <span class="badge bg-secondary d-inline-block mb-4">{{ trans('messages.order_num_lang',[],session('locale')) }} : {{ $order->order_no }}</span>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 record mb-3">
                                                    <table>
                                                        <tr class="mb-3">
                                                            <td>{{ trans('messages.cashier_lang',[],session('locale')) }}</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">{{ $order->added_by }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">{{ trans('messages.customer_name_lang',[],session('locale')) }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-sm-12 col-md-6 record mb-3">
                                                    <table>
                                                        <tr>
                                                            <td>{{ trans('messages.total_price_lang',[],session('locale')) }}</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">OMR {{ $order->total_amount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ trans('messages.add_date_lang',[],session('locale')) }}</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">{{ $order->created_at->format('Y-m-d') }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                            {{-- <p class="p-4">Customer need to recheck the product once</p> --}}
                                            <div class="btn-row d-sm-flex align-items-center justify-content-between">

                                                <a href="{{ route('pos_bill', ['order_no' => $order->order_no]) }}" target="_blank" class="btn btn-success btn-icon flex-fill">{{ trans('messages.print_lang',[],session('locale')) }} </a>
                                                <a href="{{ route('pos_bill', ['order_no' => $order->order_no]) }}" target="_blank" class="btn btn-success btn-icon flex-fill">{{ trans('messages.a4print_lang',[],session('locale')) }} </a>

                                            </div><br>
                                        </div>
                                     @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- replace and return --}}
    <div class="modal fade pos-modal" id="return_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">{{ trans('messages.return_items_lang',[],session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <label class="radios">
                                <input type="radio" checked class="return" name="return" value="1" id="replace">
                                <span class="radiomarks" for="replace"></span> {{ trans('messages.replace_lang',[],session('locale')) }}
                            </label>
                        </div>
                        <div class="col-md-4 col-6">
                            <label class="radios">
                                <input type="radio" class="return" name="return" value="2" id="restore">
                                <span class="radiomarks" for="restore"></span> {{ trans('messages.restore_lang',[],session('locale')) }}
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>{{ trans('messages.order_or_reference_no_lang', [], session('locale')) }}</label>
                                <input type="text" class="form-control return_order_no" name="return_order_no">
                             </div>
                        </div>
                    </div>
                    <div class="row" id="return_data">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- maintenance payment --}}
    <div class="modal fade pos-modal" id="maintenancepayment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">{{ trans('messages.maintenance_modal_lang',[],session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4"> 
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>{{ trans('messages.order_or_reference_no_lang', [], session('locale')) }}</label>
                                <input type="text" class="form-control maintenancepayment_order_no" name="maintenancepayment_order_no">
                             </div>
                        </div>
                    </div>
                    <div class="row" id="maintenancepayment_data">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- replace and return --}}
    <div class="modal fade pos-modal" id="payment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">{{ trans('messages.checkout_lang',[],session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="block-section">
                        <div class="selling-info">
                            <div class="row">
                                <div class="col-lg-6 col-sm-4">
                                    <div class="input-block ">
                                        <label>{{ trans('messages.cash_payment_lang', [], session('locale')) }}</label>
                                       <input type="text" class="cash_payment form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-sm-4">
                                    <div class="input-block ">
                                        <label>{{ trans('messages.order_tax_lang', [], session('locale')) }}</label>
                                       <input type="text" class="order_tax form-control">
                                    </div>
                                </div> --}}
                              <div class="col-lg-6 col-sm-4">
                                <div class="input-block">
                                        <label for="myCheckbox" id="checkboxLabel">{{ trans('messages.discount_%_lang', [], session('locale')) }}</label>
                                        <input type="checkbox" onclick="switch_discount_type()" class="discount_check" name="discount_check" id="myCheckbox" >

                                    <select class="select discount_by">
                                        <option value="1"> {{ trans('messages.discount_type_lang', [], session('locale')) }}</option>
                                        <option value="2"> {{ trans('messages.company_lang', [], session('locale')) }}</option>
                                        <option value ="3"> {{ trans('messages.shop_lang', [], session('locale')) }}</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="block-section col-md-6">
                            <div class="order-total">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>{{ trans('messages.sub_pos_lang', [], session('locale')) }}</td>
                                        <td class="text-end" name="sub_total" ><span>OMR </span><span class="sub_total">0.000</span></td>
                                    </tr>
                                    <tr>
                                        <td class="danger">{{ trans('messages.discount_pos_lang', [], session('locale')) }}</td>
                                        <td class="danger text-end " name="total_discount"><span> OMR </span><span class="grand_discount"> 0.000</span></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('messages.total_tax_pos_lang', [], session('locale')) }}</td>
                                        <td class="text-end " name="total_tax"><span>OMR </span><span class="total_tax">0.000</span></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('messages.grand_total_lang', [], session('locale')) }}</td>
                                        <td class="text-end " name="grand_total"><span>OMR </span><span class="grand_total">0.000</span></td>
                                    </tr>
                                    <tr>
                                        <td> {{ trans('messages.cash_back_pos_lang', [], session('locale')) }}</td>
                                        <td class=" text-end" name="cash_back"><span>OMR </span><span class="cash_back">0.000</span></td>
                                    </tr>



                                </table>
                            </div>
                        </div>

                        <div class="block-section payment-method col-md-6" style="padding: 10px;">
                            <h4>{{ trans('messages.payment_method_pos_lang', [], session('locale')) }}</h4>
                            <br>
                            <div class="row d-flex  methods">
                                @php $a = 1; @endphp
                                @foreach ($view_account as $account)
                                    @php 
                                        $checked = "";
                                        if($a == 1)
                                        {
                                            $checked = "checked = 'true'";
                                        }
                                    @endphp
                                <div class="col-md-6 col-lg-3 item">
                                    <div class="default-cover default-cover{{ $account->account_name }}">
                                        <a href="javascript:void(0);" class="payment-anchor" data-account-id="{{ $account->account_id }}">
                                            <input {{$checked}} class="payment_gateway_all payment_gateway{{ $account->account_id }}" type="radio" name="payment_gateway" value="{{ $account->id }}" id="payment_gateway{{ $account->account_id }}">
                                            <span>{{ $account->account_name }}</span>
                                        </a>
                                    </div>
                                </div>
                                @php $a++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="btn-row d-sm-flex align-items-center justify-content-between">

                        {{-- data-bs-toggle="modal" data-bs-target="#payment-completed" --}}
                        <a href="javascript:void(0);"   class="btn btn-success btn-icon flex-fill" id="add_pos_order"><span
                                class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                    class="feather-16" ></i></span>Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- maintenance payment --}}
    {{-- replace and return --}}
    <div class="modal fade pos-modal" id="maintenance_payment_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">{{ trans('messages.checkout_lang',[],session('locale')) }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="block-section">
                        <div class="selling-info">
                            <div class="row">
                                <div class="col-lg-6 col-sm-4">
                                    <input type="hidden" class="reference_no_maintenance form-control">
                                    <input type="hidden" class="maintenance_bill_id form-control">
                                    <div class="input-block ">
                                        <label>{{ trans('messages.cash_payment_lang', [], session('locale')) }}</label>
                                       <input type="text" class="cash_payment_maintenance form-control">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="block-section col-md-6">
                            <div class="order-total">
                                <table class="table table-borderless">
                                     
                                    <tr>
                                        <td>{{ trans('messages.grand_total_lang', [], session('locale')) }}</td>
                                        <td class="text-end " name="grand_total"><span>OMR </span><span class="grand_total_maintenance">0.000</span></td>
                                    </tr>
                                    <tr>
                                        <td> {{ trans('messages.cash_back_pos_lang', [], session('locale')) }}</td>
                                        <td class=" text-end" name="cash_back"><span>OMR </span><span class="cash_back_maintenance">0.000</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>{{ trans('messages.payment_method_lang', [], session('locale')) }}</label>
                                <select class="form-control maintenance_payment_gateway_all" name="payment_method">
                                    @foreach ($view_account as $acc) {
                                        <option value="{{$acc->id}}">{{$acc->account_name}}</option>';
                                    }
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="btn-row d-sm-flex align-items-center justify-content-between">

                        {{-- data-bs-toggle="modal" data-bs-target="#payment-completed" --}}
                        <a href="javascript:void(0);"   class="btn btn-success btn-icon flex-fill" id="add_maintenance_payment"><span
                                class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                    class="feather-16" ></i></span>Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="customizer-links" id="setdata">
        <ul class="sticky-sidebar">
            <li class="sidebar-icons">
                <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-original-title="Theme">
                    <i data-feather="settings" class="feather-five"></i>
                </a>
            </li>
        </ul>
    </div> --}}

        {{-- <script src="{{ asset('js/pos_page/jquery-3.7.1.min.js')}}" type="7a3fc97ac244f422b7ec338a-text/javascript"></script> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- jQuery UI library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <!-- Feather Icon JS -->
        <script src="{{ asset('js/pos_page/feather.min.js') }}"></script>

        <!-- Slimscroll JS -->
        <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

        <!-- Datatable JS -->
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/pos_page/dataTables.bootstrap5.min.js') }}"></script>


        <script src="{{  asset('plugins/toastr/toastr.min.js')}}"></script>
		<script src="{{  asset('plugins/toastr/toastr.js')}}"></script>

        <!-- Bootstrap Core JS -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

        <!-- Chart JS -->
        <script src="{{ asset('js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/chart-data.js') }}"></script>

        <!-- Datetimepicker JS -->
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/pos_page/daterangepicker.js') }}"></script>

        {{-- caousel js --}}
        <script src="{{ asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>


        <!-- Select2 JS -->
		<script src="{{  asset('js/select2.min.js')}}"></script>
        <script src="{{  asset('plugins/select2/js/custom-select.js')}}"></script>

        <!-- Sweetalert 2 -->
        <script src="{{ asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalert/sweetalerts.min.js') }}"></script>

        {{-- theme script --}}
        <script src="{{ asset('js/pos_page/theme-script.js')}}" ></script>

        {{-- script js --}}
        <script src="{{ asset('js/pos_page/script.js') }}"></script>

        {{-- rocket loader --}}
        <script src="{{ asset('js/pos_page/rocket-loader.min.js') }}" data-cf-settings="7a3fc97ac244f422b7ec338a-|49" defer >
        </script>

        {{-- custom js --}}
        @include('custom_js.custom_js')

        {{-- Include the JavaScript file for pos --}}
        @include('custom_js.pos_js')




    </body>

</html>
