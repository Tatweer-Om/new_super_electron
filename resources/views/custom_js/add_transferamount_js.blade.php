<script type="text/javascript">
    $(document).ready(function() {
        $('#add_transferamount_modal').on('hidden.bs.modal', function() {
            $(".add_transferamount")[0].reset();
            $('.transferamount_id').val('');
            location.reload();
        });
        $('#all_transferamount').DataTable({
            "sAjaxSource": "{{ url('show_transferamount') }}",
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
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();
                
                // Calculate the total for the entire dataset
                var total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                // Update the footer
                $(api.column(5).footer()).html(total.toFixed(3));
            },
            initComplete: function(settings, json) {
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            }
        });


        $('.add_transferamount').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_transferamount')[0]);
            var acc_from=$('.acc_from').val();
            var acc_to=$('.acc_to').val();
            var amount=$('.amount').val();
            var transfer_date=$('.transfer_date').val();
            var id=$('.transferamount_id').val();

            if(id!='')
            {
                if(acc_from=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_acc_from_lang',[],session('locale')); ?>'); return false;
                }
                if(acc_to=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_acc_to_lang',[],session('locale')); ?>'); return false;
                }
                if(amount=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_amount_lang',[],session('locale')); ?>'); return false;
                }
                if(transfer_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_transfer_date_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_transferamount").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_transferamount') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        $('#add_transferamount_modal').modal('hide');
                        $('#all_transferamount').DataTable().ajax.reload();
                        return false;
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_transferamount').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(acc_from=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_acc_from_lang',[],session('locale')); ?>'); return false;
                }
                if(acc_to=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_acc_to_lang',[],session('locale')); ?>'); return false;
                }
                if(amount=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_amount_lang',[],session('locale')); ?>'); return false;
                }
                if(transfer_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_transfer_date_lang',[],session('locale')); ?>'); return false;
                }

                $('#global-loader').show();
                before_submit();
                var str = $(".add_transferamount").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_transferamount') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_transferamount').DataTable().ajax.reload();
                        show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_transferamount_modal').modal('hide');
                        $(".add_transferamount")[0].reset();
                        $('.transaction_no').val(data.transaction_no)
                        return false;
                        },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_transferamount').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });

            }

        });
    });
    function edit(id){
        $('#global-loader').show();
        before_submit();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax ({
            dataType:'JSON',
            url : "{{ url('edit_transferamount') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){

                    $(".transaction_no").val(fetch.transaction_no);
                    $(".acc_from").val(fetch.acc_from);
                    $(".acc_to").val(fetch.acc_to);
                    $(".amount").val(fetch.amount);
                    $(".transfer_date").val(fetch.transfer_date);
                    $(".notes").val(fetch.notes);  
                    $(".transferamount_id").val(fetch.transferamount_id);
                    $(".modal-title").html('Update');
                }
            },
            error: function(html)
            {
                $('#global-loader').hide();
                after_submit();
                show_notification('error','<?php echo trans('messages.edit_failed_lang',[],session('locale')); ?>');
                console.log(html);
                return false;
            }
        });
    }


    function del(id) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then(function (result) {
            if (result.value) {
                $('#global-loader').show();
                before_submit();
                $.ajax({
                    url: "{{ url('delete_transferamount') }}",
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_transferamount').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.data_is_safe_lang',[],session('locale')); ?>');
            }
        });
    }

    // hide options
    // Save the original options for restoration
    var originalOptionsFrom = $('.acc_from').html();
    var originalOptionsTo = $('.acc_to').html();

    function updateOptions() {
        var selectedFrom = $('.acc_from').val();
        var selectedTo = $('.acc_to').val();

        // Reset the options to the original ones
        $('.acc_from').html(originalOptionsFrom);
        $('.acc_to').html(originalOptionsTo);

        // Hide the selected "Amount to" in "Amount from"
        if (selectedTo) {
            $('.acc_from option[value="' + selectedTo + '"]').remove();
        }

        // Hide the selected "Amount from" in "Amount to"
        if (selectedFrom) {
            $('.acc_to option[value="' + selectedFrom + '"]').remove();
        }

        // Restore the selected values
        $('.acc_from').val(selectedFrom);
        $('.acc_to').val(selectedTo);
    }

    $('.acc_from').change(function() {
        updateOptions();
    });

    $('.acc_to').change(function() {
        updateOptions();
    });

    </script>
