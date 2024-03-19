<script>
    $(document).ready(function() {


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
                    var id = $('.customer_id').val();

                    if (id != '') {
                        if (title == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                            return false;
                        }
                        if (phone == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                            return false;
                        }

                    } else if (id == '') {


                        if (title == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_name_lang', [], session('locale')); ?>');
                            return false;

                        }
                        if (phone == "") {
                            show_notification('error', '<?php echo trans('messages.add_customer_phone_lang', [], session('locale')); ?>');
                            return false;
                        }

                        // var str = $(".add_customer").serialize();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('add_customer') }}",
                            data: formdatas,
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                console.log(data)

                                if (data.status == 1) {
                                    show_notification('success', '<?php echo trans('messages.data_add_success_lang', [], session('locale')); ?>');
                                    $('#add_customer_modal').modal('hide');
                                    $(".add_customer")[0].reset();
                                    $('.customer_input').val(data.customer_name);
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
                url: "{{ url('customer_auto') }}",
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
                    customer_id: customer_id
                },
                success: function(response) {

                    if (response.status === 1) {
                        $('.repairing_data').empty();

                        show_notification('error','<?php echo trans('messages.no_record_found_lang',[],session('locale')); ?>');
                    }
                    else{

                if (response.success) {

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
    var item_price = parseInt(purchase_price.match(/\d+/));

    if (!isNaN(item_price)) {
        console.log('item_price:', item_price);
    } else {
        console.error('No integer part found in price:', item_price);
    }

    var warranty = $(this).find('td:eq(5)').text();
    var validity = $(this).find('td:eq(8)').text();
    var id = $(this).find('td:eq(9)').text();

    if ($('#repairing_product').find('.repairing_' + id).length >= 1) {
        show_notification('error', '<?php echo trans('messages.data_already_present_lang',[],session('locale')); ?>');
    } else {
        var orderHtml = `
        <tr class="repairing_${id}">
            <th scope="row">${barcode}</th>
            <td>${imei}</td>
            <td>${product}</td>
            <td><span class="badge bg-soft-success"><i class="ri-check-fill align-middle me-1"></i>${warranty}</span></td>
            <td>${validity}</td>
        </tr>
        `;

        $('#repairing_product').append(orderHtml);
    }
});



                $('#clear_list').click(function() {
                    $('#repairing_product').empty();
                    show_notification('success','<?php echo trans('messages.item_deleted_lang',[],session('locale')); ?>');

                });




</script>
