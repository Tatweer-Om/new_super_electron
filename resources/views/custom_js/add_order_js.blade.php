<script>
$(document).ready(function() {
    $('.submit-btn').on('click', function() {

        var sub_total = $('.sub_total').text().trim();
        var total_tax = $('.total_tax').text().trim();
        var cash_back = $('.cash_back').text().trim();
        var grand_discount = $('.grand_discount').text().trim();
        var grand_total = $('.grand_total').text().trim();

        var data = {
            sub_total: sub_total,
            total_tax: total_tax,
            cash_back: cash_back,
            grand_discount: grand_discount,
            grand_total: grand_total
        };

        $.ajax({
            url: '{{ url('pos_order') }}',
            type: 'POST',
            data: { data: data },
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success: function(response) {
                if(response.status==1){
                   show_notification('success','<?php echo trans('messages.data_add_success_lang',[],session('locale')); ?>');
                }
                else{
                    show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');
                    }
            },
                 error: function(xhr, status, error) {
                show_notification('error','<?php echo trans('messages.data_add_failed_lang',[],session('locale')); ?>');}

        });
    });
});


</script>
