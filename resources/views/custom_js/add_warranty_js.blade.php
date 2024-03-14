<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        //saving_data
        $('#warranty_card').click(function() {

            var customer_id = $('.customer_id').val();

            var product_id = [];
            $('.stock_ids').each(function() {
                product_id.push($(this).val());
            });

            var item_barcode = [];
            $('.barcode').each(function() {
                item_barcode.push($(this).text());
            });
            console.log('item_barcode', item_barcode);



            var quantities = [];
            $('.quantity').each(function() {
                var quantityText = $(this).text();
                var integerPart = parseInt(quantityText.match(/\d+/));
                if (!isNaN(integerPart)) {
                    quantities.push(integerPart);
                } else {

                    console.error('No integer part found in quantity:', quantityText);
                }
            });

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

            var product_name = [];
            $('.product_name').each(function() {
                product_name.push($(this).val());
            });



            var purchase_price = [];
            $('.purchase_price').each(function() {
                var priceText = $(this).text();
                var integerPrice = parseInt(priceText.match(/\d+/));
                if (!isNaN(integerPrice)) {
                    purchase_price.push(integerPrice);
                } else {
                    console.error('No integer part found in price:', priceText);
                }
            });

            var total_price = [];

            $('.total_price').each(function() {
                var totalText = $(this).text();
                var integerTotal = parseInt(totalText.match(/\d+/));
                if (!isNaN(integerTotal)) {
                    total_price.push(integerTotal);
                } else {
                    console.error('No integer part found in total price:', totalText);
                }
            });

            var warranty = [];
            $('.warranty').each(function() {
                warranty.push($(this).val());
            })

            var warranty_days_hidden = [];
            $('.warranty_days_hidden').each(function() {
                warranty_days_hidden.push($(this).val());
            });
            var warranty_type_hidden = [];
            $('.warranty_type_hidden').each(function() {
                warranty_type_hidden.push($(this).val());
            });


            var form_data = new FormData();


            form_data.append('customer_id', customer_id);
            form_data.append('product_id', JSON.stringify(product_id));
            form_data.append('barcode', JSON.stringify(item_barcode));
            form_data.append('item_imei', JSON.stringify(Array.from(uniqueItemIMEI)));
            form_data.append('quantity', JSON.stringify(quantities));
            form_data.append('purchase_price', JSON.stringify(purchase_price));
            form_data.append('total_price', JSON.stringify(total_price));
            form_data.append('warranty_type_hidden', JSON.stringify(warranty_type_hidden));
            form_data.append('warranty_days_hidden', JSON.stringify(warranty_days_hidden));
            form_data.append('_token', csrfToken);


            $.ajax({
                url: "{{ url('warranty_list') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: form_data,
                success: function(response) {

                    if (response.status == 1) {

                        if ($('#approved_warranty_pro').children().length === 0) {
                        show_notification('error','<?php echo trans('messages.add_record_first_lang',[],session('locale')); ?>');
                        return;
                        }
                        show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                    }
                }
            });

        });

        //end_saving_data
        $('.order_id, #hash').on('keypress click', function(event) {
        if ((event.which === 13 && event.target.tagName !== 'A') || (event.target.id === 'hash' && event.type === 'click')) {
        var order_id = $('.order_id').val();


            $.ajax({
                url: "{{ url('warranty_products') }}",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    order_id: order_id
                },
                success: function(response) {

                    if (response.status === 1) {
                        $('#warranty_data').empty();

                        show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                    }
                    else{

                if (response.success) {

                    show_notification('success','<?php echo trans('messages.record_found_lang',[],session('locale')); ?>');
                    $('#warranty_data').empty();
                    $.each(response.aaData, function(index, product) {
                        var row = '<tr>';
                        $.each(product, function(idx, value) {
                            row += '<td>' + value + '</td>';
                        });
                        row += '</tr>';
                        $('#warranty_data').append(row);
                    });
                }
            }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }
        });
    });

    $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#fetch_warranty_data_btn').click(function() {
        if ($('#warranty_data tbody').is(':empty')) {
            show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
        }
        else{
        $('#warranty_data tr').each(function(index, tr) {
            $(tr).trigger('click');
            show_notification('success','<?php echo trans('messages.all_records_added_lang',[],session('locale')); ?>');
        });}
    });

    $('#warranty_data').on('click', 'tr', function() {

        var invoice_no = $(this).find('td:eq(1)').text();
        var product_name = $(this).find('td:eq(2)').text();
        var imei = $(this).find('td:eq(3)').text();
        var barcode = $(this).find('td:eq(4)').text();

        var quantityText = $(this).find('td:eq(6)').text();
        var integerPart = parseInt(quantityText.match(/\d+/));
        if (!isNaN(integerPart)) {
            console.log('quantity:', integerPart);
        } else {

            console.error('No integer part found in quantity:', quantityText);
        }

        var purchase_price = $(this).find('td:eq(5)').text();
        var integer_price = parseInt(purchase_price.match(/\d+/));
        if (!isNaN( integer_price)) {
            console.log(' integer_price:',  integer_price);
        } else {

            console.error('No integer part found in price:',  integer_price);
        }

            var totalText = $(this).find('td:eq(7)').text();
            var integerTotal = parseInt(totalText.match(/\d+/));
            if (!isNaN(integerTotal)) {
                console.log('Total:', integerTotal);
            } else {

                console.error('No integer part found in total:', totalText);
            }


            var warranty = $(this).find('td:eq(8)').text();
            var id = $(this).find('td:eq(11)').text();

            var customer_id = $.trim($(this).find('td:eq(12)').text());
            var product_id = $(this).find('td:eq(13)').text();
            var warranty_type_hidden = $(this).find('td:eq(14)').text();
            var warranty_days_hidden = $(this).find('td:eq(15)').text();

        if  ($('#approved_warranty_pro').find('div.approved_' + barcode).length >= 1) {

            show_notification('error','<?php echo trans('messages.data already_present_lang',[],session('locale')); ?>');

        }
        else
        {
            var orderHtml = `<div class="product-list d-flex align-items-center justify-content-between approved_${barcode}" >
            <div class="d-flex align-items-center product-info" >

                <input type="hidden" name="stock_ids" value="${product_id}" class="stock_ids">
                <input type="hidden"  value="${customer_id}" class="customer_id">
                <input type="hidden"  value="${imei}" class="imei">
                <input type="hidden"  value="${warranty_type_hidden}" class="warranty_type_hidden">
                <input type="hidden"  value="${warranty_days_hidden}" class="warranty_days_hidden">

                <div class="info">
                    <span class="barcode" >${barcode}</span>
                    <h6><a href="javascript:void(0);" class="product_name">${product_name}</a></h6>
                    <p>Invo: ${invoice_no }</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span class="purchase_price">${integer_price} OMR</span>
                    <h6><a href="javascript:void(0);" class="quantity">${integerPart} Item</a></h6>
                    <p class="total_price">${integerTotal} OMR</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span>Warranty</span>
                    <h6><a href="javascript:void(0);">${warranty}</a></h6>
                    <p> Active</p>
                </div>
                </div>

                <div class="d-flex align-items-center action">
                <a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" id="delete-item">
                    <i data-feather="trash-2" class="fas fa-trash"></i>
                </a>
                </div>
            </div>
            `;

            $('#approved_warranty_pro').append(orderHtml);
        }

    });

    $('#approved_warranty_pro').on('click', '#delete-item', function() {
            var $productItem = $(this).closest('.product-list');
            $productItem.remove();
            show_notification('success','<?php echo trans('messages.item_deleted_lang',[],session('locale')); ?>');
        });
        $('#clear_all').click(function() {
            $('#approved_warranty_pro').empty();
            show_notification('success','<?php echo trans('messages.all_items_deleted_lang',[],session('locale')); ?>');

        });

        $('.delete').click(function() {
            $('#approved_warranty_pro').empty();
            show_notification('success','<?php echo trans('messages.all_items_deleted_lang',[],session('locale')); ?>');

        });

});

