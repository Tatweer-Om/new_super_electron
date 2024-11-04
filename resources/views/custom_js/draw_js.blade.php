<script type="text/javascript">
    $(document).ready(function() {
        $('#winnerModal').on('hidden.bs.modal', function() {
            location.reload();
        });
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
                        if(data.error == 2)
                        {
                            show_notification('error','<?php echo trans('messages.error_draw_not_finish_lang',[],session('locale')); ?>');
                            return false;
                        }
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
                    $(".amount").val(fetch.amount);
                    $(".draw_total").val(fetch.draw_total);
                    $(".total_draw_detail").html(fetch.draw_total_div);
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

    $("#std_uni_check").click(function(){
    if($("#std_uni_check").is(':checked') ){
        $(".student_university > option").prop("selected","selected");
        $(".student_university").trigger("change");
    }else{
        $(".student_university > option").prop("selected", false);
        $(".student_university").trigger("change");
    }
});

    $("#min_check").click(function(){
    if($("#min_check").is(':checked') ){
        $(".ministry_id > option").prop("selected","selected");
        $(".ministry_id").trigger("change");
    }else{
        $(".ministry_id > option").prop("selected", false);
        $(".ministry_id").trigger("change");
    }
});

$("#emp_check").click(function(){
    if($("#emp_check").is(':checked') ){
        $(".employee_workplace > option").prop("selected","selected");
        $(".employee_workplace").trigger("change");
    }else{
        $(".employee_workplace > option").prop("selected", false);
        $(".employee_workplace").trigger("change");
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

$(document).ready(function() {
        $(".student_university").select2({
            dropdownParent: $("#add_draw_modal")
        });
        $(".ministry_id").select2({
            dropdownParent: $("#add_draw_modal")
        })
        $(".employee_workplace").select2({
            dropdownParent: $("#add_draw_modal")
        });
        $(".nationality_id").select2({
            dropdownParent: $("#add_draw_modal")
        });
        $('#add_draw_modal').on('hidden.bs.modal', function() {
            $(".add_draw")[0].reset();
            $('.draw_id').val('');

        });

    });

    function check_customer()
    {


        if ($("#draw_type_student:checked").length > 0)
        {
            $(".student_detail").show();
            $('.student_university').val('')
        }
        else
        {
            $(".student_detail").hide();
            $('.student_university').val('')
        }
        if ($("#draw_type_employee:checked").length > 0)
        {
            $(".employee_detail").show();
            $('.ministry_id').val('')
            $('.employee_workplace').val('')

        }
        else
        {
            $(".employee_detail").hide();
            $('.ministry_id').val('')
            $('.employee_workplace').val('')
        }
    }
    $('.ministry_id').change(function() {
        var ministry_id = $(this).val();
        $('#global-loader').show();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('get_draw_workplaces') }}",
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


    <?php if(!empty($lucky_customer)){ ?>
    // draw profile
    // Global Variable Init
    let interval, currentWinner = {index:null,id:null,text:null,el:null,luckydraw_no:null,single_draw_id:null}, winnerHistory=[];
    let dummyData = [
        <?php
            for ($i=1; $i < count($lucky_customer) ; $i++)
            {
                if(isset($lucky_customer[$i]["customer_name"])){
                    echo '{ id: '.$lucky_customer[$i]["customer_id"].',status: 0,luckydraw_no: '.$lucky_customer[$i]["luckydraw_no"].',single_draw_id: '.$lucky_customer[$i]["single_draw_id"].', name: "'.$lucky_customer[$i]["customer_name"].'" },';
                }
            }

        ?>
    ]

    let currentIndex = Math.floor(Math.random() * dummyData.length);
    let counter = 0;
    let winnerCounter = 0;
    let liveboxElement = $('#livebox-slideshow');
    let sandboxElement = $('#sandbox-data');

    $(document).ready(function(){
        loadData();
    });

    function loadData() {
        // Set element to empty
        liveboxElement.empty();
        sandboxElement.empty();

        // NB: Ini bisa diganti dengan fetching datanya melalui api
        // Init element
        dummyData.forEach((item, index) => {
            if (item.status == 0) {
                let selectedIndex = (currentIndex === index) ? 'current' : 'in';
                let liveboxItems = '<li class="'+ selectedIndex +'" data-id="'+ item.id +'" data-luckydraw_no="'+ item.luckydraw_no +'" data-single_draw_id="'+ item.single_draw_id +'" data-index="' + index + '"><h1 class="text-primary">' + item.name + '</h1></li>';
                let sandboxItems = '<div class="d-flex flex-1 p-2 border border-secondary rounded m-1 bg-white" data-id="'+ item.id +'" data-index="' + index + '"><h5 class="text-secondary m-0">' + item.name + '</h5></div>'
                liveboxElement.append(liveboxItems);
                sandboxElement.append(sandboxItems);
            }
        });
    }

    function slideshow() {
        var slides = $('#livebox-slideshow').find('li');

        currentIndex += 1;
        if (currentIndex >= slides.length) {
            currentIndex = 0;
        }

        // move any previous 'out' slide to the right side.
        $('.out').removeClass().addClass('in');

        // move current to left.
        $('.current').removeClass().addClass('out');

        // move next one to current.
        $(slides[currentIndex]).removeClass().addClass('current');
        // Set the winner data
        let winner = $(slides[currentIndex]);
        currentWinner = {
            index: winner.data('index'),
            id: winner.data('id'),
            luckydraw_no: winner.data('luckydraw_no'),
            single_draw_id: winner.data('single_draw_id'),
            id: winner.data('id'),
            text: winner[0].innerText,
            el: winner[0].innerHTML,
        }
        // Counter increment
        counter += 1;
    }

    $('#start').click(function(){
        // Check if data exist
        // if (dummyData.length > 2) {
            // start counter from 0
            counter = 0;
            $('#livebox-slideshow').show()
            interval = setInterval(slideshow, 77); // Start slideshow with interval value Recommend Value 60-200
            // Hide and disable start button
            $('#start').hide();
            // $('#stop').show();
            $('#start').attr('disabled','true');
            // Automatically stop after 10 seconds
            setTimeout(function() {
                $('#stop').click();
            }, 10000); // 10000 milliseconds = 10 seconds
        // }
    });

    $('#stop').click(function(){
        clearInterval(interval); // Stop slideshow to get current winner
        // Show and enabled start button
        $('#stop').hide();
        $('#start').show();
        $('#start').removeAttr('disabled');
        // Set Current winner data to show in modal
        winnerCounter += 1;
        $('#winnerModalTitle').html('<h2><?php echo trans('messages.winner_lang', [], session('locale')) ?></h2>')
        $('#winnerModalContent').html(currentWinner.el)
        $('#winnerModal').show()
        // NB: Mulai dari sini bisa diganti dengan fetch ke API ya untuk sent data pemenang saat ini ke back end
        // Set current winner data to object
        let currentWinnerData = {
            winner: winnerCounter,
            data: currentWinner
        };
        console.log(currentWinnerData)
        // console.log(currentWinnerData, currentIndex)
        winnerHistory.push(currentWinnerData) // Optional if to show winner history
        dummyData.splice(currentWinner.index, 1) // Remove 1 object for reupdate dummy data

        add_winner_history(currentWinnerData.data.id,currentWinnerData.data.luckydraw_no,currentWinnerData.data.single_draw_id);
    })

    function hideWinnerModal() {
        $('#winnerModal').hide()
        // update and remove every current winner element
        liveboxElement.find('li[data-index="'+ currentWinner.index +'"]').remove()
        sandboxElement.find('div[data-index="'+ currentWinner.index +'"]').remove()
        loadData() // reload data
    }

    // add winnder history
    function add_winner_history(id,luckydraw_no,single_draw_id) {
        var draw_id = $('#draw_id').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('add_winner_history') }}",
            type: 'POST',
            data: {id: id,draw_id: draw_id,luckydraw_no:luckydraw_no,single_draw_id: single_draw_id,_token: csrfToken},
            error: function () {
            },
            success: function (data) {

            }
        });
    }
    <?php }?>

    $('.draw_total').keyup(function() {
        var total_draw = parseInt($('.draw_total').val());
        var rowContainer = $('.total_draw_detail');
        rowContainer.empty(); // Clear previous rows
        if (total_draw > 0) {
            for (var i = 1; i <= total_draw; i++) {
                var col1 = $('<div class="col-md-6 col-sm-12 col-12"></div>');
                var formGroup1 = $('<div class="form-group"></div>');
                formGroup1.append('<label for="gift' + i + '"><?php echo trans('messages.gift_lang', [], session('locale')) ?> ' + i + '</label>');
                formGroup1.append('<input type="text" class="form-control gift" name="gift[]" id="gift' + i + '">');
                col1.append(formGroup1);

                var col2 = $('<div class="col-md-6 col-sm-12 col-12"></div>');
                var formGroup2 = $('<div class="form-group"></div>');
                formGroup2.append('<label for="draw_date' + i + '"><?php echo trans('messages.draw_date_lang', [], session('locale')) ?> ' + i + '</label>');
                formGroup2.append('<input type="text" class="form-control single_draw_date datepick" name="single_draw_date[]" id="draw_date' + i + '">');
                col2.append(formGroup2);

                rowContainer.append(col1);
                rowContainer.append(col2);

                // Initialize datepicker
                $('.datepick').datetimepicker({
                    format: 'YYYY-MM-DD',
                    icons: {
                        up: "fas fa-angle-up",
                        down: "fas fa-angle-down",
                        next: 'fas fa-angle-right',
                        previous: 'fas fa-angle-left'
                    }
                });
            }
        }
    });



</script>
