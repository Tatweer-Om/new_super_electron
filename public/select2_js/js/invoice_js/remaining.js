
    function get_invoice_payment(id) {
        $('#invoice_id').val(id);

        $.ajax({
            type: 'POST',
            url: '/get_invoice_payment',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if (response.invoice) {

                    $('#remaining_amount').val(response.invoice.remaining_amount);
                    $('#client_id').val(response.invoice.client_id);
                    $('#invoice_no').val(response.invoice.invoice_no);


                    $('#payment_date').val(response.invoice.payment_date);

                    // Add event listener to the paid amount field
                    $('#paid_amount').on('input', function () {
                        // Get the paid amount
                        var paidAmount = parseFloat($(this).val()) || 0;

                        // Calculate remaining amount
                        var remainingAmount = response.invoice.remaining_amount - paidAmount;

                        // Update the remaining amount field
                        $('#remaining_amount').val(remainingAmount);
                    });
                } else {
                    console.error('Invalid JSON response:', response);
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
