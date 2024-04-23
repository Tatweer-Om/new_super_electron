<script type="text/javascript">
    $(document).ready(function() {

        $('#all_order').DataTable({
            "sAjaxSource": "{{ url('show_order') }}",
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


    });


    window.onload = function() {
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';
        }, 3000);
    };



</script>
