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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

		{{-- carousel css --}}
		<link rel="stylesheet" href="{{asset('plugins/owlcarousel/owl.carousel.min.css')}}">

        {{-- custom css --}}

		<link rel="stylesheet" href="{{asset('css/custom.css')}}">

        {{-- qoutation --}}

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Bootstrap Css -->
    <link href="{{ asset('css/invoice_css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('css/invoice_css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/invoice_css/success.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css -->
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

					<!-- <li class="nav-item nav-item-box">
						<a href="javascript:void(0);" id="btnFullscreen">
							<i data-feather="maximize"></i>
						</a>
					</li>
					<li class="nav-item nav-item-box">
						<a href="email.html">
							<i data-feather="mail"></i>
							<span class="badge rounded-pill">1</span>
						</a>
					</li> -->
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
										<a href="javascript:void(0);"><i data-feather="smartphone"></i><span>{{ trans('messages.main_stock_lang', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
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
										<a href="javascript:void(0);"><i data-feather="smartphone"></i><span>{{ trans('messages.sidebar_customer', [], session('locale')) }}</span><span class="menu-arrow"></span></a>
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
                                		<li><a href="{{  url('purchases')}}"><i data-feather="shopping-bag"></i><span>{{ trans('messages.add_purchase_lang', [], session('locale')) }}</span></a></li>

									</li>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->






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


        <!-- jQuery -->
		<script src="{{  asset('js/jquery-3.6.0.min.js')}}"></script>

		<!-- Feather Icon JS -->
		<script src="{{  asset('js/feather.min.js')}}"></script>

		<!-- Slimscroll JS -->
		<script src="{{  asset('js/jquery.slimscroll.min.js')}}"></script>

		<!-- Datatable JS -->
		<script src="{{  asset('js/jquery.dataTables.min.js')}}"></script>
		<script src="{{  asset('js/dataTables.bootstrap4.min.js')}}"></script>

		<!-- Bootstrap Core JS -->
		<script src="{{  asset('js/bootstrap.bundle.min.js')}}"></script>

        <!-- Select2 JS -->
		<script src="{{  asset('js/select2.min.js')}}"></script>
        <script src="{{  asset('plugins/select2/js/custom-select.js')}}"></script>

        <!-- Datetimepicker JS -->
		<script src="{{  asset('js/moment.min.js')}}"></script>
		<script src="{{  asset('js/bootstrap-datetimepicker.min.js')}}"></script>

        <!-- Mask JS -->
		<script src="{{  asset('js/jquery.maskedinput.min.js')}}"></script>

		<!-- Chart JS -->
		<script src="{{  asset('js/apexcharts.min.js')}}"></script>
		<script src="{{  asset('js/chart-data.js')}}"></script>

        {{-- image js --}}
        <script src="{{  asset('plugins/fileupload/fileupload.min.js') }}"></script>

        {{-- toastr js --}}
        <script src="{{  asset('plugins/toastr/toastr.min.js')}}"></script>
		<script src="{{  asset('plugins/toastr/toastr.js')}}"></script>

        {{-- tags js --}}
        <script src="{{  asset('js/tags_js/bootstrap-tagsinput.min.js')}}"></script>
		<script src="{{  asset('js/tags_js/typeahead.bundle.min.js')}}"></script>

        {{-- barcode js --}}
        <script src="{{  asset('js/JsBarcode.all.min.js')}}"></script>

        <!-- jQuery UI library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        {{-- caousel js --}}
        <script src="{{  asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>

         <!-- Sweetalert 2 -->
		<script src="{{  asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
		<script src="{{  asset('plugins/sweetalert/sweetalerts.min.js')}}"></script>

        {{-- qoutation --}}
     <script src="{{ asset('js/invoice_js/layout.js') }}"></script>
    <script src="{{ asset('js/invoice_js/app.js') }}"></script>
     {{-- <script src="{{ asset('js/invoice_js/chek.js') }}"></script> --}}
   <script src="{{ asset('js/invoice_js/company_name.js') }}"></script>
    <script src="{{ asset('js/invoice_js/success_error.js') }}"></script>
    <script src="https://unpkg.com/signature_pad"></script>
    <script src="{{ asset('js/invoice_js/signature.js') }}"></script>
    <script src="{{ asset('js/invoice_js/remaining.js') }}"></script>
    <!-- Include Signature Pad library scripts -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@1.5.3/dist/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ja.js"></script>


        {{-- endqoutation  --}}


		<!-- Custom JS -->
        <script src="{{  asset('js/script.js')}}"></script>
        @include('custom_js.custom_js')

        @php
            // Get the current route name
            $routeName = Route::currentRouteName();

            // Split the route name to get the controller name
            $segments = explode('.', $routeName);

            // Get the controller name (assuming it's the first segment)
            $controllerName = isset($segments[0]) ? $segments[0] : null;
        @endphp

        @if ($controllerName == 'category')
            {{-- Include the JavaScript file for adding category --}}
            @include('custom_js.add_category_js')
        @elseif ($controllerName == 'brand')
            {{-- Include the JavaScript file for adding brand --}}
            @include('custom_js.add_brand_js')
        @elseif ($controllerName == 'supplier')
            {{-- Include the JavaScript file for adding supplier --}}
            @include('custom_js.add_supplier_js')
        @elseif ($controllerName == 'store')
            {{-- Include the JavaScript file for adding store --}}
            @include('custom_js.add_store_js')
        @elseif ($controllerName == 'addproduct')
            {{-- Include the JavaScript file for adding product --}}
            @include('custom_js.add_purchase_js')
        @elseif ($controllerName == 'purchases')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_purchase_js')
        @elseif ($controllerName == 'edit_purchase')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_purchase_js')
        @elseif ($controllerName == 'account')
            {{-- Include the JavaScript file for adding account --}}
            @include('custom_js.add_account_js')
        @elseif ($controllerName == 'products')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_product_js')
        @elseif ($controllerName == 'product_view')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_product_js')
        @elseif ($controllerName == 'qty_audit')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_product_js')
        @elseif ($controllerName == 'university')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_university_js')
        @elseif ($controllerName == 'workplace')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_workplace_js')
        @elseif ($controllerName == 'customer')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_customer_js')
        @elseif ($controllerName == 'service')
            {{-- Include the JavaScript file for purchase --}}
            @include('custom_js.add_service_js')
        @elseif ($controllerName == 'technician')
        {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_technician_js')
        @elseif ($controllerName == 'qoutation')
        {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_qout_js')
        @endif



	</body>
</html>
