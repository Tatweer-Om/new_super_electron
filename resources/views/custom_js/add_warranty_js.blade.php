<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        //saving_data
        $('#warranty_card').click(function() {

            var customer_id = $('.customer_id').text();

            var product_id = [];
            $('.stock_ids').each(function() {
                product_id.push($(this).val());
            });
            var item_barcode = [];
            $('.barcode').each(function() {
                item_barcode.push($(this).val());
            });

            var product_name = [];
            $('.product_name').each(function() {
                product_name.push($(this).val());
            });

            var purchase_price = [];
            $('.purchase_price').each(function() {
                purchase_price.push($(this).val());
            });

            var total_price = [];
            $('.total_price').each(function() {
                total_price.push($(this).val());
            });

            var quantity = [];
            $('.quantity').each(function() {
                quantity.push($(this).val());
            });

            var barcode = [];
            $('.barcode').each(function() {
                barcode.push($(this).val());
            });

            var warranty = [];
            $('.warranty').each(function() {
                var value = $(this).val();
                var warrantyValue = value.split(': ')[1];
                warranty.push(warrantyValue);
            });


            var form_data = new FormData();
            form_data.append('customer_id', customer_id);
            form_data.append('product_id', JSON.stringify(product_id));
            form_data.append('barcode', JSON.stringify(barcode));
            form_data.append('quantity', JSON.stringify(quantity));
            form_data.append('purchase_price', JSON.stringify(purchase_price));
            form_data.append('total_price', JSON.stringify(total_price));
            form_data.append('customer_id', JSON.stringify(customer_id));
            form_data.append('warranty', JSON.stringify(warranty));
            form_data.append('_token', csrfToken);

            $.ajax({
                url: "{{ url('warranty_list') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: form_data,
                success: function(response) {

                    if (response.status == 1) {
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
        var id = $(this).find('td:eq(11)').text();
        var product_id = $(this).find('td:eq(13)').text();
        var barcode = $(this).find('td:eq(4)').text();
        var product_name = $(this).find('td:eq(2)').text();
        var purchase_price = $(this).find('td:eq(5)').text();
        var quantity = $(this).find('td:eq(6)').text();
        var total = $(this).find('td:eq(7)').text();
        var warranty = $(this).find('td:eq(8)').text();
        var invoice_no = $(this).find('td:eq(1)').text();
        var customer_id = $(this).find('td:eq(12)').text();


        if  ($('#approved_warranty_pro').find('div.approved_' + barcode).length >= 1) {

            show_notification('error','<?php echo trans('messages.data already_present_lang',[],session('locale')); ?>');

        }
        else
        {
            var orderHtml = `<div class="product-list d-flex align-items-center justify-content-between approved_${barcode}" >
            <div class="d-flex align-items-center product-info" >

                <input type="hidden" name="stock_ids" value="${product_id}" class="stock_ids">
                <input type="hidden"  value="${customer_id}" class="customer_id">

                <div class="info">
                    <span class="barcode">${barcode}</span>
                    <h6><a href="javascript:void(0);" class="product_name">${product_name}</a></h6>
                    <p>Invo: ${invoice_no }</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span class="purchase_price">${purchase_price}</span>
                    <h6><a href="javascript:void(0);" class="quantity">${quantity} Items</a></h6>
                    <p class="total_price">${total}</p>
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
        // warranty_list(id);
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





</script>
