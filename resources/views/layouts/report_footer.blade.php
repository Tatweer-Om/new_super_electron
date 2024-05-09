        <!-- jQuery -->
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
        <script src="{{  asset('js/select2.min.js')}}"></script>


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


        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>



        {{-- multiple select --}}
        <script src="{{  asset('select2_js/select2.min.js')}}"></script>



		<!-- Custom JS -->
        <script src="{{  asset('js/script.js')}}"></script>
        @include('custom_js.custom_js')

        @php
            // Get the current route name
            $routeName = Route::currentRouteName();

            // Split \ route name to get the controller name
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
            @elseif ($controllerName == 'customer_profile')
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
            @elseif ($controllerName == 'qouts')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_qout_js')
             @elseif ($controllerName == 'view_qout')
                {{-- Include the JavaScript file for technician --}}
             @include('custom_js.add_qout_js')
        @elseif ($controllerName == 'sms')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_sms_js')
        @elseif ($controllerName == 'tax_setting')
            {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'inspection_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'maint_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'proposal_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'qout_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'pos_qout_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'tax_setting')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'points')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_setting_js')
        @elseif ($controllerName == 'offer')
        {{-- Include the JavaScript file for technician --}}
        @include('custom_js.add_offer_js')

        @elseif ($controllerName == 'repair_data')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_repairing_js')
        @elseif ($controllerName == 'maintenance_profile')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_repairing_js')
        @elseif ($controllerName == 'expense_category')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_expense_category_js')
        @elseif ($controllerName == 'expense')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_expense_js')

        @elseif ($controllerName == 'ministry')
            {{-- Include the JavaScript file for minsitry --}}
            @include('custom_js.add_ministry_js')
        @elseif ($controllerName == 'issuetype')
            {{-- Include the JavaScript file for issuetype --}}
            @include('custom_js.add_issuetype_js')
        @elseif ($controllerName == 'authuser')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_authuser_js')
        @elseif ($controllerName == 'draw' || $controllerName == 'draw_profile')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.draw_js')
        @elseif ($controllerName == 'localmaintenance')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_local_maintenance_js')
        @elseif ($controllerName == 'loginform')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.add_authuser_js')
        @elseif ($controllerName == 'customer_profile')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.profile_js')

        @elseif ($controllerName == 'reprint')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reprint_js')
            @elseif ($controllerName == 'expense_report')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'sales_report')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')

            @elseif ($controllerName == 'supplier_report')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'most_sold')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'profit_expense')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'category_sale')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'brand_sale')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'customer_point')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.customer_point_js')
            @elseif ($controllerName == 'local_repair')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'warranty_repair')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.reports_js')
            @elseif ($controllerName == 'stock_report')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.stock_report_js')
            @elseif ($controllerName == 'reports')
            {{-- Include the JavaScript file for technician --}}
            @include('custom_js.report_page_js')

        @endif



	</body>
</html>
