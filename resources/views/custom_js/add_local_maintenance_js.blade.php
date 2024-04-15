<script>
    $(document).ready(function() {
        $(".category_id").select2({
            dropdownParent: $("#add_local_maintenance_modal")
        }); 
        $(".brand_id").select2({
            dropdownParent: $("#add_local_maintenance_modal")
        })
        $(".maintenance_customer_id").select2({
            dropdownParent: $("#add_local_maintenance_modal")
        });
        $(".review_by").select2({
            dropdownParent: $("#add_local_maintenance_modal")
        });
        document.getElementById('customer_modal_btn').addEventListener('click', function() {
            $('#add_customer_modal').modal('show'); // Show Modal 2
            $('#add_customer_modal').appendTo('body'); // Append Modal 2 to body
        });
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        

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

    function get_rand_barcode(i) {
        var randomNumber = Math.floor(100000 + Math.random() * 900000);
        $('.barcode_' + i).val(randomNumber);
    }
        // get ministry
$('.ministry_id').change(function() {
    var ministry_id = $(this).val(); 
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ url('get_workplaces') }}",
        type: 'POST',
        data: {ministry_id: ministry_id,_token: csrfToken},
        error: function () {
            $('#global-loader').hide(); 
         },
        success: function (data) {
            $('#global-loader').hide();
            $('.employee_workplace').html(data.workplace_data);            
        }
    });
});
        //adding customer 
                $('#add_customer_modal').on('hidden.bs.modal', function() {
                    $(".add_customer")[0].reset();
                    $('.customer_id').val('');
                    $('.customer_image').val('');
                    var imagePath = '{{ asset('images/dummy_image/no_image.png') }}';
                    $('#img_tag').attr('src', imagePath)

                });
                $('.add_customer_form').off().on('submit', function(e) {
                    e.preventDefault();
                    var formdatas = new FormData($(this)[0]);
                    var title = $('.customer_name').val();
                    var phone = $('.customer_phone').val();
                    var national_id = $('.national_id').val();
                    var customer_number = $('.customer_number').val();
                    var id = $('.customer_id').val();

                    if (id == '') {
                        if (title == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                            return false;

                        }
                        if (phone == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                            return false;
                        }
                        if (national_id == "") {
                            show_notification('error', '<?php echo trans('messages.add_national_id_lang', [], session('locale')); ?>');
                            return false;
                        }
                        if (customer_number == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_number_lang', [], session('locale')); ?>');
                            return false;
                        }
                        // var str = $(".add_customer").serialize();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('add_maintenance_customer') }}",
                            data: formdatas,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)

                                if (data.status == 1) {
                                    show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                                    $('#add_customer_modal').modal('hide');
                                    $(".add_customer_form")[0].reset();
                                    $('.maintenance_customer_id').html(data.customer_id);
                                    return false;
                                } else if (data.status == 2) {
                                    show_notification('error', '<?php echo trans('messages.national_id_exist_lang', [], session('locale')); ?>');
                                }
                            },
                            error: function(data) {
                                show_notification('error', '<?php echo trans('messages.data_add_failed_lang', [], session('locale')); ?>');
                                console.log(data);
                                return false;
                            }
                        });

                    }

                });
            });
                // check customer type
                function check_customer() {
                    var customer_type = $(".customer_type:checked").val();

                    if (customer_type == 1) {
                        $(".student_detail").show();
                        $(".teacher_detail").hide();
                        $(".employee_detail").hide();
                    } else if (customer_type == 2) {
                        $(".student_detail").hide();
                        $(".teacher_detail").show();
                        $(".employee_detail").hide();

                    } else if (customer_type == 3) {
                        $(".student_detail").hide();
                        $(".teacher_detail").hide();
                        $(".employee_detail").show();

                    } else if (customer_type == 4) {
                        $(".student_detail").hide();
                        $(".teacher_detail").hide();
                        $(".employee_detail").hide();

                    }
                }
                check_customer();


//customer_autocomplete
 


 



