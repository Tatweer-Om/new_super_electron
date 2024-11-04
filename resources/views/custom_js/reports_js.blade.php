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
                                <div>{{ trans('messages.date_from_lang', [], session('locale')) }}: <?php echo "$sdata"; ?>  </div> <div>{{ trans('messages.to_date_lang', [], session('locale')) }}: <?php echo "$edata"; ?>  </div>
                                <div><?php echo $report_name; ?></div>
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

        // $.fn.dataTable.moment('YYYY-MM-DD HH:mm:ss'); // Format of your timestamps

        var bank_statement = $('#bank_statement').DataTable({
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
                        $(win.document.body).prepend(`
                            <div style="text-align:center;">
                                <img style="width:150px;height:150px" src="<?php echo asset('images/setting_images/' . $shop->invo_logo); ?>" />
                            </div>
                            <div style="text-align:center; margin-top:10px;">
                                <h3><?php echo "$shop->system_name"; ?></h3>
                            </div>
                            <div style="border:1px solid #333; display: flex; justify-content: space-between; padding: 5px; margin-top:10px;">
                                <div>{{ trans('messages.date_from_lang', [], session('locale')) }}: <?php echo "$sdata"; ?></div>
                                <div>{{ trans('messages.to_date_lang', [], session('locale')) }}: <?php echo "$edata"; ?></div>
                                <div><?php echo $report_name; ?></div>
                            </div>
                        `);
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
            "order": [[1, 'asc']], // Sort by the second column (date) in ascending order
            "columnDefs": [
                {
                    "type": "datetime-moment",
                    "targets": 1 // Target the second column for date type sorting
                }
            ],
            "fnInitComplete": function(oSettings, json) {
                show_balance();
            },
        });
    });




function show_balance()
{
    var counter=0;
    var bot=0;
    var bin=0;
    var bbl=0;
    $('.bank-in').each(function(e){

        if(counter==0)
        {
            bbl =$('.bank-balance').text();
        }
        else
        {
             bbl =$(this).closest('tr').prev().find('.bank-balance').text();
        }
        bin =$(this).text();
        bot =$(this).closest('tr').find('.bank-out').text();
        if(bin==''){
           bin=0;
         }
         if(bot==''){
           bot=0;
         }

        var balance =parseFloat(bbl)+parseFloat(bin);

        var final_balance=balance -  bot  ;
        $(this).closest('tr').find('.bank-balance').text(final_balance.toFixed(3));
        counter++;
    });
}


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






</script>
