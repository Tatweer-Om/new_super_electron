<script>
    $(document).ready(function() {
        $('#login').off().on('submit', function(e){
            e.preventDefault();
            var formdatas = new FormData($('#login')[0]);

            $('#global-loader').show();
            before_submit();
            var str = $("#login").serialize();
            $.ajax({
                type: "POST",
                url: "{{ url('login') }}",
                data: formdatas,
                contentType: false,
                processData: false,
                success: function(data) {
                    after_submit();
                    $('#global-loader').hide();
                    if (data.status == 1) {

                        show_notification('success', '<?php echo trans('messages.login_success_lang',[],session('locale')); ?>');
                        window.location.href = '{{ route("home") }}';
                    }


                    else if (data.status == 2) {

                        show_notification('error', '<?php echo trans('messages.login_fail_lang',[],session('locale')); ?>');
                    }

                },
                error: function (xhr, status, error) {

                    show_notification('error', 'Failed to save data: ' + error);
                    console.error(xhr.responseText);
                }
            });
        });
    });

</script>
