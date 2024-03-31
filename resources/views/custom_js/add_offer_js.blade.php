<script type="text/javascript">
    $(document).ready(function() {
        $('#add_offer_modal').on('hidden.bs.modal', function() {
            $(".add_offer")[0].reset();
            $('.offer_id').val('');

        });
        $('#all_offer').DataTable({
            "sAjaxSource": "{{ url('show_offer') }}",
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
        });

        $('.add_offer').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_offer')[0]);
            var title=$('.offer_name').val();
            var start_date=$('.offer_start').val();
            var end_date=$('.offer_end').val();
            var id=$('.offer_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_name_lang',[],session('locale')); ?>'); return false;
                }
                if(start_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_start_date_lang',[],session('locale')); ?>'); return false;
                }
                if(end_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_end_date_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_offer").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_offer') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        if(data.status==1)
                        {
                            show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                            $('#add_offer_modal').modal('hide');
                            $('#all_offer').DataTable().ajax.reload();
                            return false;
                        }

                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_offer').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_name_lang',[],session('locale')); ?>'); return false;

                }
                if(start_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_start_date_lang',[],session('locale')); ?>'); return false;
                }
                if(end_date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_offer_end_date_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_offer").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_offer') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        if(data.status==1)
                        {
                            $('#all_offer').DataTable().ajax.reload();
                            show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                            $('#add_offer_modal').modal('hide');
                            $(".add_offer")[0].reset();
                            return false;
                        }
                        else if(data.status==2)
                        {
                            show_notification('error','<?php echo trans('messages.national_id_exist_lang',[],session('locale')); ?>');
                        }
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_offer').DataTable().ajax.reload();
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
            url : "{{ url('edit_offer') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){

                    $(".offer_id").val(fetch.offer_id);
                    $(".offer_name").val(fetch.offer_name);
                    $(".offer_discount_type").val(fetch.offer_discount_type);
                    $(".offer_discount").val(fetch.offer_discount);
                    $(".offer_start").val(fetch.offer_start_date);
                    $(".offer_end").val(fetch.offer_end_date);
                    $(".offer_detail").val(fetch.offer_detail);
                    $(".offer_type").val(fetch.offer_type);
                    $(".offer_apply").val(fetch.offer_apply);
                    $(".offer_product").html(fetch.offer_product);
                    $(".offer_brand").html(fetch.offer_brand);
                    $(".offer_category").html(fetch.offer_category);
                    $('.employee_detail').hide();
                    $('.student_detail').hide();
                    $('.teacher_detail').hide();
                    var offer_types = fetch.offer_type;
                    $('.offer_type').each(function() {
                        var value = $(this).val();

                        if (offer_types.includes(value)) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    });
                    var offer_apply = fetch.offer_apply;
                    $('.offer_type').each(function() {
                        var value = $(this).val();

                        if (offer_apply.includes(value)) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    });

                    $(".modal-title").html('<?php echo trans('messages.update_lang',[],session('locale')); ?>');

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
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('delete_offer') }}",
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
                        $('#all_offer').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }

    $(document).ready(function() {
    $("#my_select").select2();
});

function check_offer(checkbox) {
        // Get all checkboxes with the same name
        var checkboxes = document.getElementsByName(checkbox.name);
        // Uncheck all checkboxes
        checkboxes.forEach(function(item) {
            if (item !== checkbox) {
                item.checked = false;
            }
        });
    }

    function toggleTaxSign() {
    var checkbox = document.getElementById("box");
    var taxSign = document.getElementById("tax_sign");

    if (checkbox.checked) {
        taxSign.textContent = "OMR";
    } else {
        taxSign.textContent = "%";
    }
}

    </script>
