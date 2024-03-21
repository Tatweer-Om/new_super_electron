<script type="text/javascript">
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        //start

     $('#add_qout').click(function() {
        var product = [];
        $('.product_select').each(function() {
            var value = $(this).val();
            var parts = value.split('+');
            product.push(parts[0]);
        });

        var product_line_price = [];
        $('.product-line-price').each(function() {
            product_line_price.push($(this).val());
        });

        var item_quantity_product = [];
        $('.quantity_product').each(function() {
            item_quantity_product.push($(this).val());
        });

        var total_price_product = [];
        $('.total_price_product').each(function() {
            total_price_product.push($(this).val());
        });

        var product_warranty = [];
        $('.product_warranty').each(function() {
            product_warranty.push($(this).val());
        });

        var product_detail = [];
        $('.product_detail').each(function() {
            product_detail.push($(this).val());
        });

        var service = [];
        $('.service_select').each(function() {
            service.push($(this).val());
        });

        var service_line_price = [];
        $('.service-line-price').each(function() {
            service_line_price.push($(this).val());
        });

        var item_quantity_service = [];
        $('.quantity_service').each(function() {
            item_quantity_service.push($(this).val());
        });

        var total_price_service = [];
        $('.total_price_service').each(function() {
            total_price_service.push($(this).val());
        });

        var service_warranty = [];
        $('.service_warranty').each(function() {
            service_warranty.push($(this).val());
        });

        var service_detail = [];
        $('.service_detail').each(function() {
            service_detail.push($(this).val());
        });

        var sub_total = $('.sub_total').text();
        var shipping = $('.shipping').text();
        var tax = $('.tax').text();
        var grand_total = $('.grand_total').text();
        var paid_amount = $('.paid_amount').text();
        var remaining_amount = $('.remaining_amount').text();

        var customer_id = parseInt($('.add_customer').val().split(':')[0].trim());
        var taxValue = $('#box').prop('checked') ? 'tax' : 'OMR';
        var date = $('.date').text();

        var formData = new FormData();

        // Append product data
        for (var i = 0; i < product.length; i++) {
            formData.append('product[]', product[i]);
            formData.append('product_line_price[]', product_line_price[i]);
            formData.append('item_quantity_product[]', item_quantity_product[i]);
            formData.append('total_price_product[]', total_price_product[i]);
            formData.append('product_warranty[]', product_warranty[i]);
            formData.append('product_detail[]', product_detail[i]);
        }

        // Append service data
        for (var i = 0; i < service.length; i++) {
            formData.append('service[]', service[i]);
            formData.append('service_line_price[]', service_line_price[i]);
            formData.append('item_quantity_service[]', item_quantity_service[i]);
            formData.append('total_price_service[]', total_price_service[i]);
            formData.append('service_warranty[]', service_warranty[i]);
            formData.append('service_detail[]', service_detail[i]);
        }

        // Append other data
        formData.append('sub_total', sub_total);
        formData.append('shipping', shipping);
        formData.append('tax', tax);
        formData.append('grand_total', grand_total);
        formData.append('paid_amount', paid_amount);
        formData.append('remaining_amount', remaining_amount);
        formData.append('customer_id', customer_id);
        formData.append('taxValue', taxValue);
        formData.append('date', date);

        $.ajax({
            url: "{{ url('add_qout') }}",
            type: 'POST',
            processData: false,
            contentType: false
            data: formData,
            success: function(response) {
                show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);

            }
        });
    });

        //end


        function updateTotal() {
            let total = 0;

            $('.product-line-price').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            $('.service-line-price').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            $('#cart-subtotal').val(total.toFixed(2));
            updateRemainingAmount();
        }

        $(document).ready(function() {
            $('#tax, #shipping').on('input', function() {
                updateRemainingAmount();
            });
        });

        function updateRemainingAmount() {
            let totalAmount = parseFloat($('#cart-subtotal').val()) || 0;
            let shipping = parseFloat($('#shipping').val()) || 0;
            let tax = parseFloat($('#tax').val()) || 0;
            let checkbox = $('#box');
            if (checkbox.prop('checked')) {
                let taxPercent = parseFloat($('#tax').val()) || 0;
                tax = (totalAmount * taxPercent) / 100;
            } else {
                tax = parseFloat($('#tax').val()) || 0;
            }

            let grandTotal = totalAmount + shipping + tax;
            $('#grand_total').val(grandTotal.toFixed(2));
            let paidAmount = parseFloat($('#paid').val()) || 0;
            let remainingAmount = grandTotal - paidAmount;
            $('#remaining').val(remainingAmount.toFixed(2));


        }

        $(document).on('input', '.product-line-price, .service-line-price', function() {
            updateTotal();
        });

        $(document).on('input', '#paid', function() {
            updateRemainingAmount();
        });

        $('#box').on('change', function() {
            updateRemainingAmount();
        });

    });

    let rowCount = 1;

    function addNewRow() {
        rowCount++;
        var select_product =
            `<input type="text" class="form-control bg-light border-0 product_select" id="product_select-${rowCount}" placeholder="Select Product" name="product_select[]" />`;
        let newRow = `<tr id="${rowCount}" class="product">
            <td></td>
            <td class="text-start  ">
                <div class="mb-2 ">
                    ${select_product}
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 product-line-price" id="productPrice-${rowCount}" placeholder="$0.00" name="product_amount[]"/>
                </div>
            </td>
            <td class="text-end">
                <input type="text" class="form-control bg-light border-0 quantity" id="quantity-${rowCount}" placeholder="" name="quantity[]" />
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 total_price" id="total_price-${rowCount}" placeholder="OMR 0.00" name="total_price[]" />
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 product_warranty" id="product_warranty-${rowCount}" name="product_warranty[]" />
                </div>
            </td>
            <td>
                <textarea class="form-control bg-light border-0 product_detail" name="product_detail[]" id="productDetails-${rowCount}" rows="2" placeholder="Product Details"></textarea>
            </td>
            <td class="product-removal">
                <a href="javascript:void(0)"  onclick="deleteRow1(${rowCount})"><i class="fas fa-trash fa-lg"></i> </a>
            </td>
        </tr>`;

        $('#newlink tr:last').before(newRow);


        initializeAutocomplete(`#product_select-${rowCount}`);
        updateTotal();

        $(document).on('input', '.product-line-price, .quantity', function() {
            let rowNumber = $(this).attr('id').split('-')[1];
            updateTotal(rowNumber);
        });
    }

    // Function to initialize autocomplete for the specified input field
    function initializeAutocomplete(selector) {
        $(selector).autocomplete({
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
            select: function(event, ui) {

                var $input = $(this);
                var warrantyType = ui.item.warranty;
                var purchasePrice = ui.item.purchase_price;



                $input.closest('tr').find('.product_warranty').val(warrantyType);
                $input.closest('tr').find('.product-line-price').val(purchasePrice);
            }
        }).keypress(function(event) {
            if (event.which === 13) {

                event.preventDefault();

                $(this).autocomplete("search", $(this).val());
            }
        });
    }





    $(".product_select").each(function() {
        var $this = $(this);
        $this.autocomplete({
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
            select: function(event, ui) {

                var value = ui.item.value;
                var warrantyType = ui.item.warranty;
                var purchasePrice = ui.item.purchase_price;

                $this.val(value);

                $('.product_warranty').val(warrantyType);
                $('.product-line-price').val(purchasePrice);
            }
        }).keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $(this).autocomplete("search", $(this).val());
            }
        });
    });

    function updateTotal(rowNumber) {
        let productPrice = parseFloat($(`#productPrice-${rowNumber}`).val()) || 0;
        let quantity = parseFloat($(`#quantity-${rowNumber}`).val()) || 1; // Set quantity to 1 if empty
        let totalPrice = productPrice * quantity;
        $(`#total_price-${rowNumber}`).val(totalPrice.toFixed(2)); // Round to 2 decimal places
    }



    //services
    $(".service_select").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ url('service_autocomplete') }}",
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
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        },
        select: function(event, ui) {
            var value = ui.item.value;
            var serviceCost = ui.item.service_cost;

            $(this).val(value);

            $('.service-line-price').val(serviceCost);
        }
    }).keypress(function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $(this).autocomplete("search", $(this).val());
        }
    });


    let serviceRowCount = 1;

    function addNewServiceRow() {
        serviceRowCount++;
        var select =
            `<input type="text" class="form-control bg-light border-0 service_select" id="service_select-${serviceRowCount}" placeholder="Select service" name="service_select[]" />`;
        let newRow = `<tr id="serviceRow-${serviceRowCount}" class="service">
            <td></td>
            <td class="text-start">
                <div class="mb-2">
                    ${select}
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 service-line-price" id="servicePrice-${serviceRowCount}" placeholder="$0.00" name="service_amount[]"/>
            </td>

            <td class="text-end">
                <input type="text" class="form-control bg-light border-0 service_quantity" id="service_quantity-${serviceRowCount}" placeholder="" name="service_quantity[]" />
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 total_service" id="total_service-${serviceRowCount}" placeholder="OMR 0.00" name="total_service[]" />
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 service_warranty" id="service_warranty-${serviceRowCount}" name="service_warranty[]" />
                </div>
            </td>
            <td>
                <textarea class="form-control bg-light border-0 service_detail" name="service_detail[]" id="serviceDetails-${serviceRowCount}" rows="2" placeholder="Service Details"></textarea>
            </td>
            <td class="service-removal">
                <a href="javascript:void(0)"  onclick="deleteRow(${serviceRowCount})"><i class="fas fa-trash fa-lg"></i> </a>
            </td>
        </tr>`;

        $('#serviceRows tr:last').before(newRow);

        service_auto(`#service_select-${serviceRowCount}`);

        updateTotal();

        $(document).on('input', '.service-line-price, .service_quantity', function() {
            let rowNumber = $(this).attr('id').split('-')[1];
            updateServiceTotal(rowNumber);
        });
    }

    function updateServiceTotal(rowNumber) {
        let servicePrice = parseFloat($(`#servicePrice-${rowNumber}`).val()) || 0;
        let serviceQuantity = parseFloat($(`#service_quantity-${rowNumber}`).val()) || 1; // Set quantity to 1 if empty
        let totalService = servicePrice * serviceQuantity;
        $(`#total_service-${rowNumber}`).val(totalService.toFixed(2)); // Round to 2 decimal places
    }

    // Function to initialize autocomplete for the specified input field
    function service_auto(selector) {
        $(selector).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ url('service_autocomplete') }}",
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
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            },
            select: function(event, ui) {
                var value = ui.item.value;
                var serviceCost = ui.item.service_cost;

                $(this).val(value);

                $(this).closest('tr').find('.service-line-price').val(serviceCost);
            }
        }).keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $(this).autocomplete("search", $(this).val());
            }
        });
    }

    //customer auto complete

    $(document).ready(function() {


        //adding customer

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
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


    //customer_autocomplete

    $(document).ready(function() {
        $(".add_customer").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ url('customer_auto') }}",
                    method: "POST",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        term: request.term
                    },
                    success: function(data) {

                        var filteredData = data.slice(0, 10);
                        response(filteredData);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching autocomplete data:", error);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {

                $(this).val(ui.item.label);
                return false;
            }
        });
    });


    //delete buttons

    function deleteRow(rowId) {
        $(`#serviceRow-${rowId}`).remove();
        updateTotal();
    }

    function deleteRow1(rowId1) {
        $(`#${rowId1}`).remove();
        updateTotal();
    }


    //total_price

    $('.quantity, .product-line-price').on('input', function() {
        var $row = $(this).closest('tr');
        var productLinePrice = parseFloat($row.find('.product-line-price').val());
        var quantity = parseInt($row.find('.quantity').val());

        if (!isNaN(productLinePrice) && !isNaN(quantity)) {
            var totalPrice = productLinePrice * quantity;
            $row.find('.total_price').val(totalPrice);
        } else {
            $row.find('.total_price').val('');
        }
    });



    $('.service_quantity, .service-line-price').on('input', function() {
        var $row = $(this).closest('tr');
        var productLinePrice = parseFloat($row.find('.service-line-price').val());
        var quantity = parseInt($row.find('.service_quantity').val());

        if (!isNaN(productLinePrice) && !isNaN(quantity)) {
            var totalPrice = productLinePrice * quantity;
            $row.find('.total_service').val(totalPrice);
        } else {
            $row.find('.total_service').val('');
        }
    });


    //%age check

    function toggleTaxSign() {
        var taxCheckbox = document.getElementById("box");
        var taxSign = document.getElementById("tax_sign");

        if (taxCheckbox.checked) {
            taxSign.innerText = "%";
        } else {
            taxSign.innerText = "OMR";
        }
    }



    //saving data to db

</script>
