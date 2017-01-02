<!DOCTYPE html>
<html>
<head>
    <!-------------------------------- Begin: Meta ----------------------------------->
    @include('layouts.user.meta')
    @yield('metadata')
    <!-------------------------------- End: Meta ----------------------------------->

    <!-------------------------------- Begin: stylesheet ----------------------------------->
    @include('layouts.user.styles')
    @yield('styles')
    <!-------------------------------- End: stylesheet ----------------------------------->

</head>
<body>
@include('layouts.user.header')
@include('layouts.user.topNavigation')
@include('layouts.user.mainSlideShow')
<hr style="margin-bottom: 0;"/>
<div id="Content">
    <div id="LeftBanner">
            <img src="{!! \URLHelper::asset('libs/userlte/banner/120x600.jpg', 'user') !!}" alt="">
        </div>

        <div id="MainContent">
            <section>
                @yield('content')
            </section>
        </div>

        <div id="RightBanner">
            <img src="{!! \URLHelper::asset('libs/userlte/banner/120x600.jpg', 'user') !!}" alt="">

    </div>
</div>
@include('layouts.user.footer')

<!-------------------------------- Begin: Script ----------------------------------->
@include('layouts.user.scripts')
@yield('scripts')
<!-------------------------------- End: Script ----------------------------------->
</body>
</html>
