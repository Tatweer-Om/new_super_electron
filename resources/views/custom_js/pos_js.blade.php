<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // add pos order
        $('#add_pos_order').click(function() {

            var item_count = $('.count').text();
            var grand_total = $('.grand_total').text();
            var discount_by =$('.discount_by').val();
            var cash_payment = $('.cash_payment').val();
            var discount_type = 1;
            if ($('.discount_check').is(':checked')) {
                var discount_type = 2;
            }
            var total_tax = $('.total_tax').text();
            var total_discount = $('.grand_discount').text();
            var cash_back = $('.cash_back').text();
            var customer_id = parseInt($('.add_customer').val().split(':')[0].trim());
            var payment_method = $('input[name="payment_gateway"]:checked').val();
            var product_id = [];
            $('.stock_ids').each(function() {
                product_id.push($(this).val());
            });
            var item_barcode = [];
            $('.barcode').each(function() {
                item_barcode.push($(this).val());
            });

            var item_tax = [];
            $('.tax').each(function() {
                item_tax.push($(this).val());
            });
            // var item_imei = [];
            // $('.imei').each(function() {
            //     var imei = $(this).val().trim();
            //     if (imei !== '') {
            //         item_imei.push(imei);
            //     }
            //     else{
            //         item_imei.push('');
            //     }
            // });
            var item_imei = [];
            var uniqueItemIMEI = new Set();
            $('.imei').each(function() {
                var imei = $(this).val().trim();
                if (imei !== '') {
                    uniqueItemIMEI.add(imei);
                } else {
                    uniqueItemIMEI.add('');
                }
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
            form_data.append('cash_payment', cash_payment);
            form_data.append('discount_type', discount_type);
            form_data.append('discount_by', discount_by);
            form_data.append('total_tax', total_tax);
            form_data.append('total_discount', total_discount);
            form_data.append('cash_back', cash_back);
            form_data.append('payment_method', payment_method);
            form_data.append('product_id', JSON.stringify(product_id));
            form_data.append('item_barcode', JSON.stringify(item_barcode));
            form_data.append('item_tax', JSON.stringify(item_tax));
            // form_data.append('item_imei', JSON.stringify(item_imei));
            form_data.append('item_imei', JSON.stringify(Array.from(uniqueItemIMEI)));
            form_data.append('item_quantity', JSON.stringify(item_quantity));
            form_data.append('item_discount', JSON.stringify(item_discount));
            form_data.append('item_price', JSON.stringify(item_price));
            form_data.append('item_total', JSON.stringify(item_total));
            form_data.append('customer_id', JSON.stringify(customer_id));
            form_data.append('_token', csrfToken);

            $.ajax({
                url: "{{ url('add_pos_order') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: form_data,
                success: function(response) {

                    show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');


                }
            });
        });

        cat_products('all');
        var totalQuantity = 0;

        $(document).on('click', '.inc', function() {
            var $qtyInput = $(this).siblings('.qty-input');
            var productBarcode = $(this).closest('.product-list').find('.barcode').val();
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
                    $('.show_pro_price_' + productBarcode).html('OMR ' + response.product_price);

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
            var productBarcode = $(this).closest('.product-list').find('.barcode').val();
            var count = parseInt($qtyInput.val());
            product_quantity(productBarcode, count - 1, $qtyInput, 2);
        });

        $('#order_list').on('click', '#delete-item', function() {
            var $productItem = $(this).closest('.product-list');
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
                $('#hold_order').modal('show');
                $('#all_pro_imei').html("");
                var productHtml = "";
                response.product_imei.forEach(function(product) {
                    onclick_func = 'onclick="order_list('+product.barcode+','+product.imei+')"';
                    productHtml = productHtml + `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 pe-2 ">
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg" ${onclick_func}>
                                    <img src="{{ asset('images/product_images/') }}/${response.stock_image}" alt="Products"
                                        style= height:60px;" >
                                    <span><i data-feather="check" class="feather-16"></i></span>
                                </a>
                                <h6 class="product_name"><a href="javascript:void(0);">${response.product_name}</a></h6>
                                <h6 class="product_imei"><a href="javascript:void(0);">${product.imei}</a></h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <p> OMR ${response.sale_price}</p>
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
                    if(product.check_imei==1)
                    {
                        onclick_func = 'onclick="get_pro_imei('+product.barcode+')"';
                    }
                    else
                    {
                        onclick_func = 'onclick="order_list('+product.barcode+')"';
                    }
                    productHtml = productHtml + `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 pe-2 ">
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg" ${onclick_func}>
                                    <img src="{{ asset('images/product_images/') }}/${product.stock_image}" alt="Products"
                                        style= height:60px;" >
                                    <span><i data-feather="check" class="feather-16"></i></span>
                                </a>
                                <h6 class="cat-name"><a href="javascript:void(0);">${response.category_name}</a></h6>
                                <h6 class="product-name"><a href="javascript:void(0);">${product.product_name}</a></h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>${product.quantity} PCs</span>
                                    <p> OMR ${product.sale_price}</p>
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

    function order_list(product_barcode,imei) {

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
                }

                else {

                    if ($('#order_list').find('div.list_' + product_barcode).length > 0) {
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

                    else
                    {
                        var orderHtml = `
                            <div class="product-list item_list d-flex align-items-center justify-content-between list_${product_barcode}">
                                <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                                    <input type="hidden" value="${imei}" class="imei imei_${response.product_barcode}">
                                    <input type="hidden" name="stock_ids" value="${response.id}" class="stock_ids product_id_${response.id}">
                                    <input type="hidden" name="product_tax" value="${response.product_tax}" class="tax tax_${response.product_barcode}">
                                    <input type="hidden" name="product_discount" value="0"  class="discount discount_${response.product_barcode}">
                                    <input type="hidden" value="${response.product_min_price}"  class="min_price min_price_${response.product_barcode}" >
                                    <input type="hidden"  value="${response.product_name}"  class="product_name product_name_${response.product_barcode}">
                                    <input type="hidden" value="${response.product_price}" class="price price_${response.product_barcode}">

                                    <input type="hidden" name="product_barcode" value="${response.product_barcode}" class="barcode barcode_${response.product_barcode}">
                                    <a href="javascript:void(0);" class="img-bg">
                                        <img src="{{ asset('images/product_images/') }}/${response.product_image}" alt="${response.product_name}">
                                    </a>
                                    <div class="info">
                                        <span>${response.product_barcode}</span>
                                        <h6><a href="javascript:void(0);">${response.product_name}</a></h6>
                                        <p><span name="product_barcode" class="show_pro_price_${response.product_barcode}"> OMR ${response.product_price} </span></p>
                                    </div>
                                </div>
                                <div class="qty-item text-center">
                                    <span name="product_total" class="badge bg-warning">Total OMR: <span class="total_price total_price_${response.product_barcode}"></span></span>
                                </div>

                                <div class="qty-item text-center">
                                    <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i class="fas fa-minus-circle"></i></a>
                                    <input type="text" class="form-control text-center qty-input" name="product_quantity" value="1" >
                                    <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i class="fas fa-plus-circle"></i></a>
                                </div>
                                <div class="d-flex align-items-center action">
                                    <a class="btn-icon edit-icon me-2 "  href="#" data-bs-toggle="modal" onclick="edit_product(${response.product_barcode})" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>
                                    <a class="btn-icon delete-icon confirm-text " id ="delete-item" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>

                        `;
                        // if (response.popup) {

                        //    $('#hold_order').modal('show')
                        // }
                        $('#order_list').append(orderHtml);
                    }
                }

                total_calculation();
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
        $('.show_pro_price_' + barcode).text('OMR ' + price);
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
                }
            });
        },
        // minLength: 2,
        select: function(event, ui) {
        console.log(ui.item);

        $('.product_input, #enter').on('keypress click', function(event) {
            if ((event.which === 13 && event.target.tagName !== 'A') || (event.target.id === 'enter' && event.type === 'click')) {
                order_list(ui.item.barcode, ui.item.imei);
            }
        });
    }
}).autocomplete("search", "");










    //end autocomplete
    var discount_type = 1;

    function switch_discount_type() {
        discount_type = $('.discount_check').is(':checked') ? 2 : 1;
        total_calculation();
    }

    function total_calculation() {
        var total_price = 0;
        var total_qty = 0;
        var total_tax = 0;
        var total_discount = 0;
        var cash_payment = parseFloat($('.cash_payment').val()) || 0;
        var cash_back = 0;
        var remaining_amount = 0;
        $('.item_list').each(function() {
            var $qtyInput = $(this).find('.qty-input');
            var qty = parseFloat($qtyInput.val()) || 0;
            total_qty += qty;

            var price = $(this).closest('.item_list').find('.price').val();
            var product_cost = qty * price;

            // tax total
            var tax = $(this).closest('.item_list').find('.tax').val();
            var tax_amount = product_cost / 100 * tax;
            total_tax += tax_amount;

            var barcode = $(this).closest('.item_list').find('.barcode').val();
            $('.total_price_' + barcode).text(product_cost.toFixed(3));
            total_price += parseFloat(product_cost);

            //total discount
            var discount = parseFloat($(this).closest('.item_list').find('.discount').val());
            var min_price = parseFloat($(this).closest('.item_list').find('.min_price').val());
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

            } else {
                total_discount += final_discount;
            }

        });
           grand_total = total_price + total_tax + total_discount;

            cash_back = grand_total - cash_payment;

            if (cash_back == grand_total) {
                cash_back = 0;
            }

        $('.sub_total').text(total_price.toFixed(3));
        $('.total_tax').html(total_tax.toFixed(3));
        $('.count').text(total_qty);
        $('.grand_discount').text(total_discount.toFixed(3));
        $('.grand_total').text(grand_total.toFixed(3))
        $('.cash_back').text(cash_back.toFixed(3));
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
        var id = $('.customer_id').val();

        if (id != '') {
            if (title == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                return false;
            }
            if (phone == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                return false;
            }

        } else if (id == '') {


            if (title == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                return false;

            }
            if (phone == "") {
                show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                return false;
            }

            // var str = $(".add_customer").serialize();
            $.ajax({
                type: "POST",
                url: "{{ url('add_customer') }}",
                data: formdatas,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)

                    if (data.status == 1) {
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                        $('#add_customer_modal').modal('hide');
                        $(".add_customer")[0].reset();
                        $('.customer_input').val(data.customer_name);
                        return false;
                    } else if (data.status == 2) {
                        show_notification('error', '<?php echo trans('messages.national_id_exist_lang', [], session('locale')); ?>');
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
            var customer_id = ui.item.id;
            $.ajax({
            url: "{{ url('add_pos_order') }}",
            method: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                customer_id: customer_id
            },
            success: function(response) {
               e
            },
            error: function(xhr, status, error) {

            }
        });


        }
    }).autocomplete("search", "");

    $('.payment-anchor').click(function() {
        var accountId = $(this).data('account-id');
        var radio = $('#payment_gateway' + accountId);

        radio.prop('checked', !radio.prop('checked'));
    });




</script>
