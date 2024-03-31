<script type="text/javascript">

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('.sms_status').on('change', function () {
        const smsStatus = $(this).val();
        $('#global-loader').show();
        $.ajax({
            url:  "{{ url('get_sms_status') }}",
            method: "POST",
            data: { sms_status: smsStatus,_token: csrfToken },
            success: function (data) {
                $('#global-loader').hide();
                if (data.status === 1) {
                    $(".sms_area").val(data.sms);
                } else {
                    $(".sms_area").val('');
                }
            },
            error: function (data) {
                $('#global-loader').hide();
                show_notification('error',  '<?php echo trans('messages.get_data_failed_lang',[],session('locale')); ?>');
                console.log(data);
            }
        });
    });

    $(".item_name").click(function () {
        $(".sms_area").val((index, value) => value + '{ITEM_NAME}');
    });

    $(".customer_name").click(function () {
        $(".sms_area").val((index, value) => value + '{CUSTOMER_NAME}');
    });

    $(".unit_price").click(function () {
        $(".sms_area").val((index, value) => value + '{UNIT_PRICE}');
    });

    $(".qty").click(function () {
        $(".sms_area").val((index, value) => value + '{QTY}');
    });

    $(".url").click(function () {
        $(".sms_area").val((index, value) => value + '{URL}');
    });

    $(".payment_method").click(function () {
        $(".sms_area").val((index, value) => value + '{PAYMENT_METHOD}');
    });

    $(".discount").click(function () {
        $(".sms_area").val((index, value) => value + '{DISCOUNT}');
    });

    $(".tax").click(function () {
        $(".sms_area").val((index, value) => value + '{TAX}');
    });

    $(".grand_total").click(function () {
        $(".sms_area").val((index, value) => value + '{GRAND_TOTAL}');
    });

    $(".total").click(function () {
        $(".sms_area").val((index, value) => value + '{TOTAL}');
    });

    $(".notes").click(function () {
        $(".sms_area").val((index, value) => value + '{NOTES}');
    });

    $(".pay_later_total_amount").click(function () {
        $(".sms_area").val((index, value) => value + '{PAY_LATER_TOTAL_AMOUNT}');
    });

    $(".remaining_payment").click(function () {
        $(".sms_area").val((index, value) => value + '{REMAINING_PAYMENT}');
    });

    $(".bill_num").click(function () {
        $(".sms_area").val((index, value) => value + '{BILL_NUM}');
    });
</script>
