<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // seach paid ordr
        // $('.order-details').hide();

        // Show order details when order number matches the search input
        // Function to show matching order details based on search input
        function showMatchingOrders(searchOrderNo) {
            if (searchOrderNo.trim() === '') {
                // If search input is empty, show all order details
                $('.order-details').show();
            } else {
                // If search input has a value, show matching order details
                $('.order-details').hide().filter(function() {
                    return $(this).data('order-no').startsWith(searchOrderNo);
                }).show();
            }
        }

        // Initially show all order details
        showMatchingOrders('');

        // Show matching order details when user types in the search input
        $('#orderNoSearch').on('input', function() {
            var searchOrderNo = $(this).val().trim();
            showMatchingOrders(searchOrderNo);
        });
        // focus on product list
        $('.product_input ').focus();
        // catregory carusel
        // POS Category Slider
        var dirValue = $('html').attr('dir');
        if(dirValue=='rtl')
        {
            if($('.pos-category').length > 0) {
                $('.pos-category').owlCarousel({
                    rtl : true,
                    items: 6,
                    loop:false,
                    margin:8,
                    nav:true,
                    dots: false,
                    autoplay:false,
                    smartSpeed: 1000,
                    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                    responsive:{
                        0:{
                            items:2
                        },
                        500:{
                            items:3
                        },
                        768:{
                            items:4
                        },
                        991:{
                            items:5
                        },
                        1200:{
                            items:6
                        },
                        1401:{
                            items:6
                        }
                    }
                })
            }
        }
        else
        {
            if($('.pos-category').length > 0) {
                $('.pos-category').owlCarousel({
                    ltr : true,
                    items: 6,
                    loop:false,
                    margin:8,
                    nav:true,
                    dots: false,
                    autoplay:false,
                    smartSpeed: 1000,
                    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                    responsive:{
                        0:{
                            items:2
                        },
                        500:{
                            items:3
                        },
                        768:{
                            items:4
                        },
                        991:{
                            items:5
                        },
                        1200:{
                            items:6
                        },
                        1401:{
                            items:6
                        }
                    }
                })
            }
        }

        // on open payment modal
        $('#payment_modal_id').on('click', function (e) {
            var tbody = $('#order_list');
            if (tbody.find('tr').length > 0) {
                $('#payment_modal').modal('show');
                var grand_total = $('.grand_total').text();
                $('.cash_payment').val(grand_total);
                total_calculation();
            }
            else
            {
                show_notification('error', '<?php echo trans('messages.please_add_product_in_list_lang', [], session('locale')); ?>');

            }
        });
        // add pos order
        $('#add_pos_order').click(function() {


            var action_type = ($(this).attr('id') === 'hold') ? 'hold' : 'add';
            var item_count = $('.count').text();
            var grand_total = $('.grand_total').text();
            var sub_total = $('.sub_total').text();
            // var payment_gateway= $('.payment_gateway_all').val();
            // var discount_by = $('.discount_by').val();
            var discount_by = "";
            var cash_payment = $('.cash_payment').val();
            if(cash_payment==''){
                show_notification('error', '<?php echo trans('messages.please_pay_cash_payment_lang', [], session('locale')); ?>');
            }
            var discount_type = 1;
            // if ($('.discount_check').is(':checked')) {
            //     var discount_type = 2;
            // }
            var total_tax = $('.total_tax').text();
            var total_discount = $('.grand_discount').text();
            // var cash_back = $('.cash_back').text();
            var cash_back = $('.remaining_point_amount').text();
            var customer_id = "";
            if($('.pos_customer_id').val()!="")
            {
                customer_id = $('.pos_customer_id').val();
            }

            // var payment_method = $('input[name="payment_gateway"]:checked').val();
            // if(payment_method == "")
            // {
            //     show_notification('error', '<?php echo trans('messages.please_select_payment_method_lang', [], session('locale')); ?>');
            //     return false;
            // }
            // point omr
            var point_omr = $('.get_point_amount').val();
            if(point_omr == "")
            {
                point_omr =0;
            }
            var sum = 0;
            var cash_sum = 0;
            $('.payment_methods_value').each(function() {
                var value = parseFloat($(this).val());
                var cash_type = $(this).attr('cash-type');
                if(cash_type == 1)
                {
                    if (!isNaN(value)) {
                        cash_sum = value;
                    }
                }
                else
                {
                    if (!isNaN(value)) {
                        sum += value;
                    }
                }

            });

            var final_omr = $('.grand_total').text();
            if(final_omr == "")
            {
                final_omr =0;
            }
            final_without_cash = parseFloat(sum) + parseFloat(point_omr);
            final_with_cash = parseFloat(cash_sum) + parseFloat(sum) + parseFloat(point_omr);

            if(cash_sum <= 0 &&  final_without_cash > final_omr)
            {
                show_notification('error','<?php echo trans('messages.validation_amount_greater_than_lang',[],session('locale')); ?>');
                return false;
            }

            if(cash_sum <= 0 && final_without_cash < final_omr)
            {
                show_notification('error','<?php echo trans('messages.validation_amount_less_than_lang',[],session('locale')); ?>');
                return false;
            }

            if(cash_sum > 0 && final_without_cash > final_omr)
            {
                show_notification('error','<?php echo trans('messages.validation_amount_greater_than_lang',[],session('locale')); ?>');
                return false;
            }

            // get payment method
            var payment_method = [];

            // Iterate over each checked checkbox
            $('.payment_methods:checked').each(function() {
                var checkboxValue = $(this).val(); // Get the value of the checked checkbox

                var inputValue = $('#payment_methods_value_id' + checkboxValue).val();
                var cash_type = $('#payment_methods_value_id' + checkboxValue).attr('cash-type');
                if(cash_type == 1)
                {
                    cash_acc = 1;
                }
                else
                {
                    cash_acc = "";
                }
                console.log(inputValue)
                // Push both checkbox and input values as an object to the values array
                payment_method.push({ checkbox: checkboxValue, input: inputValue,cash_data : cash_acc});
            });
            // Add the "point" checkbox value and the input value "10" outside the loop
            if(point_omr != "")
            {
                var pointValue = 0;
                var inputValue10 = point_omr;
                payment_method.push({ checkbox: pointValue, input: inputValue10,cash_data : ""});

            }


            var product_id = [];
            $('.stock_ids').each(function() {
                product_id.push($(this).val());
            });
            if(product_id.length===0)
            {
                show_notification('error', '<?php echo trans('messages.please_add_product_in_list_lang', [], session('locale')); ?>');
                return false;
            }
            var item_barcode = [];
            $('.barcode').each(function() {
                item_barcode.push($(this).val());
            });

            var item_tax = [];
            $('.tax').each(function() {
                item_tax.push($(this).val());
            });

            var item_imei = [];
            $('.imei').each(function() {
                if($(this).val() == 'undefined' || $(this).val()=="")
                {
                    imei_one = ""
                }
                else
                {
                    imei_one = $(this).val()
                }
                item_imei.push(imei_one);
            });
            if (item_imei!="") {
                if(customer_id=="")
                {
                    show_notification('error', '<?php echo trans('messages.please_select_customer_lang', [], session('locale')); ?>');
                    return false;
                }
            }
            var item_quantity = [];
            $('.qty-input').each(function() {
                item_quantity.push($(this).val());
            });
            var item_price = [];
            $('.price').each(function() {
                item_price.push($(this).val());
            });

            var item_total = [];
            $('.total_price').each(function() {
                item_total.push($(this).text());
            });
            var item_discount = [];
            $('.discount').each(function() {
                item_discount.push($(this).val());
            });

            var form_data = new FormData();
            form_data.append('item_count', item_count);
            // form_data.append('payment_gateway', payment_gateway);
            form_data.append('action_type', action_type);
            form_data.append('grand_total', grand_total);
            form_data.append('cash_payment', cash_payment);
            form_data.append('discount_type', discount_type);
            form_data.append('discount_by', discount_by);
            form_data.append('total_tax', total_tax);
            form_data.append('total_discount', total_discount);
            form_data.append('cash_back', cash_back);
            form_data.append('payment_method', JSON.stringify(payment_method));
            form_data.append('product_id', JSON.stringify(product_id));
            form_data.append('item_barcode', JSON.stringify(item_barcode));
            form_data.append('item_tax', JSON.stringify(item_tax));
            form_data.append('item_imei', JSON.stringify(item_imei));
            form_data.append('item_quantity', JSON.stringify(item_quantity));
            form_data.append('item_discount', JSON.stringify(item_discount));
            form_data.append('item_price', JSON.stringify(item_price));
            form_data.append('item_total', JSON.stringify(item_total));
            form_data.append('customer_id', customer_id);
            form_data.append('_token', csrfToken);

            $.ajax({
                url: "{{ url('add_pos_order') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: form_data,
                success: function(response) {
                    if(response.not_available > 0)
                    {
                        show_notification('error', response.finish_name + ' <?php echo trans('messages.product_stock_not_available_lang', [], session('locale')); ?>');
                        return false;
                    }
                    else
                    {
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                        $('#payment_modal').modal('hide');
                        // $('#payment-completed').modal('show');
                        let orderUrl = `pos_bill/${response.order_no}`;
                        window.open(orderUrl, '_blank');
                        $('#pos_order_no').text(response.order_no);
                        $('#customer_input_data').val('');
                        $('.pos_customer_id').val('');
                        location.reload();
                    }
                }
            });
        });

        $('#payment-completed').on('hidden.bs.modal', function() {
            location.reload();
        });

        cat_products('all');
        var totalQuantity = 0;

        $(document).on('click', '.inc', function() {
            var $qtyInput = $(this).siblings('.qty-input');
            var productBarcode = $(this).closest('tr').find('.barcode').val();
            var count = parseInt($qtyInput.val());
            product_quantity(productBarcode, count + 1, $qtyInput, 1);
        });

        function product_quantity(productBarcode, count, $qtyInput, qty_type) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ url('order_list') }}",
                data: {
                    product_barcode: productBarcode,
                    quantity: count,
                    _token: csrfToken
                },
                success: function(response) {

                    $('.price_' + productBarcode).val(response.product_price);
                    $('.show_pro_price_' + productBarcode).html(' ' + response.product_price);

                    if (response.error_code == 2) {
                        show_notification('error', '<?php echo trans('messages.product_stock_not_available_lang', [], session('locale')); ?>');
                        count--;
                        $qtyInput.val(count)

                    } else {

                        if (qty_type == 1) {
                            // count++;
                            $qtyInput.val(count);
                            totalQuantity++;
                            total_calculation();
                        } else {
                            if (count != 0) {

                                $qtyInput.val(count);
                                totalQuantity--;
                                total_calculation();
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).on('click', '.dec', function() {
            var $qtyInput = $(this).siblings('.qty-input');
            var productBarcode = $(this).closest('tr').find('.barcode').val();
            var count = parseInt($qtyInput.val());
            product_quantity(productBarcode, count - 1, $qtyInput, 2);
        });

        $('#order_list').on('click', '#delete-item', function() {

            var $productItem = $(this).closest('tr');
            $productItem.remove();
            total_calculation();
        });

        $('#clear_list').click(function() {
            $('#order_list').empty();
            totalQuantity = 0;
            total_calculation();
        });

    });

    //get pro imei
    function get_pro_imei(barcode) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ url('get_pro_imei') }}",
            data: {
                barcode: barcode,
                _token: csrfToken
            },
            success: function(response) {
                $('#quick').modal('hide');
                $('#hold_order').modal('show');

                $('#all_pro_imei').html("");
                var productHtml = "";
                response.product_imei.forEach(function(product) {
                    var ime_string = "'" + product.imei + "'";
                    onclick_func = 'onclick="order_list(' + product.barcode + ','  +ime_string +
                        ')"';
                    var pro_image = "{{ asset('images/dummy_image/no_image.png') }}";
                    if (response.stock_image && response.stock_image !== '') {
                        pro_image = "{{ asset('images/product_images/') }}" + response.stock_image;
                    }
                    productHtml = productHtml + `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 pe-2" ${onclick_func}>
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg" >
                                    <img src="${pro_image}" alt="Products"
                                        style= height:60px;" >
                                    <span><i data-feather="check" class="feather-16"></i></span>
                                </a>
                                <h6 class="product_name"><a href="javascript:void(0);">${response.product_name}</a></h6>
                                <h6 class="product_imei"><a href="javascript:void(0);">${product.imei}</a></h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p>  ${response.sale_price}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#all_pro_imei').html(productHtml);


            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }



    function cat_products(cat_id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ url('cat_products') }}",
            data: {
                cat_id: cat_id,
                _token: csrfToken
            },
            success: function(response) {

                $('#cat_products').html("");
                var productHtml = "";
                response.products.forEach(function(product) {
                    if (product.check_imei == 1) {
                        onclick_func = 'onclick="get_pro_imei(' + product.barcode + ')"';
                    } else {
                        onclick_func = 'onclick="order_list(' + product.barcode + ')"';
                    }
                    var pro_image = "{{ asset('images/dummy_image/no_image.png') }}";
                    if (product.stock_image && product.stock_image !== '') {
                        pro_image = "{{ asset('images/product_images/') }}" + product.stock_image;
                    }
                    var title = product.product_name;
                    if (title === null || title === undefined || title === '')
                    {
                        title = product.product_name_ar;
                    }

                    productHtml = productHtml + `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 pe-2 " ${onclick_func}>
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg" >
                                    <img src="${pro_image}" alt="Products"
                                        style= height:60px;" >
                                    <span><i data-feather="check" class="feather-16"></i></span>
                                </a>
                                <h6 class="cat-name"><a href="javascript:void(0);">${response.category_name}</a></h6>
                                <h6 class="product-name"><a href="javascript:void(0);">${title}</a></h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>${product.quantity} PCs</span>
                                    <p>  ${product.sale_price}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#cat_products').html(productHtml);


            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // scroll to bottom of order_list
    function order_list_bottom()
    {
        $('.product-wrap').animate({ scrollTop: $('.product-wrap')[0].scrollHeight }, 'slow');
    }
    function order_list(product_barcode, imei) {

        var quantity = 0;
        if ($('#order_list').find('div.list_' + product_barcode).length > 0) {
            var old_quantity = $('.product-list.list_' + product_barcode + ' .qty-input').val();
            var quantity = parseFloat(old_quantity) + 1;
        } else {
            var quantity = 1;
        }


        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ url('order_list') }}",
            data: {
                quantity: quantity,
                imei: imei,
                product_barcode: product_barcode,
                _token: csrfToken
            },
            success: function(response) {

                if (response.error_code == 2) {
                    show_notification('error', '<?php echo trans('messages.product_stock_not_available_lang', [], session('locale')); ?>');
                    var audio = new Audio('/sounds/qty.mp3'); // Adjust the filename as per your audio file
                    audio.play();
                }

                else {


                    if ($('#order_list').find('div.list_' + product_barcode).length > 0 && (typeof imei === 'undefined')) {

                        if (response.is_bulk == 1) {
                            $('.price_' + product_barcode).val(response.product_price);
                            $('.show_pro_price_' + product_barcode).html(response.product_price);
                        }

                        var $existingProduct = $('#order_list').find('div.list_' + product_barcode);
                        var $qtyInput = $existingProduct.find('.qty-input');
                        var count = parseInt($qtyInput.val());
                        count++;
                        $qtyInput.val(count);

                    }

                 else {

                    if($('#order_list').find('.imei_'+ imei).length ===1 && (typeof imei != 'undefined')){
                        show_notification('error', '<?php echo trans('messages.product_already_added_with_same_emei_lang', [], session('locale')); ?>');
                        var audio = new Audio('/sounds/horn.mp3'); // Adjust the filename as per your audio file
                        audio.play();
                    }

                        else{
                    var rowCount = $('#order_list tr').length;
                    rowCount = rowCount+1;
                    var pro_image = "{{ asset('images/dummy_image/no_image.png') }}";
                    if (response.product_image && response.product_image !== '') {
                        pro_image = "{{ asset('images/product_images/') }}" + response.product_image;
                    }

                    var warranty_type = "";
                    if(response.warranty_type!="")
                    {
                        warranty_type =  `<br><span class="badge badge-success"> ${response.warranty_type}</span> `;
                    }
                    var show_imei="";
                    if (typeof imei !== 'undefined' && imei !== "") {
                        show_imei = `<br>${response.imei_serial} : <span class="badge badge-warning">${imei}</span>`;
                    }
                    var final_name = "";
                    if(response.title_name != "")
                    {
                        final_name = response.title_name;
                    }
                    if(final_name == "")
                    {
                        final_name = response.title_name_ar;
                    }
                    else if(final_name!= "" && response.title_name_ar != "")
                    {
                        final_name = final_name+"<br>"+response.title_name_ar;
                    }
                    // <a  href="#" data-bs-toggle="modal" onclick="edit_product(${response.product_barcode})" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>
                        var orderHtml = `
                        <tr class="list_${product_barcode}">
                            <th>${rowCount}</th>
                            <th>${final_name}
                                <input type="hidden" name="stock_ids" value="${response.id}" class="stock_ids product_id_${response.id}">
                                <input type="hidden" name="product_tax" value="${response.product_tax}" class="tax tax_${response.product_barcode}">
                                <input type="hidden" value="${response.product_min_price}" class="min_price min_price_${response.product_barcode}">
                                <input type="hidden" value="${response.product_name}" class="product_name product_name_${response.product_barcode}">
                                <input type="hidden" name="product_barcode" value="${response.product_barcode}" class="barcode barcode_${response.product_barcode}">

                                <br>
                                <span class="badge badge-warning"> ${response.product_barcode}</span>
                                ${warranty_type}
                                ${show_imei}
                                <input type="hidden" value="${imei}" class="imei imei_${imei}">
                            </th>
                            <th class="text-center">
                                <input type="text" readonly style="width:60px" value="${response.product_price}" class="price price_${response.product_barcode}">
                            </th>
                            <th class="text-center">
                                <div class="product-list item_list d-flex align-items-center justify-content-between">

                                    <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                                        <div class="qty-item text-center " ${typeof imei === 'undefined' ? '' : 'style="display:none"'} >
                                            <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i class="fas fa-minus-circle"></i></a>

                                            <input type="text" class="form-control text-center qty-input" name="product_quantity" value="1">

                                            <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i class="fas fa-plus-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th class="text-center"><span class="total_price total_price_${response.product_barcode}"></span></th>
                            <th class="text-center">
                                <input type="text" style="width:60px" readonly value="25">
                                <br>
                                <input type="text" style="width:60px" readonly value="5">
                            </th>
                            <th class="text-center">
                                <input type="text" style="width:60px" name="product_discount" value="0" class="discount discount_${response.product_barcode}">
                            </th>
                            <th class="text-center">
                                <span class="grand_price grand_price_${response.product_barcode}"></span>
                            </th>
                            <th class="text-center">
                                <a  href="#" data-bs-toggle="modal" onclick="edit_product(${response.product_barcode})" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>

                                <a id="delete-item" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                            </th>
                        </tr>

                `;

                        $('#order_list').append(orderHtml);
                        show_notification('success', '<?php echo trans('messages.item_add_to_list_lang', [], session('locale')); ?>');
                        var audio = new Audio('/sounds/test.mp3'); // Adjust the filename as per your audio file
                        audio.play();
                    }
                }
                }
                total_calculation();
                $('.product_input ').val('');
                $('.product_input ').focus();
                setTimeout(order_list_bottom, 100);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }


    //edit product
    function edit_product(barcode) {
        var tax = $('.tax_' + barcode).val();
        var min_price = $('.min_price_' + barcode).val();
        var product_name = $('.product_name_' + barcode).val();
        var price = $('.price_' + barcode).val();
        var discount = $('.discount_' + barcode).val();
        $('.edit_barcode').val(barcode);
        $('.edit_tax').val(tax);
        $('.edit_price').val(price);
        $('.edit_min_price').val(min_price);
        $('.edit_discount').val(discount);
        $('.edit_pro_name').text(product_name);
    }

    function update_product() {
        var barcode = $('.edit_barcode').val();
        var tax = $('.edit_tax').val();
        var price = $('.edit_price').val();
        var min_price = $('.edit_min_price').val();
        var discount = $('.edit_discount').val();

        if (parseFloat(price) < parseFloat(min_price)) {
            show_notification('error', '<?php echo trans('messages.total_price_cannot_exceed_lang', [], session('locale')); ?>');
            return;
        }
        $('.tax_' + barcode).val(tax);
        $('.min_price_' + barcode).val(min_price);
        $('.price_' + barcode).val(price);
        $('.discount_' + barcode).val(discount);
        $('.show_pro_price_' + barcode).text(' ' + price);
        $('#edit-product').modal('hide');
        total_calculation()
    }

    //auto complete

    $(".product_input").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "{{ url('product_autocomplete') }}",
            method: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                term: request.term
            },

            success: function(data) {
                response(data.slice(0, 10));
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    },

}).autocomplete("search", "");

