<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#repairing_table').DataTable({
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
            "createdRow": function(row, data, dataIndex) {
                // Apply d-none class to the specified columns
                $(row).find('td:eq(8), td:eq(9)').css('display', 'none');
            }
        });
        //adding customer

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
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
                            url: "{{ url('add_customer_repair') }}",
                            data: formdatas,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)

                                if (data.status == 1) {
                                    show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                                    $('#add_customer_modal').modal('hide');
                                    $(".add_customer_form")[0].reset();
                                    $('.customer_input').val(data.customer_id);
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

$(document).ready(function() {
    $(".add_customer").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ url('customer_auto_repair') }}",
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    term: request.term
                },
                success: function(data) {

                    var filteredData = data.slice(0, 10);
                    response(filteredData);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching autocomplete data:", error);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {

            $(this).val(ui.item.label);
            return false;
        }
    });
});


//Warranty_no Auto Complete

$(document).ready(function() {
    $("#warranty_no").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: "{{ url('warranty_auto') }}",
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    term: request.term
                },
                success: function(data) {

                    if (Array.isArray(data) && data.length > 0) {
                        response(data);
                    } else {

                       console.log(nothing)
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message if request fails
                    console.log(nothing)
                }
            });
        },
        minLength: 1, // Minimum length before triggering autocomplete
        select: function(event, ui) {
            // Set the selected value in the input field
            $(this).val(ui.item.label);
            return false;
        }
    });


});



