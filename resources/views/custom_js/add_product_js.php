<script>
    $(document).ready(function() {
        JsBarcode(".barcode").init();
        // show all products
        $('#all_product').DataTable({
            "sAjaxSource": "<?php echo url('show_product'); ?>",
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
        // 

        // check damage qty
        $('.damage_qty').keyup(function() {
            var current_qty = $('.current_qty').val();
            if(parseFloat($(this).val())>parseFloat(current_qty))
            {
                show_notification('error', 'Damage quantity can not be greater than current quantity');
                $(this).val("")
                return false;
            }
        });
        // 

        // add damage qty
        $('.add_damage_qty').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_damage_qty')[0]);
            var reason=$('.reason').val();
            var product_id=$('.product_id').val(); 
            var stock_type=$('.stock_type').val(); 
            
            if(stock_type==1)
            {
                var damage_qty=$('.damage_qty').val();
                if(damage_qty=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_damage_qty_lang',[],session('locale')); ?>'); return false;

                }
            }
            else
            {
                var imei_checked = $('.all_imeis:checked').length;
                // If no checkbox is checked, display an alert message
                if (imei_checked === 0) {
                    show_notification('error','<?php echo trans('messages.check_atleast_one_imei_lang',[],session('locale')); ?>'); return false;
                }
            }
            if(reason=="" )
            {
                show_notification('error','<?php echo trans('messages.add_reason_lang',[],session('locale')); ?>'); return false;

            }
             
            $('#global-loader').show();
            before_submit();
            var str = $(".add_damage_qty").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo url('add_damage_qty');?>",
                data: formdatas,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#global-loader').hide();
                    after_submit();
                    $('#all_product').DataTable().ajax.reload();
                    show_notification('success','<?php echo trans('messages.data_add_damage_qty_success',[],session('locale')); ?>');
                    get_product_qty(product_id)
                    $(".add_damage_qty")[0].reset();
                    return false;
                    },
                error: function(data)
                {
                    $('#global-loader').hide();
                    after_submit();
                    show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                    $('#all_product').DataTable().ajax.reload();
                    console.log(data);
                    return false;
                }
            }); 
        }); 
        // 
    });

    // get purchase payment
    function get_product_qty(id)
    {
        $('#global-loader').show();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "<?php echo url('get_product_qty'); ?>",
            method: "POST",
            data: {
                id:id,
                _token: csrfToken
            },
            success: function(data) {
                $('#global-loader').hide();
                if(data.qty_status==1)
                {
                    $('#damag_qty_div').html(data.qty_div);
                    $('#damage_qty_modal').modal('show');
                }
                else
                {
                    show_notification('error', 'This product is out of stock');
                }
                
            },
            error: function(data) {
                $('#global-loader').hide();
                after_submit();
                show_notification('error', 'get qty failed');
                console.log(data);
                return false;
            }
        });
    }
</script>    