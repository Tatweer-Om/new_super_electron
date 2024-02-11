<script>
    $(document).ready(function() {
        // brand
        $('.add_brand').off().on('submit', function(e) {
            e.preventDefault();
            var formdatas = new FormData($('.add_brand')[0]);
            var title = $('.brand_name').val();
            var id = $('.brand_id').val();
            var stock_number = $('.stock_number').val();

            if (id == '') {

                if (title == "") {
                    show_notification('error', '<?php echo trans('messages.add_brand_name_lang',[],session('locale')); ?>');
                    return false;

                }

                $('#global-loader').show();
                before_submit();
                var str = $(".add_brand").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('add_brand'); ?>",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_brand').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_brand_modal').modal('hide');
                        $(".add_brand")[0].reset();
                        get_selected_new_data(stock_number, 'brand')
                        setTimeout(function() {
                            $('.brand_id_' + stock_number).val(data.brand_id).trigger('change');
                        }, 1000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', '<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_brand').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });

            }

        });
        // brand
        // category
        $('.add_category').off().on('submit', function(e) {
            e.preventDefault();
            var formdatas = new FormData($('.add_category')[0]);
            var title = $('.category_name').val();
            var id = $('.category_id').val();
            var stock_number = $('.stock_number').val();

            if (id == '') {


                if (title == "") {
                    show_notification('error', '<?php echo trans('messages.data_add_category_name_lang',[],session('locale')); ?>');
                    return false;

                }

                $('#global-loader').show();
                before_submit();
                var str = $(".add_category").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('add_category'); ?>",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_category').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_category_modal').modal('hide');
                        $(".add_category")[0].reset();
                        get_selected_new_data(stock_number, 'category')
                        setTimeout(function() {
                            $('.category_id_' + stock_number).val(data.category_id).trigger('change');
                        }, 1000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', '<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_category').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });

            }

        });
        // category
        // store
        $('.add_store').off().on('submit', function(e) {
            e.preventDefault();
            var formdatas = new FormData($('.add_store')[0]);
            var title = $('.store_name').val();
            var phone = $('.store_phone').val();
            var id = $('.store_id').val();
            var stock_number = $('.stock_number').val();

            if (id == '') {


                if (title == "") {
                    show_notification('error', '<?php echo trans('messages.add_store_name_lang',[],session('locale')); ?>');
                    return false;

                }
                if (phone == "") {
                    show_notification('error', '<?php echo trans('messages.add_store_phone_lang',[],session('locale')); ?>');
                    return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_store").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('add_store'); ?>",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_store').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_store_modal').modal('hide');
                        $(".add_store")[0].reset();
                        get_selected_new_data(stock_number, 'store');
                        setTimeout(function() {
                            $('.store_id_' + stock_number).val(data.store_id).trigger('change');
                        }, 1000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', '<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_store').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });

            }

        });
        // store
        // supplier
        $('.add_supplier').off().on('submit', function(e) {
            e.preventDefault();
            var formdatas = new FormData($('.add_supplier')[0]);
            var title = $('.supplier_name').val();
            var phone = $('.supplier_phone').val();
            var id = $('.supplier_id').val();

            if (id == '') {


                if (title == "") {
                    show_notification('error', '<?php echo trans('messages.add_supplier_name_lang',[],session('locale')); ?>');
                    return false;

                }
                if (phone == "") {
                    show_notification('error', '<?php echo trans('messages.add_supplier_phone_lang',[],session('locale')); ?>');
                    return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_supplier").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('add_supplier') ?>",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_supplier').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_supplier_modal').modal('hide');
                        $(".add_supplier")[0].reset();
                        get_selected_new_data(1, 'supplier')
                        setTimeout(function() {
                            $('.supplier_id').val(data.supplier_id).trigger('change');
                        }, 2000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', '<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_supplier').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });

            }

        });
        // supplier
    });
    // stock_number
    function stock_number(i) {
        $('.stock_number').val(i);
    }
    //
    //get new selected values
    function get_selected_new_data(i, type) {
        $('#global-loader').show();
        before_submit();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "<?php echo url('get_selected_new_data'); ?>",
            method: "POST",
            data: {
                _token: csrfToken
            },
            success: function(data) {
                $('#global-loader').hide();
                after_submit();
                // Access data and populate select boxes

                if (type == "supplier") {
                    $('.supplier_id').html(data.suppliers);
                }
                else
                {
                    var total_stock = $('.stocks_class').length;
                    for (let index = 1; index <= total_stock; index++) {
                        if (type == "brand") {
                            var this_brand_id=$('.brand_id_' + index).val();
                            $('.brand_id_' + index).html(data.brands);
                            if(i!=index)
                            {
                                $('.brand_id_' + index).val(this_brand_id).trigger('change');
                            }
                        } else if (type == "category") {
                            var this_category_id=$('.category_id_' + index).val();
                            $('.category_id_' + index).html(data.categories);
                            if(i!=index)
                            {
                                $('.category_id_' + index).val(this_category_id).trigger('change');
                            }
                        } else if (type == "store") {
                            var this_store_id=$('.store_id_' + index).val();
                            $('.store_id_' + index).html(data.stores);
                            if(i!=index)
                            {
                                $('.store_id_' + index).val(this_store_id).trigger('change');
                            }
                        }
                    }
                }

            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error', '<?php echo trans('messages.get_data_failed_lang',[],session('locale')); ?>');
                console.log(data);
                return false;
            }
        });
    }
    // get barcode random
    function get_rand_barcode(i) {
        var randomNumber = Math.floor(100000 + Math.random() * 900000);
        $('.barcode_' + i).val(randomNumber);
    }
    //
    // check warranty type
    function check_warranty(i) {
        var selectedValue = $(".warranty_type_" + i + ":checked").val();
        var daysInput = $(".warranty_days_" + i);
        var daysDiv = $(".warranty_days_div_" + i);

        if (selectedValue == 3) {
            // If "None" is selected, hide the "Days" div and empty the input value
            daysDiv.hide();
            daysInput.val("");
        } else {
            // If any other option is selected, show the "Days" div
            daysDiv.show();
            daysInput.val("");
        }
    }
    // check whole sale
    function check_whole_sale(i) {
        $('.bulk_price_' + i).val('');
        $('.bulk_quantity_' + i).val('');
        if ($('#whole_sale_' + i).is(':checked')) {
            $('.bulk_stock_div_' + i).show();
        } else {
            $('.bulk_stock_div_' + i).hide();
        }

    }
    // check imei
    function check_imei(i) {
        before_submit();
        var barcode = $(".barcode_"+i).val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "<?php echo url('check_imei_availability'); ?>",
            method: "POST",
            data: {
                barcode:barcode,
                _token: csrfToken
            },
            success: function(data) {
                after_submit();
                // Access data and populate select boxes
                if (data.status==1) {
                    if(data.check_imei==1)
                    {
                        $('#imei_check_' + i).prop('checked', true);
                        show_notification('error',  '<?php echo trans('messages.product_with_imei_lang',[],session('locale')); ?>');
                    }
                    else
                    {
                        $('#imei_check_' + i).prop('checked', false);
                        show_notification('error', '<?php echo trans('messages.product_without_imei_lang',[],session('locale')); ?>');
                    }
                }
                else
                {
                    $(".imei_no_"+i).tagsinput('removeAll');
                    if ($('#imei_check_' + i).is(':checked')) {
                        $('.imei_div_' + i).show();
                        $('.quantity_' + i).attr('readonly',true);
                        $('.quantity_' + i).val('');
                    } else {
                        $('.imei_div_' + i).hide();
                        $('.quantity_' + i).attr('readonly',false);
                        $('.quantity_' + i).val('');
                    }
                }
            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error',  '<?php echo trans('messages.get_data_failed_lang',[],session('locale')); ?>');
                console.log(data);
                return false;
            }
        });

    }
    // get imei quantity
    function get_imei_qty(i) {
        if ($('#imei_check_' + i).is(':checked')) {
            var imei_nos = $('.imei_no_' + i).val();
            var total_qty = imei_nos.split(',').length;
            $('.quantity_' + i).val(total_qty);
            $('.quantity_' + i).trigger('keyup');
        }
    }
    //
    // get_sale_price
    function get_sale_price(i) {
        setTimeout( function() {
            var purchase_price = $('.purchase_price_' + i).val();
            if (purchase_price == "") {
                purchase_price = 0;
            }

            var profit_percent = $('.profit_percent_' + i).val();
            if (profit_percent == "") {
                profit_percent = 0;
            }

            // Convert to numeric values
            purchase_price = parseFloat(purchase_price);
            profit_percent = parseFloat(profit_percent);

            // Calculate sale price
            var profit = purchase_price / 100 * profit_percent;
            var calculated_sale_price = purchase_price + profit;

            // Update the sale price input field
            $('.sale_price_' + i).val(three_digit_after_decimal(calculated_sale_price));
        }, 2000);
    }
    function get_profit_percent(i) {
        setTimeout( function() {
            var purchase_price = $('.purchase_price_' + i).val();
            if (purchase_price == "") {
                purchase_price = 0;
            }

            var sale_price = $('.sale_price_' + i).val();
            if (sale_price == "") {
                sale_price = 0;
            }

            // Convert to numeric values
            purchase_price = parseFloat(purchase_price);
            sale_price = parseFloat(sale_price);

            // Calculate profit percent
            var profit = sale_price-purchase_price;
            var profit_percent = 100* profit / purchase_price ;

            $('.profit_percent_' + i).val(three_digit_after_decimal(profit_percent));
        }, 2000);
    }

    // tags input
    $(".imei_no_1").tagsinput();


    // append the stock down
    $(document).on('click', '#add_more_stk_btn', function(e) {
        show_notification('success', 'New stock has added');
        var count = $('.stocks_class').length;
        count = count + 1;
        $('#more_stk').append(`<div class="stocks_class stock_no_${count}"><hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h1 class="pro_number">Stock ${count}</h1>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="item_remove"><i class="fa fa-trash fa-3x"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Stores</label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <select class="searchable_select select2 store_id_${count}" name="store_id_stk[]">
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                        data-bs-target="#add_store_modal" onclick="stock_number(${count})">
                                                            <i class="plus_i_class fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Categories</label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <select class="searchable_select select2 category_id_${count}" name="category_id_stk[]">
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                        data-bs-target="#add_category_modal" onclick="stock_number(${count})">
                                                            <i class="plus_i_class fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Brands</label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <select class="searchable_select select2 brand_id_${count}" name="brand_id_stk[]">
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal"
                                                        data-bs-target="#add_brand_modal" onclick="stock_number(${count})">
                                                            <i class="plus_i_class fas fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Product Name (en)</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control product_name_${count}" name="product_name[]">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Product Name (ar)</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control product_name_ar_${count}" name="product_name_ar[]">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Barcode </label>
                                            <div class="row">
                                                <div class="col-lg-10 col-sm-10 col-10">
                                                    <input type="text" onkeyup="search_barcode(${count})" onchange="search_barcode(${count})" class="form-control barcodes barcode_${count}" name="barcode[]">
                                                    <span class="barcode_err_${count}"></span>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                    <div class="add-icon">
                                                        <a onclick="get_rand_barcode(${count})">
                                                            <i class="plus_i_class fas fa-barcode"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Purchase Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" class="form-control all_purchase_price purchase_price_${count} isnumber" onkeyup="get_sale_price(${count})" name="purchase_price[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Tax</label>
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="text" class="form-control all_tax tax_${count}  isnumber" name="tax[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Profit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="text" class="form-control profit_percent_${count} isnumber" onkeyup="get_sale_price(${count})" name="profit_percent[]">
                                        </div>
                                    </div>



                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Sale Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" class="form-control sale_price_${count} isnumber" onkeyup="get_profit_percent(${count})" name="sale_price[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Minnimum Sale Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" class="form-control min_sale_price_${count} isnumber" name="min_sale_price[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control all_qty quantity_${count} isnumber1" name="quantity[]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Notification Limit</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control notification_limit_${count} isnumber1" name="notification_limit[]">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="row product_radio_class" >
                                            <label class="col-lg-6">Product Type : </label>
                                            <div class="col-lg-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="product_type_${count}" id="product_type_retail_${count}" value="1" checked>
                                                    <label class="form-check-label" for="product_type_retail_${count}">
                                                    Retail
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="product_type_${count}" id="product_type_spare_${count}" value="2">
                                                    <label class="form-check-label" for="product_type_spare_${count}">
                                                    Spare Parts
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12 pb-5">
                                        <div class="row product_radio_class" >
                                            <label class="col-lg-6">Warranty : </label>
                                            <div class="col-lg-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input warranty_type_${count}" type="radio" onclick="check_warranty(${count})" name="warranty_type_${count}" id="warranty_type_none_${count}" value="3" checked>
                                                    <label class="form-check-label" for="warranty_type_none_${count}">
                                                    None
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input warranty_type_${count}" type="radio" onclick="check_warranty(${count})" name="warranty_type_${count}" id="warranty_type_shop_${count}" value="1" >
                                                    <label class="form-check-label" for="warranty_type_shop_${count}">
                                                    Shop
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input warranty_type_${count}" type="radio" onclick="check_warranty(${count})" name="warranty_type_${count}" id="warranty_type_agent_${count}" value="2">
                                                    <label class="form-check-label" for="warranty_type_agent_${count}">
                                                    Agent
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12 pb-5 warranty_days_div_${count} display_none" >
                                        <label class="col-lg-6">Days</label>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-10 col-10">
                                                <input type="text" class="form-control warranty_days_${count}" name="warranty_days[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12 pb-5">
                                        <div class="row product_radio_class">
                                                <label class="checkboxs">Whole Sale
                                                    <input type="checkbox" onclick="check_whole_sale(${count})" name="whole_sale${count}" value="1" id="whole_sale_${count}">
                                                    <span class="checkmarks" for="whole_sale_${count}"></span>
                                                </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12 pb-5 bulk_stock_div_${count} display_none">
                                        <label class="col-lg-6">Bulk Quantity</label>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-10 col-10">
                                                <input type="text" class="form-control bulk_quantity_${count}" name="bulk_quantity[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12 pb-5 bulk_stock_div_${count} display_none">
                                        <label class="col-lg-6">Unit Price</label>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-10 col-10">
                                                <input type="text" class="form-control bulk_price_${count}" name="bulk_price[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12 pb-5">
                                        <div class="row product_radio_class">
                                                <label class="checkboxs">IMEI #
                                                    <input type="checkbox" value="1"  onclick="check_imei(${count})" name="imei_check${count}" id="imei_check_${count}">
                                                    <span class="checkmarks" for="imei_check_${count}"></span>
                                                </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12 pb-5 imei_div_${count} display_none">
                                        <label class="col-lg-6">IMEI</label>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-10 col-10">
                                                <input onchange="get_imei_qty(${count})" class="form-control imei_no_${count}" name="imei_no[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12 pb-5">
                                        <label class="col-lg-6">Description</label>
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-10 col-10">
                                                <textarea class="form-control description_${count}" name="description[]" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="validationTooltip03">Upload Image</label>
                                            <div class="fileinput fileinput-new input-group"  data-provides="fileinput">
                                                <span class="input-group-addon fileupload btn btn-submit" style="width: 100%">
                                                    <input type="file" class="image" onchange="return fileValidation('stock_img_${count}','stock_img_tag_${count}')"   name="stock_image_${count}" id="stock_img_${count}"  >
                                                </span>
                                            </div>
                                            <img src="<?php echo asset('images/dummy_image/no_image.png'); ?>" class="im img-thumbnail module_image" id="stock_img_tag_${count}" width="150px" height="100px">
                                        </div>
                                    </div>
                                </div>
                            </div>`);


        $(".imei_no_" + count).tagsinput();

        // clone select boxes
        var last_count = count - 1;


        // Initialize Select2 for the newly cloned select boxes
        $('.category_id_' + count).select2();
        $('.brand_id_' + count).select2();
        $('.store_id_' + count).select2();

        get_selected_new_data(count, 'category')
        get_selected_new_data(count, 'brand')
        get_selected_new_data(count, 'store')


        var divs = $('.stocks_class');

        // Assign numbers based on their order
        divs.each(function(index) {
            var h1 = $(this).find('.pro_number');
            h1.text('Stock ' + (index + 1));
        });


    });
    // remove stock
    $(document).on('click', '.item_remove', function(e) {
        e.preventDefault();
        $(this).closest('.stocks_class').remove();
        var divs = $('.stocks_class');
        // Assign numbers based on their order
        divs.each(function(index) {
            var h1 = $(this).find('.pro_number');
            h1.text('Stock ' + (index + 1));
        });
        show_notification('success',  '<?php echo trans('messages.stock_area_removed_lang',[],session('locale')); ?>');
    });
    //

    // get total purchase price and total tax
    $('body').on('keyup', '.all_purchase_price, .all_tax, .all_qty', function() {
        var totalTax = 0;
        var totalPurchasePrice = 0;
        var total_qty = 0;

        // Loop through all elements with class 'all_purchase_price'
        $('.all_purchase_price').each(function() {

            // Get the closest parent row of the purchase price input
            var row = $(this).closest('.row');
            // Find the next row and get the value of all_qty
            var qty_value = row.next('.row').find('.all_qty');
            var total_qty = parseFloat(qty_value.val()) || 0;


            var inputValue = parseFloat($(this).val()) || 0;
            totalPurchasePrice += inputValue*total_qty;

            // Find the corresponding tax input by going up to the parent row and then finding the tax input within the same row
            var taxInput = row.find('.all_tax');
            console.log('Tax input:', taxInput);

            var taxValue = parseFloat(taxInput.val()) || 0;

            console.log('Tax value:', taxValue);

            taxValue = inputValue / 100 * taxValue;
            totalTax += taxValue*total_qty;

        });

        // Update the totals in the HTML
        $('#total_tax').text(totalTax.toFixed(3));
        $('#total_price').text(totalPurchasePrice.toFixed(3));
        $('#total_tax_input').val(totalTax.toFixed(3));
        $('#total_price_input').val(totalPurchasePrice.toFixed(3));
    });


    //
    // add purchase product

    $('.add_purchase_product').off().on('submit', function(e) {

        e.preventDefault();
        var formdatas = new FormData($('.add_purchase_product')[0]);
        var supplier_id = $('.supplier_id').val();
        var invoice_no = $('.invoice_no').val();
        var purchase_date = $('.purchase_date').val();
        var shipping_cost = $('.shipping_cost').val();


        // invoice validation
        if(invoice_no=="")
        {
            show_notification('error',  '<?php echo trans('messages.provide_invoice#_lang',[],session('locale')); ?>');
            return false;
        }
        if(supplier_id=="")
        {
            show_notification('error',  '<?php echo trans('messages.provide_supplier_first_lang',[],session('locale')); ?>');
            return false;
        }
        if(purchase_date=="")
        {
            show_notification('error', '<?php echo trans('messages.provide_purchase_date_lang',[],session('locale')); ?>');
            return false;
        }
        if(shipping_cost=="")
        {
            show_notification('error',  '<?php echo trans('messages.provide_shipping_cost_lang',[],session('locale')); ?>');
            return false;
        }

        // product validation
        var stocks_class = $('.stocks_class').length;
        for (var i = 1; i <= stocks_class; i++) {

            if($('.store_id_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_store_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.category_id_'+i).val()=="")
            {
                show_notification('error',  +i  '<?php echo trans('messages.provide_category_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.brand_id_'+i).val()=="")
            {
                show_notification('error',  +i '<?php echo trans('messages.provide_brand_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.product_name_'+i).val()=="" && $('.product_name_ar_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_product_name_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.barcode_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_barcode_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.purchase_price_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_purchase_price_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.profit_percent_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_profit_percent_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.quantity_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_quantity_lang',[],session('locale')); ?>');
                return false;
            }
            if($('.notification_limit_'+i).val()=="")
            {
                show_notification('error', +i '<?php echo trans('messages.provide_notification_limit_first_lang',[],session('locale')); ?>');
                return false;
            }
            if($('input[name="warranty_type_' + i + '"]:checked').val() != 3)
            {
                if($('.warranty_days_'+i).val()=="")
                {
                    show_notification('error', +i '<?php echo trans('messages.provide_warranty_days_lang',[],session('locale')); ?>');
                    return false;
                }
            }
            if ($('#whole_sale_'+i).is(':checked'))
            {
                if($('.bulk_quantity_'+i).val()=="")
                {
                    show_notification('error',  +i '<?php echo trans('messages.provide_bulk_quantity_lang',[],session('locale')); ?>');
                    return false;
                }
                if($('.bulk_price_'+i).val()=="")
                {
                    show_notification('error', +i '<?php echo trans('messages.provide_bulk_price_lang',[],session('locale')); ?>');
                    return false;
                }
            }

            if ($('#imei_check_'+i).is(':checked'))
            {
                if($('.imei_no_'+i).val()=="")
                {
                    show_notification('error', ' '+i '<?php echo trans('messages.provide_imei_product_lang',[],session('locale')); ?>');
                    return false;
                }
            }

        }

        // Store entered barcodes in an object
        var enteredBarcodes = {};
        var duplicate_barcodes = '';
        $('.barcodes').each(function () {
            var barcode = $(this).val();
            if (enteredBarcodes.hasOwnProperty(barcode)) {
                duplicate_barcodes=duplicate_barcodes+barcode + ', '
            } else {
                enteredBarcodes[barcode] = true;
            }
        });

        before_submit();
        $('#global-loader').show();

        if(duplicate_barcodes!="")
        {
            show_notification('error', duplicate_barcodes+ '<?php echo trans('messages.duplicate barcode_lang',[],session('locale')); ?>');
            $('#global-loader').hide();
            after_submit();
            return false;
        }
        var str = $(".add_purchase_product").serialize();

        $.ajax({
            type: "POST",
            url: "<?php echo url('add_purchase_product' ) ?>",
            data: formdatas,
            contentType: false,
            processData: false,
            success: function(html) {
                $('#global-loader').hide();
                after_submit();
                show_notification('success',  '<?php echo trans('messages.purchase_added_success_lang',[],session('locale')); ?>');
                location.reload();
            },
            error: function(html) {
                show_notification('error', '<?php echo trans('messages.purchase_add_failed_lang',[],session('locale')); ?>');
                console.log(html);
            }
        });
    });

    //

    // search invoice no
    $('.invoice_no').keyup(function() {
        $('.invoice_err').html('<span class="text text-warning"> '<?php echo trans('messages.checking_invoice#_lang',[],session('locale')); ?>'<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></span>');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "<?php echo url('search_invoice'); ?>",
            method: "POST",
            data: {search:$('.invoice_no').val(),
                _token: csrfToken
            },
            success: function(data) {
                if(data.error_code==1)
                {
                    $('.invoice_err').html('<span class="text text-danger">'+data.error+'</span>');
                    $('.submit_form').attr('disabled',true);
                }
                else
                {
                    $('.invoice_err').html('');
                    $('.submit_form').attr('disabled',false);
                }

            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error',  '<?php echo trans('messages.search_data_failed_lang',[],session('locale')); ?>');
                console.log(data);
                return false;
            }
        });
    });
    //

    // search barcode
    function search_barcode(i) {
        // $('.barcode_err_'+i).html('<span class="text text-warning">Searching Barcode <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></span>');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('.barcode_' + i).autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo url('search_barcode'); ?>",
                    dataType: 'json',
                    data: {
                        search: request.term,
                        _token: csrfToken
                    },
                    success: function(data) {
                        $('.barcode_err_'+i).html('');
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $.ajax({
                    dataType:'JSON',
                    url: "<?php echo url('get_product_data'); ?>" ,
                    method: "POST",
                    data: {
                        result: ui.item.value,
                        _token: csrfToken
                    },
                    success: function(data) {
                        if(data!=""){
                            setTimeout(function() {
                                $('.category_id_'+i).val(data.category_id).trigger('change');
                                $('.store_id_'+i).val(data.store_id).trigger('change');
                                $('.brand_id_'+i).val(data.brand_id).trigger('change');
                            }, 1000);
                            $(".product_name_"+i).val(data.product_name);
                            $(".product_name_ar_"+i).val(data.product_name_ar);
                            $(".barcode_"+i).val(data.barcode);
                            $(".purchase_price_"+i).val(data.purchase_price);
                            $(".profit_percent_"+i).val(data.profit_percent);
                            $(".sale_price_"+i).val(data.sale_price);
                            $(".min_sale_price_"+i).val(data.min_sale_price);
                            $(".tax_"+i).val(data.tax);

                            $(".notification_limit_"+i).val(data.notification_limit);
                            $('input[type="radio"][name="product_type_' + i + '"][value="' + data.product_type + '"]').prop('checked', true);
                            $('input[type="radio"][name="warranty_type_' + i + '"][value="' + data.warranty_type + '"]').prop('checked', true);
                            if(data.warranty_type!=3)
                            {
                                $(".warranty_days_"+i).val(data.warranty_days);
                                $(".warranty_days_div_"+i).show();
                            }
                            else
                            {
                                $(".warranty_days_"+i).val('');
                                $(".warranty_days_div_"+i).hide();
                            }

                            if(data.whole_sale==1)
                            {
                                $('#whole_sale_'+i).attr('checked',true);
                                $(".bulk_quantity_"+i).val(data.bulk_quantity);
                                $(".bulk_price_"+i).val(data.bulk_price);
                                $(".bulk_stock_div_"+i).show();
                            }
                            else
                            {
                                $('#whole_sale_'+i).attr('checked',false);
                                $(".bulk_quantity_"+i).val('');
                                $(".bulk_price_"+i).val('');
                                $(".bulk_stock_div_"+i).hide();
                            }
                            if(data.check_imei==1)
                            {
                                $('#imei_check_' + i).prop('checked', true);
                                $(".imei_no_"+i).tagsinput('removeAll');
                                $(".imei_div_"+i).show();
                                $(".quantity_"+i).val(0);
                                $(".quantity_"+i).attr('readonly',true);
                            }
                            else
                            {
                                $('#imei_check_'+i).attr('checked',false);
                                $(".imei_no_"+i).val('');
                                $(".imei_div_"+i).hide();
                                $(".quantity_"+i).val(0);
                                $(".quantity_"+i).attr('readonly',false);
                            }
                            $(".description_"+i).val(data.description);
                            var imagePath = '<?php echo asset('images/dummy_image/no_image.png'); ?>';
                            $('#stock_img_tag_'+i).attr('src',imagePath);
                            if(data.stock_image!="")
                            {
                                imagePath = '<?php echo asset('images/product_images/'); ?>/' + data.stock_image;
                                $('#stock_img_tag_'+i).attr('src',imagePath);
                            }

                            // get the total and total purchase
                            $('.all_purchase_price').trigger('keyup');

                        }
                    }
                });
            }
        });
    }
    // view_purchase
    $('#all_purchase').DataTable({
        "sAjaxSource": "<?php echo url('show_purchase'); ?>",
        "bFilter": true,
        "sDom": 'fBtlpi',
        'pagingType': 'numbers',
        "ordering": true,
        "language": {
            search: ' ',
            sLengthMenu: '_MENU_',
            searchPlaceholder: "Search...",
            info: "_START_ - _END_ of _TOTAL_ items",
        },
        initComplete: (settings, json)=>{
            $('.dataTables_filter').appendTo('#tableSearch');
            $('.dataTables_filter').appendTo('.search-input');
        },

    });
    // approve purchase
    function approved_purchase(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: '<?php echo trans('messages.sure_lang',[],session('locale')); ?>',
            text:  '<?php echo trans('messages.want_complete_purchase_lang',[],session('locale')); ?>',
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: '<?php echo trans('messages.complete_it_lang',[],session('locale')); ?>',
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then(function (result) {
            if (result.value) {
                $('#global-loader').show();
                before_submit();
                $.ajax({
                    url: "<?php echo url('approved_purchase'); ?>" ,
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.approve_purchase_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        $('#all_purchase').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.purchase_approved_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.data_safe_lang',[],session('locale')); ?>');
            }
        });
    }


    // delete purchase
    function del_purchase(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title:  '<?php echo trans('messages.sure_lang',[],session('locale')); ?>',
            text:  '<?php echo trans('messages.delete_lang',[],session('locale')); ?>',
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: '<?php echo trans('messages.delete_it_lang',[],session('locale')); ?>',
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then(function (result) {
            if (result.value) {
                $('#global-loader').show();
                before_submit();
                $.ajax({
                    url: "<?php echo url('delete_purchase'); ?>",
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        $('#all_purchase').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }


    // get purchase payment
    function get_purchase_payment(id)
    {
        $('#global-loader').show();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "<?php echo url('get_purchase_payment'); ?>",
            method: "POST",
            data: {
                id:id,
                _token: csrfToken
            },
            success: function(data) {
                $('#global-loader').hide();
                if(data.remaining_price>0)
                {
                    $('.grand_total').val(data.grand_total);
                    $('.remaining_price').val(data.remaining_price);
                    $('.bill_id').val(data.bill_id);
                    $('.purchase_id').val(id);
                    $('#purchase_payment_modal').modal('show');
                }
                else
                {
                    show_notification('error',  '<?php echo trans('messages.purchase_payment_paid_lang',[],session('locale')); ?>');
                }

            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error',  '<?php echo trans('messages.purchase_payment_failed_lang',[],session('locale')); ?>');
                console.log(data);
                return false;
            }
        });
    }

    // check paid amount
    $('.paid_amount').keyup(function() {
        var remaining_price = $('.remaining_price').val();
        if(parseFloat($(this).val())>parseFloat(remaining_price))
        {
            show_notification('error',  '<?php echo trans('messages.paid_amount_cannot_be_greater_lang',[],session('locale')); ?>');
            $(this).val("")
            return false;
        }
    });
    //

    // check payment_method
    $('.payment_method').change(function() {
        var selectedOption = $(this).find(':selected');
        var status = selectedOption.attr('status');
        if(status!=1)
        {
            $('.payment_reference_no_div').show();
            $('.payment_reference_no').val("");
        }
        else
        {
            $('.payment_reference_no_div').hide();
            $('.payment_reference_no').val("");
        }
    });
    //

    // add purchase payment
    $('.add_purchase_payment').off().on('submit', function(e){
        e.preventDefault();
        var formdatas = new FormData($('.add_purchase_payment')[0]);
        var paid_amount=$('.paid_amount').val();
        var payment_date=$('.payment_date').val();
        var purchase_id=$('.purchase_id').val();
        var payment_reference_no=$('.payment_reference_no').val();
        var payment_method_selected = $('.payment_method').find(':selected');
        var account_status = payment_method_selected.attr('status');

        if(paid_amount=="" )
        {
            show_notification('error','<?php echo trans('messages.add_paid_amount_lang',[],session('locale')); ?>'); return false;

        }
        if(payment_date=="" )
        {
            show_notification('error','<?php echo trans('messages.add_payment_date_lang',[],session('locale')); ?>'); return false;

        }
        if(account_status!=1)
        {
            if(payment_reference_no=="")
            {
                show_notification('error','<?php echo trans('messages.add_payment_reference_no_lang',[],session('locale')); ?>'); return false;
            }
        }

        $('#global-loader').show();
        before_submit();
        var str = $(".add_purchase_payment").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo url('add_purchase_payment');?>",
            data: formdatas,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#global-loader').hide();
                after_submit();
                $('#all_purchase').DataTable().ajax.reload();
                show_notification('success','<?php echo trans('messages.data_add_payment_success',[],session('locale')); ?>');
                get_purchase_payment(purchase_id)
                $(".add_purchase_payment")[0].reset();
                return false;
                },
            error: function(data)
            {
                $('#global-loader').hide();
                after_submit();
                show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                $('#all_purchase').DataTable().ajax.reload();
                console.log(data);
                return false;
            }
        });
    });
    //

</script>
