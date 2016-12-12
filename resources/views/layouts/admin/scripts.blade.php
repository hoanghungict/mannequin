<script src="{!! \URLHelper::asset('libs/plugins/jQuery/jquery-2.2.3.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/plugins/jQueryUI/jQuery-ui.min.js', 'admin') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{!! \URLHelper::asset('libs/bootstrap/js/bootstrap.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/adminlte/js/app.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs//plugins/toastr/toastr.min.js', 'admin') !!}"></script>

<script type="text/javascript">
    var Boilerplate = {
        'csrfToken': "{!! csrf_token() !!}"
    };
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    @if(Session::has('message-success'))
        toastr["success"]("{{ Session::get('message-success') }}", "Successfully !!!");
    @endif

    @if(Session::has('message-failed'))
        toastr["error"]("{{ Session::get('message-failed') }}", "Error !!!");
    @endif
</script>