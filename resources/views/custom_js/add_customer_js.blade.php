<script type="text/javascript">
    $(document).ready(function() {
        $('#add_customer_modal').on('hidden.bs.modal', function() {
            $(".add_customer")[0].reset();
            $('.customer_id').val('');
            $('.customer_image').val('');
            var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
            $('#img_tag').attr('src',imagePath)

        });
        $('#all_customer').DataTable({
            "sAjaxSource": "{{ url('show_customer') }}",
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

        $('.add_customer').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('.add_customer')[0]);
            var title=$('.customer_name').val();
            var phone=$('.customer_phone').val();
            var id=$('.customer_id').val();

            if(id!='')
            {
                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_customer_name_lang',[],session('locale')); ?>'); return false;
                }
                if(phone=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_customer_phone_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_customer").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('update_customer') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        if(data.status==1)
                        {
                            show_notification('success','<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                            $('#add_customer_modal').modal('hide');
                            $('#all_customer').DataTable().ajax.reload();
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
                        show_notification('error','<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                        $('#all_customer').DataTable().ajax.reload();
                        console.log(data);
                        return false;
                    }
                });
            }
            else if(id==''){


                if(title=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_customer_name_lang',[],session('locale')); ?>'); return false;

                }
                if(phone=="" )
                {
                    show_notification('error','<?php echo trans('messages.add_customer_phone_lang',[],session('locale')); ?>'); return false;
                }
                $('#global-loader').show();
                before_submit();
                var str = $(".add_customer").serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('add_customer') }}",
                    data: formdatas,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#global-loader').hide();
                        after_submit();
                        if(data.status==1)
                        {
                            $('#all_customer').DataTable().ajax.reload();
                            show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                            $('#add_customer_modal').modal('hide');
                            $(".add_customer")[0].reset();
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
                        $('#all_customer').DataTable().ajax.reload();
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
            url : "{{ url('edit_customer') }}",
            method : "POST",
            data :   {id:id,_token: csrfToken},
            success: function(fetch) {
                $('#global-loader').hide();
                after_submit();
                if(fetch!=""){
                    // Define a variable for the image path
                    var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';

                    // Check if the customer_image is present and not an empty string
                    if (fetch.customer_image && fetch.customer_image !== "") {
                        imagePath = '{{ asset('images/customer_images/') }}/' + fetch.customer_image;
                    }
                    $(".customer_id").val(fetch.customer_id);
                    $(".customer_name").val(fetch.customer_name);
                    $(".customer_phone").val(fetch.customer_phone);
                    $(".customer_email").val(fetch.customer_email);
                    $(".national_id").val(fetch.national_id);
                    $(".customer_detail").val(fetch.customer_detail);
                    $(".customer_type").val(fetch.customer_type);
                    $('.employee_detail').hide();
                    $('.student_detail').hide();
                    $('.teacher_detail').hide();
                    if (fetch.customer_type == 1) {

                        $(".student_id").val(fetch.student_id);
                        $(".student_university").val(fetch.student_university).trigger('change');
                        $('#img_tag').prop('src', imagePath);
                        $("#customer_type_student").prop("checked", true);
                        $('.student_detail').show();
                    }
                    else if (fetch.customer_type == 3)
                    {
                        $(".employee_id").val(fetch.employee_id);
                        $(".employee_workplace").val(fetch.employee_workplace).trigger('change');
                        $("#customer_type_employee").prop("checked", true);
                        $('.employee_detail').show();

                    } else if (fetch.customer_type == 2)
                    {
                        $(".teacher_university").val(fetch.teacher_university).trigger('change');
                        $("#customer_type_teacher").prop("checked", true);
                        $('.teacher_detail').show();
                    }

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
                    url: "{{ url('delete_customer') }}",
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
                        $('#all_customer').DataTable().ajax.reload();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success', '<?php echo trans('messages.safe_lang',[],session('locale')); ?>');
            }
        });
    }
        // check customer type
        function check_customer()
        {
        var customer_type = $(".customer_type:checked").val();

        if (customer_type == 1)
        {
            $(".student_detail").show();
            $(".teacher_detail").hide();
            $(".employee_detail").hide();
        }
        else if (customer_type == 2)
        {
            $(".student_detail").hide();
            $(".teacher_detail").show();
            $(".employee_detail").hide();

        }
        else if (customer_type == 3)
        {
            $(".student_detail").hide();
            $(".teacher_detail").hide();
            $(".employee_detail").show();

        }
        else if (customer_type == 4)
        {
            $(".student_detail").hide();
            $(".teacher_detail").hide();
            $(".employee_detail").hide();

        }
    }



    </script>
