<script type="text/javascript">
    $(document).ready(function() {
        $(".student_university").select2({
            dropdownParent: $("#add_offer_modal")
        });
        $(".ministry_id").select2({
            dropdownParent: $("#add_offer_modal")
        })
        $(".employee_workplace").select2({
            dropdownParent: $("#add_offer_modal")
        });
        $(".nationality_id").select2({
            dropdownParent: $("#add_offer_modal")
        });
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
            // Collect the university_id value separately
            var universityIds = [];
            $('.student_university option:selected').each(function() {
                universityIds.push($(this).val());
            });

            // Append university_id to form data
            formdatas.append('university_id', universityIds);

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
                            // location.reload();
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
                            // location.reload();
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


    function edit(id) {
    $('#global-loader').show();
    before_submit();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax ({
        dataType: 'JSON',
        url: "{{ url('edit_offer') }}",
        method: "POST",
        data: { id: id, _token: csrfToken },
        success: function(fetch) {
            $('#global-loader').hide();
            after_submit();
            if (fetch != "") {
                $(".offer_id").val(fetch.offer_id);
                $(".offer_name").val(fetch.offer_name);
                $(".offer_discount_type").val(fetch.offer_discount_type);
                $(".offer_discount").val(fetch.offer_discount);
                $(".offer_start").val(fetch.offer_start_date);
                $(".offer_end").val(fetch.offer_end_date);
                $(".offer_detail").val(fetch.offer_detail);
                $('.male').prop('checked', false);
                if (fetch.male == 1) {
                    $('.male').prop('checked', true);
                }
                $('.female').prop('checked', false);
                if (fetch.female == 1) {
                    $('.female').prop('checked', true);
                }
                $('.employee_detail').hide();
                $('.student_detail').hide();
                $('.offer_type').prop('checked', false);
                if (fetch.offer_type == 1) {
                    $('.offer_type').prop('checked', true);
                }
                $('.offer_type_student').prop('checked', false);
                if (fetch.offer_type_student == 1) {
                    $('.offer_type_student').prop('checked', true);
                    $('.student_detail').show();
                    $(".student_university").html(fetch.options_uni);
                }
                $('.offer_type_employee').prop('checked', false);
                if (fetch.offer_type_employee == 1) {
                    $('.offer_type_employee').prop('checked', true);
                    $('.employee_detail').show();
                    $(".ministry_id").html(fetch.options_min);
                    $(".employee_workplace").html(fetch.options_work);
                }
                $(".offer_product").val("");
                $(".offer_brand").val("");
                $(".offer_category").val("");
                $('input[name="option"]').prop('checked', false);
                $(".offer_apply").val(fetch.offer_apply);

                // Hide the elements here
                $('#category_input').css('display', 'none');
                $('#product_input').css('display', 'none');
                $('#brand_input').css('display', 'none');

                if (fetch.pro_type == 1) {
                    $(".offer_product").html(fetch.offer_product);
                    $('input[name="option"][value="1"]').prop('checked', true);
                    $('#product_input').css('display', 'block');
                }
                if (fetch.pro_type == 2) {
                    $(".offer_brand").html(fetch.offer_brand);
                    $('input[name="option"][value="2"]').prop('checked', true);
                    $('#brand_input').css('display', 'block');
                }
                if (fetch.pro_type == 3) {
                    $(".offer_category").html(fetch.offer_category);
                    $('input[name="option"][value="3"]').prop('checked', true);
                    $('#category_input').css('display', 'block');
                }

                $(".nationality_id").html(fetch.options_nat);

                var offer_apply = fetch.offer_apply;
                $('.offer_apply_maint').prop('checked', false);
                $('.offer_apply_product').prop('checked', false);
                // Loop through each element of the array
                $.each(offer_apply, function(index, value){
                    if (value == 2) {
                        $('.offer_apply_maint').prop('checked', true);
                    } else if (value == 3) {
                        $('.offer_apply_product').prop('checked', true);
                    }
                });

                $(".modal-title").html('<?php echo trans('messages.update_lang',[],session('locale')); ?>');
            }
        },
        error: function(html) {
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



document.addEventListener("DOMContentLoaded", function() {
  // Get references to radio buttons and inputs
  var option1 = document.getElementById("option1");
  var option2 = document.getElementById("option2");
  var option3 = document.getElementById("option3");
  var productInput = document.getElementById("product_input");
  var brandInput = document.getElementById("brand_input");
  var categoryInput = document.getElementById("category_input");

  // Function to hide all inputs
  function hideAllInputs() {
    productInput.style.display = "none";
    brandInput.style.display = "none";
    categoryInput.style.display = "none";
  }

  // Initially hide all inputs
  hideAllInputs();

  // Show products input initially
  productInput.style.display = "block";

  // Add event listeners to radio buttons
  option1.addEventListener("change", function() {
    if (option1.checked) {
      productInput.style.display = "block";
      brandInput.style.display = "none";
      categoryInput.style.display = "none";
      $('.offer_product').val([]);
      $('#product_check').prop('checked',false);
      $('.offer_brand').val([]);
      $('#brand_check').prop('checked',false);
      $('.offer_category').val([]);
      $('#category_check').prop('checked',false);

    }
  });

  option2.addEventListener("change", function() {
    if (option2.checked) {
      productInput.style.display = "none";
      brandInput.style.display = "block";
      categoryInput.style.display = "none";
      $('.offer_product').val([]);
      $('#product_check').prop('checked',false);
      $('.offer_brand').val([]);
      $('#brand_check').prop('checked',false);
      $('.offer_category').val([]);
      $('#category_check').prop('checked',false);
    }
  });

  option3.addEventListener("change", function() {
    if (option3.checked) {
      productInput.style.display = "none";
      brandInput.style.display = "none";
      categoryInput.style.display = "block";
      $('.offer_product').val([]);
      $('#product_check').prop('checked',false);
      $('.offer_brand').val([]);
      $('#brand_check').prop('checked',false);
      $('.offer_category').val([]);
      $('#category_check').prop('checked',false);
    }
  });
});

document.addEventListener("DOMContentLoaded", function() {
        var allCheckbox = document.getElementById("offer_type_all");
        var otherCheckboxes = document.querySelectorAll(".offer_type");

        allCheckbox.addEventListener("change", function() {
            var isChecked = allCheckbox.checked;

            otherCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        otherCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                if (!this.checked) {
                    allCheckbox.checked = false;
                }
            });
        });
    });


    // check custoer
    function check_customer()
    {


        if ($("#offer_type_student:checked").length > 0)
        {
            $(".student_detail").show();
            // $('.student_university').val('')
        }
        else
        {
            $(".student_detail").hide();
            // $('.student_university').val('')
        }
        if ($("#offer_type_employee:checked").length > 0)
        {
            $(".employee_detail").show();
            // $('.ministry_id').val('')
            // $('.employee_workplace').val('')

        }
        else
        {
            $(".employee_detail").hide();
            // $('.ministry_id').val('')
            // $('.employee_workplace').val('')
        }
    }

$('.ministry_id').change(function() {
    var ministry_id = $(this).val();
    $('#global-loader').show();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ url('get_offer_workplaces') }}",
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

$("#std_uni_check").click(function(){
    if($("#std_uni_check").is(':checked') ){
        $(".student_university > option").prop("selected","selected");
        $(".student_university").trigger("change");

            // $('.employee_workplace').val('')
    }else{
        $(".student_university > option").prop("selected", false);
        $(".student_university").trigger("change");
        $('.student_university').val('')
    }
});


$("#min_check").click(function(){
    if($("#min_check").is(':checked') ){
        $(".ministry_id > option").prop("selected","selected");
        $(".ministry_id").trigger("change");

    }else{
        $(".ministry_id > option").prop("selected", false);
        $(".ministry_id").trigger("change");
        $('.ministry_id').val('')
    }
});

$("#emp_check").click(function(){
    if($("#emp_check").is(':checked') ){
        $(".employee_workplace > option").prop("selected","selected");
        $(".employee_workplace").trigger("change");
    }else{
        $(".employee_workplace > option").prop("selected", false);
        $(".employee_workplace").trigger("change");
        $('.employee_workplace').val('')
    }
});

$("#national_check").click(function(){
    if($("#national_check").is(':checked') ){
        $(".nationality_id > option").prop("selected","selected");
        $(".nationality_id").trigger("change");
    }else{
        $(".nationality_id > option").prop("selected", false);
        $(".nationality_id").trigger("change");

    }
});

$("#product_check").click(function(){
    if($("#product_check").is(':checked') ){
        $(".offer_product > option").prop("selected","selected");
        $(".offer_product").trigger("change");
    }else{
        $(".offer_product > option").prop("selected", false);
        $(".offer_product").trigger("change");
    }
});

$("#category_check").click(function(){
    if($("#category_check").is(':checked') ){
        $(".offer_category > option").prop("selected","selected");
        $(".offer_category").trigger("change");
    }else{
        $(".offer_category > option").prop("selected", false);
        $(".offer_category").trigger("change");
    }
});

$("#brand_check").click(function(){
    if($("#brand_check").is(':checked') ){
        $(".offer_brand > option").prop("selected","selected");
        $(".offer_brand").trigger("change");
    }else{
        $(".offer_brand > option").prop("selected", false);
        $(".offer_brand").trigger("change");
    }
});

</script>
