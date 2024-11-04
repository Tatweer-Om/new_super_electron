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

    <div class="" style="padding: 10px">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ trans('messages.maintenance_list_lang', [], session('locale')) }}</h4>
                 </div>
            </div>
           <!-- /product list this is my first commit -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>{{ trans('messages.status_lang', [], session('locale')) }}</label>
                                <select class="status form-control" id="status" name="status">
                                    <option value="">{{ trans('messages.choose_lang', [], session('locale')) }}</option>
                                    <option value="1">{{ trans('messages.receive_status_lang', [], session('locale')) }}</option>
                                    <option value="6">{{ trans('messages.inspection_status_lang', [], session('locale')) }}</option>
                                    <option value="2">{{ trans('messages.send_agent_status_lang', [], session('locale')) }}</option>
                                    <option value="3">{{ trans('messages.receive_agent_status_lang', [], session('locale')) }}</option>
                                    <option value="4">{{ trans('messages.ready_status_lang', [], session('locale')) }}</option>
                                    <option value="5">{{ trans('messages.deleivered_status_lang', [], session('locale')) }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="all_maintenance" class="table  ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.reference_no_lang',[],session('locale')) }}</th>
                                    <th>{{ trans('messages.receiving_date_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.deliver_date_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.repair_type_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.status_lang',[],session('locale'))}}</th>
                                    <th>{{ trans('messages.created_at_lang',[],session('locale')) }}</th>
                                    <th>{{ trans('messages.action_lang', [], session('locale')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
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
