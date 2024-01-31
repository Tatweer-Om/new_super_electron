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
                    show_notification('error', 'Please add brand name');
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
                        show_notification('success', 'Data has been added successfully');
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
                        show_notification('error', 'Data add failed');
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
                    show_notification('error', 'Please add category name');
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
                        show_notification('success', 'Data has been added successfully');
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
                        show_notification('error', 'Data add failed');
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
                    show_notification('error', 'Please add store name');
                    return false;

                }
                if (phone == "") {
                    show_notification('error', 'Please add store name');
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
                        show_notification('success', 'Data has been added successfully');
                        $('#add_store_modal').modal('hide');
                        $(".add_store")[0].reset();
                        get_selected_new_data(stock_number, 'store')
                        setTimeout(function() {
                            $('.store_id_' + stock_number).val(data.store_id).trigger('change');
                        }, 1000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', 'Data add failed');
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
                    show_notification('error', 'Please add supplier name');
                    return false;

                }
                if (phone == "") {
                    show_notification('error', 'Please add supplier Phone');
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
                        show_notification('success', 'Data has been added successfully');
                        $('#add_supplier_modal').modal('hide');
                        $(".add_supplier")[0].reset();
                        get_selected_new_data(1, 'supplier')
                        setTimeout(function() {
                            $('.supplier_id').val(data.supplier_id).trigger('change');
                        }, 1000);
                        return false;
                    },
                    error: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', 'Data add failed');
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
                } else if (type == "brand") {
                    $('.brand_id_' + i).html(data.brands);
                } else if (type == "category") {
                    $('.category_id_' + i).html(data.categories);
                } else if (type == "store") {
                    $('.store_id_' + i).html(data.stores);
                }
            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error', 'Get data failed');
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
        $('.imei_no_' + i).val('');
        if ($('#imei_check_' + i).is(':checked')) {
            $('.imei_div_' + i).show();
        } else {
            $('.imei_div_' + i).hide();
        }

    }
    // get_sale_price
    function get_sale_price(i) {
        var purchase_price = $('.purchase_price_' + i).val();
        if (purchase_price == "") {
            purchase_price = 0;
        }
        var profit_percent = $('.profit_percent_' + i).val();
        if (profit_percent == "") {
            profit_percent = 0;
        }
        var profit = purchase_price / 100 * profit_percent;
        var sale_price = three_digit_after_decimal(parseFloat(purchase_price) + parseFloat(profit));
        $('.sale_price_' + i).val(sale_price);
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
                                                        <option value="">Choose...</option>
                                                            <?php foreach ($stores as $store) {
                                                                echo '<option value="' . $store->id . '">' . $store->store_name . '</option>';
                                                            } ?>

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
                                                        <option value="">Choose...</option>
                                                            <?php foreach ($category as $cat) {
                                                                echo '<option value="' . $cat->id . '">' . $cat->category_name . '</option>';
                                                            } ?>
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
                                                        <option value="">Choose...</option>
                                                            <?php foreach ($brands as $brand) {
                                                                echo '<option value="' . $brand->id . '">' . $brand->brand_name . '</option>';
                                                            } ?>
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
                                                    <input type="text" onchange="search_barcode(${count})" class="form-control barcode_${count}" name="barcode[]">
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
                                        <label class="form_group_input" style="margin-bottom: 10px">Profit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="text" class="form-control profit_percent_${count} isnumber" onkeyup="get_sale_price(${count})" name="profit_percent[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Sale Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" readonly class="form-control sale_price_${count} isnumber" name="sale_price[]">
                                        </div>
                                    </div>
                                    

                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <label class="form_group_input" style="margin-bottom: 10px">Minnimum Sale Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">OMR</span>
                                            <input type="text" class="form-control min_sale_price_${count} isnumber" name="min_sale_price[]">
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
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-10 col-10">
                                                    <input type="text" class="form-control quantity_${count} isnumber1" name="quantity[]">
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
                                                <input class="form-control imei_no_${count}" name="imei_no[]">
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
                                            <img src="<?php echo asset('images/dummy_image/no_image.png'); ?>" id="stock_img_tag_${count}" width="150px" height="100px">
                                        </div>
                                    </div>
                                </div>
                            </div>`);

        $('.category_id_' + count).select2();
        $('.brand_id_' + count).select2();
        $('.store_id_' + count).select2();
        $(".imei_no_" + count).tagsinput();
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
        show_notification('success', 'Stock area has been removed');
    });
    //

    // get total purchase price and total tax
    $('body').on('keyup', '.all_purchase_price, .all_tax', function() {
        var totalTax = 0;
        var totalPurchasePrice = 0;

        // Loop through all elements with class 'all_purchase_price'
        $('.all_purchase_price').each(function() {
            var inputValue = parseFloat($(this).val()) || 0;
            totalPurchasePrice += inputValue;

            // Get the corresponding tax input in the same row
            var taxInput = $(this).closest('.row').find('.all_tax');
            var taxValue = parseFloat(taxInput.val()) || 0;
            taxValue = inputValue / 100 * taxValue;
            totalTax += taxValue;
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
            show_notification('error', 'Please provide Invoice # first');
            return false;
        }
        if(supplier_id=="")
        {
            show_notification('error', 'Please provide supplier first');
            return false;
        }
        if(purchase_date=="")
        {
            show_notification('error', 'Please provide Purchase Date first');
            return false;
        }
        if(shipping_cost=="")
        {
            show_notification('error', 'Please provide Shipping Cost first');
            return false;
        }

        // product validation
        var stocks_class = $('.stocks_class').length;
        for (var i = 1; i <= stocks_class; i++) {
            if($('.store_id_'+i).val()=="")
            {
                show_notification('error', 'Please provide store '+i+' first');
                return false;
            }
            if($('.category_id_'+i).val()=="")
            {
                show_notification('error', 'Please provide category '+i+' first');
                return false;
            }
            if($('.brand_id_'+i).val()=="")
            {
                show_notification('error', 'Please provide brand '+i+' first');
                return false;
            }
            if($('.product_name_'+i).val()=="" && $('.product_name_ar_'+i).val()=="")
            {
                show_notification('error', 'Please provide product name '+i+' first');
                return false;
            }
            if($('.barcode_'+i).val()=="")
            {
                show_notification('error', 'Please provide Barcode '+i+' first');
                return false;
            }
            if($('.purchase_price_'+i).val()=="")
            {
                show_notification('error', 'Please provide purchase price '+i+' first');
                return false;
            }
            if($('.profit_percent_'+i).val()=="")
            {
                show_notification('error', 'Please provide profit percent '+i+' first');
                return false;
            }
            if($('.quantity_'+i).val()=="")
            {
                show_notification('error', 'Please provide quantity '+i+' first');
                return false;
            }
            if($('.notification_limit_'+i).val()=="")
            {
                show_notification('error', 'Please provide Notification Limit '+i+' first');
                return false;
            }
            if($('#warranty_type_shop_'+i+':checked').val()!=3)
            {
                if($('.warranty_days_'+i).val()=="")
                {
                    show_notification('error', 'Please provide warranty days for product '+i);
                    return false;
                }
            }
            if ($('#whole_sale_'+i).is(':checked'))
            {
                if($('.bulk_quantity_'+i).val()=="")
                {
                    show_notification('error', 'Please provide Bulk Quantity for product '+i);
                    return false;
                }
                if($('.bulk_price_'+i).val()=="")
                {
                    show_notification('error', 'Please provide Bulk Price for product '+i);
                    return false;
                }
            }

            if ($('#imei_check_'+i).is(':checked'))
            {
                if($('.imei_no_'+i).val()=="")
                {
                    show_notification('error', 'Please provide IMEI for product '+i);
                    return false;
                }
            }

        }

        before_submit();
        $('#global-loader').show();
        var str = $(".add_purchase_product").serialize();

        $.ajax({
            type: "POST",
            url: "<?php echo url('add_purchase_product') ?>",
            data: formdatas,
            contentType: false,
            processData: false,
            success: function(html) {
                $('#global-loader').hide();
                after_submit();
                show_notification('success', 'Product purchase has been added successfully!');
            },
            error: function(html) {
                show_notification('error', 'Product purchase addition failed!');
                console.log(html);
            }
        });
    });

    //

    // search invoice no
    $('.invoice_no').keyup(function() {
        $('.submit_form').attr('disabled',true);
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
                show_notification('error', 'Search data failed');
                console.log(data);
                return false;
            }
        });
    });
    // 

    // search barcode 
    function search_barcode(i) {
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
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $.ajax({
                    dataType:'JSON',
                    url: "<?php echo url('get_product_data'); ?>",
                    method: "POST",
                    data: {
                        result: ui.item.value,
                        _token: csrfToken
                    },
                    success: function(data) {
                        if(data!=""){
                            setTimeout(function() {
                                $('.category_id_'+1).val(data.category_id).trigger('change');
                                $('.store_id_'+1).val(data.store_id).trigger('change');
                                $('.brand_id_'+1).val(data.brand_id).trigger('change');
                            }, 1000);
                            $(".product_name_"+i).val(data.product_name);
                            $(".product_name_ar	_"+i).val(data.product_name_ar	);
                            $(".barcode_"+i).val(data.barcode);
                            $(".purchase_price_"+i).val(data.purchase_price);
                            $(".profit_percent_"+i).val(data.profit_percent);
                            $(".sale_price_"+i).val(data.sale_price);
                            $(".min_sale_price_"+i).val(data.min_sale_price);
                            $(".tax_"+i).val(data.tax);
                            $(".quantity_"+i).val(data.quantity);
                            $(".notification_limit_"+i).val(data.notification_limit);
                            $('input[type="radio"][name="product_type_' + i + '"][value="' + data.product_type + '"]').prop('checked', true);
                            $('input[type="radio"][name="warranty_type_' + i + '"][value="' + data.warranty_type + '"]').prop('checked', true);
                            $(".warranty_days_"+i).val(data.warranty_days);
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
                                $('#imei_check_'+i).attr('checked',true);
                                $(".imei_no_"+i).val(data.imei_no); 
                                $(".imei_div__"+i).show(); 
                            }
                            else
                            {
                                $('#imei_check_'+i).attr('checked',false);
                                $(".imei_no_"+i).val(''); 
                                $(".imei_div__"+i).hide(); 
                            }
                            $(".description_"+i).val(data.description);
                            var imagePath = '<?php echo asset('images/dummy_image/no_image.png'); ?>';
                            $('#stock_img_tag_').attr('src',imagePath);
                            if(data.stock_image!="")
                            {
                                imagePath = '<?php echo asset('images/product_images/'); ?>/' + data.stock_image;
                                $('#stock_img_tag_'.i).attr('src',imagePath);
                            }
                        }
                    }
                });
            }
        });
    } 
    // 


</script>
