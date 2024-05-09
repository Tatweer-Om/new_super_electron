<script>
    $(document).ready(function () {


        var table =$('#example').DataTable({
            "pageLength": 500,
            dom: 'Blfript',
            buttons: [
                {
                    extend: 'print',
                    footer: true,
                    title: '',
                    visible: false,
                    filename: 'Report',
                    customize: function (win) {

                        $(win.document.body).prepend(`<div style="text-align:center;"><img style="width:150px;height:150px"  src="<?php echo asset('images/setting_images/' . $shop->invo_logo); ?>" </div>
                            <div style="text-align:center;  margin-top:10px;"><h3><?php echo "$shop->system_name"; ?></h3></div>
                            <div style="border:1px solid #333; display: flex; justify-content: space-between; padding: 5px; margin-top:10px;">

                                <div><?= $report_name ?></div>

                            </div>`);
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    title: '',
                    filename: 'Report',
                    visible: false
                },

            ],
        });
        $('.buttons-csv, .buttons-excel , .buttons-print').hide();

        $('#printButton').on('click', function() {
            table.button('.buttons-print').trigger();
        });

        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
        });
    });



    // order detail data
function formatDate(date) {
    var dd = date.getDate();
    var mm = date.getMonth() + 1; // January is 0!
    var yyyy = date.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }

    return yyyy + '-' + mm + '-' + dd;
}

// Function to get the start and end dates for different time ranges
function getDates(timeRange) {
    var endDate = new Date();
    var startDate;

    switch (timeRange) {
        case '0':
            startDate = new Date(endDate);
            startDate.setDate(endDate.getDate() - 7);
            break;
        case '1':
            startDate = new Date(endDate.getFullYear(), endDate.getMonth() - 1, 1);
            endDate = new Date(endDate.getFullYear(), endDate.getMonth(), 0);
            break;
        case '2':
            startDate = new Date(endDate.getFullYear(), endDate.getMonth() - 1, 1);
            endDate = new Date(endDate.getFullYear(), endDate.getMonth(), 0);

            break;
        case '3':
            startDate = new Date(endDate.getFullYear() - 1, endDate.getMonth(), 1);
            break;
        default:
            break;
    }

    return {
        start: formatDate(startDate),
        end: formatDate(endDate)
    };
}
function get_order_detail_report(type)
{
    var lastMonthDates = getDates(type);
    // Change start and end date values
    $('#date_from').val(lastMonthDates.start); // Change this to the desired start date
    $('#to_date').val(lastMonthDates.end);   // Change this to the desired end date

    // Submit the form
    $('.form_data').submit();
}


function points_history(customer_id) {
    $.ajax({
        url: "{{ route('points_history') }}",
        method: 'GET',
        data: { customer_id: customer_id },
        success: function(response) {
            var pointsHistoryHtml = '';
            $.each(response.points_history, function(index, history) {
                pointsHistoryHtml += '<tr>';
                pointsHistoryHtml += '<td>' + (history.order_no ?? '') + ' <br>' + (history.created_at ? new Date(history.created_at).toLocaleDateString() : '') + '</td>';
                pointsHistoryHtml += '<td>' + (history.points ?? '') + '</td>';
                pointsHistoryHtml += '<td>' + (history.amount ?? '') + '</td>';
                pointsHistoryHtml += '<td>' + (history.type == 1 ? 'Points Added' : 'Points Used') + '</td>';
                pointsHistoryHtml += '<td><a class="me-3" href="{{ url('pos_bill/') }}/' + (history.order_no ?? '') + '"><i class="fas fa-eye"></i></a></td>';
                pointsHistoryHtml += '</tr>';
            });

            $('#point_history_body').html(pointsHistoryHtml);
            $('#customer_name').text(response.customer_name);
            $('#points').modal('show');

        }
    });
}

</script>
