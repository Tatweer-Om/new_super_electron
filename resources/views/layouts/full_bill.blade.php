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
		{{-- <link rel="stylesheet" href="{{asset('css/rtl/dataTables.bootstrap4.min.css')}}"> --}}
		{{-- <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap5.min.css')}}"> --}}


		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{asset('fonts/css/all.min.css')}}">


        {{-- toastr css --}}
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.css')}}">

		<!-- Main CSS -->
		<?php if($locale=="ar"){ ?>
			<link rel="stylesheet" href="{{asset('css/rtl/style.css')}}">
			{{-- <link rel="stylesheet" href="{{asset('css/style_setting_rtl.css')}}"> --}}
			<link rel="stylesheet" href="{{asset('css/rtl/dataTables.bootstrap4.min.css')}}">
		<?php } else {?>
			<link rel="stylesheet" href="{{asset('css/style.css')}}">
			{{-- <link rel="stylesheet" href="{{asset('css/style_setting.css')}}"> --}}
			<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">

		<?php }?>

{{-- qout --}}
        <link href="{{ asset('css/invoice_css/success.css') }}" rel="stylesheet" type="text/css" />

		{{-- tags input css --}}
		<link rel="stylesheet" href="{{asset('css/tags_css/bootstrap-tagsinput.css')}}">

		<!-- jQuery UI CSS -->
		<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">

		{{-- carousel css --}}
		<link rel="stylesheet" href="{{asset('plugins/owlcarousel/owl.carousel.min.css')}}">

        {{-- custom css --}}

		<link rel="stylesheet" href="{{asset('css/custom.css')}}">

        <link rel="stylesheet" href="{{asset('css/summer/summernote-bs4.min.css')}}">

        <style type="text/css">
            body
            {
                font-family: Tajawal;
                font-size: 16px!important;

                /*font-weight: bold*/
            }
            .bold
            {
                font-weight: bold;
            }
            .header_td
            {
               border-top:0px!important;
               font-weight: bold;
            }
            table td, th
            {
               border: 1px solid;
            }
            .data_tr > td
            {
                border-top: 0px;
                border-bottom: 0px;
            }
           /* .item_table td
            {
                text-align: left;
            }*/
            .bold-header
            {
                font-weight: bolder;
            }
            table {
                font-size: 24px; /* Increase the font size to your desired value */
            }
        </style>

	</head>

	<body>
 <div class="main-wrapper">
     <div class="container-fluid" style="background-color: #fff">
         <div class="row">
             <div class="col-md-12 text-center">
            <img src="{{ asset('images/setting_images/' . $shop->invo_logo) }}" style="width: 10%;">
             </div>
         </div>
         <div class="row">
             <div class="col-md-4"></div>
             <div class="col-md-4 text-center">
                 <h1 style="font-size: 40px;font-weight: bold;">Warranty Card فاتورة </h1><br><p>Warranty No. {{ $order_no ?? 'N/A' }}</p>

             </div>
             <div class="col-md-4 text-right">
                 <h1 style="margin-right: 65px;font-size: 40px;font-weight: bold;"></h1>
             </div>
         </div>
         <div class="row" style="padding: 52px;">
            <table width="100%" style="border-bottom: 0px!important;">
                <tr>
                    <td colspan="3" style="padding-bottom: 0px!important; padding-left: 20px; padding-right: 20px; width: 70%;">
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <span class="bold-header">Customer Name:</span><br>
                                <span>{{ $customer_name  ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-3 text-right">
                                <span class="bold-header">Customer Phone:</span><br>
                                <span>{{ $customer_phone ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="bold-header">Customer ID:</span><br>
                                <span>{{ $customer_no ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-3 text-center">
                                <span class="bold-header">National ID:</span><br>
                                <span>{{ $national_id ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>

                    <td colspan="3" style="padding-bottom: 0px!important; padding-left: 20px; width: 30%;">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <span class="bold-header">Created By:</span>
                                <span>user</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <span class="bold-header">Created At:</span>
                                <span>
                                    <?php echo date('Y-m-d'); ?>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Table for warranty details -->
            <table width="100%" style="border-collapse: collapse;">
                <!-- Header row for the column names -->
                <tr>
                    <th class="bold-header" style="width: 20%; text-align: center;">Product Detail</th>
                    <th class="bold-header" style="width: 20%; text-align: center;">Total Price</th>
                    <th class="bold-header" style="width: 20%; text-align: center;">Product Barcode/IMEI</th>
                    <th class="bold-header" style="width: 20%; text-align: center;">Warranty</th>
                    <th class="bold-header" style="width: 20%; text-align: center;">Warranty Validity</th>
                </tr>

                @foreach ($warrantyData as $data)
                <tr>
                    <td style="padding-bottom: 0px!important; text-align: center;">
                        <span>
                            {{ $data['product_name'] ?? 'N/A' }}<br>
                            <small>({{ $data['warranty']->quantity ?? 'N/A' }} Item)</small>
                        </span>
                    </td>
                    <td style="padding-bottom: 0px!important; text-align: center;">
                        <span>{{ $data['warranty']->total_price ?? 'N/A' }}</span>
                    </td>
                    <td style="padding-bottom: 0px!important; text-align: center;">
                        <span>
                            {{ $data['warranty']->item_imei ? $data['warranty']->item_imei : $data['warranty']->item_barcode ?? 'N/A' }}
                        </span>
                    </td>
                    <td style="padding-bottom: 0px!important; text-align: center;">
                        <span>
                            Type: {{ $data['warranty']->warranty_type == 1 ? 'shop' : 'agent' }}<br>
                            Days: {{ $data['warranty']->warranty_days ?? 'N/A' }}
                        </span>
                    </td>
                    <td style="padding-bottom: 0px!important; text-align: center;">
                        <span>
                            {{ $created_at->addDays($data['warranty']->warranty_days)->format('Y-m-d') }}
                            <br>
                            @php
                                // Calculate the difference between the start and end date using DateInterval
                                $start_date = $created_at;
                                $end_date = clone $start_date;
                                $end_date->addDays($data['warranty']->warranty_days);

                                // Calculate the interval (difference) between the start and end date
                                $interval = $start_date->diff($end_date);

                                // Extract months and days from the interval
                                $months = $interval->m + ($interval->y * 12);
                                $days = $interval->d;
                            @endphp
                            ({{ $months }} months and {{ $days }} days)
                        </span>
                    </td>

                </tr>
                @endforeach
            </table>
        </div>






     </div>
 </div>

 <script src="{{  asset('js/jquery-3.6.0.min.js')}}"></script>


 <!-- Feather Icon JS -->
 <script src="{{  asset('js/feather.min.js')}}"></script>

 <!-- Slimscroll JS -->
 <script src="{{  asset('js/jquery.slimscroll.min.js')}}"></script>

 <!-- Datatable JS -->
  <script src="{{  asset('js/jquery.dataTables.min.js')}}"></script>
 <script src="{{  asset('js/dataTables.bootstrap5.min.js')}}"></script>
 {{-- <script src="{{  asset('js/dataTables.bootstrap4.min.js')}}"></script> --}}
  {{-- <script src="{{  asset('js/jquery_repair.dataTables.min.js')}}"></script> --}}

 <!-- Bootstrap Core JS -->
 <script src="{{  asset('js/bootstrap.bundle.min.js')}}"></script>

 <!-- Select2 JS -->
 <script src="{{  asset('js/select2.min.js')}}"></script>
 <script src="{{  asset('js/select_repair.min.js')}}"></script>

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
 <script src="{{  asset('js/jquery-ui.min.js')}}"></script>

 {{-- caousel js --}}
 <script src="{{  asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>

  <!-- Sweetalert 2 -->
 <script src="{{  asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
 <script src="{{  asset('plugins/sweetalert/sweetalerts.min.js')}}"></script>
 <script src="{{  asset('plugins/summer/summernote-bs4.min.js')}}"></script>

 {{-- //settingsjs --}}
 <script src="{{  asset('js/ResizeSensor.js')}}"></script>
 <script src="{{  asset('js/theia-sticky-sidebar.js')}}"></script>




 {{-- multiple select --}}
 <script src="{{  asset('select2_js/select2.min.js')}}"></script>



 <!-- Custom JS -->
 <script src="{{  asset('js/script.js')}}"></script>
 @include('custom_js.custom_js')

</body>
</html>