// send for repairing
$('.add_local_maintenance').off().on('submit', function(e){
    e.preventDefault();
    var formdatas = new FormData($('.add_local_maintenance')[0]);
     
    var repairing_type = $('.repairing_type').val();
    var technician_id = $('.technician_id').val();
    if(repairing_type=="")
    {
        show_notification('error','<?php echo trans('messages.select_repairing_type_lang',[],session('locale')); ?>');
        return false;
    }
    
    if(technician_id=="")
    {
        show_notification('error','<?php echo trans('messages.select_technician_lang',[],session('locale')); ?>');
        return false;
    }
     

    $('#global-loader').show();
    before_submit();
     $.ajax({
        type: "POST",
        url: "{{ url('add_local_maintenance') }}",
        data: formdatas,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        success: function(data) {
            $('#global-loader').hide();
            after_submit(); 
            if(data.status == 2)
            {
                show_notification('error','<?php echo trans('messages.warranty_reference_no_exist_lang',[],session('locale')); ?>');
                return false;
            }
            if(data.status == 3)
            {
                show_notification('error','<?php echo trans('messages.warranty_days_finished_lang',[],session('locale')); ?>');
                return false;
            }
            show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
            $('#add_local_maintenance_modal').modal('hide');
            $('#all_show_maintenance').DataTable().ajax.reload();
            $('.add_local_maintenance')[0].reset();
             window.location.href = "{{ url('/local_maintenance_profile/') }}"+"/"+ data.id;
            return false;
        },
        error: function(data)
        {
            $('#global-loader').hide();
            after_submit();
            show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
            $('#all_brand').DataTable().ajax.reload();
            console.log(data);
            return false;
        }
    });

});


// maintenace table
$('#all_show_maintenance').DataTable({
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
        "url": "{{ url('show_local_maintenance') }}",
        "type": "POST",
        "headers": {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token here
        },
        "data": function (d) {
            d.status = $('#status').val();  // Change "your_status_value" to the actual status value you want to pass
        }
    }
});

// check reparit type
$('.repairing_type').change(function() {
    $('.inspection_cost').val('');
    $('.warranty_reference_no').val('');
    $('.warranty_day').val('');
    if($(this).val()==2)
    {
        $('.inspection_cost_div').show();
        $('.warranty_reference_no_div').hide();
        $('.warranty_day_div').hide();
        $('.product_detail_div').show();
        
    }
    else if($(this).val()==1)
    {
        $('.inspection_cost_div').hide();
        $('.warranty_reference_no_div').hide();
        $('.warranty_day_div').show();
        $('.product_detail_div').show();
    }
    else  
    {
        $('.inspection_cost_div').hide();
        $('.warranty_reference_no_div').show();
        $('.warranty_day_div').hide();
        $('.product_detail_div').hide();
        $('.product_name').val('');
        $('.category_id').val('');
        $('.brand_id').val('');
        $('.imei_no').val('');
    }
});

// 
$('.status').change(function() {
    // Get the DataTable instance
    var dataTable = $('#all_maintenance').DataTable();
    // Redraw the DataTable
    dataTable.ajax.reload();
});

// add service direct
$('.add_service').off().on('submit', function(e){
    e.preventDefault();
    var formdatas = new FormData($('.add_service')[0]);
    var title=$('.service_name').val();
    var cost=$('.service_cost').val();

    if(title=="" )
    {
        show_notification('error','<?php echo trans('messages.add_service_name_lang',[],session('locale')); ?>'); return false;

    }
    if(cost=="" )
    {
        show_notification('error','<?php echo trans('messages.add_service_cost_lang',[],session('locale')); ?>'); return false;
    }
    $('#global-loader').show();
    before_submit();
    var str = $(".add_service").serialize();
    $.ajax({
        type: "POST",
        url: "{{ url('add_service_maintenance') }}",
        data: formdatas,
        contentType: false,
        processData: false,
        success: function(data) {
            $('#global-loader').hide();
            after_submit();
            $('#all_service').DataTable().ajax.reload();
            show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
            $('#add_service_modal').modal('hide');
            $(".add_service")[0].reset();
            $('.service_id').html(data.options);
            $('.service_id').trigger('change');
            return false;
        },
        error: function(data)
        {
            $('#global-loader').hide();
            after_submit();
            show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
            $('#all_service').DataTable().ajax.reload();
            console.log(data);
            return false;
        }
    });

});

