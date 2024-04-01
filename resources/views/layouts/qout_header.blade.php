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
<!DOCTYPE html>
<html lang="en" <?php echo $dir; ?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="description" content="POS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
		<meta name="author" content="Dreamguys - Bootstrap Admin Template">
		<meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @stack('title')

		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">

		<!-- Bootstrap CSS -->
		<?php if($locale=="ar"){ ?>
			<link rel="stylesheet" href="{{asset('css/rtl/bootstrap.rtl.min.css')}}">
		<?php } else {?>
			<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
		<?php }?>
        {{-- datapicker --}}
        <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.min.css')}}">

		<!-- Animation CSS -->
		<link rel="stylesheet" href="{{asset('css/rtl/animate.css')}}">

        <!-- Select2 CSS -->
		<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="{{asset('css/rtl/dataTables.bootstrap4.min.css')}}">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{asset('fonts/css/all.min.css')}}">

        {{-- toastr css --}}
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.css')}}">

		<!-- Main CSS -->
		<?php if($locale=="ar"){ ?>
			<link rel="stylesheet" href="{{asset('css/rtl/style.css')}}">
		<?php } else {?>
			<link rel="stylesheet" href="{{asset('css/style.css')}}">
		<?php }?>

		{{-- tags input css --}}
		<link rel="stylesheet" href="{{asset('css/tags_css/bootstrap-tagsinput.css')}}">

		<!-- jQuery UI CSS -->
		<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">

		{{-- carousel css --}}
		<link rel="stylesheet" href="{{asset('plugins/owlcarousel/owl.carousel.min.css')}}">

        {{-- custom css --}}

		<link rel="stylesheet" href="{{asset('css/custom.css')}}">

{{-- qoutation --}}

    <link rel="stylesheet" href="{{asset('css/flatpickr/flatpickr.min.css')}}">
    <link href="{{ asset('css/invoice_css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/invoice_css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/invoice_css/success.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/invoice_css/app.min.css') }}" rel="stylesheet" type="text/css" />

