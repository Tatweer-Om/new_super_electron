<script type="text/javascript">
    $(document).ready(function() {
        $('#add_supplier_modal').on('hidden.bs.modal', function() {
            $(".add_supplier")[0].reset();
            $('.supplier_id').val('');
            $('.supplier_image').val('');
            var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
            $('#img_tag').attr('src',imagePath)
        });
        $('#all_supplier').DataTable({
            "sAjaxSource": "{{ url('show_supplier') }}",
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

        $('.add_supplier').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_supplier')[0]);
            var title=$('.supplier_name').val();
            var phone=$('.supplier_phone').val();
            var id=$('.supplier_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_supplier_name_lang',[],session('locale')); ?>'); return false;
                }
                if(phone=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_supplier_phone_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_supplier").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_supplier') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        $('#add_supplier_modal').modal('hide');
                        $('#all_supplier').DataTable().ajax.reload();
                        return false;
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_supplier').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_supplier_name_lang',[],session('locale')); ?>'); return false;

                }
                if(phone=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_supplier_phone_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_supplier").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_supplier') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_supplier').DataTable().ajax.reload();
                        show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_supplier_modal').modal('hide');
                        $(".add_supplier")[0].reset();
                        return false;
                        },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_supplier').DataTable().ajax.reload();
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
            url : "{{ url('edit_supplier') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){
                    // Define a variable for the image path
                    var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';

                    // Check if the supplier_image is present and not an empty string
                    if (fetch.supplier_image && fetch.supplier_image !== "") {
                        imagePath = '{{ asset('images/supplier_images/') }}/' + fetch.supplier_image;
                    }
                    $('#img_tag').attr('src',imagePath)

                    $(".supplier_name").val(fetch.supplier_name);
                    $(".supplier_phone").val(fetch.supplier_phone);
                    $(".supplier_email").val(fetch.supplier_email);
                    $(".supplier_detail").val(fetch.supplier_detail);
                    $(".supplier_id").val(fetch.supplier_id);
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
                    url: "{{ url('delete_supplier') }}",
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
                        $('#all_supplier').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }



    </script>