// select service
$('.service_id').on('change', function(event) {
    var service_id = $('.service_id').val();
    var reference_no = $('.reference_no').val();
    if(service_id=="")
    {
        show_notification('error','<?php echo trans('messages.validation_select_service_lang',[],session('locale')); ?>');
        return false;
    }
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('add_local_maintenance_service'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            service_id:service_id,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            show_notification('success',  '<?php echo trans('messages.data.data_add_success_lang',[],session('locale')); ?>');
            get_maintenance_data(reference_no);
        },
        error: function(data) {
            $('#global-loader').hide();
            show_notification('error',  '<?php echo trans('messages.get_data_failed',[],session('locale')); ?>');
            console.log(data);
            return false;
        }
    });
});

function del_service(id) {
   
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

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ url('delete_local_maintenance_service') }}",
                type: 'POST',
                data: {id: id,_token: csrfToken},
                error: function () {
                    $('#global-loader').hide();
                    show_notification('error', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                    get_maintenance_data(reference_no);
                },
                success: function (data) {
                    $('#global-loader').hide();
                    show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                    get_maintenance_data(reference_no);
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
        }
    });
}



// select product
$('.product_id').change(function() {
    var product_id = $('.product_id').val();
    var reference_no = $('.reference_no').val();
    if(product_id=="")
    {
        show_notification('error','<?php echo trans('messages.validation_select_product_lang',[],session('locale')); ?>');
        return false;
    }
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('add_local_maintenance_product'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            product_id:product_id,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            if(data.status==2)
            {
                show_notification('error',  '<?php echo trans('messages.validation_quantity_less_lang',[],session('locale')); ?>');
                return false;
            }
            else
            {
                show_notification('success',  '<?php echo trans('messages.data.data_add_success_lang',[],session('locale')); ?>');

            }
            get_maintenance_data(reference_no);
        },
        error: function(data) {
            $('#global-loader').hide();
            show_notification('error',  '<?php echo trans('messages.get_data_failed',[],session('locale')); ?>');
            console.log(data);
            return false;
        }
    });
});

    function del_product(id) {

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
                    url: "{{ url('delete_local_maintenance_product') }}",
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                        get_maintenance_data(reference_no);
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                        get_maintenance_data(reference_no);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
            }
        });
    }

// select issuetype
$('.issuetype_id').change(function() {
    var issuetype_id = $('.issuetype_id').val();
    var reference_no = $('.reference_no').val();
    if(issuetype_id=="")
    {
        show_notification('error','<?php echo trans('messages.validation_select_issuetype_lang',[],session('locale')); ?>');
        return false;
    }
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('add_local_maintenance_issuetype'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            issuetype_id:issuetype_id,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            show_notification('success',  '<?php echo trans('messages.data.data_add_success_lang',[],session('locale')); ?>');

            get_maintenance_data(reference_no);
        },
        error: function(data) {
            $('#global-loader').hide();
            show_notification('error',  '<?php echo trans('messages.get_data_failed',[],session('locale')); ?>');
            console.log(data);
            return false;
        }
    });
});

    function del_issuetype(id) {

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
                    url: "{{ url('delete_local_maintenance_issuetype') }}",
                    type: 'POST',
                    data: {id: id,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.delete_failed_lang',[],session('locale')); ?>');
                        get_maintenance_data(reference_no);
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        show_notification('success', '<?php echo trans('messages.delete_success_lang',[],session('locale')); ?>');
                        get_maintenance_data(reference_no);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
            }
        });
    }

// get main tenance_data
var path = window.location.pathname;
var parts = path.split('/');
var componentName = parts[1];
<?php 
    
    if(isset($repair_detail->reference_no)){ ?>
        if(componentName=='local_maintenance_profile')
        {
            var reference_no =  $('.reference_no').val();
            get_maintenance_data(reference_no)
        }
        
<?php }  ?>

