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
                    {{-- <div class="top-nav-search">
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
                    </div> --}}
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
    
    <div class="page-wrapper" style="margin: 0 0 0 0;">
        <input type="hidden" class="reference_no" value="{{ $repair_detail->reference_no }}"> 
        <div class="content">
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center welcome-text">
                <h3 class="d-flex align-items-center"> {{ $customer_data->customer_name }} ({{ $customer_data->customer_phone }})</h3>&nbsp; 
                <h6><span class='badges bg-lightgreen badges_table'>{{ trans('messages.purchase_date_lang', [], session('locale')) }} : {{ get_date_only($order_data->created_at)}}</span>
                    <span class='badges bg-lightgreen badges_table'>{{ trans('messages.receiving_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->receive_date) }}</span>
                    <span class='badges bg-lightgreen badges_table'>{{ trans('messages.deliver_date_lang', [], session('locale')) }} : {{ get_date_only($repair_detail->deliver_date)}}</span>
                </h6>
            </div>
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <select class="change_status form-control" disabled id="change_status" name="status">
                            <option {{ $repair_detail->status == 1 ? 'selected' : '' }} value="1">{{ trans('messages.receive_status_lang', [], session('locale')) }}</option> 
                            <option {{ $repair_detail->status == 6 ? 'selected' : '' }} value="6">{{ trans('messages.inspection_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 2 ? 'selected' : '' }} value="2">{{ trans('messages.send_agent_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 3 ? 'selected' : '' }} value="3">{{ trans('messages.receive_agent_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 4 ? 'selected' : '' }} value="4">{{ trans('messages.ready_status_lang', [], session('locale')) }}</option>
                            <option {{ $repair_detail->status == 5 ? 'selected' : '' }} value="5">{{ trans('messages.deleivered_status_lang', [], session('locale')) }}</option>
                        </select>
                     </div> 
                </div>
             </div>
        </div>
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <label>{{ trans('messages.technicians_lang', [], session('locale')) }}</label>
                        <select disabled class="searchable_select select2 technician_id" name="technician_id" multiple>
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
        </div>
        <div class="row sales-cards">
            <div class="col-xl-3 col-sm-12 col-12">
                <div class="card d-flex align-items-center justify-content-between default-cover mb-4">
                    <div>
                        <h6>
                            @php if ($repair_detail->repairing_type == 1) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.inspection_and_repair_lang', [], session('locale')) . "</span>";
                            } else if ($repair_detail->repairing_type == 2) {
                                echo "<span class='badges bg-lightgreen badges_table'>" . trans('messages.replace_lang', [], session('locale')) . "</span>";
                            }
                            @endphp
                            <br>
                            {{ $title }}
                        </h6>
                        @php
                            if ($imei != "") {
                        @endphp
                            <h3><span>{{ $imei }}</span></h3>
                        @php
                            }
                        @endphp

                        <h6 class="sales-range"><span class="text-success">{{ trans('messages.purchase_price_lang', [], session('locale')) }} {{ $pro_data->total_purchase }}</span></h6>
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
            @php if($warranty_type==1){ @endphp
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
                        <i class="fas fa-tools fa-3x"></i>                        <h3 class="counters" data-count="{{$serv_sum }}" id="total_service">{{$serv_sum }}</h3>
                        <p>{{ trans('messages.total_service_lang', [], session('locale')) }}</p>
                        <i data-feather="rotate-ccw" class="feather-16" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"></i>
                    </div>
                </div>
            @php } @endphp
        </div>


        {{-- add pro and service for reparing --}}
        @php if($warranty_type==1){ @endphp
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-6 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ trans('messages.services_lang', [], session('locale')) }}</h4>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.service_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th> 
                                     </tr>
                                </thead>
                                <tbody id="service_tbody">
                                    @php echo $service_data; @endphp
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
                        <div class="table-responsive no-pagination">
                            <table class="table no-footer">
                                <thead>
                                    <tr>
                                        <th>{{ trans('messages.product_name_lang', [], session('locale')) }}</th>
                                        <th>{{ trans('messages.cost_lang', [], session('locale')) }}</th> 
                                     </tr>
                                </thead>
                                <tbody id="product_tbody">
                                    @php echo $product_data; @endphp
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php } @endphp
    

        
    
    
        
         
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

   @include('custom_js.add_repairing_js')


</body>

</html>