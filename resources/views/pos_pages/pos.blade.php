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

                {{-- <li class="nav-item dropdown has-arrow main-drop select-store-dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link select-store"
                        data-bs-toggle="dropdown">
                        <span class="user-info">
                            <span class="user-letter">
                                <img src="assets/img/store/store-01.png" alt="Store Logo" class="img-fluid">
                            </span>
                            <span class="user-detail">
                                <span class="user-name">Select Store</span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/store/store-01.png" alt="Store Logo" class="img-fluid"> Grocery
                            Alpha
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/store/store-02.png" alt="Store Logo" class="img-fluid"> Grocery Apex
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/store/store-03.png" alt="Store Logo" class="img-fluid"> Grocery Bevy
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/store/store-04.png" alt="Store Logo" class="img-fluid"> Grocery Eden
                        </a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                        role="button">
                        <img src="assets/img/flags/us.png" alt="Language" class="img-fluid">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0);" class="dropdown-item active">
                            <img src="assets/img/flags/us.png" alt height="16"> English
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/fr.png" alt height="16"> French
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/es.png" alt height="16"> Spanish
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="assets/img/flags/de.png" alt height="16"> German
                        </a>
                    </div>
                </li> --}}

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i data-feather="maximize"></i>
                    </a>
                </li>
                {{-- <li class="nav-item nav-item-box">
                    <a href="email.html">
                        <i data-feather="mail"></i>
                        <span class="badge rounded-pill">1</span>
                    </a>
                </li> --}}

                {{-- <li class="nav-item dropdown nav-item-box">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <i data-feather="bell"></i><span class="badge rounded-pill">2</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt src="assets/img/profiles/avatar-02.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added
                                                    new task <span class="noti-title">Patient appointment
                                                        booking</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt src="assets/img/profiles/avatar-03.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Tarah
                                                        Shropshire</span> changed the task name <span
                                                        class="noti-title">Appointment booking with payment
                                                        gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt src="assets/img/profiles/avatar-06.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                                    added <span class="noti-title">Domenic Houston</span> and <span
                                                        class="noti-title">Claire Mapes</span> to project <span
                                                        class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt src="assets/img/profiles/avatar-17.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                                    completed task <span class="noti-title">Patient and Doctor video
                                                        conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins
                                                        ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt src="assets/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Bernardo
                                                        Galaviz</span> added new task <span class="noti-title">Private
                                                        chat module</span></p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li> --}}

                {{-- <li class="nav-item nav-item-box">
                    <a href="general-settings.html"><i data-feather="settings"></i></a>
                </li> --}}
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
                        <div class="btn-row d-sm-flex align-items-center">
                            <a href="javascript:void(0);" class="btn btn-secondary mb-xs-3" data-bs-toggle="modal"
                                data-bs-target="#orders"><span class="me-1 d-flex align-items-center"><i
                                        data-feather="shopping-cart" class="feather-16"></i></span>View Orders</a>
                            <a href="javascript:void(0);" class="btn btn-info clear_list"><span
                                    class="me-1 d-flex align-items-center "><i data-feather="rotate-cw"
                                        class="feather-16 "></i></span>Reset</a>
                            {{-- <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#recents"><span class="me-1 d-flex align-items-center"><i
                                data-feather="refresh-ccw" class="feather-16"></i></span>Transaction</a> --}}
                        </div>
                        <div class="pos-categories tabs_wrapper">
                            <h5>{{ trans('messages.item_catgory_pos_lang', [], session('locale')) }}</h5>
                            <p>{{ trans('messages.item_list_pos_lang', [], session('locale')) }}</p>
                            <ul class="tabs owl-carousel pos-category">
                                <li id="all" class="{{ $active_cat === 'all' ? 'active' : '' }}" onclick="cat_products('all')">
                                    <a href="javascript:void(0);">
                                        <img src="{{  asset('images/dummy_image/category-03.png')}}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">{{ trans('messages.all_products_pos_lang', [], session('locale')) }}</a></h6>
                                    <span>{{$count_products}} Items</span>
                                </li>
                                @foreach ( $categories as $category)
                                <li id="cat_ {{  $category->id}}" onclick="cat_products('{{ $category->id }}')">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('images/category_images/' . $category->category_image) }}" alt="Categories">
                                    </a>
                                    <h6><a  class="cat_products" data-category-id="{{ $category->id }}">{{ $category->category_name }}</a></h6>
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
                    <div class="col-md-12 col-lg-4 ps-0">
                        <aside class="product-order-list">
                            <div class="head d-flex align-items-center justify-content-between w-100">
                                <div class>

                                   
                                  
                                    <h5>{{ trans('messages.order_list_lang', [], session('locale')) }}</h5>
                                    <span>{{ trans('messages.order_num_lang', [], session('locale')) }}</span>

                                </div>
                            </div>
                            <div class="customer-info block-section">
                                <div class="input-block d-flex align-items-center">
                                        <input type="text" class="product_input form-control" placeholder="{{ trans('messages.enter_prosuct_pos_lang', [], session('locale')) }}">
                                        <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                        ><i data-feather="code" class="feather-16"></i></a>

                                </div>
                                <div class="input-block d-flex align-items-center">

                                    <input type="text" class="add_customer form-control" name="customer_id" placeholder="{{ trans('messages.enter_custoemr_pos_lang', [], session('locale')) }}">

                                    <input type="text" class="add_customer form-control"  name="customer_id" placeholder="Enter Customer's Name or Phone">

                                    <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#add_customer_modal"><i data-feather="user-plus" class="feather-16"></i></a>
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
                            <div class="block-section">
                                <div class="selling-info">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block ">
                                                <label>Cash Payment</label>
                                               <input type="text" class="cash_payment form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="input-block ">
                                                <label>Order Tax</label>
                                               <input type="text" class="order_tax form-control">
                                            </div>
                                        </div>
                                      <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                                <label for="myCheckbox" id="checkboxLabel">Discount %</label>
                                                <input type="checkbox" onclick="switch_discount_type()" class="discount_check" name="discount_check" id="myCheckbox" >

                                            <select class="select discount_by">
                                                <option value=1>Discount Type</option>
                                                <option value=2>Company</option>
                                                <option value =3>Shop</option>
                                            </select>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="order-total">
                                    <table class="table table-responsive table-borderless">
                                        <tr>
                                            <td>{{ trans('messages.sub_pos_lang', [], session('locale')) }}</td>
                                            <td class="text-end" name="sub_total" ><span>OMR </span><span class="sub_total">0.000</span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('messages.total_tax_pos_lang', [], session('locale')) }}</td>
                                            <td class="text-end " name="total_tax"><span>OMR </span><span class="total_tax">0.000</span></td>
                                        </tr>
                                        <tr>
                                            <td> {{ trans('messages.cash_back_pos_lang', [], session('locale')) }}</td>
                                            <td class=" text-end" name="cash_back"><span>OMR </span><span class="cash_back">0.000</span></td>
                                        </tr>

                                        <tr>
                                            <td class="danger">{{ trans('messages.discount_pos_lang', [], session('locale')) }}</td>
                                            <td class="danger text-end " name="total_discount"><span> OMR </span><span class="grand_discount"> 0.000</span></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="block-section payment-method">
                                <h6>{{ trans('messages.payment_method_pos_lang', [], session('locale')) }}</h6>
                                <div class="row d-flex align-items-center justify-content-center methods">
                                    @foreach ($view_account as $account)
                                     <div class="col-md-6 col-lg-4 item">
                                        <div class="default-cover default-cover{{ $account->account_name }}">
                                            <a href="javascript:void(0);" class="payment-anchor" data-account-id="{{ $account->account_id }}">
                                                <input class="payment_gateway_all payment_gateway{{ $account->account_id }}" type="radio" name="payment_gateway" value="{{ $account->id }}" id="payment_gateway{{ $account->account_id }}">
                                                <span>{{ $account->account_name }}</span>
                                            </a>
                                        </div>
                                     </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-grid btn-block">
                                <a class="btn btn-secondary" href="javascript:void(0);">
                                {{ trans('messages.grand_total_pos_lang', [], session('locale')) }}: <span>ر.ع </span><span class="grand_total">0.000</span>
                                </a>
                            </div>
                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#hold-order"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="pause"
                                            class="feather-16"></i></span>Hold</a>
                                            <a  class="btn btn-danger btn-icon flex-fill clear_list" >
                                                <span class="me-1 d-flex align-items-center"><i data-feather="trash-2" class="feather-16"></i></span>Void
                                            </a>
                                {{-- <a href="#" >pos order</a> --}}
                                <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill" id="add_pos_order"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                            class="feather-16" ></i></span>Payment</a>
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
                    <h5 class="modal-title">Add Customer</h5>
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
                        <h4>Payment Completed</h4>
                        <p class="mb-0">Do you want to Print Receipt for the Completed Order</p>
                        <div class="modal-footer d-sm-flex justify-content-between">
                            <button type="button" class="btn btn-primary flex-fill" data-bs-toggle="modal"
                                data-bs-target="#print-receipt">Print Receipt<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
                            <button type="submit" class="btn btn-secondary flex-fill">Next Order<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
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
                                <td>3. Apple Series 8</td>
                                <td>$50</td>
                                <td>3</td>
                                <td class="text-end">$150</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table class="table-borderless w-100 table-fit">
                                        <tr>
                                            <td>Sub Total :</td>
                                            <td class="text-end">$700.00</td>
                                        </tr>
                                        <tr>
                                            <td>Discount :</td>
                                            <td class="text-end">-$50.00</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping :</td>
                                            <td class="text-end">0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Tax (5%) :</td>
                                            <td class="text-end">$5.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Bill :</td>
                                            <td class="text-end">$655.00</td>
                                        </tr>
                                        <tr>
                                            <td>Due :</td>
                                            <td class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Payable :</td>
                                            <td class="text-end">$655.00</td>
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
    <div class="modal fade modal-default pos-modal" id="hold-order" aria-labelledby="create">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5>Hold order</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="pos.html">
                        <h2 class="text-center p-4">4500.00</h2>
                        <div class="input-block">
                            <label>Order Reference</label>
                            <input class="form-control" type="text" value placeholder>
                        </div>
                        <p>The current order will be set on hold. You can retreive this order from the pending order
                            button. Providing a reference to it might help you to identify the order more quickly.</p>
                        <div class="modal-footer d-sm-flex justify-content-end">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
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


    <div class="modal fade pos-modal" id="recents" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title">Recent Transactions</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="tabs-sets">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="purchase-tab" data-bs-toggle="tab"
                                    data-bs-target="#purchase" type="button" aria-controls="purchase"
                                    aria-selected="true" role="tab">Purchase</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="payment-tab" data-bs-toggle="tab"
                                    data-bs-target="#payment" type="button" aria-controls="payment"
                                    aria-selected="false" role="tab">Payment</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="return-tab" data-bs-toggle="tab"
                                    data-bs-target="#return" type="button" aria-controls="return"
                                    aria-selected="false" role="tab">Return</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="purchase" role="tabpanel"
                                aria-labelledby="purchase-tab">
                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div>
                                    <div class="wordset">
                                        <ul>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Pdf"><img src="assets/img/icons/pdf.svg"
                                                        alt="img"></a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Excel"><img src="assets/img/icons/excel.svg"
                                                        alt="img"></a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Print"><i data-feather="printer"
                                                        class="feather-rotate-ccw"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reference</th>
                                                <th>Customer</th>
                                                <th>Amount </th>
                                                <th class="no-sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0101</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0102</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0103</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0104</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0105</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0106</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0107</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel">
                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div>
                                    <div class="wordset">
                                        <ul>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Pdf"><img src="assets/img/icons/pdf.svg"
                                                        alt="img"></a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Excel"><img src="assets/img/icons/excel.svg"
                                                        alt="img"></a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Print"><i data-feather="printer"
                                                        class="feather-rotate-ccw"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reference</th>
                                                <th>Customer</th>
                                                <th>Amount </th>
                                                <th class="no-sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0101</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0102</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0103</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0104</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0105</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0106</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0107</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="return" role="tabpanel">
                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div>
                                    <div class="wordset">
                                        <ul>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"
                                                    class="d-flex align-items-center justify-content-center"><img
                                                        src="assets/img/icons/pdf.svg" alt="img"></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"
                                                    class="d-flex align-items-center justify-content-center"><img
                                                        src="assets/img/icons/excel.svg" alt="img"></a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"
                                                    class="d-flex align-items-center justify-content-center"><i
                                                        data-feather="printer" class="feather-rotate-ccw"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reference</th>
                                                <th>Customer</th>
                                                <th>Amount </th>
                                                <th class="no-sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0101</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0102</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0103</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0104</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0105</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0106</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>19 Jan 2023</td>
                                                <td>INV/SL0107</td>
                                                <td>Walk-in Customer</td>
                                                <td>$1500.00</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="eye" class="feather-eye"></i></a>
                                                        <a class="me-2 p-2" href="javascript:void(0);"><i
                                                                data-feather="edit" class="feather-edit"></i></a>
                                                        <a class="p-2 confirm-text" href="javascript:void(0);"><i
                                                                data-feather="trash-2"
                                                                class="feather-trash-2"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                        {{-- <ul class="nav nav-tabs" id="myTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="onhold-tab" data-bs-toggle="tab"
                                    data-bs-target="#onhold" type="button" aria-controls="onhold"
                                    aria-selected="true" role="tab">Onhold</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="unpaid-tab" data-bs-toggle="tab"
                                    data-bs-target="#unpaid" type="button" aria-controls="unpaid"
                                    aria-selected="false" role="tab">Unpaid</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="paid-tab" data-bs-toggle="tab"
                                    data-bs-target="#paid" type="button" aria-controls="paid"
                                    aria-selected="false" role="tab">Paid</button>
                            </li>
                        </ul> --}}
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="onhold" role="tabpanel"
                                aria-labelledby="onhold-tab">
                                <div class="table-top">
                                    {{-- <div class="search-set w-100 search-order">
                                        <div class="search-input w-100">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="order-body">
                                    <div class="default-cover p-4 mb-4">
                                        @foreach ($orders as $order )
                                        <span class="badge bg-secondary d-inline-block mb-4">Order ID : {{ $order->id }}</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->added_by }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Customer</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">OMR {{ $order->total_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">{{ $order->created_at->format('Y-m-d') }}</td>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div><br>
                                     @endforeach
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="unpaid" role="tabpanel">
                                <div class="table-top">
                                    <div class="search-set w-100 search-order">
                                        <div class="search-input">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-body">
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-info d-inline-block mb-4">Order ID : #666662</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Anastasia</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$2500</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">10-09-2023 17:15:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-info d-inline-block mb-4">Order ID : #666663</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Lucia</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$1500</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">11-09-2023 14:50:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-info d-inline-block mb-4">Order ID : #666664</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Diego</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$30000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">12-09-2023 17:22:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4 mb-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paid" role="tabpanel">
                                <div class="table-top">
                                    <div class="search-set w-100 search-order">
                                        <div class="search-input">
                                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-body">
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-primary d-inline-block mb-4">Order ID : #666665</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Hugo</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$5000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">13-09-2023 19:39:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-primary d-inline-block mb-4">Order ID : #666666</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">Antonio</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$7000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">15-09-2023 18:39:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                    <div class="default-cover p-4 mb-4">
                                        <span class="badge bg-primary d-inline-block mb-4">Order ID : #666667</span>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr class="mb-3">
                                                        <td>Cashier</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">admin</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">MacQuoid</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 record mb-3">
                                                <table>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">$7050</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date</td>
                                                        <td class="colon">:</td>
                                                        <td class="text">17-09-2023 19:39:11</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <p class="p-4 mb-4">Customer need to recheck the product once</p>
                                        <div class="btn-row d-flex align-items-center justify-content-between">
                                            <a href="javascript:void(0);"
                                                class="btn btn-info btn-icon flex-fill">Open</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger btn-icon flex-fill">Products</a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-success btn-icon flex-fill">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="customizer-links" id="setdata">
        <ul class="sticky-sidebar">
            <li class="sidebar-icons">
                <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-original-title="Theme">
                    <i data-feather="settings" class="feather-five"></i>
                </a>
            </li>
        </ul>
    </div>

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
        @include('custom_js.add_order_js')



    </body>

</html>
