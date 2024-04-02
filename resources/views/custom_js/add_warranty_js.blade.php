<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#warranty_table').DataTable({
            "bFilter": true,
            "sDom": 'fBtlpi',
            'pagingType': 'numbers',
            "ordering": true,
            "language": {
                search: ' ',
                sLengthMenu: '_MENU_',
                searchPlaceholder: '<?php echo trans('messages.search_lang',[],session('locale')); ?>',
                info: "_START_ - _END_ of _TOTAL_ items",
            },
            initComplete: (settings, json)=>{
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            }, 
            "ajax": {
                "url": "{{ url('warranty_products') }}",
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token here
                },
                "data": function (d) { 
                    d.order_id = $('.order_id').val();;  // Change "your_status_value" to the actual status value you want to pass
                }
            },
            "drawCallback": function() {
                // Apply d-none class to the hidden column
                $('#warranty_table tbody tr').each(function() {
                    $(this).find('td:eq(11)').addClass('d-none');
                    $(this).find('td:eq(12)').addClass('d-none');
                    $(this).find('td:eq(13)').addClass('d-none');
                    $(this).find('td:eq(14)').addClass('d-none');
                    $(this).find('td:eq(15)').addClass('d-none');
                });
            } 
        });
         
        
        //saving_data
        $('#warranty_card').click(function() {

            var customer_id = $('.customer_id').val();
            var order_no = $('.order_id').val();

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
            form_data.append('order_no', order_no);
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
                        $('#print_warranty_card').attr('order_no', order_no);
                    }
                    else
                    {
                        show_notification('error', response.same_item +' <?php echo trans('messages.already_present_lang', [], session('locale')); ?>');
                        return false;
                    }
                }
            });

        });

        //end_saving_data
        $('.order_id, #hash').on('keypress click', function(event) {
        if ((event.which === 13 && event.target.tagName !== 'A') || (event.target.id === 'hash' && event.type === 'click')) {
            var order_id = $('.order_id').val();
            // Get the DataTable instance
            var dataTable = $('#warranty_table').DataTable(); 
            // Redraw the DataTable
            dataTable.ajax.reload();
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

        if  ($('#approved_warranty_pro').find('div.approved_' + barcode+imei).length >= 1) {

            show_notification('error','<?php echo trans('messages.data already_present_lang',[],session('locale')); ?>');

        }
        else
        {
            var orderHtml = `<div class="product-list d-flex align-items-center justify-content-between approved_${barcode}${imei}" >
            <div class="d-flex align-items-center product-info" >

                <input type="hidden" name="stock_ids" value="${product_id}" class="stock_ids">
                <input type="hidden"  value="${customer_id}" class="customer_id">
                <input type="hidden"  value="${imei}" class="imei">
                <input type="hidden"  value="${warranty_type_hidden}" class="warranty_type_hidden">
                <input type="hidden"  value="${warranty_days_hidden}" class="warranty_days_hidden">

                <div class="info">
                    <span class="barcode" >${barcode}</span>
                    <h6><a href="javascript:void(0);" class="product_name">${product_name}</a></h6>
                    <p>${invoice_no}</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span class="purchase_price">${integer_price} <?php echo trans('messages.OMR_lang',[],session('locale')); ?></span>
                    <h6><a href="javascript:void(0);" class="quantity">${integerPart} <?php echo trans('messages.quantity_lang',[],session('locale')); ?></a></h6>
                    <p class="total_price">${integerTotal} <?php echo trans('messages.OMR_lang',[],session('locale')); ?></p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span><?php echo trans('messages.warranty_lang',[],session('locale')); ?></span>
                    <h6><a href="javascript:void(0);">${warranty}</a></h6>
                    <p> <?php echo trans('messages.active_lang',[],session('locale')); ?></p>
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

function warranty_card() {
    var order_no = $('#print_warranty_card').attr('order_no');
    var baseUrl = "{{ url('/') }}";
    var warranty_card = baseUrl + '/warranty_card/' + order_no;
    window.open(warranty_card, '_blank');
    window.location.reload();

}








</script>
