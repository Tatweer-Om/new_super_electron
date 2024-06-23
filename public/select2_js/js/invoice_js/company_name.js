var base_url="<?php echo url('/'); ?>";
$(document).ready(function() {
    $('#clientSelect').on('change', function () {
        var clientId = $(this).val();

        $.ajax({
                // dataType:'JSON',
                type: 'POST',
                url: '/get_client_company',
                data: {
                    client_id: clientId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#companyName').val(response.company_name)
                },
                error: function(error) {
                    console.error('Error:', error);
                }
});
    });
});
