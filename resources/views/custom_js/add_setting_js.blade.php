<script type="text/javascript">

function toggleTaxInput() {
    var taxInputTitle = document.getElementById("taxInputLabel");
    var taxInput = document.getElementById("taxInput");
    var taxToggle = document.getElementById("taxToggle");

    if (taxToggle.checked) {
        taxInputTitle.textContent = "Percentage Tax";
        taxInput.placeholder = "Enter tax percentage";
    } else {
        taxInputTitle.textContent = "OMR Tax";
        taxInput.placeholder = "Enter tax in OMR";
    }
}



$(document).ready(function() {
    $('#company_data').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('company_data_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});


$(document).ready(function() {
    $('#inspection_data').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('inspection_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});


$(document).ready(function() {
    $('#maint_data').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('maint_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});

//proposal

$(document).ready(function() {
    $('#proposal').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('proposal_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});


//qout

$(document).ready(function() {
    $('#qout').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('qout_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});

//posinvodata
$(document).ready(function() {
    $('#pos_invoice_data').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('pos_qout_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});


//taxsetting

$(document).ready(function() {
    $('#taxsetting').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('tax_setting_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});

//
$(document).ready(function() {
    $('#points_data').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#global-loader').show();

        $.ajax({
            url: "{{ url('points_post') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#global-loader').hide();
                if (data.status == 1) {
                    show_notification('success', 'Data added successfully.');
                } else if (data.status == 2) {
                    show_notification('success', 'Data updated successfully.');
                }
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                $('#global-loader').hide();
                show_notification('error', 'Failed to save data: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
