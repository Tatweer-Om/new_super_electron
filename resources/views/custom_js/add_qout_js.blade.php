<script type="text/javascript">
               function updateTotal() {
                let total = 0;

                $('.total_service').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                $('.total_price').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                $('#cart-subtotal').val(total.toFixed(2));
                updateRemainingAmount();
            }
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

        $(document).ready(function() {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');



            $(document).ready(function() {
                $('#tax, #shipping').on('input', function() {
                    updateRemainingAmount();
                });
            });



                $(document).on('input', '.product-line-price, .service-line-price', function() {
                    updateTotal();
                });

                $(document).on('input', '#paid', function() {
                    updateRemainingAmount();
                });

                $('#box').on('input', function() {
                    updateRemainingAmount();
                });

        });


    $(document).on('input', '.product-line-price, .quantity', function() {
            let rowNumber = $(this).attr('id').split('-')[1];
            update_Total(rowNumber);
            updateTotal();
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
                    <input type="text" class="form-control bg-light border-0 total_price" id="total_price-${rowCount}" readonly placeholder="OMR 0.00" name="total_price[]" />
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
                var pro_quantity = ui.item.pro_quantity;
                var product_total= purchasePrice * pro_quantity;

                $input.closest('tr').find('.product_warranty').val(warrantyType);
                $input.closest('tr').find('.product-line-price').val(purchasePrice);
                $input.closest('tr').find('.quantity').val(pro_quantity);
                $input.closest('tr').find('.total_price').val(product_total);
                updateTotal();
            }
        }).keypress(function(event) {
            if (event.which === 13) {

                event.preventDefault();

                $(this).autocomplete("search", $(this).val());
                updateTotal();
            }
        });
    }

    function update_Total(rowNumber) {
        let productPrice = parseFloat($(`#productPrice-${rowNumber}`).val()) || 0;
        let quantity = parseFloat($(`#quantity-${rowNumber}`).val()) || 1;

        let totalPrice = productPrice * quantity;
        $(`#total_price-${rowNumber}`).val(totalPrice.toFixed(2));
        updateTotal();
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
                var pro_quantity = ui.item.pro_quantity;
                var product_total= purchasePrice * pro_quantity;

                $this.val(value);

                $('.product_warranty').val(warrantyType);
                $('.product-line-price').val(purchasePrice);
                $('.quantity').val(pro_quantity);
                $('.total_price').val(product_total);
                updateTotal();
            }
        }).keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();
                $(this).autocomplete("search", $(this).val());

            }
        });
    });




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
            var servicequan = ui.item.service_quantity;
            var total_service = serviceCost * servicequan;


            $(this).val(value);

            $('.service-line-price').val(serviceCost);
            $('.service_quantity').val(servicequan);
            $('.total_service').val(total_service);

            updateTotal();
        }
    }).keypress(function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $(this).autocomplete("search", $(this).val());
        }
    });


    $(document).on('input', '.service-line-price, .service_quantity', function() {
            let rowNumber = $(this).attr('id').split('-')[1];
            updateServiceTotal(rowNumber);
            updateTotal();
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
                    <input type="text" class="form-control bg-light border-0 total_service" id="total_service-${serviceRowCount}" readonly placeholder="OMR 0.00" name="total_service[]" />
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


    }

    function updateServiceTotal(rowNumber) {
        let servicePrice = parseFloat($(`#servicePrice-${rowNumber}`).val()) || 0;
        let serviceQuantity = parseFloat($(`#service_quantity-${rowNumber}`).val()) || 1;
        let totalService = servicePrice * serviceQuantity;
        $(`#total_service-${rowNumber}`).val(totalService.toFixed(2));
        updateTotal();
    }


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
                var servicequan = ui.item.service_quantity;
                var total_service = serviceCost * servicequan;

                $(this).val(value);

                $(this).closest('tr').find('.service-line-price').val(serviceCost);
                $(this).closest('tr').find('.service_quantity').val(servicequan);
                $(this).closest('tr').find('.total_service').val(total_service);


                updateTotal();
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
         //start

$('#add_qout').click(function(event) {
event.preventDefault();
var csrfToken = $('meta[name="csrf-token"]').attr('content');
         $('#add_qout').click(function() {
        var product = [];
        $('.product_select').each(function() {
            var value = $(this).val();
            var parts = value.split(':');
            product.push(parts[0]);
        });

        var warranty_type = [];
        $('.product_warranty').each(function() {
            var value = $(this).val();
            var parts = value.split(':');
            warranty_type.push(parts[0]);
        });

        var warranty_days = [];

        $('.product_warranty').each(function() {
            var value = $(this).val();
            var parts = value.split(':');
            warranty_days.push(parts[1]);
        });
        console.log('warranty_days', warranty_days);

        var product_line_price = [];
        $('.product-line-price').each(function() {
            product_line_price.push($(this).val());
        });

        var item_quantity_product = [];
        $('.quantity').each(function() {
            item_quantity_product.push($(this).val());
        });

        var total_price_product = [];
        $('.total_price').each(function() {
            total_price_product.push($(this).val());
        });

        // var product_warranty = [];
        // $('.product_warranty').each(function() {
        //     product_warranty.push($(this).val());
        // });

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
        $('.service_quantity').each(function() {
            item_quantity_service.push($(this).val());
        });

        var total_price_service = [];
        $('.total_service').each(function() {
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

        var sub_total = $('.sub_total').val();
        console.log('sub_total', sub_total );
        var shipping = $('.shipping').val();
        console.log('shipping', shipping );
        var tax = $('.tax').val();
        console.log('tax', tax );
        var grand_total = $('.grand_total').val();
        console.log('grand_total', grand_total );
        var paid_amount = $('.paid').val();
        console.log('paid_amount', paid_amount );
        var remaining_amount = $('.remaining_amount').val();
        console.log('remaining_amount', remaining_amount );
        var customer_id = parseInt($('.add_customer').val().split(':')[0].trim());
        var tax_value = $('#box').prop('checked') ? 'tax' : 'OMR';
        var date = $('.date').val();
        console.log('date', date );
        var form_data = new FormData();
        form_data.append('product', JSON.stringify(product));
        form_data.append('product_line_price', JSON.stringify(product_line_price));
        form_data.append('item_quantity_product', JSON.stringify(item_quantity_product));
        form_data.append('total_price_product', JSON.stringify(total_price_product));
        form_data.append('warranty_type', JSON.stringify(warranty_type));
        form_data.append('warranty_days', JSON.stringify(warranty_days));
        form_data.append('product_detail', JSON.stringify(product_detail));
        form_data.append('service', JSON.stringify(service));
        form_data.append('service_line_price', JSON.stringify(service_line_price));
        form_data.append('item_quantity_service', JSON.stringify(item_quantity_service));
        form_data.append('total_price_service', JSON.stringify(total_price_service));
        form_data.append('service_warranty', JSON.stringify(service_warranty));
        form_data.append('service_detail', JSON.stringify(service_detail));
        form_data.append('sub_total', sub_total);
        form_data.append('shipping', shipping);
        form_data.append('tax', tax);
        form_data.append('tax_value', tax_value);
        form_data.append('grand_total', grand_total);
        form_data.append('paid_amount', paid_amount);
        form_data.append('remaining_amount', remaining_amount);
        form_data.append('customer_id', customer_id);
        form_data.append('date', date);
        form_data.append('_token', csrfToken);

        $.ajax({
            url: "{{ url('add_qout') }}",
            type: 'POST',
            processData: false,
            contentType: false,
            data: form_data,
            success: function(response) {
                show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
            },
            error: function(xhr, status, error) {
                console.log('error', error);

            }
        });
    });
});
    //     //end

</script>