//chek_imei
$('.product_input, #enter').on('keypress click', function(event) {
    if ((event.which === 13 && event.target.tagName !== 'A') || (event.target.id === 'enter' && event.type === 'click')) {
        var product_input = $('.product_input').val();
        // var value = $(this).val();
        var parts = product_input.split('+');
        var barcode = parts[1];
        $.ajax({
            url: "{{ url('get_product_type') }}",
            method: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                barcode: barcode
            },

            success: function(data) {
                if (data.check_imei == 1) {
                    get_pro_imei(barcode)
                    return false;
                }
                else
                {
                    order_list(barcode)
                    return false;
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }
});





//end check_imei


    //end autocomplete
    var discount_type = 1;

    function switch_discount_type() {
        discount_type = $('.discount_check').is(':checked') ? 2 : 1;
        total_calculation();
    }
    // discount change
    $(document).on('keyup', '.discount', function(event) {
        total_calculation();
    });
    function total_calculation() {
        var total_price = 0;
        var total_qty = 0;
        var total_tax = 0;
        var total_discount = 0;
        var cash_payment = parseFloat($('.cash_payment').val()) || 0;
        var cash_back = 0;
        var remaining_amount = 0;
        $('.barcode').each(function() {
            var $qtyInput = $(this).closest('tr').find('.qty-input');
            var qty = parseFloat($qtyInput.val()) || 0;
            total_qty += qty;

            var price = $(this).closest('tr').find('.price').val();
            var product_cost = qty * price;

            // tax total
            var tax = $(this).closest('tr').find('.tax').val();
            var tax_amount = product_cost / 100 * tax;
            total_tax += tax_amount;

            var barcode = $(this).val();
            $('.total_price_' + barcode).text(product_cost.toFixed(3));
            total_price += parseFloat(product_cost);

            //total discount
            var discount = parseFloat($(this).closest('tr').find('.discount').val());
            var min_price = parseFloat($(this).closest('tr').find('.min_price').val());

            if (discount_type == 1) {
                var discount_total_price = total_price - discount;
                var final_discount = discount;
            } else {
                var discounted_price = total_price / 100 * discount;
                var discount_total_price = total_price - discounted_price;
                var final_discount = discounted_price;
            }

            if (discount_total_price < min_price) {
                show_notification('error', '<?php echo trans('messages.total_price_cannot_exceed_min_price_lang', [], session('locale')); ?>');
                total_discount += 0;
                var final_discount =0;
                $('.discount_' + barcode).val(0);
            } else {
                total_discount += final_discount;
            }
            var final_total = (product_cost + tax_amount) - final_discount;

            $('.grand_price_' + barcode).text(final_total.toFixed(3));
        });
        grand_total = (total_price + total_tax) - total_discount;

        cash_back = grand_total - cash_payment;

        if (cash_back == grand_total) {
            cash_back = 0;
        }

        $('.sub_total').text(total_price.toFixed(3));
        $('.total_tax').html(total_tax.toFixed(3));
        $('.count').text(total_qty);
        $('.grand_discount').text(total_discount.toFixed(3));
        $('.grand_total').text(grand_total.toFixed(3))
        $('.sub_total_show').text(total_price.toFixed(3));
        $('.total_tax_show').html(total_tax.toFixed(3));
        $('.grand_discount_show').text(total_discount.toFixed(3));
        $('.grand_total_show').text(grand_total.toFixed(3))
    }

    $('.cash_payment').on('input', function() {
        total_calculation();
    });
    //customer_js

    $('#add_customer_modal').on('hidden.bs.modal', function() {
        $(".add_customer")[0].reset();
        $('.customer_id').val('');
        $('.customer_image').val('');
        var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
        $('#img_tag').attr('src', imagePath)

    });
    $('.add_customer_form').off().on('submit', function(e) {
        e.preventDefault();
        var formdatas = new FormData($(this)[0]);
        var title = $('.customer_name').val();
        var phone = $('.customer_phone').val();
        var national_id = $('.national_id').val();
        var customer_number = $('.customer_number').val();
        var id = $('.customer_id').val();
        if (id == '') {


            if (title == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                return false;

            }
            if (phone == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                return false;
            }
            if (national_id == "") {
                show_notification('error', '<?php echo trans('messages.add_national_id_lang', [], session('locale')); ?>');
                return false;
            }
            if (customer_number == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_number_lang', [], session('locale')); ?>');
                return false;
            }

            // var str = $(".add_customer").serialize();
            $.ajax({
                type: "POST",
                url: "{{ url('add_customer_repair') }}",
                data: formdatas,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    if (data.status == 3) {
                        show_notification('error', '<?php echo trans('messages.customer_number_or_contact_exist_lang', [], session('locale')); ?>');
                        return false;
                    }
                    else if (data.status == 2) {
                        show_notification('error', '<?php echo trans('messages.national_id_exist_lang', [], session('locale')); ?>');
                    }
                    else if (data.status == 1) {
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                        $('#add_customer_modal').modal('hide');


                        var customer_number = parseInt(data.customer_id.split(':')[0].trim());
                        $('.pos_customer_id').val(data.customer_number)

                        $('#customer_input_data').val(data.customer_id);
                        $(".add_customer_form")[0].reset();
                        return false;
                    }


                },
                error: function(data) {
                    show_notification('error', '<?php echo trans('messages.data_add_failed_lang', [], session('locale')); ?>');
                    console.log(data);
                    return false;
                }
            });

        }

    });
    // check customer type
    function check_customer() {
        var customer_type = $(".customer_type:checked").val();

        if (customer_type == 1) {
            $(".student_detail").show();
            $(".teacher_detail").hide();
            $(".employee_detail").hide();
        } else if (customer_type == 2) {
            $(".student_detail").hide();
            $(".teacher_detail").show();
            $(".employee_detail").hide();

        } else if (customer_type == 3) {
            $(".student_detail").hide();
            $(".teacher_detail").hide();
            $(".employee_detail").show();

        } else if (customer_type == 4) {
            $(".student_detail").hide();
            $(".teacher_detail").hide();
            $(".employee_detail").hide();

        }
    }
    check_customer();


    //customer autocomplete

    $(".add_customer").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ url('customer_autocomplete') }}",
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });

        },
        // minLength: 2,


        select: function(event, ui) {
            console.log(ui.item);
            order_list(ui.item.phone);
            var customer_id = ui.item.value;
            var customer_number = parseInt(customer_id.split(':')[0].trim());
            $('.pos_customer_id').val(customer_number)
            $.ajax({
                url: "{{ url('get_customer_data') }}",
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

                },
                data: {
                    'customer_number':customer_number
                },
                success: function(data) {
                    $('.customer_draw').val(data.draw_name)
                    $('.payment_customer_name').val(data.customer_name)
                    $('.payment_customer_point').val(data.points)
                    $('.payment_customer_point_amount').val(data.points_amount)
                    $('.payment_customer_point_from').val(data.points_from)
                    $('.payment_customer_amount_to').val(data.amount_to)
                    // response(data);
                }
            });

        }
    }).autocomplete("search", "");

    $('.payment-anchor').click(function() {
        var accountId = $(this).data('account-id');
        var radio = $('#payment_gateway' + accountId);

        radio.prop('checked', !radio.prop('checked'));
    });



    $('#nextOrderButton').click(function() {
    window.location.href = "{{ url('pos') }}";
});