{{-- endqoutation --}}

	</head>
	<body>
		<div id="global-loader" >
			<div id="preloader-img">
				<img src="{{asset('images/system_images/logo.png')}}" alt="Logo">
			</div>
		</div>
		<!-- Main Wrapper -->
		<div class="main-wrapper">

			<!-- Header -->
			<div class="header">

				<!-- Logo -->
				<div class="header-left active">
					<a href="index.html" class="logo logo-normal">
						<img src="{{ asset('img/logo.png')}}"  alt="">
					</a>
					<a href="index.html" class="logo logo-white">
						<img src="{{ asset('img/logo-white.png')}}"  alt="">
					</a>
					<a href="index.html" class="logo-small">
						<img src="{{ asset('img/logo-small.png')}}"  alt="">
					</a>
					<a id="toggle_btn" href="javascript:void(0);">
						<i data-feather="chevrons-left" class="feather-16"></i>
					</a>
				</div>
				<!-- /Logo -->

				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<!-- Header Menu -->
				<ul class="nav user-menu">
					<!-- Search -->
					<li class="nav-item nav-searchinputs">
						<div class="top-nav-search">

							<a href="javascript:void(0);" class="responsive-search">
								<i class="fa fa-search"></i>
							</a>
							<form action="#">
								<div class="searchinputs">
									<input type="text" placeholder='<?php echo trans('messages.search_lang',[],session('locale')); ?>'>
									<div class="search-addon">
										<span><i data-feather="search" class="feather-14"></i></span>
									</div>
								</div>
								{{-- <a class="btn"  id="searchdiv"></a> --}}
							</form>
						</div>
					</li>
					<!-- /Search -->

					<!-- Flag -->
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
					<!-- /Flag -->

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
					</li> --> --}}
					<!-- Notifications -->
					{{-- <li class="nav-item dropdown nav-item-box">
						<a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<i data-feather="bell"></i><span class="badge rounded-pill">2</span>
						</a>
						<div class="dropdown-menu notifications">
							<div class="topnav-dropdown-header">
								<span class="notification-title">الإشعارات</span>
								<a href="javascript:void(0)" class="clear-noti">  عرض الكل </a>
							</div>
							<div class="noti-content">
								<ul class="notification-list">
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar flex-shrink-0">
													<img alt="" src="{{ asset('img/profiles/avatar-02.jpg')}}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">sسلطان</span> added new task <span class="noti-title"></span></p>
													<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar flex-shrink-0">
													<img alt="" src="{{ asset('img/profiles/avatar-03.jpg')}}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title"></span></p>
													<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar flex-shrink-0">
													<img alt="" src="{{ asset('img/profiles/avatar-06.jpg')}}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title"></span></p>
													<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar flex-shrink-0">
													<img alt="" src="{{ asset('img/profiles/avatar-17.jpg')}}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title"></span></p>
													<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
												</div>
											</div>
										</a>
									</li>
									<li class="notification-message">
										<a href="activities.html">
											<div class="media d-flex">
												<span class="avatar flex-shrink-0">
													<img alt="" src="{{ asset('img/profiles/avatar-13.jpg')}}">
												</span>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title"></span></p>
													<p class="noti-time"><span class="notification-time">2 days ago</span></p>
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
					<!-- /Notifications -->

					{{-- <li class="nav-item nav-item-box">
						<a href="generalsettings.html"><i data-feather="settings"></i></a>
					</li> --}}
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
				<!-- /Header Menu -->

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<!-- <a class="dropdown-item" href="#">My Profile</a> -->
						<!-- <a class="dropdown-item" href="generalsettings.html">Settings</a> -->
						<a class="dropdown-item" href="#">خروج</a>
					</div>
				</div>
				<!-- /Mobile Menu -->
			</div>
			<!-- Header -->

			<!-- Sidebar -->
			<div class="sidebar" id="sidebar">
				<div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="submenu-open">
								<h6 class="submenu-hdr"> {{ trans('messages.main_lang', [], session('locale')) }}</h6>
								<ul>
									<li class="active">
										<a href="index.html" ><i data-feather="grid"></i><span>{{ trans('messages.dashboard_lang', [], session('locale')) }}</span></a>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);"><i data-feather="align-justify"></i><span>{{ trans('messages.main_stock_lang', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
										<ul>
										<li><a href="{{ url('store') }}"><i data-feather="speaker"></i><span>{{ trans('messages.store_lang', [], session('locale')) }}</span></a></li>
										<li><a href="{{ url('category') }}"><i data-feather="codepen"></i><span>{{ trans('messages.category_lang', [], session('locale')) }}</span></a></li>
										<li><a href="{{ url('brand') }}"><i data-feather="tag"></i><span>{{ trans('messages.brand_lang', [], session('locale')) }}</span></a></li>
										<li><a href="{{ url('supplier') }}"><i data-feather="speaker"></i><span>{{ trans('messages.supplier_lang', [], session('locale')) }}</span></a></li>
										<li><a href="{{ url('addproduct') }}"><i data-feather="plus-square"></i><span>{{ trans('messages.sidebar_add_stock_lang', [], session('locale')) }}</span></a></li>
                                		<li><a href="{{  url('products')}}"><i data-feather="database"></i><span>{{ trans('messages.view_stock_lang', [], session('locale')) }}</span></a></li>
                                		<li><a href="{{  route('qty_audit')}}"><i data-feather="book"></i><span>{{ trans('messages.view_qty_audit_lang', [], session('locale')) }}</span></a></li>
                                        {{-- <li><a href="{{  url('pos')}}"><i data-feather="truck"></i><span>{{ trans('messages.pos_lang', [], session('locale')) }}</span></a></li> --}}

									</li>


								</ul>

								<li class="submenu">
										<a href="javascript:void(0);"><i data-feather="user-plus"></i><span>{{ trans('messages.sidebar_customer', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
										<ul>

                                        <li><a href="{{  url('customer')}}"><i data-feather="award"></i><span>{{ trans('messages.customer_list_lang', [], session('locale')) }}</span></a></li>
										<li><a href="{{  url('workplace')}}"><i data-feather="briefcase"></i><span>{{ trans('messages.workplace_lang', [], session('locale')) }}</span></a></li>
                                        <li><a href="{{  url('university')}}"><i data-feather="airplay"></i><span>{{ trans('messages.university_lang', [], session('locale')) }}</span></a></li>

								</li>
							</li>
						</ul>

						    <li class="submenu">
										<a href="javascript:void(0);"><i data-feather="smartphone"></i><span>{{ trans('messages.sidebar_accounting', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
									<ul>
                                		<li><a href="{{  url('account')}}"><i data-feather="shopping-bag"></i><span>{{ trans('messages.sidebar_bank_lang', [], session('locale')) }}</span></a></li>
                                		<li><a href="{{  url('purchases')}}"><i data-feather="pocket"></i><span>{{ trans('messages.add_purchase_lang', [], session('locale')) }}</span></a></li>

									</ul>
							</li>

                            <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="settings"></i><span>{{ trans('messages.maintenance', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('warranty')}}"><i data-feather="key"></i><span>{{ trans('messages.warranty', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('repairing')}}"><i data-feather="sliders"></i><span>{{ trans('messages.maintenance_main', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('repair_data')}}"><i data-feather="tool"></i><span>{{ trans('messages.maintenance_record', [], session('locale')) }}</span></a></li>
                                </ul>
                             </li>
                             <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="pie-chart"></i><span>{{ trans('messages.services', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('service')}}"><i data-feather="shopping-cart"></i><span>{{ trans('messages.services_list', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('technician')}}"><i data-feather="users"></i><span>{{ trans('messages.technicians_list', [], session('locale')) }}</span></a></li>

                                </ul>
                             </li>
                             <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="toggle-right"></i><span>{{ trans('messages.offers', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('offer')}}"><i data-feather="list"></i><span>{{ trans('messages.offer_list', [], session('locale')) }}</span></a></li>

                                </ul>
                             </li>
                             <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="send"></i><span>{{ trans('messages.messages_panel', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('sms')}}"><i data-feather="message-circle"></i><span>{{ trans('messages.create_message', [], session('locale')) }}</span></a></li>

                                </ul>
                             </li>
                             <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="check-square"></i><span>{{ trans('messages.quotation', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('qoutation')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.add_quotation', [], session('locale')) }}</span></a></li>

                                </ul>
                             </li>

                             <li class="submenu">
                                <a href="javascript:void(0);"><i data-feather="briefcase"></i><span>{{ trans('messages.setting', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{  url('setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.main_profile', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('maint_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.maint_setting', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('pos_qout_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.pos_qout', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('qout_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.qoutation', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('proposal_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.proposal', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('tax_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.tax', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('inspection_setting')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.inspection_agreement', [], session('locale')) }}</span></a></li>
                                    <li><a href="{{  url('points')}}"><i data-feather="help-circle"></i><span>{{ trans('messages.points_to_discount', [], session('locale')) }}</span></a></li>
                                </ul>
                             </li>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->

            @yield('main')
