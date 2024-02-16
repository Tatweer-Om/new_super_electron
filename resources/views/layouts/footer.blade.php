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
                @endif



	</body>
</html>