function get_rand_barcode(i) {
        var randomNumber = Math.floor(100000 + Math.random() * 900000);
        $('.barcode_' + i).val(randomNumber);
    }

// return item
var csrfToken = $('meta[name="csrf-token"]').attr('content');
$('.return_order_no').on('keypress', function(event) {
    if (event.which === 13) {
        $('#return_data').empty();
        var order_no = $(this).val();
        var return_type = $('.return:checked').val();
        $.ajax({
            url: "{{ url('get_return_items') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                order_no: order_no,
                return_type: return_type,
            },
            success: function(response) {
                if (response.status == 2) {
                    $('.repairing_data').empty();
                    show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                }
                else{
                    show_notification('success','<?php echo trans('messages.record_found_lang',[],session('locale')); ?>');
                    $('#return_data').html(response.return_data);
                }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

});

// replace item
$(document).on('click', '#replace_item_btn', function(e) {
    var order_no = $('.replace_reference_no').val();
    var replaced_imei = $('.replaced_imei').val();
    var old_product_id = $('.old_product_id').val();
    var old_imei = $('.old_imei').val();

    $.ajax({
        url: "{{ url('add_replace_item') }}",
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            order_no: order_no,
            replaced_imei: replaced_imei,
            old_product_id: old_product_id,
            old_imei: old_imei,
        },
        success: function(response) {
            if (response.status == 2) {
                show_notification('error','<?php echo trans('messages.item_not_found_lang',[],session('locale')); ?>');
                return false;
            }
            else{
                show_notification('success','<?php echo trans('messages.item_replace_successfully_lang',[],session('locale')); ?>');
                $('#return_data').empty();
                $('.return_order_no').val('');
                return false;
            }

        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});


// maintenance payment
$('.maintenancepayment_order_no').on('keypress', function(event) {
    if (event.which === 13) {
        $('#maintenance_data').empty();
        var order_no = $(this).val();
        $.ajax({
            url: "{{ url('get_maintenance_payment_data') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                order_no: order_no,
            },
            success: function(response) {
                if (response.status == 2) {
                    $('.repairing_data').empty();
                    show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                }
                else if (response.status == 3) {
                    $('.repairing_data').empty();
                    show_notification('error','<?php echo trans('messages.payment_already_paid_lang',[],session('locale')); ?>');
                    return false;
                }
                else{
                    show_notification('success','<?php echo trans('messages.record_found_lang',[],session('locale')); ?>');
                    $('#maintenancepayment_data').html(response.maintenance_data);
                }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

});

function get_maintenance_payment(id)
{
    $.ajax({
            url: "{{ url('get_maintenance_payment') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                id: id,
            },
            success: function(response) {
                if (response.status == 2) {
                    $('.repairing_data').empty();
                    show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                }

                else{
                    var remaining = response.remaining;
                    $('.grand_total_maintenance').text(remaining);
                    $('.cash_payment_maintenance').val(remaining);
                    $('.reference_no_maintenance').val(response.reference_no);
                    $('.maintenance_bill_id').val(id);
                    maintenance_total_calculation();
                }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
}

// maintance total calculation
$('.cash_payment_maintenance').on('input', function() {
    maintenance_total_calculation();
});
function maintenance_total_calculation() {
        var cash_payment = parseFloat($('.cash_payment_maintenance').val()) || 0;
        var grand_total = parseFloat($('.grand_total_maintenance').text()) || 0;
        var cash_back = 0;

        cash_back = grand_total - cash_payment;

        if (cash_back == grand_total) {
            cash_back = 0;
        }

        $('.cash_back_maintenance').text(cash_back.toFixed(3));
    }
// add maintence pauyment
// add pos order
$('#add_maintenance_payment').click(function() {

var grand_total = $('.grand_total_maintenance').text();
var cash_payment = $('.cash_payment_maintenance').val();
var reference_no = $('.reference_no_maintenance').val();
var bill_id = $('.maintenance_bill_id').val();
if(cash_payment==''){
    show_notification('error', '<?php echo trans('messages.please_pay_cash_payment_lang', [], session('locale')); ?>');
    return false;
}

if(cash_payment<grand_total){
    show_notification('error', '<?php echo trans('messages.please_pay_full_payment_lang', [], session('locale')); ?>');
    return false;
}
var cash_back = $('.cash_back').text();


var payment_method = $('.maintenance_payment_gateway_all').val();


var form_data = new FormData();

// form_data.append('payment_gateway', payment_gateway);

form_data.append('reference_no', reference_no);
form_data.append('bill_id', bill_id);
form_data.append('grand_total', grand_total);
form_data.append('cash_payment', cash_payment);
form_data.append('cash_back', cash_back);
form_data.append('payment_method', payment_method);
form_data.append('_token', csrfToken);
$('#global-loader').show();
$('#add_maintenance_payment').attr('disabled',true);
$.ajax({
    url: "{{ url('add_maintenance_payment') }}",
    type: 'POST',
    processData: false,
    contentType: false,
    data: form_data,
    success: function(response) {
        $('#global-loader').hide();
        show_notification('success', '<?php echo trans('messages.payment_added_success_lang', [], session('locale')); ?>');
        setTimeout(function(){
          location.reload();
        }, 2000);
    }
});
});
//pending order
    $('#hold').click(function() {



        var item_count = $('.count').text();
        var grand_total = $('.grand_total').text();
        var discount_by = $('.discount_by').val();
        var discount_type = 1;
        if ($('.discount_check').is(':checked')) {
            var discount_type = 2;
        }
        var total_tax = $('.total_tax').text();
        var total_discount = $('.grand_discount').text();
        var customer_id = "";
        if($('.pos_customer_id').val()!="")
        {
            customer_id = $('.pos_customer_id').val();
        }

        var product_id = [];
        $('.stock_ids').each(function() {
            product_id.push($(this).val());
        });
        if(product_id.length===0)
        {
            show_notification('error', '<?php echo trans('messages.please_add_product_in_list_lang', [], session('locale')); ?>');
            return false;
        }
        var item_barcode = [];
        $('.barcode').each(function() {
            item_barcode.push($(this).val());
        });

        var item_tax = [];
        $('.tax').each(function() {
            item_tax.push($(this).val());
        });


        var item_imei = [];
        $('.imei').each(function() {
            item_imei.push($(this).val());
        });



        var item_quantity = [];
        $('.qty-input').each(function() {
            item_quantity.push($(this).val());
        });
        var item_price = [];
        $('.price').each(function() {
            item_price.push($(this).val());
        });

        var item_total = [];
        $('.total_price').each(function() {
            item_total.push($(this).text());
        });
        var item_discount = [];
        $('.discount').each(function() {
            item_discount.push($(this).val());
        });

        var form_data = new FormData();
        form_data.append('item_count', item_count);
        form_data.append('grand_total', grand_total);
        form_data.append('discount_type', discount_type);
        form_data.append('discount_by', discount_by);
        form_data.append('total_tax', total_tax);
        form_data.append('total_discount', total_discount);
        form_data.append('product_id', JSON.stringify(product_id));
        form_data.append('item_barcode', JSON.stringify(item_barcode));
        form_data.append('item_tax', JSON.stringify(item_tax));
        form_data.append('item_imei', JSON.stringify(item_imei));
        form_data.append('item_quantity', JSON.stringify(item_quantity));
        form_data.append('item_discount', JSON.stringify(item_discount));
        form_data.append('item_price', JSON.stringify(item_price));
        form_data.append('item_total', JSON.stringify(item_total));
        form_data.append('customer_id', customer_id);
        form_data.append('_token', csrfToken);

        $.ajax({
            url: "{{ url('add_pending_order') }}",
            type: 'POST',
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                if (response.status == 1) {
                        $('#order_list').empty();
                            show_notification('success','<?php echo trans('messages.pending_record_added_lang',[],session('locale')); ?>');
                        }
                        else{
                            show_notification('error','<?php echo trans('messages.data_added_failed_lang',[],session('locale')); ?>');

                        }
                        $('.count').text('');
                        get_pending_data();
            }
        });
    });
        get_pending_data()
        function get_pending_data()
        {
            $.ajax({
            url: "{{ url('hold_orders') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            processData: false,
            contentType: false,
            success: function(response) {
                var hold_list = response.hold_list;

                $('#hold_data').html(hold_list);

            }
        });

        }



$(document).on('click', '#btn_hold', function() {
    var orderId = $(this).data('order-id');
    $.ajax({
        url: "{{ url('get_hold_data') }}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            order_id: orderId
        },
        success: function(response) {
            var orderList = response.order_list;
            var customer = response.customer_data;
            $('#customer_input_data').val(customer);
            $('.pos_customer_id').val(response.customer_number);
            $('#order_list').html(orderList);

            total_calculation();
            get_pending_data()
            setTimeout(order_list_bottom, 100);
        },

        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


// calcualtor js

// Select all the from document using queryselectAll
var keys = document.querySelectorAll('#calculator span');

//adding keyboard input functionality
// document.onkeydown = function(event) {
//     var key_press = String.fromCharCode(event.keyCode);
//     var key_code = event.keyCode;
//     var focusedInput = document.activeElement;

//     // Check if the focused element is an input with the class 'payment_methods_value'
//     if (focusedInput && focusedInput.classList.contains('payment_methods_value')) {
//         // Retrieve the cash-type attribute value to identify the corresponding digit
//         var cashType = focusedInput.getAttribute('cash-type');

//         // If cashType is not empty and key_press is a digit, update the input value
//         if (cashType !== null && !isNaN(parseInt(key_press))) {
//             focusedInput.value += key_press;
//         }
//     }
// };

// Variable to store the reference to the last focused input field
var lastFocusedInput = null;

// Event listener to track focus on input fields
document.querySelectorAll('.payment_methods_value').forEach(function(input) {
    input.addEventListener('focus', function() {
        // Update the last focused input field
        lastFocusedInput = this;
    });
});

// Event listener for digit spans
document.querySelectorAll('.digit').forEach(function(span) {
    span.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the click event

        console.log('Span clicked'); // Debugging: Check if click event is fired

        // Check if there is a last focused input field
        if (lastFocusedInput) {
            // Get the digit from the clicked span
            var digit = this.innerHTML;
            console.log('Digit:', digit); // Debugging: Check if correct digit is retrieved

            // Append the digit to the last focused input value
            lastFocusedInput.value += digit;
            console.log('Updated value:', lastFocusedInput.value); // Debugging: Check if input value is updated

            // Set focus back to the last focused input field
            lastFocusedInput.focus();
            payment_modal_calculation()
        }
    });
});











// gety point amount
$(document).on('click', '#get_total_point_value', function() {
     var payment_customer_point = $('.payment_customer_point').val();
     $('.get_point_amount').val(payment_customer_point);
     payment_modal_calculation()

});
$(document).on('keyup', '.get_point_amount', function() {
    payment_modal_calculation()
});

$(document).on('keyup', '.payment_methods_value', function() {
    payment_modal_calculation()
});
// check payment modal calculations
function payment_modal_calculation()
{
    // point omr
    var point_omr = $('.get_point_amount').val();
    if(point_omr == "")
    {
        point_omr =0;
    }
    // payment methods
    var sum = 0;
    var cash_sum = 0;
    $('.payment_methods_value').each(function() {
        var value = parseFloat($(this).val());
        var cash_type = $(this).attr('cash-type');
        if(cash_type == 1)
        {
            if (!isNaN(value)) {
                cash_sum = value;
            }
        }
        else
        {
            if (!isNaN(value)) {
                sum += value;
            }
        }

    });

    var final_omr = $('.grand_total').text();
    if(final_omr == "")
    {
        final_omr =0;
    }
    final_without_cash = parseFloat(sum) + parseFloat(point_omr);
    final_with_cash = parseFloat(cash_sum) + parseFloat(sum) + parseFloat(point_omr);

    if(cash_sum <= 0 &&  final_without_cash > final_omr)
    {
        show_notification('error','<?php echo trans('messages.validation_amount_greater_than_lang',[],session('locale')); ?>');
        $('.payment_methods_value').val('');
        $('.paid_point_amount').text('');
        $('.get_point_amount').val('');
        $('.remaining_point_amount_input').val(final_omr);
        $('.remaining_point_amount').text(final_omr);
        return false;
    }

    // if(cash_sum <= 0 && final_without_cash < final_omr)
    // {
    //     show_notification('error','<?php echo trans('messages.validation_amount_less_than_lang',[],session('locale')); ?>');
    //     $('.payment_methods_value').val('');
    //     $('.get_point_amount').val('');
    //     $('.remaining_point_amount_input').val(final_omr);
    //     $('.remaining_point_amount').text(final_omr);
    //     return false;
    // }

    if(cash_sum > 0 && final_without_cash > final_omr)
    {
        show_notification('error','<?php echo trans('messages.validation_amount_greater_than_lang',[],session('locale')); ?>');
        $('.payment_methods_value').val('');
        $('.paid_point_amount').text('');
        $('.get_point_amount').val('');
        $('.remaining_point_amount_input').val(final_omr);
        $('.remaining_point_amount').text(final_omr);
        return false;
    }



    var remaining_omr = final_omr - final_with_cash;
    $('.paid_point_amount_input').val(point_omr);
    $('.paid_point_amount').text(point_omr);
    $('.remaining_point_amount_input').val(remaining_omr);
    $('.remaining_point_amount').text(remaining_omr);
}

function add_payment_method(id) {
    if ($('#'+id+'_acc').prop('checked')) {
        $('#payment_methods_value_id'+id).prop('readonly', false);
        $('#payment_methods_value_id'+id).val('');
    } else {
        $('#payment_methods_value_id'+id).prop('readonly', true);
        $('#payment_methods_value_id'+id).val('');
    }
    payment_modal_calculation();
}

</script>
