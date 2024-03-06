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

        </div>


        <div class="page-wrapper pos-pg-wrapper ms-0">
            <div class="content pos-design p-0">

                <div class="row align-items-start pos-wrapper">
                    <div class="col-md-12 col-lg-8">
                        <div class="pos-categories tabs_wrapper">

                            <div class="pos-products">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="mb-3">Warranty Products</h5>
                                </div>
                                <div class="tabs_container">
                                    <div class="tab_content active" data-tab="all">
                                        <div class="row">

                                        <table class="table  datanew list">
                                                <thead>
                                                <tr class="color">

                                                <th>ID</th>
                                                <th>Invoice.No</th>
                                                <th>Product name</th>
                                                <th>Sr.No/IMEI</th>
                                                <th>Barcode</th>
                                                <th>Purchase Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Warranty Period</th>
                                                <th>Warranty Type</th>
                                                <th>Created by</th>
                                                <th>Purchase Date</th>
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
                                    <h5>Warranty Details</h5>

                                </div>
                                <div class>

                                    <a href="javascript:void(0);" class="text-default"><i
                                            data-feather="more-vertical" class="feather-16"></i></a>
                                </div>
                            </div>
                            <div class="customer-info block-section">

                                <div class="input-block d-flex align-items-center">
                                    <input type="text" class="order_id form-control" name="order_id" placeholder="{{ trans('messages.enter_invoice_number_lang', [], session('locale')) }}">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-icon"  ><i data-feather="hash" class="feather-16"></i></a>
                               </div>
                        </div>
                            <div class="product-added block-section">
                                <div class="head-text d-flex align-items-center justify-content-between">
                                    <h6 class="d-flex align-items-center mb-0">Approved Warranty<span
                                            class="count"></span></h6>
                                    <a href="javascript:void(0);"
                                        class="d-flex align-items-center text-danger" id="clear_all"><span class="me-1" ><i
                                                data-feather="x"  class="feather-16"></i></span>Clear all</a>
                                </div>
                                <div class="product-wrap" id="approved_warranty_pro">

                                </div>
                            </div>

                            <div class="d-grid btn-block">
                                <a class="btn btn-secondary" href="javascript:void(0);" >

                                </a>
                            </div>
                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                <a href="javascript:void(0);" class="delete btn btn-info btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#hold-order"  ><span
                                        class="me-1 d-flex align-items-center"><i data-feather="trash"
                                            class="feather-16"></i></span>Delete</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill" id="fetch_warranty_data_btn"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="code"
                                            class="feather-16"></i></span>Select All</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill"
                                    data-bs-toggle="modal" data-bs-target="#payment-completed"><span
                                        class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                            class="feather-16"></i></span>Warranty Card</a>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                                href="/cdn-cgi/l/email-protection#3a5f425b574a565f7a5d575b535614595557"><span
                                    class="__cf_email__"
                                    data-cfemail="91f4e9f0fce1fdf4d1f6fcf0f8fdbff2fefc">[email&#160;protected]</span></a>
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
                                <td>1. Red Nike Laser</td>
                                <td>$50</td>
                                <td>3</td>
                                <td class="text-end">$150</td>
                            </tr>
                            <tr>
                                <td>2. Iphone 14</td>
                                <td>$50</td>
                                <td>2</td>
                                <td class="text-end">$100</td>
                            </tr>
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
