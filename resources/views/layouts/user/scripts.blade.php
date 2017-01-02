<script src="{!! \URLHelper::asset('libs/plugins/jQuery/jquery-2.2.3.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/plugins/jQueryUI/jQuery-ui.min.js', 'admin') !!}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button);</script>

<script src="{!! \URLHelper::asset('libs/bootstrap/js/bootstrap.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/adminlte/js/app.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/plugins/toastr/toastr.min.js', 'admin') !!}"></script>

<script type="text/javascript">
    var Boilerplate = {
        'csrfToken': "{!! csrf_token() !!}"
    };
</script>
 <script>
        // script for left and right banner when scroll site
        var topPosition     = 740;
        var bottomPosition  = 1840;
        var heightOfSite    = $(document).height();
        $(document).on( 'scroll', function(){
            distance = 80;
            if( $(document).scrollTop() >= topPosition ) {
                distance = ($(document).scrollTop() < bottomPosition) ? ($(document).scrollTop() - topPosition + 110) : (bottomPosition - topPosition + 110);
            }

            $("#LeftBanner, #RightBanner").css(
                {
                    "margin-top": distance,
                    "-webkit-transition": "1s",
                    "-moz-transition": "1s",
                    "-ms-transition": "1s",
                    "-o-transition": "1s",
                    "transition": "1s"
                }
            );
        });
    </script>