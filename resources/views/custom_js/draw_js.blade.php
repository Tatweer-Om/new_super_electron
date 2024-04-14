<script type="text/javascript">
    $(document).ready(function() {
        $('#add_draw_modal').on('hidden.bs.modal', function() {
            $(".add_draw")[0].reset();
            $('.draw_id').val('');
        });
        $('#all_draw').DataTable({
            "sAjaxSource": "{{ url('show_draw') }}",
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

        $('.add_draw').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_draw')[0]);
            var title=$('.draw_name').val();
            var date=$('.draw_date').val();
            var id=$('.draw_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_draw_name_lang',[],session('locale')); ?>'); return false;
                }
                if(date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_draw_date_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_draw").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_draw') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        $('#add_draw_modal').modal('hide');
                        $('#all_draw').DataTable().ajax.reload();
                        return false;
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_draw').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_draw_name_lang',[],session('locale')); ?>'); return false;

                }
                if(date=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_draw_date_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_draw").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_draw') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_draw').DataTable().ajax.reload();
                        show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_draw_modal').modal('hide');
                        $(".add_draw")[0].reset();
                        return false;
                        },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_draw').DataTable().ajax.reload();
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
            url : "{{ url('edit_draw') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){

                    $(".draw_name").val(fetch.draw_name);
                    $(".draw_detail").val(fetch.draw_detail);
                    $(".draw_date").val(fetch.draw_date);
                    $(".draw_starts").val(fetch.draw_starts);
                    $(".draw_ends").val(fetch.draw_ends);
                    $(".draw_id").val(fetch.draw_id);
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
                    url: "{{ url('delete_draw') }}",
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
                        $('#all_draw').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
            }
        });
    }



    </script>