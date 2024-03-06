<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('.order_id').on('keypress', function(event) {

            if (event.which === 13) {
         var order_id = $(this).val();


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
        var id = $(this).find('td:eq(12)').text();
        var barcode = $(this).find('td:eq(4)').text();
        var product_name = $(this).find('td:eq(2)').text();
        var purchase_price = $(this).find('td:eq(5)').text();
        var quantity = $(this).find('td:eq(6)').text();
        var total = $(this).find('td:eq(7)').text();
        var warranty_days = $(this).find('td:eq(8)').text();
        var warranty_type = $(this).find('td:eq(9)').text();
        var invoice_no = $(this).find('td:eq(1)').text();


        if ($('#approved_warranty_pro').find('div.approved_' + id).length > 0) {

            show_notification('error','<?php echo trans('messages.data already_present_lang',[],session('locale')); ?>');

        }
        else
        {
            var orderHtml = `<div class="product-list d-flex align-items-center justify-content-between approved_${id}" >
            <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span>${barcode}</span>
                    <h6><a href="javascript:void(0);">${product_name}</a></h6>
                    <p>Invo: ${invoice_no }</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span><span>OMR</span>${purchase_price}</span>
                    <h6><a href="javascript:void(0);">${quantity} Items</a></h6>
                    <p>OMR ${total}</p>
                </div>
                </div>
                <div class="d-flex align-items-center product-info" >

                <div class="info">
                    <span>Warranty</span>
                    <h6><a href="javascript:void(0);">${warranty_days}</a></h6>
                    <p>${warranty_type}</p>
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
