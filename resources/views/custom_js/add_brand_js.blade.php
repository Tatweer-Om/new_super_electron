<script type="text/javascript">
    $(document).ready(function() {
        $('#add_brand_modal').on('hidden.bs.modal', function() {
            $(".add_brand")[0].reset();
            $('.brand_id').val('');
            var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
            $('#img_tag').attr('src',imagePath)
        });
        $('#all_brand').DataTable({
            "sAjaxSource": "{{ url('show_brand') }}",
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

        $('.add_brand').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_brand')[0]);
            var title=$('.brand_name').val();
            var id=$('.brand_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>','<?php echo trans('messages.add_brand_name_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_brand").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_brand') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('<?php echo trans('messages.success_lang',[],session('locale')); ?>','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        $('#add_brand_modal').modal('hide');
                        $('#all_brand').DataTable().ajax.reload();
                        return false;
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_brand').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>','<?php echo trans('messages.add_brand_name_lang',[],session('locale')); ?>'); return false;

                }

                $('#global-loader').show();
                before_submit();
                var str = $(".add_brand").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_brand') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_brand').DataTable().ajax.reload();
                        show_notification('<?php echo trans('messages.success_lang',[],session('locale')); ?>','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_brand_modal').modal('hide');
                        $(".add_brand")[0].reset();
                        return false;
                        },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_brand').DataTable().ajax.reload();
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
            url : "{{ url('edit_brand') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){
                    // Define a variable for the image path
                    var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';

                    // Check if the brand_image is present and not an empty string
                    if (fetch.brand_image && fetch.brand_image !== "") {
                        imagePath = '{{ asset('images/brand_images/') }}/' + fetch.brand_image;
                    }
                    $('#img_tag').attr('src',imagePath);
                    $(".brand_name").val(fetch.brand_name);
                    $(".brand_id").val(fetch.brand_id);
                    $(".modal-title").html('<?php echo trans('messages.update_lang',[],session('locale')); ?>');
                }
            },
            error: function(html)
            {
                $('#global-loader').hide();
                after_submit();
                show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>','<?php echo trans('messages.edit_failed_lang',[],session('locale')); ?>');
                console.log(html);
                return false;
            }
        });
    }


    function del(id) {
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
                    url: "{{ url('delete_brand') }}",
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('<?php echo trans('messages.error_lang',[],session('locale')); ?>', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_brand').DataTable().ajax.reload();
                        show_notification('<?php echo trans('messages.success_lang',[],session('locale')); ?>', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('<?php echo trans('messages.success_lang',[],session('locale')); ?>', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }



    </script>
