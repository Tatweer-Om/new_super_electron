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
    <title>Warranty Page</title>


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

                            <a class="dropdown-item" href="#"><i class="me-2" data-feather="settings"></i>الإعدادات</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="signin.html"><img src="{{ asset('img/icons/log-out.svg')}}" class="me-2" alt="img">خروج</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">

                <div class="row align-items-start pos-wrapper">
                    <div class="col-md-12 col-lg-8">
                        <div class="pos-categories tabs_wrapper">

                            <div class="pos-products">
                                <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3">{{ trans('messages.warrenty_managment_lang', [], session('locale')) }}</h5>
                                </div>
                                <div class="tabs_container">
                                    <div class="tab_content active" data-tab="all">
                                        <div class="row">

                                        <table id="warranty_table" class="table list">
                                                <thead>
                                                <tr class="color">
                                                <th>#</th>
                                                <th>{{ trans('messages.warrenty_invoice', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_pro_name', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_serial', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_barcode', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_p_price', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_qty', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_total_price', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_type', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_sale_by', [], session('locale')) }}</th>
                                                <th>{{ trans('messages.warrenty_purchase_date', [], session('locale')) }}</th>
                                                <th class="d-none"></th>
                                                <th class="d-none"></th>
                                                <th class="d-none"></th>
                                                <th class="d-none"></th>
                                                <th class="d-none"></th>
                                                </tr>
                                                </thead>
                                                <tbody id="warranty_data">
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

                                    <a href="javascript:void(0);" class="text-default"><i
                                            data-feather="more-vertical" class="feather-16"></i></a>
                                </div>
                            </div>
                            <div class="customer-info block-section">

                                <div class="input-block d-flex align-items-center">
                                    <input type="text" class="order_id form-control" name="order_id" placeholder="{{ trans('messages.enter_invoice_number_lang', [], session('locale')) }}">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon" id="hash"  ><i data-feather="hash" class="feather-16"></i></a>
                               </div>
                        </div>
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">{{ trans('messages.warrenty_selected_item', [], session('locale')) }}<span
                                            class="count"></span></h6>
                                    <a href="javascript:void(0);"
                                        class="d-flex align-items-center text-danger" id="clear_all"><span class="me-1" ><i
                                                data-feather="x"  class="feather-16"></i></span>{{ trans('messages.warrenty_clear', [], session('locale')) }}</a>
                                </div>
                                <div class="product-wrap" id="approved_warranty_pro">

                                </div>
                            </div>
                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" class="delete btn btn-info btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#hold-order"  ><span
                                        class="me-1 d-flex align-items-center"><i data-feather="trash"
                                            class="feather-16"></i></span>{{ trans('messages.warrenty_delete_list', [], session('locale')) }}</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill" id="fetch_warranty_data_btn"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="code"
                                            class="feather-16"></i></span>{{ trans('messages.warrenty_selecte_all', [], session('locale')) }}</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                     id="warranty_card" ><span
                                        class="me-1 d-flex align-items-center"><i
                                        class="feather-16"></i></span>{{ trans('messages.warrenty_print', [], session('locale')) }}</a>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-default" data-bs-backdrop="static" id="payment-completed" aria-labelledby="payment-completed">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form action="pos.html">
                        <div class="icon-head">
                            <a href="javascript:void(0);">
                                <i data-feather="check-circle" class="feather-40"></i>
                            </a>
                        </div>
                        <h4>Warranty Added</h4>
                        <p class="mb-0">Print Warranty Card</p>
                        <div class="modal-footer d-sm-flex justify-content-between">
                            <button type="button" class="btn btn-primary flex-fill"
                            onclick="warranty_card()" id="print_warranty_card" >Print Card<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/pos_page/daterangepicker.js') }}"></script>

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
     @include('custom_js.add_warranty_js')




</body>

</html>