//repairing products
$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
$('.add_customer').on('keypress', function(event) {
if (event.which === 13) {
    var customer_id = parseInt($(this).val().split(':')[0].trim());


            $.ajax({
                url: "{{ url('repairing_products') }}",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    customer_id: customer_id,
                    search_type: 1,
                },
                success: function(response) {

                    if (response.status == 2) {
                        $('.repairing_data').empty();

                        show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                    }
                    else{

                    show_notification('success','<?php echo trans('messages.record_found_lang',[],session('locale')); ?>');
                    $('.repairing_data').empty();
                    $.each(response.aaData, function(index, product) {
                        var row = '<tr>';
                        $.each(product, function(idx, value) {
                            row += '<td>' + value + '</td>';
                        });
                        row += '</tr>';
                        $('.repairing_data').append(row);
                    });

            }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }

    });

    $('#warranty_no').on('keypress', function(event) {
if (event.which === 13) {
    var inputValues = $(this).val().split('-');
    var order_no =inputValues[0];
    var barcode = inputValues[1].trim();
    var imei = "";

    if (inputValues.length > 2) {
        imei = inputValues[2].trim();
    }


            $.ajax({
                url: "{{ url('repairing_products') }}",
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    order_no: order_no,
                    barcode: barcode,
                    imei: imei,
                    search_type: 2,
                },
                success: function(response) {

                    if (response.status == 2) {
                        $('.repairing_data').empty();

                        show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                    }
                    else{



                    show_notification('success','<?php echo trans('messages.record_found_lang',[],session('locale')); ?>');
                    $('.repairing_data').empty();
                    $.each(response.aaData, function(index, product) {
                        var row = '<tr>';
                        $.each(product, function(idx, value) {
                            row += '<td>' + value + '</td>';
                        });
                        row += '</tr>';
                        $('.repairing_data').append(row);
                    });
                }

            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }

    });

});


//repairing table
$('.repairing_data').on('click', 'tr', function() {
    var product = $(this).find('td:eq(0)').text();
    var imei = $(this).find('td:eq(1)').text();
    var barcode = $(this).find('td:eq(2)').text();
    console.log('item_price:', barcode);
    var purchase_price = $(this).find('td:eq(3)').text();
    var order_no = $(this).find('td:eq(7)').text();
    var item_price = parseInt(purchase_price.match(/\d+/));

    if (!isNaN(item_price)) {
        console.log('item_price:', item_price);
    } else {
        console.error('No integer part found in price:', item_price);
    }

    var warranty = $(this).find('td:eq(5)').text();
    var validity = $(this).find('td:eq(8)').text();
    var id = $(this).find('td:eq(9)').text();

    if($('#repairing_product').children().length>0)
    {
        show_notification('error', '<?php echo trans('messages.data_already_present_lang',[],session('locale')); ?>');
        return false;
    }
    else
    {
        if ($('#repairing_product').find('.repairing_' + id).length >= 1) {
            show_notification('error', '<?php echo trans('messages.data_already_present_lang',[],session('locale')); ?>');
        } else {
            var orderHtml = `
            <tr class="repairing_${id}">
                <th class="d-none"><input type="hidden" class="get_warranty_id" value="${id}">
                    <input type="hidden" class="get_order_no" value="${order_no}"></th>
                <th scope="row">${barcode}</th>
                <td>${imei}</td>
                <td>${product}</td>
                <td><span class="badge bg-soft-success"><i class="ri-check-fill align-middle me-1"></i>${warranty}</span></td>
                <td>${validity}</td>
            </tr>
            `;

            $('#repairing_product').append(orderHtml);
        }
    }
});



                $('#clear_list').click(function() {
                    $('#repairing_product').empty();
                    show_notification('success','<?php echo trans('messages.item_deleted_lang',[],session('locale')); ?>');

                });


function send_to_repair() {
    if ($("#repairing_product").children().length === 0) {
        $('#repair_modal').modal('hide');
        show_notification('error', '<?php echo trans('messages.validation_select_warranty_product_lang',[],session('locale')); ?>');
    } else {
        $('.repair_order_no').val($('.get_order_no').val());
        $('.repair_warranty_id').val($('.get_warranty_id').val());
        $('#repair_modal').modal('show');
    }
}

// send for repairing
$('.add_repair_maintenance').off().on('submit', function(e){
    e.preventDefault();
    var formdatas = new FormData($('.add_repair_maintenance')[0]);
    var customer_id = $('.add_customer').val();
    formdatas.append('customer_id', customer_id);

    $('#global-loader').show();
    before_submit();
     $.ajax({
        type: "POST",
        url: "{{ url('add_repair_maintenance') }}",
        data: formdatas,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        success: function(data) {
            $('#global-loader').hide();
            after_submit();
            $('#repairing_product').empty();
            $('.repairing_data').empty();
            $('.warranty_no').val('');
            $('.add_customer').val('');
            show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
            $('#repair_modal').modal('hide');
            $('.add_repair_maintenance')[0].reset();
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
$('#all_maintenance').DataTable({
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
        "url": "{{ url('show_maintenance') }}",
        "type": "POST",
        "headers": {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token here
        },
        "data": function (d) {
            d.status = $('#status').val();  // Change "your_status_value" to the actual status value you want to pass
        }
    }
});
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
        url: "<?php echo url('add_maintenance_service'); ?>",
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
                url: "{{ url('delete_maintenance_service') }}",
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
        url: "<?php echo url('add_maintenance_product'); ?>",
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
                    url: "{{ url('delete_maintenance_product') }}",
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
<?php if(isset($repair_detail->reference_no)){ ?>
    var reference_no =  $('.reference_no').val();
    get_maintenance_data(reference_no)
<?php }  ?>

function  get_maintenance_data(reference_no)
{

    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "<?php echo url('get_maintenance_data'); ?>",
        method: "POST",
        data: {
            reference_no:reference_no,
            _token: csrfToken
        },
        success: function(data) {
            $('#global-loader').hide();
            $('#service_tbody').html(data.service_data);
            $('#product_tbody').html(data.product_data);
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
                    url: "{{ url('change_maintenance_status') }}",
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
                            window.location.href = "{{ url('/repair_data/') }}";

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
                    url: "{{ url('change_repair_type') }}",
                    type: 'POST',
                    data: {type: type,reference_no: reference_no,_token: csrfToken},
                    error: function () {
                        $('#global-loader').hide();
                        show_notification('error', '<?php echo trans('messages.data_update_failed_lang',[],session('locale')); ?>');
                    },
                    success: function (data) {
                        $('#global-loader').hide();
                        show_notification('success', '<?php echo trans('messages.data_update_success_lang',[],session('locale')); ?>');
                        if(type == 2)
                        {
                            window.location.href = "{{ url('/repair_data/') }}";

                        }
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
        url: "{{ url('add_maintenance_technician') }}",
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

function get_rand_barcode(i) {
        var randomNumber = Math.floor(100000 + Math.random() * 900000);
        $('.barcode_' + i).val(randomNumber);
    }
</script>