//warranty_card

function warranty_card(warranty_id) {

    if ($('#approved_warranty_pro').children().length === 0) {
        show_notification('error','<?php echo trans('messages.add_record_first_lang',[],session('locale')); ?>');
        return;
    }
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "{{ url('warranty_card') }}",
        data: {
            warranty_id: warranty_id,
            _token: csrfToken
        },
        success: function(response) {

            if (response.success) {

                $('.customer_name span:eq(1)').text(response.aaData[0].customer_name);
                $('.warranty_no span:eq(1)').text(response.aaData[0].card_id);
                $('.customer_id span:eq(1)').text(response.aaData[0].customer_id);
                $('.date span:eq(1)').text(response.aaData[0].card_date);


                $('.warranty_card').empty();


                $.each(response.aaData, function(index, card) {
                    var row = '<tr>';
                    row += '<td>' + card.product_name + '</td>';
                    row += '<td>' + card.card_imei + '</td>';
                    row += '<td>' + card.card_price + '</td>';
                    row += '<td>' + card.card_quantity + 'Item'+ '</td>';
                    row += '<td>' + card.card_warranty_type + ': ' + card.months_warranty + ' Month' + '</td>';
                    row += '<td class="text-end">' + card.validityDate + '</td>';
                    row += '</tr>';
                    $('.warranty_card').append(row);
                });


                $('#print_card').modal('show');


            } else {

                console.error("Error occurred:", response.message);
            }
        },
        error: function(xhr, status, error) {

            console.error("Error occurred:", error);

        }
    });
}








</script>