function  get_maintenance_data(reference_no)
{

    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('get_local_maintenance_data'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            $('#service_tbody').html(data.service_data);
            $('#product_tbody').html(data.product_data);
            if($('.repairing_type').val()==2)
            {
                $('#issuetype_div').show();
                $('#issuetype_tbody').html(data.issuetype_data);
            }
            else
            {
                if(data.issuetype_data!="")
                {
                    $('#issuetype_tbody').html(data.issuetype_data);
                    $('#issuetype_div').show();
                }
                else
                {
                    $('#issuetype_tbody').html(data.issuetype_data);
                    $('#issuetype_div').hide();
                }
            } 
            
            $('#total_service').text(data.total_service);
            $('#total_product').text(data.total_product);
        },
        error: function(data) {
            $('#global-loader').hide();
            show_notification('error',  '<?php echo trans('messages.get_data_failed',[],session('locale')); ?>');
            console.log(data);
            return false;
        }
    });
}

// change status of maintenance
$('#change_status').change(function() {
    var status = $(this).val();
    var reference_no = $('.reference_no').val();
    Swal.fire({
            title:  '<?php echo trans('messages.sure_lang',[],session('locale')); ?>',
            text:  '<?php echo trans('messages.wanna_change_status_lang',[],session('locale')); ?>',
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: '<?php echo trans('messages.yes_lang',[],session('locale')); ?>',
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then(function (result) {
            if (result.value) {
                $('#global-loader').show();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('change_local_maintenance_status') }}",
                    type: 'POST',
                    data: {status: status,reference_no: reference_no,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        show_notification('success', '<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        if(status == 5)
                        {
                            window.location.href = "{{ url('/localmaintenance/') }}";

                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
            }
        });
});

// change status of maintenance
$('#repairing_type').change(function() {
    var type = $(this).val();
    var reference_no = $('.reference_no').val();
    Swal.fire({
            title:  '<?php echo trans('messages.sure_lang',[],session('locale')); ?>',
            text:  '<?php echo trans('messages.wanna_change_repair_type_lang',[],session('locale')); ?>',
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: '<?php echo trans('messages.yes_lang',[],session('locale')); ?>',
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: !1
        }).then(function (result) {
            if (result.value) {
                $('#global-loader').show();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ url('change_local_repair_type') }}",
                    type: 'POST',
                    data: {type: type,reference_no: reference_no,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        show_notification('success', '<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        location.reload();
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // show_notification('success',  '<?php echo trans('messages.safe_lang',[],session('locale')); ?>' );
            }
        });
});

// change status of maintenance
$('.technician_id').change(function() {
    var technician_id = $(this).val();
    var reference_no = $('.reference_no').val();
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ url('add_local_maintenance_technician') }}",
        type: 'POST',
        data: {technician_id: technician_id,reference_no: reference_no,_token: csrfToken},
        error: function () {
            $('#global-loader').hide();
            show_notification('error', '<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
        },
        success: function (data) {
            $('#global-loader').hide();
            show_notification('success', '<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
            get_maintenance_data();
        }
    });
});

 

// deliver date
$(document).on('click', '#change_deliver_date', function() {
    var deliver_date = $('#deliver_date').val();
    var warranty_day = $('.warranty_day').val();
    var reference_no = $('.reference_no').val();
    if(deliver_date=="")
    {
        show_notification('error','<?php echo trans('messages.validation_select_deliver_date_lang',[],session('locale')); ?>');
        return false;
    }
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('change_local_deliver_date'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            deliver_date:deliver_date,
            warranty_day:warranty_day,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            show_notification('success',  '<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
            get_maintenance_data(reference_no);
        },
        error: function(data) {
            $('#global-loader').hide(); 
            show_notification('error',  '<?php echo trans('messages.get_data_failed',[],session('locale')); ?>');
            console.log(data);
            return false;
        }
    });
});
 
function get_rand_barcode(i) {
    var randomNumber = Math.floor(100000 + Math.random() * 900000);
    $('.barcode_' + i).val(randomNumber);
}

$(".technician_id").select2({
    dropdownParent: $("#repair_modal")
}); 
 
</script>
