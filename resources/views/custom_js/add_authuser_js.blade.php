<script type="text/javascript">
    $(document).ready(function() {
        $('#add_authuser_modal').on('hidden.bs.modal', function() {
            $(".add_authuser")[0].reset();
            $('.authuser_id').val('');
            $('.authuser_image').val('');
            var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
            $('#img_tag').attr('src',imagePath)
        });
        $('#all_authuser').DataTable({
            "sAjaxSource": "{{ url('show_authuser') }}",
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

        $('.add_authuser').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_authuser')[0]);
            var title=$('.authuser_username').val();
            var password=$('.authuser_password').val();
            var id=$('.authuser_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_authuser_name_lang',[],session('locale')); ?>'); return false;
                }
                if(password=="" )
                {
                    show_notification('error','<?php echo trans('messages.provide_password_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_authuser").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_authuser') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        $('#add_authuser_modal').modal('hide');
                        $('#all_authuser').DataTable().ajax.reload();
                        return false;
                    },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_authuser').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_user_name_lang',[],session('locale')); ?>'); return false;

                }
                if(password=="" )
                {
                    show_notification('error','<?php echo trans('messages.provide_password_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_authuser").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_authuser') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        $('#all_authuser').DataTable().ajax.reload();
                        show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                        $('#add_authuser_modal').modal('hide');
                        $(".add_authuser")[0].reset();
                        return false;
                        },
                    error: function(data)
                    {
                        $('#global-loader').hide();
                        after_submit();
                        show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                        $('#all_authuser').DataTable().ajax.reload();

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
            url : "{{ url('edit_authuser') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){
                    // Define a variable for the image path
                    var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';

                    // Check if the authuser_image is present and not an empty string
                    if (fetch.authuser_image && fetch.authuser_image !== "") {
                        imagePath = '{{ asset('images/authuser_images/') }}/' + fetch.authuser_image;
                    }
                    $('#img_tag').attr('src',imagePath)
                    $(".authuser_name").val(fetch.authuser_name);
                    $(".authuser_username").val(fetch.username);
                    $(".authuser_password").val(fetch.password);
                    $(".authuser_phone").val(fetch.authuser_phone);
                    $(".authuser_detail").val(fetch.authuser_detail);
                    $(".authuser_id").val(fetch.authuser_id);
                    $(".permit_type").val(fetch.permit_type);
                    $(".store").val(fetch.store_id);
                    $('#checked_html').html(fetch.checked_html);

                    $(".modal-title").html('<?php echo trans('messages.update_lang',[],session('locale')); ?>');
                }
            },
            error: function(html)
            {
                $('#global-loader').hide();
                after_submit();
                show_notification('error','<?php echo trans('messages.edit_failed_lang',[],session('locale')); ?>');

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
                    url: "{{ url('delete_authuser') }}",
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
                        $('#all_authuser').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }


        $(document).ready(function () {
            $('#permission_all').change(function () {
                $('.permit_type').prop('checked', $(this).prop('checked'));
            });

            $('.permit_type').change(function () {
                if (!$(this).prop('checked')) {
                    $('#permission_all').prop('checked', false);
                }
            });
        });



    //loginform






    </script>
